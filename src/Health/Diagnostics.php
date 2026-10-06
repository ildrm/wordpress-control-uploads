<?php
declare(strict_types=1);
namespace ContentFirewall\Health;
use ContentFirewall\Bootstrap\Services;
final class Diagnostics
{
    public function __construct(private Services $s) {}
    public function report(): array
    {
        global $wp_version;
        return ['plugin' => '0.1.0', 'wordpress' => $wp_version, 'php' => PHP_VERSION, 'database' => $this->s->db->db_version(), 'schema' => (int)get_option('cf_schema_version', 0), 'environment' => wp_get_environment_type(), 'site_id' => $this->s->siteId, 'queue' => $this->s->jobs->status(), 'worker_last_run' => (int)get_option('cf_worker_last_run', 0), 'providers' => $this->s->router->status(), 'extensions' => array_map('extension_loaded', array_combine(['gd', 'curl', 'fileinfo', 'sodium', 'zip', 'dom'], ['gd', 'curl', 'fileinfo', 'sodium', 'zip', 'dom'])), 'malware_configured' => Services::secret('CF_CLAMD_SOCKET') !== '', 'malware_required' => (bool)($this->s->settings['require_malware'] ?? false), 'persistent_private_storage' => defined('CF_PRIVATE_DIR'), 'cron_enabled' => !defined('DISABLE_WP_CRON') || !DISABLE_WP_CRON];
    }
    public function siteHealth(): array
    {
        $stale = $this->s->jobs->depth() > 0 && (int)get_option('cf_worker_last_run', 0) < time() - 300;
        return ['label' => $stale ? __('Content Firewall worker needs attention', 'content-firewall') : __('Content Firewall queue is operational', 'content-firewall'), 'status' => $stale ? 'critical' : 'good', 'badge' => ['label' => __('Security', 'content-firewall'), 'color' => 'blue'], 'description' => '<p>' . esc_html__('Run the worker using system cron for predictable moderation latency.', 'content-firewall') . '</p>', 'actions' => '', 'test' => 'content_firewall'];
    }
}
