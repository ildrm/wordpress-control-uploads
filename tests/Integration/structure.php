<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
require_once ABSPATH . 'wp-admin/includes/plugin.php';
$passed = 0;
$check = static function (bool $ok, string $label) use (&$passed): void {
    if (!$ok) { throw new RuntimeException('FAIL: ' . $label); }
    $passed++; echo 'PASS: ' . $label . PHP_EOL;
};
wp_clean_plugins_cache();
$plugins = get_plugins('/content-firewall');
$check(array_keys($plugins) === ['content-firewall.php'], 'WordPress discovers exactly one slug-named plugin entry');
$data = $plugins['content-firewall.php'];
$check($data['Name'] === 'Content Firewall' && $data['TextDomain'] === 'content-firewall' && $data['DomainPath'] === '/languages', 'Plugin name and translation metadata match the slug');
$check($data['Author'] === 'Shahin Ilderemi' && $data['AuthorURI'] === 'https://ildrm.com', 'WordPress reads the preserved single author header');
$license = get_file_data(WP_PLUGIN_DIR . '/content-firewall/content-firewall.php', ['License' => 'License', 'LicenseURI' => 'License URI']);
$check($license['License'] === 'GPL-2.0-or-later' && $license['LicenseURI'] === 'https://www.gnu.org/licenses/gpl-2.0.html', 'WordPress file-header parser reads the GPL license and URL');
$check($data['RequiresWP'] === '6.8' && $data['RequiresPHP'] === '8.2', 'WordPress reads the supported runtime requirements');
$check(is_plugin_active('content-firewall/content-firewall.php'), 'The renamed plugin has the correct active basename');
$check(has_action('activate_content-firewall/content-firewall.php', [ContentFirewall\WordPress\Lifecycle::class, 'activate']) !== false && has_action('deactivate_content-firewall/content-firewall.php', [ContentFirewall\WordPress\Lifecycle::class, 'deactivate']) !== false, 'Lifecycle callbacks register against the renamed entry');
$check(wp_next_scheduled('cf_worker_tick') !== false && wp_next_scheduled('cf_retention_tick') !== false, 'Activation schedules worker and retention hooks');
wp_set_current_user(1);
(new ContentFirewall\Admin\App(WP_PLUGIN_DIR . '/content-firewall/content-firewall.php', static function (): ContentFirewall\Bootstrap\Services { global $wpdb; return new ContentFirewall\Bootstrap\Services($wpdb); }))->assets('toplevel_page_content-firewall');
$script = wp_scripts()->registered['cf-admin']; $style = wp_styles()->registered['cf-admin'];
$check(str_ends_with($script->src, '/content-firewall/assets/js/admin.js') && str_ends_with($style->src, '/content-firewall/assets/css/admin.css'), 'Enqueued scripts and styles use their dedicated asset directories');
$check(in_array('wp-element', $script->deps, true) && in_array('wp-components', $style->deps, true), 'Assets keep their WordPress runtime dependencies');
echo json_encode(['structure_assertions' => $passed, 'wordpress' => $GLOBALS['wp_version'], 'php' => PHP_VERSION], JSON_THROW_ON_ERROR) . PHP_EOL;
