<?php
declare(strict_types=1);
if (!defined('WP_UNINSTALL_PLUGIN')) { exit; }
require_once __DIR__ . '/includes/autoload.php';
// Audit and private media are retained unless the operator explicitly opted into removal.
$remove = static function (): void {
    $settings = get_option('cf_settings', []); if (!($settings['delete_on_uninstall'] ?? false)) { return; }
    global $wpdb; $tables = new ContentFirewall\Persistence\Tables($wpdb);
    $services = new ContentFirewall\Bootstrap\Services($wpdb);
    $after = 0;
    do {
        $rows = $wpdb->get_results($wpdb->prepare("SELECT id,private_key FROM %i WHERE id>%d AND private_key<>'' ORDER BY id LIMIT 100", $tables->name('scans'), $after), ARRAY_A);
        foreach ($rows as $row) { $after = (int)$row['id']; try { $services->storage->delete($row['private_key'], get_current_blog_id()); } catch (RuntimeException $e) { if ($e->getMessage() !== 'STORAGE.NOT_FOUND') { throw $e; } } }
    } while (count($rows) === 100);
    do { $recovery = (new ContentFirewall\Application\MediaJournal($services))->recover(100); if ($recovery['failed']) { throw new RuntimeException('STORAGE.JOURNAL'); } } while ($recovery['recovered'] > 0);
    $services->storage->purgeTenant(get_current_blog_id());
    foreach (['scans', 'findings', 'policies', 'jobs', 'cases', 'case_notes', 'appeals', 'audit', 'usage', 'fingerprints', 'cache', 'events', 'limits', 'evaluations'] as $suffix) { $wpdb->query($wpdb->prepare('DROP TABLE IF EXISTS %i', $tables->name($suffix))); }
    delete_metadata('user', 0, 'cf_queue_views_' . get_current_blog_id(), '', true);
    foreach (['cf_settings', 'cf_schema_version', 'cf_active_policy', 'cf_worker_last_run', 'cf_worker_error', 'cf_retention_error', 'cf_recovery_error', 'cf_migration_error', 'cf_onboarding_step'] as $key) { delete_option($key); }
    $role = get_role('administrator'); if ($role) { foreach (ContentFirewall\WordPress\Lifecycle::CAPS as $cap) { $role->remove_cap($cap); } }
};
if (is_multisite()) { $offset = 0; do { $ids = get_sites(['fields' => 'ids', 'number' => 100, 'offset' => $offset]); foreach ($ids as $id) { switch_to_blog((int)$id); try { $remove(); } finally { restore_current_blog(); } } $offset += 100; } while (count($ids) === 100); } else { $remove(); }
