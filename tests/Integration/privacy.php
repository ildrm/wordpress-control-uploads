<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
if (wp_get_environment_type() !== 'development') { throw new RuntimeException('Development only'); }
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Domain\UploadContext;
use ContentFirewall\Policy\Presets;
use ContentFirewall\WordPress\PrivacyTools;
use ContentFirewall\Application\{Publisher, Retention};
global $wpdb; wp_set_current_user(1); $passed = 0; $old = get_option('cf_settings'); $oldPolicy = get_option('cf_active_policy');
$check = static function (bool $ok, string $name) use (&$passed): void { if (!$ok) { throw new RuntimeException('FAIL: ' . $name); } $passed++; echo 'PASS: ' . $name . PHP_EOL; };
$dir = sys_get_temp_dir() . '/cf-privacy-' . bin2hex(random_bytes(6)); mkdir($dir, 0700); $path = $dir . '/fixture.png';
$im = imagecreatetruecolor(12, 12); imagepng($im, $path); unset($im);
$uid = wp_create_user('cf-privacy-' . bin2hex(random_bytes(4)), wp_generate_password(), 'cf-privacy-' . bin2hex(random_bytes(4)) . '@example.test');
if (is_wp_error($uid)) { throw new RuntimeException('Cannot create fixture user'); }
$email = get_userdata($uid)->user_email;
try {
    update_option('cf_settings', array_merge($old, ['privacy_retain_audit' => true, 'retention' => ['private_files_days' => 2, 'safe_metadata_days' => 2, 'blocked_metadata_days' => 1, 'audit_days' => 2, 'analytics_days' => 2, 'job_days' => 2]]));
    $s = new Services($wpdb); $s->tables->migrate(); $policy = $s->policies->save((new Presets())->make('Security Only')->toArray(), 1);
    $file = $s->inspector->inspect($path, 'fixture.png', 'image/png'); $ids = []; $private = [];
    for ($i = 0; $i < 103; $i++) { $key = $s->storage->put($path, $s->siteId, $file->sha256); $ids[] = $s->scans->create($file, new UploadContext($s->siteId, $uid), $policy, $key); $private[] = $s->storage->path($key, $s->siteId); }
    $expiry = strtotime($s->scans->get($ids[0])['expires_at'] . ' UTC'); $check(abs($expiry - (time() + 2 * DAY_IN_SECONDS)) < 5, 'Configured private retention applies to new snapshots');
    $s->audit->record('test.privacy', $ids[0], $uid); $audit = $wpdb->get_row($wpdb->prepare('SELECT * FROM %i WHERE object_id=%d ORDER BY id DESC LIMIT 1', $s->tables->name('audit'), $ids[0]), ARRAY_A);
    $wpdb->insert($s->tables->name('case_notes'), ['scan_id' => $ids[0], 'actor_id' => $uid, 'action' => 'note', 'reason' => 'Personal note', 'created_at' => gmdate('Y-m-d H:i:s')]);
    $s->jobs->enqueue('scan', ['scan_id' => $ids[0], 'revision' => 0], 'privacy-fixture:' . $ids[0]);
    $other = $s->scanner->receive($path, 'fixture.png', 'image/png', new UploadContext($s->siteId, 1));
    $tools = new PrivacyTools(fn() => $s); $export = $tools->export($email);
    $check(!$export['done'] && count(array_filter($export['data'], static fn($item) => $item['group_id'] === 'cf-scans')) === 100, 'Exporter pages all owned scans');
    $check(str_contains(json_encode($export), 'Personal note') && str_contains(json_encode($export), 'test.privacy'), 'Exporter includes notes and signed audit subjects');
    $check(!str_contains(json_encode($export), 'private_key') && !str_contains(json_encode($export), 'cf-private'), 'Exporter excludes private storage identifiers and paths');
    $check($tools->export($email, 2)['done'], 'Exporter terminates after final partial page');
    $first = $tools->erase($email, 1); $second = $tools->erase($email, 2);
    $check($first['items_removed'] && $first['items_retained'] && !$first['done'] && $second['done'], 'Eraser consumes first remaining batch without OFFSET skipping');
    $check(count(array_filter($private, 'is_file')) === 0, 'Eraser removes all 103 private originals');
    $row = $s->scans->get($ids[0]); $check($row['state'] === 'DELETED' && (int)$row['user_id'] === 0 && $row['file_name'] === '' && (int)$row['metadata_erased'] === 1, 'Eraser clears identifying scan fields and holds unaccepted media');
    $check((int)$wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM %i WHERE scan_id=%d', $s->tables->name('case_notes'), $ids[0])) === 0, 'Eraser removes free-text subject notes');
    $check((int)$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM %i WHERE JSON_UNQUOTE(JSON_EXTRACT(payload,'$.scan_id'))=%s", $s->tables->name('jobs'), (string)$ids[0])) === 0, 'Eraser cancels outstanding scan work');
    $check($s->scans->get($other['id'])['user_id'] === '1' && is_file($s->storage->path($s->scans->get($other['id'])['private_key'], $s->siteId)), 'Erasure preserves unrelated users');
    $retained = $wpdb->get_row($wpdb->prepare('SELECT * FROM %i WHERE id=%d', $s->tables->name('audit'), $audit['id']), ARRAY_A);
    $check($retained && $s->audit->verify($retained), 'Retained audit signature remains valid');
    $check(!$tools->erase($email, 3)['items_removed'], 'Completed erasure is idempotent');
    $accepted = $s->scanner->receive($path, 'fixture.png', 'image/png', new UploadContext($s->siteId, $uid)); $attachment = (new Publisher($s))->publish($accepted['id'], (int)$s->scans->get($accepted['id'])['revision']);
    $tools->erase($email); $check(is_file(get_attached_file($attachment)) && $s->scans->latest($attachment)['state'] === 'ALLOWED', 'Erasure preserves minimal publication state and WordPress-owned accepted media');
    $wpdb->update($s->tables->name('scans'), ['created_at' => '2000-01-01 00:00:00'], ['id' => $other['id']]);
    (new Retention($s))->run(); $check((int)$s->scans->get($other['id'])['metadata_erased'] === 1, 'Scheduled metadata retention erases expired summaries');
    $wpdb->insert($s->tables->name('usage'), ['provider' => 'retention-fixture', 'day' => '2000-01-01']);
    $s->audit->record('test.old_audit', 0, $uid); $oldAuditId = $wpdb->insert_id; $wpdb->update($s->tables->name('audit'), ['created_at' => '2000-01-01 00:00:00'], ['id' => $oldAuditId]);
    (new Retention($s))->run(); $check(!$wpdb->get_var($wpdb->prepare('SELECT id FROM %i WHERE id=%d', $s->tables->name('audit'), $oldAuditId)) && !$wpdb->get_var($wpdb->prepare('SELECT id FROM %i WHERE provider=%s', $s->tables->name('usage'), 'retention-fixture')), 'Audit and analytics classes honor configured retention');
    update_option('cf_settings', array_merge($s->settings, ['privacy_retain_audit' => false])); $withoutAudit = new Services($wpdb);
    (new PrivacyTools(fn() => $withoutAudit))->erase($email);
    $check((int)$wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM %i WHERE actor_id=%d', $s->tables->name('audit'), $uid)) === 0, 'Operator-approved erasure removes retained subject audit rows');
    update_user_meta($uid, 'cf_upload_suspended', 1);
    $check(str_contains(json_encode((new PrivacyTools(fn() => $withoutAudit))->export($email)), 'Upload suspension'), 'Exporter discloses an active administrator-managed suspension');
    $suspended = (new PrivacyTools(fn() => $withoutAudit))->erase($email);
    $check($suspended['items_retained'] && count($suspended['messages']) === 1 && (bool)get_user_meta($uid, 'cf_upload_suspended', true), 'Erasure reports retained suspension without silently unbanning an uploader'); delete_user_meta($uid, 'cf_upload_suspended');
    echo json_encode(['privacy_assertions' => $passed, 'wordpress' => $GLOBALS['wp_version'], 'php' => PHP_VERSION], JSON_THROW_ON_ERROR) . PHP_EOL;
} finally { update_option('cf_settings', $old); update_option('cf_active_policy', $oldPolicy); unlink($path); rmdir($dir); }
