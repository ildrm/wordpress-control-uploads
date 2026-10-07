<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
if (wp_get_environment_type() !== 'development') { throw new RuntimeException('Development only'); }
use ContentFirewall\Persistence\Tables;
global $wpdb; $saved = get_option('cf_schema_version'); $passed = 0;
$fixture = new wpdb(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST); $prefix = 'cf_migration_fixture_' . bin2hex(random_bytes(5)) . '_'; $fixture->set_prefix($prefix); $fixture->set_blog_id(1); $tables = new Tables($fixture);
$names = ['scans', 'findings', 'policies', 'jobs', 'cases', 'case_notes', 'appeals', 'audit', 'usage', 'fingerprints', 'cache', 'events', 'limits', 'evaluations'];
$check = static function (bool $ok, string $name) use (&$passed): void { if (!$ok) { throw new RuntimeException('FAIL: ' . $name); } $passed++; echo 'PASS: ' . $name . PHP_EOL; };
try {
    $tables->migrate(); $check((int)get_option('cf_schema_version') === Tables::VERSION, 'A fresh isolated table family records the verified schema');
    foreach ($names as $name) { if ($fixture->get_var($fixture->prepare('SHOW TABLES LIKE %s', $fixture->esc_like($tables->name($name)))) !== $tables->name($name)) { throw new RuntimeException('Missing fixture table'); } }
    $check(true, 'All fourteen isolated tables exist');
    $values = ['site_id' => 1, 'correlation' => bin2hex(random_bytes(16)), 'sha256' => str_repeat('a', 64), 'state' => 'REVIEW_REQUIRED', 'file_name' => 'synthetic-legacy.txt', 'mime' => 'text/plain', 'bytes' => 10, 'policy_id' => 'fixture', 'policy_version' => 1, 'context_json' => '{}', 'signals_json' => '{}', 'decision_json' => '{}', 'created_at' => gmdate('Y-m-d H:i:s'), 'updated_at' => gmdate('Y-m-d H:i:s'), 'expires_at' => gmdate('Y-m-d H:i:s', time() + 3600)];
    if ($fixture->insert($tables->name('scans'), $values) === false) { throw new RuntimeException('Fixture insert'); }
    $id = $fixture->insert_id;
    if ($fixture->query($fixture->prepare('ALTER TABLE %i DROP INDEX metadata_expiry, DROP COLUMN metadata_erased', $tables->name('scans'))) === false) { throw new RuntimeException('Fixture prototype'); }
    update_option('cf_schema_version', 1, false); $tables->migrate();
    $row = $fixture->get_row($fixture->prepare('SELECT * FROM %i WHERE id=%d', $tables->name('scans'), $id), ARRAY_A);
    $check($row['file_name'] === 'synthetic-legacy.txt' && $row['sha256'] === str_repeat('a', 64) && (int)$row['metadata_erased'] === 0, 'Schema 1 to 2 preserves legacy records and adds the erasure default');
    $check(in_array('metadata_expiry', $fixture->get_col($fixture->prepare('SHOW INDEX FROM %i', $tables->name('scans')), 2), true), 'Schema upgrade creates the metadata expiry index');
    $tables->migrate(); $check((int)$fixture->get_var($fixture->prepare('SELECT COUNT(*) FROM %i', $tables->name('scans'))) === 1, 'Repeat migration does not duplicate or destroy data');
    $lock = 'cf_schema_' . substr(hash('sha256', DB_NAME . ':' . $prefix), 0, 40); $wpdb->get_var($wpdb->prepare('SELECT GET_LOCK(%s,0)', $lock));
    try { $tables->migrate(); throw new RuntimeException('Expected migration contention'); }
    catch (RuntimeException $e) { $check($e->getMessage() === 'DATABASE.MIGRATION_BUSY', 'A competing database connection cannot migrate the same table family'); }
    finally { $wpdb->get_var($wpdb->prepare('SELECT RELEASE_LOCK(%s)', $lock)); }
    $tables->migrate(); $check((int)get_option('cf_schema_version') === Tables::VERSION, 'Migration resumes after the competing lock is released');
    echo json_encode(['migration_assertions' => $passed, 'wordpress' => $GLOBALS['wp_version'], 'php' => PHP_VERSION], JSON_THROW_ON_ERROR) . PHP_EOL;
} finally {
    foreach ($names as $name) { $fixture->query($fixture->prepare('DROP TABLE IF EXISTS %i', $tables->name($name))); } $fixture->close(); update_option('cf_schema_version', $saved, false);
}
