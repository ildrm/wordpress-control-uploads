<?php
declare(strict_types=1);
namespace ContentFirewall\Queue;
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Application\{MediaWithdrawal, Publisher, ScanService};
use ContentFirewall\Domain\UploadContext;
final class Worker
{
    public function __construct(private Services $s) {}
    public function run(int $maximum = 20, int $seconds = 25): array
    {
        if ($this->s->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        (new \ContentFirewall\Application\ReviewService($this->s))->escalateDue();
        $this->s->storage->cleanupTemporary($this->s->siteId);
        $recovery = (new \ContentFirewall\Application\MediaJournal($this->s))->recover(10);
        if ($recovery['failed']) { update_option('cf_recovery_error', 'STORAGE.JOURNAL', false); } else { delete_option('cf_recovery_error'); }
        $deadline = microtime(true) + min(300, max(1, $seconds)); $done = $failed = 0;
        while ($done + $failed < min(100, max(1, $maximum)) && microtime(true) < $deadline && ($job = $this->s->jobs->claim())) {
            $payload = [];
            $this->s->router->setHeartbeat(fn() => $this->s->jobs->renew((int)$job['id'], $job['lease_token']));
            try {
                $payload = json_decode($job['payload'], true, 16, JSON_THROW_ON_ERROR);
                if (!is_array($payload)) { throw new \InvalidArgumentException('QUEUE.PAYLOAD'); }
                if (in_array($job['kind'], ['scan', 'rescan'], true)) {
                    if (!is_int($payload['scan_id'] ?? null) || !is_int($payload['revision'] ?? null)) { throw new \InvalidArgumentException('QUEUE.PAYLOAD'); }
                    $row = $this->s->scans->get($payload['scan_id']);
                    $signals = json_decode($row['signals_json'], true, 16, JSON_THROW_ON_ERROR);
                    $finished = ['ALLOWED', 'SANITIZING', 'SANITIZED', 'BLOCKED', 'REVIEW_REQUIRED', 'QUARANTINED'];
                    $resume = (int)$row['revision'] !== $payload['revision'] && ($signals['queue_revision'] ?? -1) === $payload['revision'] && in_array($row['state'], $finished, true);
                    if (!$resume) { $this->s->scanner->process($payload['scan_id'], $payload['revision']); $row = $this->s->scans->get($payload['scan_id']); }
                    if (in_array($row['state'], ['ALLOWED', 'SANITIZING', 'SANITIZED'], true)) { (new Publisher($this->s))->publish((int)$row['id'], (int)$row['revision']); }
                    else { (new MediaWithdrawal($this->s))->enforce((int)$row['id'], (int)$row['revision']); }
                } elseif ($job['kind'] === 'library') { $this->library($payload); }
                elseif ($job['kind'] === 'retention') { (new \ContentFirewall\Application\Retention($this->s))->run(); }
                elseif ($job['kind'] === 'webhook') { (new \ContentFirewall\Integrations\WebhookSender($this->s))->send($payload); }
                else { throw new \InvalidArgumentException('QUEUE.PAYLOAD'); }
                if (!$this->s->jobs->finish((int)$job['id'], $job['lease_token'])) { throw new \RuntimeException('QUEUE.LEASE_EXPIRED'); } $done++;
            } catch (\Throwable $e) {
                $code = $e instanceof \JsonException ? 'QUEUE.PAYLOAD' : ScanService::errorCode($e); $retry = in_array($code, ['PROVIDER.TRANSPORT', 'DATABASE.CLAIM', 'QUEUE.PUBLICATION_BUSY', 'STORAGE.DERIVATIVE', 'STORAGE.PUBLIC_COPY', 'STORAGE.UPLOAD_DIR', 'STORAGE.ATTACHMENT', 'STORAGE.MEDIA_WITHDRAWAL', 'DATABASE.ENQUEUE', 'DATABASE.COMMIT', 'DATABASE.TRANSITION', 'DATABASE.FINDING'], true);
                if ($code !== 'QUEUE.LEASE_EXPIRED' && (!$retry || (int)$job['attempts'] >= 5) && in_array($job['kind'], ['scan', 'rescan'], true) && is_int($payload['scan_id'] ?? null) && is_int($payload['revision'] ?? null)) {
                    $this->terminalFailure($payload['scan_id'], $payload['revision'], $code);
                }
                $this->s->jobs->fail((int)$job['id'], $job['lease_token'], (int)$job['attempts'], $code, $retry);
                $this->s->audit->record('job.failed', (int)($payload['scan_id'] ?? 0), 0, ['job_id' => (int)$job['id'], 'code' => $code]); $failed++;
            } finally { $this->s->router->setHeartbeat(null); }
        }
        foreach ($this->s->jobs->exhausted() as $expired) {
            try {
                $payload = json_decode($expired['payload'], true, 16, JSON_THROW_ON_ERROR);
                if (!is_int($payload['scan_id'] ?? null) || !is_int($payload['revision'] ?? null) || $this->terminalFailure($payload['scan_id'], $payload['revision'], 'QUEUE.LEASE_EXHAUSTED')) { $this->s->jobs->reconciled((int)$expired['id']); }
            } catch (\Throwable $e) { $this->s->audit->record('job.recovery_failed', 0, 0, ['job_id' => (int)$expired['id'], 'code' => ScanService::errorCode($e)]); }
        }
        update_option('cf_worker_last_run', time(), false); return ['completed' => $done, 'failed' => $failed];
    }
    private function terminalFailure(int $id, int $revision, string $code): bool
    {
        try {
            $row = $this->s->scans->get($id);
            $signals = json_decode($row['signals_json'], true, 16, JSON_THROW_ON_ERROR);
            if ((int)$row['revision'] !== $revision) {
                if (($signals['queue_revision'] ?? -1) !== $revision || !in_array($row['state'], ['ALLOWED', 'SANITIZING', 'SANITIZED'], true)) { return true; }
                $decision = new \ContentFirewall\Domain\Decision(\ContentFirewall\Domain\Action::Review, [$code], [], $row['policy_id'], (int)$row['policy_version'], (float)$row['risk']);
                if (!$this->s->scans->complete($id, (int)$row['revision'], \ContentFirewall\Domain\State::Review, $decision, $signals, $this->s->scans->findings($id))) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
                $row = $this->s->scans->get($id); (new MediaWithdrawal($this->s))->enforce($id, (int)$row['revision']);
                $this->s->audit->record('media.publication_failed', $id, 0, ['code' => $code]); return true;
            }
            if (!in_array($row['state'], ['PENDING_PROVIDER', 'CONTENT_SCANNING'], true)) { return true; }
            $decision = new \ContentFirewall\Domain\Decision(\ContentFirewall\Domain\Action::Quarantine, [$code], [], $row['policy_id'], (int)$row['policy_version'], 0);
            if ($this->s->scans->complete($id, $revision, \ContentFirewall\Domain\State::Failed, $decision, [], $this->s->scans->findings($id), true)) {
                $row = $this->s->scans->get($id); (new MediaWithdrawal($this->s))->enforce($id, (int)$row['revision']);
            }
            return true;
        } catch (\Throwable $e) { $this->s->audit->record('job.recovery_failed', $id, 0, ['code' => ScanService::errorCode($e)]); return false; }
    }
    private function library(array $payload): void
    {
        $id = (int)($payload['attachment_id'] ?? 0);
        $args = ['post_type' => 'attachment', 'post_status' => 'inherit', 'posts_per_page' => 25, 'orderby' => 'ID', 'order' => 'ASC', 'fields' => 'ids', 'no_found_rows' => true];
        if ($id) { $ids = [$id]; }
        else {
            $after = max(0, (int)($payload['after'] ?? 0));
            $filter = function (string $where) use ($after): string { return $where . $this->s->db->prepare(' AND ID > %d', $after); };
            add_filter('posts_where', $filter); try { $query = new \WP_Query($args); $ids = $query->posts; } finally { remove_filter('posts_where', $filter); }
        }
        foreach ($ids as $attachmentId) {
            try {
            if (!get_post($attachmentId) || get_post_type($attachmentId) !== 'attachment') { continue; }
            $path = get_attached_file($attachmentId, true); $uploads = wp_upload_dir(null, false); $base = realpath($uploads['basedir']); $real = $path ? realpath($path) : false;
            if (!$base || !$real || !str_starts_with($real, $base . '/') || is_link($path)) { continue; }
            $context = new UploadContext($this->s->siteId, (int)get_post_field('post_author', $attachmentId), 'library');
            $result = $this->s->scanner->receive($real, basename($real), get_post_mime_type($attachmentId), $context);
            $row = $this->s->scans->get($result['id']);
            $this->s->scans->associate((int)$row['id'], (int)$attachmentId);
            update_post_meta($attachmentId, '_cf_scan_id', $result['id']);
            if (in_array($row['state'], ['ALLOWED', 'SANITIZING', 'SANITIZED'], true)) { (new Publisher($this->s))->publish((int)$row['id'], (int)$row['revision']); delete_post_meta($attachmentId, '_cf_pending'); }
            else { update_post_meta($attachmentId, '_cf_pending', 1); if (!in_array($row['state'], ['PENDING_PROVIDER', 'CONTENT_SCANNING'], true)) { (new MediaWithdrawal($this->s))->enforce((int)$row['id'], (int)$row['revision']); } }
            } catch (\Throwable $e) {
                update_post_meta((int)$attachmentId, '_cf_pending', 1);
                $this->s->audit->record('library.item_failed', (int)$attachmentId, 0, ['code' => ScanService::errorCode($e)]);
            }
        }
        if (!$id && count($ids) === 25) { $after = (int)end($ids); $this->s->jobs->enqueue('library', ['after' => $after, 'batch' => $payload['batch'] ?? 'default'], 'library:' . ($payload['batch'] ?? 'default') . ':' . $after); }
    }
}
