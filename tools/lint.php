<?php
declare(strict_types=1);
$paths = ['src', 'includes', 'tests', 'tools', 'content-firewall.php', 'uninstall.php']; $failed = 0;
foreach ($paths as $path) {
    $files = is_dir($path) ? new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) : [$path];
    foreach ($files as $file) { $name = (string)$file; if (!str_ends_with($name, '.php')) { continue; } passthru(escapeshellarg(PHP_BINARY) . ' -l ' . escapeshellarg($name), $code); $failed += $code; }
}
exit($failed ? 1 : 0);
