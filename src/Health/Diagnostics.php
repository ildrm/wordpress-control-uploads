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
        $queue = $this->s->jobs->status(); $issues = []; $recovery = 0;
        foreach (new \DirectoryIterator($this->s->storage->journalDirectory($this->s->siteId)) as $entry) { if (preg_match('/^(publish|withdraw)-\d+\.json$/D', $entry->getFilename())) { $recovery++; if ($recovery >= 1000) { break; } } }
        foreach ($queue as $group) { if ($group['status'] === 'dead' && (int)$group['count'] > 0) { $issues[] = 'QUEUE.DEAD_JOBS'; } }
        if (($this->s->jobs->depth() > 0 || $recovery > 0) && (int)get_option('cf_worker_last_run', 0) < time() - 300) { $issues[] = 'QUEUE.WORKER_STALE'; }
        if ($this->s->settings['require_malware'] && Services::secret('CF_CLAMD_SOCKET') === '') { $issues[] = 'CONFIGURATION.MALWARE_REQUIRED'; }
        if (wp_get_environment_type() === 'production' && !defined('CF_PRIVATE_DIR')) { $issues[] = 'CONFIGURATION.PRIVATE_STORAGE_REQUIRED'; }
        foreach (['cf_worker_error', 'cf_retention_error', 'cf_recovery_error', 'cf_migration_error'] as $key) { if (get_option($key)) { $issues[] = 'CONFIGURATION.OPERATION_FAILED'; } }
        if ((int)get_option('cf_schema_version', 0) !== \ContentFirewall\Persistence\Tables::VERSION) { $issues[] = 'DATABASE.MIGRATION_REQUIRED'; }
        $processors = [];
        foreach (['documents' => ['CF_PDFINFO_BIN', 'CF_PDFTOPPM_BIN', 'CF_PDFTOTEXT_BIN'], 'temporal' => ['CF_FFMPEG_BIN', 'CF_FFPROBE_BIN'], 'provenance' => ['CF_C2PA_BIN']] as $kind => $names) {
            $configured = $executable = true;
            foreach ($names as $name) { $path = Services::secret($name); $configured = $configured && $path !== ''; $executable = $executable && str_starts_with($path, '/') && is_file($path) && is_executable($path); }
            $processors[$kind] = ['enabled' => $this->s->settings['enable_' . $kind], 'configured' => $configured, 'executable' => $executable];
            if ($processors[$kind]['enabled'] && !$executable) { $issues[] = 'CONFIGURATION.PROCESSOR_REQUIRED'; }
        }
        return ['plugin' => '0.1.0', 'wordpress' => $wp_version, 'php' => PHP_VERSION, 'database' => $this->s->db->db_version(), 'schema' => (int)get_option('cf_schema_version', 0), 'environment' => wp_get_environment_type(), 'site_id' => $this->s->siteId, 'queue' => $queue, 'worker_last_run' => (int)get_option('cf_worker_last_run', 0), 'recovery_operations' => $recovery, 'issues' => array_values(array_unique($issues)), 'processors' => $processors, 'providers' => $this->s->router->status(), 'extensions' => array_map('extension_loaded', array_combine(['gd', 'curl', 'fileinfo', 'sodium', 'zip', 'dom'], ['gd', 'curl', 'fileinfo', 'sodium', 'zip', 'dom'])), 'malware_configured' => Services::secret('CF_CLAMD_SOCKET') !== '', 'malware_required' => (bool)($this->s->settings['require_malware'] ?? false), 'persistent_private_storage' => defined('CF_PRIVATE_DIR'), 'cron_enabled' => !defined('DISABLE_WP_CRON') || !DISABLE_WP_CRON];
    }
    public function siteHealth(): array
    {
        $stale = (bool)$this->report()['issues'];
        return ['label' => $stale ? __('Content Firewall worker needs attention', 'content-firewall') : __('Content Firewall queue is operational', 'content-firewall'), 'status' => $stale ? 'critical' : 'good', 'badge' => ['label' => __('Security', 'content-firewall'), 'color' => 'blue'], 'description' => '<p>' . esc_html__('Run the worker using system cron for predictable moderation latency.', 'content-firewall') . '</p>', 'actions' => '', 'test' => 'content_firewall'];
    }
}
