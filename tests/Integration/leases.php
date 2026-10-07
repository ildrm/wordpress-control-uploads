<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
if (wp_get_environment_type() !== 'development') { throw new RuntimeException('Development only'); }
use ContentFirewall\Application\HeadlessUpload;
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Policy\Presets;
global $wpdb; wp_set_current_user(1); $settings = get_option('cf_settings', []); $active = get_option('cf_active_policy'); $passed = 0; $attachment = 0;
$check = static function (bool $ok, string $name) use (&$passed): void { if (!$ok) { throw new RuntimeException('FAIL: ' . $name); } $passed++; echo 'PASS: ' . $name . PHP_EOL; };
$root = sys_get_temp_dir() . '/cf-leases-' . bin2hex(random_bytes(6)); mkdir($root, 0700); $im = imagecreatetruecolor(12, 12); imagepng($im, $root . '/sample.png'); unset($im);
try {
    update_option('cf_settings', array_merge($settings, ['require_malware' => false, 'enable_documents' => false, 'enable_temporal' => false, 'enable_provenance' => false])); $s = new Services($wpdb); $s->tables->migrate(); $s->policies->save((new Presets())->make('Security Only')->toArray(), 1);
    $make = static function () use ($s, $wpdb, $root): array {
        $received = (new HeadlessUpload($s))->receive($root . '/sample.png', 'sample.png', 'image/png');
        $wpdb->query($wpdb->prepare("UPDATE %i SET priority=1000 WHERE kind='scan' AND JSON_UNQUOTE(JSON_EXTRACT(payload,'$.scan_id'))=%s", $s->tables->name('jobs'), (string)$received['id'])); return $received;
    };
    $received = $make(); $before = $s->scans->get($received['id']); $job = $s->jobs->claim();
    $check(json_decode($job['payload'], true)['scan_id'] === $received['id'], 'Lease fixture owns its prioritized scan job');
    $s->jobs->renew((int)$job['id'], $job['lease_token']); $check(true, 'A live owner renews its lease');
    $newToken = bin2hex(random_bytes(16)); $wpdb->update($s->tables->name('jobs'), ['lease_token' => $newToken], ['id' => $job['id']]);
    $s->router->setHeartbeat(fn() => $s->jobs->renew((int)$job['id'], $job['lease_token']));
    try { $s->scanner->process($received['id'], (int)$before['revision']); throw new RuntimeException('Expected lease loss'); }
    catch (RuntimeException $e) { $check($e->getMessage() === 'QUEUE.LEASE_EXPIRED', 'Stale ownership prevents the decision from committing'); }
    finally { $s->router->setHeartbeat(null); }
    $after = $s->scans->get($received['id']); $check($after['revision'] === $before['revision'] && $after['state'] === 'PENDING_PROVIDER', 'Ownership failure rolls back scan evidence and state');
    $check(!$s->jobs->finish((int)$job['id'], $job['lease_token']) && $s->jobs->finish((int)$job['id'], $newToken), 'Only the replacement owner can acknowledge the job');
    $received = $make(); $newToken = bin2hex(random_bytes(16)); $jobId = 0;
    $replace = static function (string $point, int $scan) use ($received, $newToken, $wpdb, $s, &$jobId): void {
        if ($point !== 'copied' || $scan !== $received['id']) { return; }
        $jobId = (int)$wpdb->get_var($wpdb->prepare("SELECT id FROM %i WHERE kind='scan' AND JSON_UNQUOTE(JSON_EXTRACT(payload,'$.scan_id'))=%s", $s->tables->name('jobs'), (string)$scan));
        $wpdb->update($s->tables->name('jobs'), ['lease_token' => $newToken], ['id' => $jobId]);
    };
    add_action('cf_internal_publication_checkpoint', $replace, 10, 2);
    try { $result = (new ContentFirewall\Queue\Worker($s))->run(1, 20); } finally { remove_action('cf_internal_publication_checkpoint', $replace, 10); }
    $row = $s->scans->get($received['id']); $attachment = (int)$row['attachment_id'];
    $check($result['failed'] === 1 && $row['state'] === 'ALLOWED' && $attachment > 0 && is_file(get_attached_file($attachment, true)), 'Stale acknowledgement cannot revoke an already committed approved derivative');
    $check($s->jobs->finish($jobId, $newToken), 'Replacement ownership may complete the committed publication');
    echo json_encode(['lease_assertions' => $passed, 'wordpress' => $GLOBALS['wp_version'], 'php' => PHP_VERSION], JSON_THROW_ON_ERROR) . PHP_EOL;
} finally { wp_set_current_user(1); update_option('cf_settings', $settings); update_option('cf_active_policy', $active); if ($attachment) { wp_delete_attachment($attachment, true); } unlink($root . '/sample.png'); rmdir($root); }
