<?php
// Static analysis only. Never included by the plugin runtime.
define('ABSPATH', '/wordpress/'); define('ARRAY_A', 'ARRAY_A'); define('DAY_IN_SECONDS', 86400); define('HOUR_IN_SECONDS', 3600); define('CF_AUDIT_KEY', 'analysis-only-key-not-for-runtime-0000'); define('CF_PRIVATE_DIR', '/private'); define('WP_CLI', true); define('DISABLE_WP_CRON', false);
class WP_CLI { public static function add_command(string $name, callable $callable): void {} public static function line(string $line): void {} public static function error(string $message): void {} }
