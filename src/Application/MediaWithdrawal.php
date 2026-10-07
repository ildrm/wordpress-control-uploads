<?php
declare(strict_types=1);
namespace ContentFirewall\Application;
use ContentFirewall\Bootstrap\Services;
/** Removes local public derivatives; the private original remains available for reapproval. */
final class MediaWithdrawal
{
    public function __construct(private Services $s) {}
    public function enforce(int $scanId, int $revision): void
    {
        $db = $this->s->db; $lock = 'cf-publish-' . $this->s->siteId . '-' . $scanId;
        if ((int)$db->get_var($db->prepare('SELECT GET_LOCK(%s,0)', $lock)) !== 1) { throw new \RuntimeException('QUEUE.PUBLICATION_BUSY'); }
        $db->query('START TRANSACTION');
        try {
            $row = $this->s->scans->lock($scanId, $revision);
            if (!in_array($row['state'], ['ALLOWED', 'SANITIZED'], true)) { $this->withdraw((int)$row['attachment_id'], $scanId); }
            if ($db->query('COMMIT') === false) { throw new \RuntimeException('DATABASE.COMMIT'); }
        } catch (\Throwable $e) { $db->query('ROLLBACK'); throw $e; }
        finally { $db->get_var($db->prepare('SELECT RELEASE_LOCK(%s)', $lock)); }
    }
    public function withdraw(int $attachmentId, ?int $scanId = null): void
    {
        if ($this->s->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        if (!$attachmentId || !get_post($attachmentId)) { return; }
        $lock = 'cf-media-' . $this->s->siteId . '-' . $attachmentId;
        if ((int)$this->s->db->get_var($this->s->db->prepare('SELECT GET_LOCK(%s,0)', $lock)) !== 1) { throw new \RuntimeException('QUEUE.PUBLICATION_BUSY'); }
        try {
        if ($scanId !== null && (int)($this->s->scans->latest($attachmentId)['id'] ?? 0) !== $scanId) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
        $journal = new MediaJournal($this->s); $planned = $journal->read('withdraw', $attachmentId);
        if ($planned !== null) { $this->removePlanned($attachmentId, $planned); return; }
        $file = get_attached_file($attachmentId, true);
        if (!$file || (!is_file($file) && !get_post_meta($attachmentId, '_cf_local_withdrawn', true))) { throw new \RuntimeException('SECURITY.MEDIA_LOCATION'); }
        $meta = get_post_meta($attachmentId, '_wp_attachment_metadata', true);
        if (!is_array($meta)) { $meta = []; }
        $paths = [$file]; $directory = dirname($file);
        foreach ($meta as $key => $value) { if (in_array($key, ['thumb', 'original_image', 'source_image'], true) && $value !== '') { $paths[] = $directory . '/' . $this->name($value); } }
        foreach (array_merge($meta['sizes'] ?? [], get_post_meta($attachmentId, '_wp_attachment_backup_sizes', true) ?: []) as $size) {
            if (!empty($size['file'])) { $paths[] = $directory . '/' . $this->name($size['file']); }
        }
        $base = realpath(wp_get_upload_dir()['basedir']);
        if (!$base) { throw new \RuntimeException('SECURITY.MEDIA_LOCATION'); }
        $relative = get_post_meta($attachmentId, '_wp_attached_file', true);
        $shared = $this->s->db->get_var($this->s->db->prepare("SELECT COUNT(*) FROM %i WHERE meta_key='_wp_attached_file' AND meta_value=%s AND post_id<>%d", $this->s->db->postmeta, $relative, $attachmentId));
        if ($this->s->db->last_error !== '') { throw new \RuntimeException('DATABASE.MEDIA'); }
        if ((int)$shared > 0) { throw new \RuntimeException('SECURITY.SHARED_MEDIA'); }
        $paths = array_unique($paths);
        foreach ($paths as $path) {
            if (is_link($path)) { throw new \RuntimeException('SECURITY.MEDIA_LOCATION'); }
            if (!file_exists($path)) { continue; }
            $real = realpath($path);
            if (!$real || !str_starts_with($real, $base . '/') || !is_file($real) || !is_writable(dirname($real))) { throw new \RuntimeException('SECURITY.MEDIA_LOCATION'); }
        }
        $hashes = [];
        foreach ($paths as $path) { $relative = $journal->relative($path); $hashes[$relative] = is_file($path) ? hash_file('sha256', $path) : null; }
        $planned = ['source' => $journal->relative($file), 'paths' => array_map([$journal, 'relative'], array_values($paths)), 'hashes' => $hashes];
        $journal->write('withdraw', $attachmentId, $planned);
        $this->removePlanned($attachmentId, $planned);
        } finally { $this->s->db->get_var($this->s->db->prepare('SELECT RELEASE_LOCK(%s)', $lock)); }
    }
    public function removePlanned(int $attachmentId, array $intent): void
    {
        if ($this->s->siteId !== get_current_blog_id() || !is_array($intent['paths'] ?? null) || !is_array($intent['hashes'] ?? null) || count($intent['paths']) > 1000 || !is_string($intent['source'] ?? null)) { throw new \RuntimeException('STORAGE.JOURNAL'); }
        $journal = new MediaJournal($this->s); $paths = [];
        foreach ($intent['paths'] as $path) {
            if (!is_string($path)) { throw new \RuntimeException('STORAGE.JOURNAL'); }
            $candidate = $journal->publicPath($path); $hash = $intent['hashes'][$path] ?? null;
            if (is_file($candidate) && (!is_string($hash) || !hash_equals($hash, (string)hash_file('sha256', $candidate)))) { throw new \RuntimeException('SECURITY.MEDIA_CHANGED'); }
            $paths[] = $candidate;
        }
        foreach ($paths as $path) { if (is_file($path) && !unlink($path)) { throw new \RuntimeException('STORAGE.MEDIA_WITHDRAWAL'); } }
        if (get_attached_file($attachmentId, true) === $journal->publicPath($intent['source'])) {
            update_post_meta($attachmentId, '_cf_local_withdrawn', 1); update_post_meta($attachmentId, '_cf_pending', 1);
        }
    }
    private function name(mixed $name): string
    {
        if (!is_string($name) || $name === '' || basename($name) !== $name || str_contains($name, '\\') || str_contains($name, '..')) { throw new \RuntimeException('SECURITY.MEDIA_LOCATION'); }
        return $name;
    }
}
