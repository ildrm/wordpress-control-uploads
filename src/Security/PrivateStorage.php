<?php
declare(strict_types=1);
namespace ContentFirewall\Security;
final class PrivateStorage
{
    private string $root;
    /** @param list<string> $publicRoots */
    public function __construct(string $root, array $publicRoots = [])
    {
        if (!str_starts_with($root, '/') || is_link($root)) { throw new \RuntimeException('STORAGE.PRIVATE_ROOT'); }
        if (!is_dir($root) && !mkdir($root, 0700, true) && !is_dir($root)) { throw new \RuntimeException('STORAGE.CREATE'); }
        $resolved = realpath($root);
        if ($resolved === false || !is_writable($resolved) || (fileperms($resolved) & 0077) !== 0) { throw new \RuntimeException('STORAGE.PERMISSIONS'); }
        foreach ($publicRoots as $public) {
            $base = realpath($public);
            if ($base !== false && ($resolved === $base || str_starts_with($resolved . '/', rtrim($base, '/') . '/'))) { throw new \RuntimeException('STORAGE.PUBLIC_ROOT'); }
        }
        $this->root = $resolved;
    }
    public function put(string $source, int $siteId, ?string $expectedHash = null): string
    {
        if ($siteId < 1 || !is_file($source) || is_link($source)) { throw new \RuntimeException('STORAGE.SOURCE'); }
        $dir = $this->tenant($siteId);
        $id = bin2hex(random_bytes(32)); $dest = $dir . '/' . $id;
        $input = fopen($source, 'rb'); $output = fopen($dest, 'x+b');
        if (!$input || !$output) { if ($input) { fclose($input); } if ($output) { fclose($output); } throw new \RuntimeException('STORAGE.COPY'); }
        chmod($dest, 0600);
        try {
            if (stream_copy_to_stream($input, $output) === false || !fflush($output)) { throw new \RuntimeException('STORAGE.COPY'); }
        } catch (\Throwable $e) { unlink($dest); throw $e; }
        finally { fclose($input); fclose($output); }
        if ($expectedHash !== null && !hash_equals($expectedHash, (string)hash_file('sha256', $dest))) { unlink($dest); throw new \RuntimeException('STORAGE.HASH_CHANGED'); }
        return $id;
    }
    public function path(string $id, int $siteId): string
    {
        if ($siteId < 1 || !preg_match('/^[a-f0-9]{64}$/D', $id)) { throw new \RuntimeException('STORAGE.ID'); }
        $file = $this->root . '/' . $siteId . '/' . $id;
        if (is_link(dirname($file)) || is_link($file) || !is_file($file) || realpath(dirname($file)) !== $this->root . '/' . $siteId) { throw new \RuntimeException('STORAGE.NOT_FOUND'); }
        return $file;
    }
    public function delete(string $id, int $siteId): void { $path = $this->path($id, $siteId); if (!unlink($path)) { throw new \RuntimeException('STORAGE.DELETE'); } }
    public function temporary(int $siteId): string
    {
        $empty = tempnam($this->subdirectory($siteId, 'work'), 'work-');
        if ($empty === false) { throw new \RuntimeException('STORAGE.TEMP'); }
        chmod($empty, 0600); return $empty;
    }
    public function journalDirectory(int $siteId): string
    {
        return $this->subdirectory($siteId, 'operations');
    }
    public function workspace(int $siteId): string
    {
        $directory = $this->subdirectory($siteId, 'work') . '/work-' . bin2hex(random_bytes(12));
        if (!mkdir($directory, 0700)) { throw new \RuntimeException('STORAGE.TEMP'); } return $directory;
    }
    public function removeWorkspace(string $directory, int $siteId): void
    {
        $base = $this->subdirectory($siteId, 'work');
        if (is_link($directory) || realpath(dirname($directory)) !== $base || !preg_match('/^work-[a-zA-Z0-9]+$/D', basename($directory)) || realpath($directory) !== $directory) { throw new \RuntimeException('STORAGE.TEMP'); }
        $visited = 0;
        foreach (new \DirectoryIterator($directory) as $file) {
            if ($file->isDot()) { continue; }
            if (++$visited > 1000 || $file->isLink() || !$file->isFile() || !preg_match('/^[a-zA-Z0-9][a-zA-Z0-9_.-]{0,120}$/D', $file->getFilename()) || str_contains($file->getFilename(), '..') || !unlink($file->getPathname())) { throw new \RuntimeException('STORAGE.DELETE'); }
        }
        if (!rmdir($directory)) { throw new \RuntimeException('STORAGE.DELETE'); }
    }
    private function subdirectory(int $siteId, string $name): string
    {
        $directory = $this->tenant($siteId) . '/' . $name;
        if (is_link($directory) || (!is_dir($directory) && !mkdir($directory, 0700) && !is_dir($directory)) || realpath($directory) !== $directory || (fileperms($directory) & 0077) !== 0) { throw new \RuntimeException('STORAGE.PERMISSIONS'); }
        return $directory;
    }
    public function cleanupTemporary(int $siteId, int $limit = 100): int
    {
        $deleted = $visited = 0;
        foreach (new \DirectoryIterator($this->subdirectory($siteId, 'work')) as $entry) {
            if (++$visited > 1000 || $deleted >= max(1, min(1000, $limit))) { break; }
            if ($entry->isDot()) { continue; }
            if ($entry->isLink() || !preg_match('/^work-[a-zA-Z0-9]+$/D', $entry->getFilename())) { throw new \RuntimeException('STORAGE.TEMP'); }
            $modified = @filemtime($entry->getPathname());
            if ($modified !== false && $modified < time() - 86400) {
                if ($entry->isDir()) { $this->removeWorkspace($entry->getPathname(), $siteId); }
                elseif (!$entry->isFile() || (!@unlink($entry->getPathname()) && file_exists($entry->getPathname()))) { throw new \RuntimeException('STORAGE.DELETE'); }
                $deleted++;
            }
        }
        return $deleted;
    }
    /** Explicit uninstall cleanup; refuses unexpected paths instead of recursive blind deletion. */
    public function purgeTenant(int $siteId): void
    {
        $directory = $this->tenant($siteId);
        foreach (new \DirectoryIterator($directory) as $entry) {
            if ($entry->isDot()) { continue; }
            if ($entry->isLink()) { throw new \RuntimeException('STORAGE.TENANT'); }
            if (in_array($entry->getFilename(), ['operations', 'work'], true) && $entry->isDir()) {
                $operations = $this->subdirectory($siteId, $entry->getFilename());
                $pattern = $entry->getFilename() === 'operations' ? '/^(publish|withdraw)-\d+\.json$/D' : '/^work-[a-zA-Z0-9]+$/D';
                foreach (new \DirectoryIterator($operations) as $operation) {
                    if ($operation->isDot()) { continue; }
                    if ($entry->getFilename() === 'work' && $operation->isDir() && !$operation->isLink() && preg_match($pattern, $operation->getFilename())) { $this->removeWorkspace($operation->getPathname(), $siteId); }
                    elseif ($operation->isLink() || !$operation->isFile() || !preg_match($pattern, $operation->getFilename()) || !unlink($operation->getPathname())) { throw new \RuntimeException('STORAGE.DELETE'); }
                }
                if (!rmdir($operations)) { throw new \RuntimeException('STORAGE.DELETE'); }
            } elseif (!$entry->isFile() || !preg_match('/^(?:[a-f0-9]{64}|work-[a-zA-Z0-9]+)$/D', $entry->getFilename()) || !unlink($entry->getPathname())) { throw new \RuntimeException('STORAGE.DELETE'); }
        }
        if (!rmdir($directory)) { throw new \RuntimeException('STORAGE.DELETE'); }
    }
    private function tenant(int $siteId): string
    {
        if ($siteId < 1) { throw new \RuntimeException('STORAGE.TENANT'); }
        $directory = $this->root . '/' . $siteId;
        if (is_link($directory) || (!is_dir($directory) && !mkdir($directory, 0700) && !is_dir($directory)) || realpath($directory) !== $directory || (fileperms($directory) & 0077) !== 0) { throw new \RuntimeException('STORAGE.PERMISSIONS'); }
        return $directory;
    }
}
