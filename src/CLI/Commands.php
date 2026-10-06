<?php
declare(strict_types=1);
namespace ContentFirewall\CLI;
use ContentFirewall\Bootstrap\Services;
final class Commands
{
    /** @param callable():Services $factory */
    public function __construct(private $factory) {}
    public function register(): void
    {
        $commands = ['health', 'diagnostics', 'queue status', 'worker run', 'scan attachment', 'scan library', 'policy export', 'policy import', 'database status', 'database migrate', 'network provision', 'rescan policy', 'provider test'];
        foreach ($commands as $command) {
            \WP_CLI::add_command('content-firewall ' . $command, function (array $args, array $assoc) use ($command): void {
                try { $result = $this->execute($command, $args, $assoc); \WP_CLI::line(json_encode($result, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT)); }
                catch (\Throwable $e) { \WP_CLI::error(\ContentFirewall\Application\ScanService::errorCode($e)); }
            });
        }
    }
    public function execute(string $command, array $args, array $assoc): array
    {
        $s = ($this->factory)();
        if ($command === 'health' || $command === 'diagnostics') { return (new \ContentFirewall\Health\Diagnostics($s))->report(); }
        if ($command === 'queue status') { return $s->jobs->status(); }
        if ($command === 'worker run') { return (new \ContentFirewall\Queue\Worker($s))->run((int)($assoc['limit'] ?? 20), (int)($assoc['seconds'] ?? 25)); }
        if ($command === 'scan attachment') {
            $id = (int)($args[0] ?? 0); if (!$id || get_post_type($id) !== 'attachment') { throw new \RuntimeException('VALIDATION.ATTACHMENT'); }
            $s->jobs->enqueue('library', ['attachment_id' => $id], 'cli:attachment:' . $id . ':' . time()); return ['queued' => $id];
        }
        if ($command === 'scan library') { $batch = bin2hex(random_bytes(16)); $s->jobs->enqueue('library', ['after' => 0, 'batch' => $batch], 'cli:library:' . $batch); return ['queued' => true]; }
        if ($command === 'policy export') { return $s->policies->active()->toArray(); }
        if ($command === 'policy import') {
            $file = $args[0] ?? ''; if (!is_file($file) || filesize($file) > 262144) { throw new \RuntimeException('VALIDATION.POLICY_FILE'); }
            return $s->policies->save(json_decode((string)file_get_contents($file), true, 32, JSON_THROW_ON_ERROR), get_current_user_id())->toArray();
        }
        if ($command === 'database status') { return ['schema' => (int)get_option('cf_schema_version', 0)]; }
        if ($command === 'database migrate') { $s->tables->migrate(); return ['schema' => 1]; }
        if ($command === 'rescan policy') {
            $after = (int)($assoc['after'] ?? 0); $count = 0;
            foreach ($s->scans->page($after, 100) as $row) { $s->scanner->rescan((int)$row['id']); $count++; $after = (int)$row['id']; } return ['queued' => $count, 'after' => $after];
        }
        if ($command === 'network provision') {
            if (!is_multisite()) { throw new \RuntimeException('CONFIGURATION.MULTISITE_REQUIRED'); }
            $cursor = (int)get_site_option('cf_network_provision_cursor', 0); global $wpdb;
            $ids = $wpdb->get_col($wpdb->prepare('SELECT blog_id FROM %i WHERE blog_id>%d ORDER BY blog_id LIMIT 100', $wpdb->blogs, $cursor));
            foreach ($ids as $id) { switch_to_blog((int)$id); try { \ContentFirewall\WordPress\Lifecycle::site($wpdb); } finally { restore_current_blog(); } }
            if ($ids) { $cursor = (int)end($ids); update_site_option('cf_network_provision_cursor', $cursor); } return ['provisioned' => count($ids), 'cursor' => $cursor];
        }
        if ($command === 'provider test') {
            $providers = $s->router->status(); return ['configured' => $providers, 'note' => 'Use a lawful sample and the provider contract suite for live validation. No live request was made.'];
        }
        throw new \RuntimeException('VALIDATION.COMMAND');
    }
}
