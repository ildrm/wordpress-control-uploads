<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
if (wp_get_environment_type() !== 'development') { throw new RuntimeException('Development only'); }
use ContentFirewall\Application\FileSimulator;
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Domain\{Action, FileDescriptor, Finding, Policy, ProviderResult};
use ContentFirewall\Providers\Provider;
global $wpdb; wp_set_current_user(1); $passed = 0; $settings = get_option('cf_settings', []);
$check = static function (bool $ok, string $name) use (&$passed): void { if (!$ok) { throw new RuntimeException('FAIL: ' . $name); } $passed++; echo 'PASS: ' . $name . PHP_EOL; };
$root = sys_get_temp_dir() . '/cf-simulation-' . bin2hex(random_bytes(6)); mkdir($root, 0700); file_put_contents($root . '/sample.txt', 'Contact synthetic@example.test.');
$im = imagecreatetruecolor(12, 12); imagepng($im, $root . '/sample.png'); unset($im);
$provider = new class implements Provider {
    public int $calls = 0;
    public function id(): string { return 'fixture-simulation'; }
    public function capabilities(): array { return ['model' => '1', 'mimes' => ['image/png'], 'regions' => [], 'features' => ['image']]; }
    public function scan(FileDescriptor $file): ProviderResult { $this->calls++; return new ProviderResult($this->id(), '1', [new Finding('sexual.explicit', 0, $this->id())], durationMs: 2, estimatedCost: 0.01, text: 'Synthetic private OCR words', codes: ['https://example.test/private-code']); }
};
$inject = static fn(array $current): array => [$provider]; add_filter('cf_register_providers', $inject);
try {
    update_option('cf_settings', array_merge($settings, ['enable_documents' => false, 'enable_temporal' => false, 'enable_provenance' => false])); $s = new Services($wpdb); $s->tables->migrate();
    $count = static fn(string $table): int => (int)$wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM %i', $table));
    $scans = $count($s->tables->name('scans')); $jobs = $count($s->tables->name('jobs')); $posts = $count($wpdb->posts); $probe = $s->storage->temporary($s->siteId); $workdir = dirname($probe); unlink($probe); $work = glob($workdir . '/*') ?: [];
    $policy = new Policy('simulation', 1, 'Unsaved simulation', [['id' => 'redact', 'condition' => ['field' => 'pii.email', 'op' => 'gte', 'value' => 0.5], 'action' => 'SANITIZE']], options: ['requires_content' => true]);
    $report = (new FileSimulator($s))->run($root . '/sample.txt', 'sample.txt', 'text/plain', $policy);
    $check($report['decision']->action === Action::Sanitize && $report['published'] === false, 'Unsaved file policy uses local DLP and verifies bounded sanitation without publishing');
    $check(!str_contains(json_encode($report, JSON_THROW_ON_ERROR), 'synthetic@example.test'), 'Simulation returns no raw matched text');
    $policy = new Policy('simulation', 1, 'OCR-only sanitation', [['id' => 'redact', 'condition' => ['field' => 'ocr_text', 'op' => 'contains', 'value' => 'Contact'], 'action' => 'SANITIZE']], options: ['requires_content' => true]);
    $report = (new FileSimulator($s))->run($root . '/sample.txt', 'sample.txt', 'text/plain', $policy);
    $check($report['decision']->action === Action::Review, 'Simulation and real scans share unsupported-transformation review semantics');
    $policy = new Policy('simulation', 1, 'Provider simulation', [], options: ['requires_content' => true, 'qr_mode' => 'allow']);
    $report = (new FileSimulator($s))->run($root . '/sample.png', 'sample.png', 'image/png', $policy);
    $check($provider->calls === 1 && $report['estimated_cost'] === 0.01 && $report['providers'][0]['duration_ms'] === 2.0, 'Simulation reports normalized provider identity, latency and estimated cost');
    $serialized = json_encode($report, JSON_THROW_ON_ERROR); $check(!str_contains($serialized, 'Synthetic private OCR words') && !str_contains($serialized, 'private-code') && !str_contains($serialized, $root), 'Provider words, QR payloads and filesystem paths never enter the simulation response');
    $check($count($s->tables->name('scans')) === $scans && $count($s->tables->name('jobs')) === $jobs && $count($wpdb->posts) === $posts, 'Simulation creates no scan record, processing job, attachment or post');
    $check((glob($workdir . '/*') ?: []) === $work, 'Simulation cleans private sample and derivative work on completion');
    $r = new WP_REST_Request('POST', '/content-firewall/v1/simulation/file'); $r->set_file_params(['file' => ['error' => 0, 'tmp_name' => $root . '/sample.png', 'name' => 'sample.png', 'type' => 'image/png']]);
    $check(rest_get_server()->dispatch($r)->get_status() === 400, 'REST simulation rejects forged local-path file parameters');
    wp_set_current_user(0); $check(rest_get_server()->dispatch($r)->get_status() === 401, 'File simulation requires authenticated policy capability'); wp_set_current_user(1);
    $hash = (string)hash_file('sha256', $root . '/sample.png'); $fingerprint = $wpdb->get_row($wpdb->prepare('SELECT * FROM %i WHERE sha256=%s', $s->tables->name('fingerprints'), $hash), ARRAY_A);
    $wpdb->replace($s->tables->name('fingerprints'), ['sha256' => $hash, 'action' => 'BLOCK', 'label' => 'Synthetic simulation fixture', 'created_at' => gmdate('Y-m-d H:i:s')]);
    try { $calls = $provider->calls; $report = (new FileSimulator($s))->run($root . '/sample.png', 'sample.png', 'image/png', $policy); $check($report['decision']->action === Action::Block && $provider->calls === $calls, 'Real-file simulation honors the exact blocklist before paid processing'); }
    finally { $wpdb->delete($s->tables->name('fingerprints'), ['sha256' => $hash]); if ($fingerprint) { $wpdb->insert($s->tables->name('fingerprints'), $fingerprint); } }
    echo json_encode(['simulation_assertions' => $passed, 'wordpress' => $GLOBALS['wp_version'], 'php' => PHP_VERSION], JSON_THROW_ON_ERROR) . PHP_EOL;
} finally { remove_filter('cf_register_providers', $inject); update_option('cf_settings', $settings); foreach (glob($root . '/*') ?: [] as $file) { unlink($file); } rmdir($root); }
