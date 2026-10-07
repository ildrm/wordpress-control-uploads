<?php
declare(strict_types=1);
namespace ContentFirewall\Bootstrap;
final class Plugin
{
    private array $instances = [];
    public function __construct(private string $file) {}
    public function services(): Services
    {
        global $wpdb; $site = get_current_blog_id();
        $settings = (new \ContentFirewall\Configuration\Settings())->parse(get_option('cf_settings', []));
        if (!isset($this->instances[$site]) || $this->instances[$site]->settings !== $settings) { $this->instances[$site] = new Services($wpdb); }
        return $this->instances[$site];
    }
    public function register(): void
    {
        if ((is_admin() || (defined('WP_CLI') && WP_CLI)) && (int)get_option('cf_schema_version', 0) !== \ContentFirewall\Persistence\Tables::VERSION) {
            global $wpdb;
            try { \ContentFirewall\WordPress\Lifecycle::site($wpdb); delete_option('cf_migration_error'); }
            catch (\Throwable) { update_option('cf_migration_error', 'DATABASE.MIGRATION', false); }
        }
        $factory = fn(): Services => $this->services();
        (new \ContentFirewall\WordPress\UploadGateway($factory))->register();
        (new \ContentFirewall\WordPress\PublicationGate($factory))->register();
        add_action('rest_api_init', static fn() => (new \ContentFirewall\REST\Controller($factory))->register());
        add_action('cf_worker_tick', static function () use ($factory): void { try { (new \ContentFirewall\Queue\Worker($factory()))->run(10, 20); delete_option('cf_worker_error'); } catch (\Throwable) { update_option('cf_worker_error', 'CONFIGURATION.WORKER', false); } });
        add_action('cf_retention_tick', static function () use ($factory): void { try { (new \ContentFirewall\Application\Retention($factory()))->run(); delete_option('cf_retention_error'); } catch (\Throwable) { update_option('cf_retention_error', 'STORAGE.RETENTION', false); } });
        add_filter('site_status_tests', static function (array $tests) use ($factory): array { $tests['direct']['content_firewall'] = ['label' => __('Content Firewall', 'content-firewall'), 'test' => static function () use ($factory): array {
            try { return (new \ContentFirewall\Health\Diagnostics($factory()))->siteHealth(); }
            catch (\Throwable) { return ['label' => __('Content Firewall configuration needs attention', 'content-firewall'), 'status' => 'critical', 'badge' => ['label' => __('Security', 'content-firewall'), 'color' => 'blue'], 'description' => '<p>' . esc_html__('Required configuration or private storage is unavailable. Uploads remain held until it is restored.', 'content-firewall') . '</p>', 'actions' => '', 'test' => 'content_firewall']; }
        }]; return $tests; });
        (new \ContentFirewall\WordPress\PrivacyTools($factory))->register();
        add_action('init', static function () use ($factory): void {
            $gate = new \ContentFirewall\WordPress\PublicationGate($factory);
            foreach (get_post_types(['show_in_rest' => true]) as $type) { if ($type !== 'attachment') { add_filter('rest_pre_insert_' . $type, [$gate, 'check'], 10, 2); } }
        }, 20);
        $basename = plugin_basename($this->file);
        add_action('wp_initialize_site', static function (\WP_Site $site) use ($basename): void { if (!is_plugin_active_for_network($basename)) { return; } global $wpdb; switch_to_blog((int)$site->blog_id); try { \ContentFirewall\WordPress\Lifecycle::site($wpdb); } finally { restore_current_blog(); } }, 200);
        if (is_admin()) { (new \ContentFirewall\Admin\App($this->file, $factory))->register(); }
        if (defined('WP_CLI') && WP_CLI) { (new \ContentFirewall\CLI\Commands($factory))->register(); }
    }
}
