<?php
declare(strict_types=1);
namespace ContentFirewall\Application;
use ContentFirewall\Bootstrap\Services;

/** Private, durable intent precedes irreversible local filesystem changes. */
final class MediaJournal
{
    public function __construct(private Services $s) {}

    public function write(string $kind, int $id, array $intent): void
    {
        $target = $this->file($kind, $id);
        $json = json_encode(['schema' => 1, 'site_id' => $this->s->siteId, 'kind' => $kind, 'id' => $id, 'intent' => $intent], JSON_THROW_ON_ERROR);
        if (strlen($json) > 65536) { throw new \RuntimeException('STORAGE.JOURNAL_LIMIT'); }
        $temporary = $this->s->storage->temporary($this->s->siteId);
        try {
            $stream = fopen($temporary, 'wb');
            if (!$stream) { throw new \RuntimeException('STORAGE.JOURNAL'); }
            try { if (fwrite($stream, $json) !== strlen($json) || !fflush($stream) || !fsync($stream)) { throw new \RuntimeException('STORAGE.JOURNAL'); } } finally { fclose($stream); }
            if (is_link($target) || !rename($temporary, $target)) { throw new \RuntimeException('STORAGE.JOURNAL'); }
        } finally { if (is_file($temporary)) { unlink($temporary); } }
    }

    public function read(string $kind, int $id): ?array
    {
        $file = $this->file($kind, $id);
        if (is_link($file)) { throw new \RuntimeException('STORAGE.JOURNAL'); }
        if (!is_file($file)) { return null; }
        if (filesize($file) > 65536) { throw new \RuntimeException('STORAGE.JOURNAL_LIMIT'); }
        $value = json_decode((string)file_get_contents($file), true, 16, JSON_THROW_ON_ERROR);
        if (($value['schema'] ?? null) !== 1 || ($value['site_id'] ?? null) !== $this->s->siteId || ($value['kind'] ?? null) !== $kind || ($value['id'] ?? null) !== $id || !is_array($value['intent'] ?? null)) { throw new \RuntimeException('STORAGE.JOURNAL'); }
        return $value['intent'];
    }

    public function clear(string $kind, int $id): void
    {
        $file = $this->file($kind, $id);
        if (is_link($file) || (is_file($file) && !unlink($file))) { throw new \RuntimeException('STORAGE.JOURNAL'); }
    }

    public function recover(int $limit = 25, ?int $onlyScan = null): array
    {
        $done = $failed = 0;
        foreach (new \DirectoryIterator($this->s->storage->journalDirectory($this->s->siteId)) as $entry) {
            if ($done + $failed >= max(1, min(100, $limit))) { break; }
            if (!preg_match('/^(publish|withdraw)-(\d+)\.json$/D', $entry->getFilename(), $match)) { continue; }
            if ($onlyScan !== null && ($match[1] !== 'publish' || (int)$match[2] !== $onlyScan)) { continue; }
            $kind = $match[1]; $id = (int)$match[2]; $lock = ($kind === 'publish' ? 'cf-publish-' : 'cf-media-') . $this->s->siteId . '-' . $id;
            if ((int)$this->s->db->get_var($this->s->db->prepare('SELECT GET_LOCK(%s,0)', $lock)) !== 1) { continue; }
            try {
                $intent = $this->read($kind, $id); if ($intent === null) { continue; }
                if ($kind === 'withdraw') { (new MediaWithdrawal($this->s))->removePlanned($id, $intent); }
                else {
                    $path = $this->publicPath($intent['path']);
                    if (!preg_match('/^cf-[a-f0-9]{24}-/', basename($path), $prefix)) { throw new \RuntimeException('STORAGE.JOURNAL'); }
                    try { $row = $this->s->scans->get($id); } catch (\RuntimeException $e) { if ($e->getMessage() !== 'DATABASE.NOT_FOUND') { throw $e; } $row = ['attachment_id' => 0, 'state' => 'DELETED']; }
                    $attachment = (int)$row['attachment_id']; $current = $attachment ? get_attached_file($attachment, true) : '';
                    // Core may change the attached path to a -scaled derivative during metadata generation.
                    $sameFamily = is_string($current) && dirname($current) === dirname($path) && str_starts_with(basename($current), $prefix[0]);
                    $committed = $attachment && $sameFamily && in_array($row['state'], ['ALLOWED', 'SANITIZED'], true) && (int)get_post_meta($attachment, '_cf_published_scan', true) === $id;
                    if ($committed) {
                        $mediaLock = 'cf-media-' . $this->s->siteId . '-' . $attachment;
                        if ((int)$this->s->db->get_var($this->s->db->prepare('SELECT GET_LOCK(%s,0)', $mediaLock)) !== 1) { continue; }
                        try {
                            if (!is_file($path)) { throw new \RuntimeException('STORAGE.PUBLIC_COPY'); }
                            require_once ABSPATH . 'wp-admin/includes/image.php';
                            wp_update_attachment_metadata($attachment, wp_generate_attachment_metadata($attachment, $path));
                            delete_post_meta($attachment, '_cf_pending');
                        } finally { $this->s->db->get_var($this->s->db->prepare('SELECT RELEASE_LOCK(%s)', $mediaLock)); }
                    } else {
                        foreach (new \DirectoryIterator(dirname($path)) as $file) {
                            if (!str_starts_with($file->getFilename(), $prefix[0])) { continue; }
                            $candidate = $this->publicPath($this->relative($file->getPathname()));
                            if (is_file($candidate) && !unlink($candidate)) { throw new \RuntimeException('STORAGE.MEDIA_WITHDRAWAL'); }
                        }
                    }
                }
                $this->s->audit->record('media.recovered', $kind === 'publish' ? $id : 0, 0, ['action' => $kind]);
                $this->clear($kind, $id); $done++;
            } catch (\Throwable $e) {
                $failed++;
                try { $this->s->audit->record('media.recovery_failed', $kind === 'publish' ? $id : 0, 0, ['code' => ScanService::errorCode($e)]); } catch (\Throwable) {}
            } finally { $this->s->db->get_var($this->s->db->prepare('SELECT RELEASE_LOCK(%s)', $lock)); }
        }
        return ['recovered' => $done, 'failed' => $failed];
    }

    public function relative(string $path): string
    {
        $base = realpath(wp_get_upload_dir()['basedir']);
        if (!$base || !str_starts_with($path, $base . '/')) { throw new \RuntimeException('SECURITY.MEDIA_LOCATION'); }
        $relative = substr($path, strlen($base) + 1); $this->publicPath($relative); return $relative;
    }

    public function publicPath(string $relative): string
    {
        $base = realpath(wp_get_upload_dir()['basedir']);
        if (!$base || $relative === '' || preg_match('~(^/|(^|/)\.\.?(/|$)|[\\\\\x00-\x1f])~', $relative)) { throw new \RuntimeException('SECURITY.MEDIA_LOCATION'); }
        $path = $base . '/' . $relative; $parent = realpath(dirname($path));
        if (!$parent || ($parent !== $base && !str_starts_with($parent, $base . '/')) || is_link($path) || (file_exists($path) && !is_file($path))) { throw new \RuntimeException('SECURITY.MEDIA_LOCATION'); }
        return $path;
    }

    private function file(string $kind, int $id): string
    {
        if ($this->s->siteId !== get_current_blog_id() || !in_array($kind, ['publish', 'withdraw'], true) || $id < 1) { throw new \RuntimeException('SECURITY.TENANT'); }
        return $this->s->storage->journalDirectory($this->s->siteId) . '/' . $kind . '-' . $id . '.json';
    }
}
