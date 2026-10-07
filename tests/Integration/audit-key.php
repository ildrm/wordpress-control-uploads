<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
if (wp_get_environment_type() !== 'development') { throw new RuntimeException('Development only'); }
use ContentFirewall\Persistence\{AuditRepository, Tables};
global $wpdb; $tables = new Tables($wpdb); $passed = 0;
$check = static function (bool $ok, string $name) use (&$passed): void { if (!$ok) { throw new RuntimeException('FAIL: ' . $name); } $passed++; echo 'PASS: ' . $name . PHP_EOL; };
foreach (['', 'short-test-key', str_repeat('x', 4097)] as $key) {
    try { new AuditRepository($wpdb, $tables, get_current_blog_id(), $key); throw new RuntimeException('Expected invalid key'); }
    catch (RuntimeException $e) { $check($e->getMessage() === 'CONFIGURATION.AUDIT_KEY', 'Invalid audit key is rejected (' . strlen($key) . ' bytes)'); }
}
$key = bin2hex(random_bytes(32)); $audit = new AuditRepository($wpdb, $tables, get_current_blog_id(), $key); $audit->record('test.audit_key', 0, 1, ['code' => 'OK']); $id = $wpdb->insert_id;
try {
    $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM %i WHERE id=%d', $tables->name('audit'), $id), ARRAY_A);
    $check($audit->verify($row), 'A configured strong test key verifies the stored audit event'); $row['metadata'] = '{"code":"CHANGED"}'; $check(!$audit->verify($row), 'Modified audit metadata cannot reuse its integrity signature');
    $before = getenv('CF_AUDIT_KEY'); putenv('CF_AUDIT_KEY=short-test-key');
    try { new ContentFirewall\Bootstrap\Services($wpdb); throw new RuntimeException('Expected invalid environment key'); }
    catch (RuntimeException $e) { $check($e->getMessage() === 'CONFIGURATION.AUDIT_KEY', 'An explicitly configured weak environment key cannot silently fall back'); }
    finally { $before === false ? putenv('CF_AUDIT_KEY') : putenv('CF_AUDIT_KEY=' . $before); }
    echo json_encode(['audit_key_assertions' => $passed, 'wordpress' => $GLOBALS['wp_version'], 'php' => PHP_VERSION], JSON_THROW_ON_ERROR) . PHP_EOL;
} finally { $wpdb->delete($tables->name('audit'), ['id' => $id]); }
