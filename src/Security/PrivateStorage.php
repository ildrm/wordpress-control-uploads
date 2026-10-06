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
        $dir = $this->root . '/' . $siteId;
        if (is_link($dir) || (!is_dir($dir) && !mkdir($dir, 0700))) { throw new \RuntimeException('STORAGE.TENANT'); }
        if ((fileperms($dir) & 0077) !== 0) { throw new \RuntimeException('STORAGE.PERMISSIONS'); }
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
        $empty = tempnam($this->root, 'work-');
        if ($empty === false) { throw new \RuntimeException('STORAGE.TEMP'); }
        chmod($empty, 0600); return $empty;
    }
}
