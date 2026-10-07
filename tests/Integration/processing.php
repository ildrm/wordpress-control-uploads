<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
if (wp_get_environment_type() !== 'development') { throw new RuntimeException('Development only'); }
use ContentFirewall\Application\Publisher;
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Domain\{Action, FileDescriptor, Finding, ProviderResult, UploadContext};
use ContentFirewall\Infrastructure\ProcessRunner;
use ContentFirewall\Media\ImagePdf;
use ContentFirewall\Policy\Presets;
use ContentFirewall\Providers\Provider;
use ContentFirewall\Security\FileInspector;
global $wpdb; wp_set_current_user(1); $settings = get_option('cf_settings', []); $active = get_option('cf_active_policy'); $passed = 0; $attachments = [];
$check = static function (bool $ok, string $name) use (&$passed): void { if (!$ok) { throw new RuntimeException('FAIL: ' . $name); } $passed++; echo 'PASS: ' . $name . PHP_EOL; };
$root = sys_get_temp_dir() . '/cf-processing-' . bin2hex(random_bytes(6)); mkdir($root, 0700); $runner = new ProcessRunner();
$provider = new class implements Provider {
    public int $calls = 0;
    public function id(): string { return 'fixture-media'; }
    public function capabilities(): array { return ['model' => 'synthetic-v1', 'mimes' => ['image/jpeg', 'audio/mpeg'], 'regions' => [], 'features' => ['image', 'transcription']]; }
    public function scan(FileDescriptor $file): ProviderResult { $this->calls++; return new ProviderResult($this->id(), 'synthetic-v1', [new Finding('sexual.explicit', 0, $this->id())], text: 'Harmless synthetic words', language: 'fa'); }
};
$inject = static fn(array $current): array => [$provider]; add_filter('cf_register_providers', $inject);
try {
    update_option('cf_settings', array_merge($settings, ['enable_documents' => true, 'enable_temporal' => true, 'enable_provenance' => false, 'allowed_extensions' => ['jpg', 'pdf', 'mp4', 'wav'], 'processing' => ['max_duration' => 5, 'max_frames' => 3, 'max_pages' => 3, 'sampling' => 'uniform']]));
    $s = new Services($wpdb); $s->tables->migrate(); $context = new UploadContext($s->siteId, 1); $s->policies->save((new Presets())->make('Security Only')->toArray(), 1);
    $im = imagecreatetruecolor(24, 16); imagejpeg($im, $root . '/page.jpg'); unset($im);
    $page = (new FileInspector())->inspect($root . '/page.jpg', 'page.jpg'); (new ImagePdf())->write([$page], $root . '/fixture.pdf', [[612.0, 792.0]]);
    foreach (['fixture.pdf' => 'application/pdf', 'video.mp4' => 'video/mp4', 'audio.wav' => 'audio/wav'] as $name => $mime) {
        if ($name !== 'fixture.pdf') {
            $args = $name === 'video.mp4' ? ['-f', 'lavfi', '-i', 'color=c=blue:s=64x48:r=5:d=2', '-c:v', 'libx264', '-pix_fmt', 'yuv420p', '-threads', '1'] : ['-f', 'lavfi', '-i', 'sine=frequency=440:duration=1', '-c:a', 'pcm_s16le'];
            $reply = $runner->run(array_merge([Services::secret('CF_FFMPEG_BIN'), '-hide_banner', '-loglevel', 'error'], $args, [$root . '/' . $name]), $root); if ($reply['exit_code'] !== 0) { throw new RuntimeException('Fixture generation'); }
        }
        $received = $s->scanner->receive($root . '/' . $name, $name, $mime, $context); $row = $s->scans->get($received['id']);
        $check($row['state'] === 'PENDING_PROVIDER' && $row['attachment_id'] == 0, $name . ': original remains private until structural processing');
        $check($s->scanner->process($received['id'], (int)$row['revision'])->action === Action::Allow, $name . ': Security Only completes without paid content calls');
        $row = $s->scans->get($received['id']); $attachment = (new Publisher($s))->publish($received['id'], (int)$row['revision']); $attachments[] = $attachment;
        $check(is_file(get_attached_file($attachment, true)) && !array_filter($s->scans->findings($received['id']), static fn(Finding $f): bool => $f->hardSecurity), $name . ': checked reconstruction becomes the public attachment');
        if ($name === 'fixture.pdf') { $info = $runner->run([Services::secret('CF_PDFINFO_BIN'), get_attached_file($attachment, true)], $root); $check(preg_match('/^Page size:\s+612 x 792 pts/m', $info['stdout']) === 1, 'WordPress PDF publication preserves page size'); }
    }
    $check($provider->calls === 0, 'Security Only native workflows do not disclose media to providers');
    $policy = (new Presets())->make('Custom')->toArray(); $policy['bands'] = ['sexual.explicit' => ['review' => 0.5, 'block' => 0.9, 'calibrated' => false]]; $policy['options']['requires_content'] = true; $policy['options']['consensus'] = true; $s->policies->save($policy, 1);
    $received = $s->scanner->receive($root . '/fixture.pdf', 'fixture.pdf', 'application/pdf', $context); $row = $s->scans->get($received['id']);
    $decision = $s->scanner->process($received['id'], (int)$row['revision']); $check($decision->action === Action::Review && in_array('provider.consensus_incomplete', $decision->reasons, true), 'Local PDF text cannot count as an independent consensus provider');
    $policy['options']['consensus'] = false; $s->policies->save($policy, 1);
    $received = $s->scanner->receive($root . '/audio.wav', 'audio.wav', 'audio/wav', $context); $row = $s->scans->get($received['id']); $decision = $s->scanner->process($received['id'], (int)$row['revision']); $row = $s->scans->get($received['id']);
    $check($decision->action === Action::Allow && json_decode($row['signals_json'], true)['languages'] === ['fa'], 'Audio policy combines normalized transcription and measured language');
    $check(!str_contains($row['signals_json'], 'Harmless synthetic words'), 'Transcript words are removed before persistence');
    $policy['rules'] = [['id' => 'mask', 'action' => 'SANITIZE', 'condition' => ['field' => 'duration', 'op' => 'gt', 'value' => 0]]]; $s->policies->save($policy, 1);
    $received = $s->scanner->receive($root . '/video.mp4', 'video.mp4', 'video/mp4', $context); $row = $s->scans->get($received['id']); $decision = $s->scanner->process($received['id'], (int)$row['revision']);
    $check($decision->action === Action::Review && in_array('privacy.temporal_redaction_unavailable', $decision->reasons, true), 'Unsupported temporal sanitation cannot publish unredacted media');
    echo json_encode(['processing_assertions' => $passed, 'wordpress' => $GLOBALS['wp_version'], 'php' => PHP_VERSION], JSON_THROW_ON_ERROR) . PHP_EOL;
} finally {
    remove_filter('cf_register_providers', $inject); update_option('cf_settings', $settings); update_option('cf_active_policy', $active);
    foreach ($attachments as $attachment) { wp_delete_attachment($attachment, true); }
    foreach (glob($root . '/*') ?: [] as $path) { if (is_file($path)) { unlink($path); } } rmdir($root);
}
