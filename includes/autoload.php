<?php
declare(strict_types=1);
// Allow isolated CLI tools; web requests must enter through WordPress.
if (!defined('ABSPATH') && PHP_SAPI !== 'cli') { exit; }
// Development can use Composer; releases load the same PSR-4 tree without vendor.
if (is_file(dirname(__DIR__) . '/vendor/autoload.php')) {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
} else {
    spl_autoload_register(static function (string $class): void {
        $prefix = 'ContentFirewall\\';
        if (str_starts_with($class, $prefix)) {
            $file = dirname(__DIR__) . '/src/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
            if (is_file($file)) { require $file; }
        }
    });
}
