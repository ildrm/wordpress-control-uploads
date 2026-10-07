<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
if (wp_get_environment_type() !== 'development') { throw new RuntimeException('Development only'); }
use ContentFirewall\Application\HeadlessUpload;
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Policy\Presets;
global $wpdb; wp_set_current_user(1); $settings = get_option('cf_settings', []); $active = get_option('cf_active_policy'); $passed = 0; $attachment = 0;
$check = static function (bool $ok, string $name) use (&$passed): void { if (!$ok) { throw new RuntimeException('FAIL: ' . $name); } $passed++; echo 'PASS: ' . $name . PHP_EOL; };
$root = sys_get_temp_dir() . '/cf-headless-' . bin2hex(random_bytes(6)); mkdir($root, 0700); $im = imagecreatetruecolor(12, 12); imagepng($im, $root . '/sample.png'); unset($im);
try {
    update_option('cf_settings', array_merge($settings, ['require_malware' => false, 'enable_documents' => false, 'enable_temporal' => false, 'enable_provenance' => false])); $s = new Services($wpdb); $s->tables->migrate(); $s->policies->save((new Presets())->make('Security Only')->toArray(), 1);
    $headless = new HeadlessUpload($s); $received = $headless->receive($root . '/sample.png', 'sample.png', 'image/png');
    $check($received['state'] === 'PENDING_PROVIDER' && $received['attachment_id'] === 0, 'Headless receipt always queues private processing before publication');
    $check(!array_intersect(['findings', 'decision', 'sha256', 'file_name', 'private_key', 'signals_json'], array_keys($received)), 'Headless receipt exposes only owner-safe progress');
    $wpdb->query($wpdb->prepare("UPDATE %i SET priority=1000 WHERE kind='scan' AND JSON_UNQUOTE(JSON_EXTRACT(payload,'$.scan_id'))=%s", $s->tables->name('jobs'), (string)$received['id']));
    (new ContentFirewall\Queue\Worker($s))->run(1, 20); $status = $headless->status($received['id']); $attachment = $status['attachment_id'];
    $check($status['stage'] === 'approved' && $attachment > 0 && is_file(get_attached_file($attachment, true)), 'Headless worker publishes a checked derivative and status exposes its attachment ID');
    $request = new WP_REST_Request('GET', '/content-firewall/v1/uploads/' . $received['id']); $check(rest_get_server()->dispatch($request)->get_data()['stage'] === 'approved', 'Owner status endpoint returns the accepted summary');
    $subscriber = wp_create_user('cf-headless-' . bin2hex(random_bytes(4)), wp_generate_password(), 'cf-headless-' . bin2hex(random_bytes(4)) . '@example.test'); if (is_wp_error($subscriber)) { throw new RuntimeException('Fixture user'); } wp_set_current_user($subscriber);
    $check(rest_get_server()->dispatch($request)->get_status() === 403, 'Another authenticated owner cannot read a case status');
    $check(rest_get_server()->dispatch(new WP_REST_Request('POST', '/content-firewall/v1/uploads'))->get_status() === 403, 'Upload endpoint requires upload_files capability');
    wp_set_current_user(0); $check(rest_get_server()->dispatch($request)->get_status() === 401, 'Status endpoint rejects unauthenticated access'); wp_set_current_user(1);
    update_user_meta(1, 'cf_upload_suspended', 1);
    try { $headless->receive($root . '/sample.png', 'sample.png', 'image/png'); throw new RuntimeException('Expected suspension'); } catch (RuntimeException $e) { $check($e->getMessage() === 'SECURITY.UPLOAD_SUSPENDED', 'Headless uploads respect uploader suspension'); } finally { delete_user_meta(1, 'cf_upload_suspended'); }
    $forged = new WP_REST_Request('POST', '/content-firewall/v1/uploads'); $forged->set_file_params(['file' => ['error' => 0, 'tmp_name' => $root . '/sample.png', 'name' => 'sample.png', 'type' => 'image/png']]);
    $check(rest_get_server()->dispatch($forged)->get_status() === 400, 'Headless HTTP boundary rejects forged local file paths');
    echo json_encode(['headless_assertions' => $passed, 'wordpress' => $GLOBALS['wp_version'], 'php' => PHP_VERSION], JSON_THROW_ON_ERROR) . PHP_EOL;
} finally { wp_set_current_user(1); update_option('cf_settings', $settings); update_option('cf_active_policy', $active); if ($attachment) { wp_delete_attachment($attachment, true); } unlink($root . '/sample.png'); rmdir($root); }
