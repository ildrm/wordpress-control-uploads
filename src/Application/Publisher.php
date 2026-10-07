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
        $temp = $destination = null; $transaction = false; $mediaLock = null; $attachmentId = 0; $journal = new MediaJournal($this->s);
        try {
            if ($journal->read('publish', $id) !== null && $journal->recover(1, $id)['failed'] > 0) { throw new \RuntimeException('STORAGE.JOURNAL'); }
            $row = $this->s->scans->get($id);
            if ((int)$row['revision'] !== $expectedRevision || (!in_array($row['state'], ['ALLOWED', 'SANITIZING', 'SANITIZED'], true) && !$override) || $row['state'] === 'DELETED') { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
            $existing = (int)$row['attachment_id'];
            if ($existing) {
                $mediaLock = 'cf-media-' . $this->s->siteId . '-' . $existing;
                if ((int)$db->get_var($db->prepare('SELECT GET_LOCK(%s,0)', $mediaLock)) !== 1) { $mediaLock = null; throw new \RuntimeException('QUEUE.PUBLICATION_BUSY'); }
                if ((int)($this->s->scans->latest($existing)['id'] ?? 0) !== $id) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
            }
            $context = json_decode($row['context_json'], true, 16, JSON_THROW_ON_ERROR);
            $libraryNeedsRebuild = ($context['context'] ?? '') === 'library' && (int)get_post_meta($existing, '_cf_published_scan', true) !== $id;
            if ($existing && !$libraryNeedsRebuild && in_array($row['state'], ['ALLOWED', 'SANITIZED'], true) && is_file(get_attached_file($existing, true) ?: '')) {
                if ($onPublish) {
                    $db->query('START TRANSACTION'); $transaction = true; $this->s->scans->lock($id, $expectedRevision);
                    $onPublish(); if ($db->query('COMMIT') === false) { throw new \RuntimeException('DATABASE.COMMIT'); } $transaction = false;
                }
                return $existing;
            }
            if ($row['expires_at'] <= gmdate('Y-m-d H:i:s')) { throw new \RuntimeException('STORAGE.EXPIRED'); }
            $file = $this->s->inspector->inspect($this->s->storage->path($row['private_key'], $this->s->siteId), $row['file_name'], $row['mime']);
            if (!hash_equals($file->sha256, $row['sha256'])) { throw new \RuntimeException('STORAGE.HASH_CHANGED'); }
            $findings = $this->s->security->inspect($file);
            if (array_filter($findings, fn($f): bool => $f->hardSecurity || ($f->category === 'security.requires_document_cdr' && (!$this->s->documents || !in_array($file->mime, $this->s->documents->supportedMimes(), true))))) { throw new \RuntimeException('SECURITY.PUBLICATION_DENIED'); }
            $temp = $this->s->storage->temporary($this->s->siteId);
            $policy = $this->s->policies->get($row['policy_id'], (int)$row['policy_version']);
            $builder = new \ContentFirewall\Media\DerivativeBuilder($this->s->documents, $this->s->temporal); $decisionData = json_decode($row['decision_json'], true, 16, JSON_THROW_ON_ERROR);
            $builder->build($file, $temp, in_array($row['state'], ['SANITIZING', 'SANITIZED'], true), $this->s->scans->findings($id), $policy->options['patterns'] ?? [], $builder->categories($policy, $decisionData['rules'] ?? []));
            $this->s->inspector->inspect($temp, $file->name, $file->mime);
            $db->query('START TRANSACTION'); $transaction = true;
            // Serialize decisions with the public write, including other moderators and retention.
            $this->s->scans->lock($id, $expectedRevision);
            $this->s->router->pulse();
            $state = State::from($row['state']);
            if ($existing) { (new MediaWithdrawal($this->s))->withdraw($existing, $id); }
            if ($override && !in_array($state, [State::Allowed, State::Sanitizing, State::Sanitized], true)) {
                $decision = new Decision(Action::Allow, ['review.approved'], [], $row['policy_id'], (int)$row['policy_version'], (float)$row['risk']);
                if (!$this->s->scans->transition($id, $expectedRevision, State::Allowed, ['decision_json' => json_encode($decision, JSON_THROW_ON_ERROR)])) { throw new \RuntimeException('QUEUE.STALE_RESULT'); } $expectedRevision++;
            }
            $uploads = wp_upload_dir(); if ($uploads['error']) { throw new \RuntimeException('STORAGE.UPLOAD_DIR'); }
            $name = wp_unique_filename($uploads['path'], 'cf-' . bin2hex(random_bytes(12)) . '-' . sanitize_file_name($file->name)); $destination = $uploads['path'] . '/' . $name;
            $journal->write('publish', $id, ['path' => $journal->relative($destination), 'revision' => $expectedRevision]);
            $in = fopen($temp, 'rb'); $out = fopen($destination, 'x+b');
            if (!$in || !$out) { if ($in) { fclose($in); } if ($out) { fclose($out); } throw new \RuntimeException('STORAGE.PUBLIC_COPY'); }
            try { if (stream_copy_to_stream($in, $out) === false || !fflush($out)) { throw new \RuntimeException('STORAGE.PUBLIC_COPY'); } } finally { fclose($in); fclose($out); }
            chmod($destination, 0644);
            do_action('cf_internal_publication_checkpoint', 'copied', $id);
            $data = ['post_mime_type' => $file->mime, 'post_title' => pathinfo($name, PATHINFO_FILENAME), 'post_status' => 'inherit', 'post_author' => (int)$row['user_id'], 'meta_input' => ['_cf_scan_id' => $id, '_cf_pending' => 1]];
            if ($existing) {
                if (get_post_type($existing) !== 'attachment') { throw new \RuntimeException('SECURITY.MEDIA_LOCATION'); }
                $data = ['ID' => $existing, 'post_parent' => (int)get_post_field('post_parent', $existing), 'post_mime_type' => $file->mime, 'meta_input' => ['_cf_scan_id' => $id, '_cf_pending' => 1]];
            }
            $attachmentId = $existing ? wp_update_post($data + ['file' => $destination], true) : wp_insert_attachment($data, $destination, 0, true);
            if (is_wp_error($attachmentId) || filter_var($attachmentId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) { throw new \RuntimeException('STORAGE.ATTACHMENT'); }
            $target = in_array($state, [State::Sanitizing, State::Sanitized], true) ? State::Sanitized : State::Allowed;
            if (!$this->s->scans->transition($id, $expectedRevision, $target, ['attachment_id' => $attachmentId])) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
            $this->s->audit->record('media.published', $id, get_current_user_id(), ['state' => $target->value]);
            update_post_meta($attachmentId, '_cf_published_scan', $id);
            delete_post_meta($attachmentId, '_cf_local_withdrawn');
            if ($onPublish) { $onPublish(); }
            if ($db->query('COMMIT') === false) { throw new \RuntimeException('DATABASE.COMMIT'); } $transaction = false;
            $published = $destination; $destination = null;
            // A metadata extension failure must never remove the committed attachment's file.
            try {
                do_action('cf_internal_publication_checkpoint', 'committed', $id);
                require_once ABSPATH . 'wp-admin/includes/image.php';
                wp_update_attachment_metadata($attachmentId, wp_generate_attachment_metadata($attachmentId, $published));
                delete_post_meta($attachmentId, '_cf_pending');
                $journal->clear('publish', $id);
                if ($existing) { $journal->clear('withdraw', $existing); }
            } catch (\Throwable $e) { $this->s->audit->record('media.metadata_failed', $id, 0, ['code' => ScanService::errorCode($e)]); }
            return $attachmentId;
        } finally {
            if ($transaction) { $db->query('ROLLBACK'); if ($attachmentId || !empty($existing)) { clean_post_cache($attachmentId ?: $existing); } }
            if ($temp && is_file($temp)) { unlink($temp); } if ($destination && is_file($destination)) { unlink($destination); }
            $db->get_var($db->prepare('SELECT RELEASE_LOCK(%s)', $lock));
            if ($mediaLock) { $db->get_var($db->prepare('SELECT RELEASE_LOCK(%s)', $mediaLock)); }
        }
    }
}
