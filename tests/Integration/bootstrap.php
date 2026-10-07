<?php
declare(strict_types=1);
// Standalone CLI fixtures also need a host to select the intended multisite blog.
$_SERVER['HTTP_HOST'] = getenv('CF_TEST_HOST') ?: ($_SERVER['HTTP_HOST'] ?? 'localhost:8887');
$_SERVER['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ?? '/';
if (!defined('ABSPATH')) { require (getenv('CF_WP_ROOT') ?: '/var/www/html') . '/wp-load.php'; }
if (wp_get_environment_type() !== 'development') { throw new RuntimeException('Disposable development fixture required'); }
