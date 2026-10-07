<?php
declare(strict_types=1);
namespace ContentFirewall\WordPress;
use ContentFirewall\Persistence\Tables;
final class Lifecycle
{
    public const CAPS = ['manage_content_firewall', 'manage_content_firewall_policies', 'manage_content_firewall_providers', 'review_content_firewall_queue', 'reveal_sensitive_content', 'view_content_firewall_audit', 'view_content_firewall_analytics', 'manage_content_firewall_integrations'];
    public static function activate(bool $networkWide = false): void
    {
        global $wpdb;
        if ($networkWide && is_multisite()) {
            // Large networks provision through wp_initialize_site / CLI; never block frontend migrations.
            $ids = get_sites(['fields' => 'ids', 'number' => 100]);
            foreach ($ids as $id) { switch_to_blog((int)$id); try { self::site($wpdb); } finally { restore_current_blog(); } }
            update_site_option('cf_network_provision_cursor', $ids ? max($ids) : 0); return;
        }
        self::site($wpdb);
    }
    public static function site(\wpdb $db): void
    {
        self::requirements();
        (new Tables($db))->migrate(); $admin = get_role('administrator');
        if ($admin) { foreach (self::CAPS as $cap) { $admin->add_cap($cap); } }
        if (!wp_next_scheduled('cf_worker_tick')) { wp_schedule_event(time() + 60, 'cf_minute', 'cf_worker_tick'); }
        if (!wp_next_scheduled('cf_retention_tick')) { wp_schedule_event(time() + HOUR_IN_SECONDS, 'daily', 'cf_retention_tick'); }
        add_option('cf_settings', \ContentFirewall\Configuration\Settings::DEFAULTS, '', false);
    }
    public static function requirements(): void
    {
        foreach (['fileinfo', 'mbstring', 'sodium'] as $extension) { if (!extension_loaded($extension)) { throw new \RuntimeException('CONFIGURATION.PHP_EXTENSIONS'); } }
    }
    public static function deactivate(bool $networkWide = false): void
    {
        if ($networkWide && is_multisite()) {
            $offset = 0;
            do { $ids = get_sites(['fields' => 'ids', 'number' => 100, 'offset' => $offset]); foreach ($ids as $id) { switch_to_blog((int)$id); wp_clear_scheduled_hook('cf_worker_tick'); wp_clear_scheduled_hook('cf_retention_tick'); restore_current_blog(); } $offset += 100; } while (count($ids) === 100);
        } else { wp_clear_scheduled_hook('cf_worker_tick'); wp_clear_scheduled_hook('cf_retention_tick'); }
    }
}
