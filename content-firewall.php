<?php
/**
 * Plugin Name: Content Firewall
 * Description: Private upload governance, explainable moderation, and file security.
 * Version: 0.1.0
 * Author: Shahin Ilderemi
 * Author URI: https://ildrm.com
 * Requires at least: 6.8
 * Requires PHP: 8.2
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: content-firewall
 * Domain Path: /languages
 */
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }
require_once __DIR__ . '/includes/autoload.php';
add_filter('cron_schedules', static function (array $schedules): array {
    $schedules['cf_minute'] = ['interval' => 60, 'display' => __('Every minute', 'content-firewall')];
    return $schedules;
});
register_activation_hook(__FILE__, [ContentFirewall\WordPress\Lifecycle::class, 'activate']);
register_deactivation_hook(__FILE__, [ContentFirewall\WordPress\Lifecycle::class, 'deactivate']);
add_action('plugins_loaded', static function (): void {
    (new ContentFirewall\Bootstrap\Plugin(__FILE__))->register();
});
