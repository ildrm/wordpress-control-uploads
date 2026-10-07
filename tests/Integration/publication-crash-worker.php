<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
if (wp_get_environment_type() !== 'development' || !in_array($argv[3] ?? '', ['copied', 'committed'], true) || !function_exists('posix_kill')) { exit(2); }
wp_set_current_user(1); global $wpdb;
add_action('cf_internal_publication_checkpoint', static function (string $checkpoint) use ($argv): void { if ($checkpoint === $argv[3]) { posix_kill(getmypid(), 9); } });
$s = new ContentFirewall\Bootstrap\Services($wpdb);
(new ContentFirewall\Application\Publisher($s))->publish((int)$argv[1], (int)$argv[2]);
exit(3);
