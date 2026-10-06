<?php
declare(strict_types=1);
namespace ContentFirewall\Application;
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Domain\{Action, Decision, State};
final class Publisher
{
    public function __construct(private Services $s) {}
    public function publish(int $id, int $expectedRevision, bool $override = false, ?callable $onPublish = null): int
    {
        if ($this->s->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        $db = $this->s->db; $lock = 'cf-publish-' . $this->s->siteId . '-' . $id;
        foreach ([$db->posts, $db->postmeta] as $table) {
            $engine = $db->get_var($db->prepare('SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME=%s', $table));
            if (strtoupper((string)$engine) !== 'INNODB') { throw new \RuntimeException('CONFIGURATION.TRANSACTIONAL_TABLES_REQUIRED'); }
        }
        if ((int)$db->get_var($db->prepare('SELECT GET_LOCK(%s,0)', $lock)) !== 1) { throw new \RuntimeException('QUEUE.PUBLICATION_BUSY'); }
        $temp = $destination = null; $transaction = false;
        try {
            $row = $this->s->scans->get($id);
            if ((int)$row['revision'] !== $expectedRevision || (!in_array($row['state'], ['ALLOWED', 'SANITIZING', 'SANITIZED'], true) && !$override) || $row['state'] === 'DELETED') { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
            $existing = (int)$row['attachment_id'];
            $context = json_decode($row['context_json'], true, 16, JSON_THROW_ON_ERROR);
            $libraryNeedsRebuild = ($context['context'] ?? '') === 'library' && (int)get_post_meta($existing, '_cf_published_scan', true) !== $id;
            if ($existing && !$libraryNeedsRebuild && in_array($row['state'], ['ALLOWED', 'SANITIZED'], true) && is_file(get_attached_file($existing, true) ?: '')) {
                if ($onPublish) {
                    $db->query('START TRANSACTION'); $transaction = true; $this->s->scans->lock($id, $expectedRevision);
                    $onPublish(); if ($db->query('COMMIT') === false) { throw new \RuntimeException('DATABASE.COMMIT'); } $transaction = false;
                }
                return $existing;
            }
            $file = $this->s->inspector->inspect($this->s->storage->path($row['private_key'], $this->s->siteId), $row['file_name'], $row['mime']);
            if (!hash_equals($file->sha256, $row['sha256'])) { throw new \RuntimeException('STORAGE.HASH_CHANGED'); }
            $findings = $this->s->security->inspect($file);
            if (array_filter($findings, static fn($f): bool => $f->hardSecurity || $f->category === 'security.requires_document_cdr')) { throw new \RuntimeException('SECURITY.PUBLICATION_DENIED'); }
            $temp = $this->s->storage->temporary($this->s->siteId);
            if ($file->width) { (new \ContentFirewall\Security\RasterReconstructor())->reconstruct($file, $temp); }
            elseif ($file->mime === 'image/svg+xml') { (new \ContentFirewall\Security\SvgReconstructor())->reconstruct($file, $temp); }
            elseif ($file->mime === 'text/plain') { if (!copy($file->path, $temp)) { throw new \RuntimeException('STORAGE.DERIVATIVE'); } }
            else { throw new \RuntimeException('SECURITY.PUBLICATION_DENIED'); }
            $db->query('START TRANSACTION'); $transaction = true;
            // Serialize decisions with the public write, including other moderators and retention.
            $this->s->scans->lock($id, $expectedRevision);
            $state = State::from($row['state']);
            if ($existing) { (new MediaWithdrawal($this->s))->withdraw($existing); }
            if ($override && !in_array($state, [State::Allowed, State::Sanitizing, State::Sanitized], true)) {
                $decision = new Decision(Action::Allow, ['review.approved'], [], $row['policy_id'], (int)$row['policy_version'], (float)$row['risk']);
                if (!$this->s->scans->transition($id, $expectedRevision, State::Allowed, ['decision_json' => json_encode($decision, JSON_THROW_ON_ERROR)])) { throw new \RuntimeException('QUEUE.STALE_RESULT'); } $expectedRevision++;
            }
            $uploads = wp_upload_dir(); if ($uploads['error']) { throw new \RuntimeException('STORAGE.UPLOAD_DIR'); }
            $name = wp_unique_filename($uploads['path'], bin2hex(random_bytes(12)) . '-' . sanitize_file_name($file->name)); $destination = $uploads['path'] . '/' . $name;
            $in = fopen($temp, 'rb'); $out = fopen($destination, 'x+b');
            if (!$in || !$out) { if ($in) { fclose($in); } if ($out) { fclose($out); } throw new \RuntimeException('STORAGE.PUBLIC_COPY'); }
            try { if (stream_copy_to_stream($in, $out) === false || !fflush($out)) { throw new \RuntimeException('STORAGE.PUBLIC_COPY'); } } finally { fclose($in); fclose($out); }
            chmod($destination, 0644);
            $data = ['post_mime_type' => $file->mime, 'post_title' => pathinfo($name, PATHINFO_FILENAME), 'post_status' => 'inherit', 'post_author' => (int)$row['user_id'], 'meta_input' => ['_cf_scan_id' => $id]];
            if ($existing && get_post_type($existing) === 'attachment') { $data['ID'] = $existing; }
            $attachmentId = wp_insert_attachment($data, $destination, 0, true);
            if (is_wp_error($attachmentId)) { throw new \RuntimeException('STORAGE.ATTACHMENT'); }
            $target = $state === State::Sanitizing ? State::Sanitized : State::Allowed;
            if (!$this->s->scans->transition($id, $expectedRevision, $target, ['attachment_id' => $attachmentId])) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
            $this->s->audit->record('media.published', $id, get_current_user_id(), ['state' => $target->value]);
            update_post_meta($attachmentId, '_cf_published_scan', $id);
            delete_post_meta($attachmentId, '_cf_local_withdrawn');
            if ($onPublish) { $onPublish(); }
            if ($db->query('COMMIT') === false) { throw new \RuntimeException('DATABASE.COMMIT'); } $transaction = false;
            $published = $destination; $destination = null;
            // A metadata extension failure must never remove the committed attachment's file.
            try {
                require_once ABSPATH . 'wp-admin/includes/image.php';
                wp_update_attachment_metadata($attachmentId, wp_generate_attachment_metadata($attachmentId, $published));
                delete_post_meta($attachmentId, '_cf_pending');
            } catch (\Throwable $e) { $this->s->audit->record('media.metadata_failed', $id, 0, ['code' => ScanService::errorCode($e)]); }
            return $attachmentId;
        } finally {
            if ($transaction) { $db->query('ROLLBACK'); }
            if ($temp && is_file($temp)) { unlink($temp); } if ($destination && is_file($destination)) { unlink($destination); }
            $db->get_var($db->prepare('SELECT RELEASE_LOCK(%s)', $lock));
        }
    }
}
