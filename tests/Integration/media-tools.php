<?php
declare(strict_types=1);
// Standalone benign native-tool acceptance; use explicit tool paths, never production uploads.
require __DIR__ . '/../../includes/autoload.php';
use ContentFirewall\Domain\{Finding, Policy, ProviderResult};
use ContentFirewall\Media\{DocumentMedia, ImagePdf, TemporalMedia};
use ContentFirewall\Security\{FileInspector, PrivateStorage};
use ContentFirewall\Infrastructure\ProcessRunner;
use ContentFirewall\Configuration\Settings;
$root = sys_get_temp_dir() . '/cf-native-' . bin2hex(random_bytes(6)); mkdir($root, 0700); $storage = new PrivateStorage($root . '/private'); $passed = 0;
$check = static function (bool $ok, string $name) use (&$passed): void { if (!$ok) { throw new RuntimeException('FAIL: ' . $name); } $passed++; echo 'PASS: ' . $name . PHP_EOL; };
$bin = static function (string $name): string { $value = getenv($name); if (!$value) { throw new RuntimeException('Explicit native tool path required: ' . $name); } return $value; };
$runner = new ProcessRunner();
try {
    $im = imagecreatetruecolor(24, 16); imagefill($im, 0, 0, imagecolorallocate($im, 10, 90, 170)); imagejpeg($im, $root . '/page.jpg'); unset($im);
    $image = (new FileInspector(5242880, 24000000, ['jpg']))->inspect($root . '/page.jpg', 'page.jpg');
    (new ImagePdf())->write([$image, $image], $root . '/input.pdf'); $pdf = (new FileInspector())->inspect($root . '/input.pdf', 'input.pdf');
    $documents = new DocumentMedia($bin('CF_PDFINFO_BIN'), $bin('CF_PDFTOPPM_BIN'), $bin('CF_PDFTOTEXT_BIN'), $storage, 1, 3);
    $policy = new Policy('native', 1, 'Native fixture', [], options: ['requires_content' => true]); $seen = 0;
    $analysis = $documents->inspect($pdf, $policy, static function ($page) use (&$seen): array { $seen++; return [new ProviderResult('fixture', '1', [new Finding('sexual.explicit', 0, 'fixture')])]; });
    $check($seen === 2 && $analysis['signals']['pages'] === 2 && $analysis['signals']['document_cdr'], 'All PDF pages render through bounded raster inspection');
    $documents->reconstruct($pdf, $root . '/clean.pdf'); $clean = (new FileInspector())->inspect($root . '/clean.pdf', 'clean.pdf');
    $check($clean->bytes > 0 && !str_contains((string)file_get_contents($clean->path), '/JavaScript') && !str_contains((string)file_get_contents($clean->path), '/EmbeddedFile'), 'Rebuilt PDF contains fresh image-only objects');
    $info = $runner->run([$bin('CF_PDFINFO_BIN'), $clean->path], $root); $check($info['exit_code'] === 0 && preg_match('/^Pages:\s+2\s*$/m', $info['stdout']) === 1, 'Native parser accepts the reconstructed PDF page count');
    $check(preg_match('/^Page size:\s+24 x 16 pts/m', $info['stdout']) === 1, 'PDF reconstruction preserves physical page dimensions');
    $mixed = new Policy('mixed', 1, 'Mixed local and page evidence', [['id' => 'mixed', 'condition' => ['group' => 'AND', 'children' => [['field' => 'provenance.present', 'op' => 'gte', 'value' => 0], ['field' => 'ocr_text', 'op' => 'contains', 'value' => 'fixture']]], 'action' => 'REVIEW'] ], options: ['requires_content' => true]);
    $coverage = $documents->inspect($pdf, $mixed, static fn($page): array => [new ProviderResult('fixture', '1', [], text: 'fixture')], [new Finding('provenance.present', 0, 'local-c2pa')]);
    $check(!$coverage['signals']['media_coverage_incomplete'], 'Page coverage combines local provenance with transient page OCR evidence');
    try { (new DocumentMedia($bin('CF_PDFINFO_BIN'), $bin('CF_PDFTOPPM_BIN'), $bin('CF_PDFTOTEXT_BIN'), $storage, 1, 1))->reconstruct($pdf, $root . '/too-many.pdf'); $check(false, 'Page-limit fixture'); }
    catch (RuntimeException $e) { $check($e->getMessage() === 'SECURITY.PDF_PAGES', 'PDF page limits reject oversized documents before raster work'); }
    $ffmpeg = $bin('CF_FFMPEG_BIN'); $probe = $bin('CF_FFPROBE_BIN');
    $reply = $runner->run([$ffmpeg, '-hide_banner', '-loglevel', 'error', '-f', 'lavfi', '-i', 'color=c=blue:s=64x48:r=5:d=2', '-c:v', 'libx264', '-threads', '1', '-pix_fmt', 'yuv420p', $root . '/video.mp4'], $root);
    $check($reply['exit_code'] === 0, 'Harmless synthetic video generated');
    $video = (new FileInspector(52428800, 24000000, ['mp4']))->inspect($root . '/video.mp4', 'video.mp4'); $limits = Settings::PROCESSING; $limits['max_frames'] = 3;
    $temporal = new TemporalMedia($ffmpeg, $probe, $storage, 1, $limits); $seen = 0;
    $analysis = $temporal->inspect($video, $policy, static function ($frame) use (&$seen): array { $seen++; return [new ProviderResult('fixture', '1', [new Finding('sexual.explicit', 0.1, 'fixture')], codes: ['123'])]; });
    $check($seen > 0 && $seen <= 3 && $analysis['signals']['duration'] <= 2.1, 'Video frame sampling obeys count and duration limits');
    $check(count($analysis['results']) === 1 && $analysis['results'][0]->codes === ['123'], 'Frame aggregation preserves numeric QR strings and distinct provider identity');
    $temporal->reconstruct($video, $root . '/clean.mp4'); $check((new FileInspector(52428800, 24000000, ['mp4']))->inspect($root . '/clean.mp4', 'clean.mp4')->bytes > 0, 'Accepted video is decoded and reconstructed');
    foreach (['scene', 'adaptive'] as $mode) { $limits['sampling'] = $mode; $result = (new TemporalMedia($ffmpeg, $probe, $storage, 1, $limits))->inspect($video, $policy, static fn($frame): array => [new ProviderResult('fixture', '1', [])]); $check($result['signals']['sample_count'] >= 1, $mode . ' sampling preserves the initial frame'); }
    $limits['max_duration'] = 1; try { (new TemporalMedia($ffmpeg, $probe, $storage, 1, $limits))->probe($video); $check(false, 'Duration-limit fixture'); } catch (RuntimeException $e) { $check($e->getMessage() === 'SECURITY.MEDIA_DURATION', 'Over-duration files cannot reach moderation or publication'); }
    $reply = $runner->run([$ffmpeg, '-hide_banner', '-loglevel', 'error', '-f', 'lavfi', '-i', 'sine=frequency=440:duration=1', '-c:a', 'pcm_s16le', $root . '/audio.wav'], $root);
    $check($reply['exit_code'] === 0, 'Harmless synthetic audio generated');
    $audio = (new FileInspector(52428800, 24000000, ['wav']))->inspect($root . '/audio.wav', 'audio.wav');
    $analysis = $temporal->inspect($audio, $policy, static fn($part): array => [new ProviderResult('fixture-transcribe', '1', [], text: 'Harmless synthetic transcript')]);
    $check($analysis['signals']['has_audio'] && !$analysis['signals']['has_video'] && $analysis['results'][0]->text === 'Harmless synthetic transcript', 'Audio reduction supplies the transcription adapter');
    $temporal->reconstruct($audio, $root . '/clean.wav'); $check((new FileInspector(52428800, 24000000, ['wav']))->inspect($root . '/clean.wav', 'clean.wav')->bytes > 0, 'Accepted audio is reconstructed');
    $securityOnly = $temporal->inspect($video, new Policy('local', 1, 'Local', []), static function ($part): array { throw new RuntimeException('Unexpected paid call'); });
    $check($securityOnly['results'][0]->provider === 'local-media', 'Security-only processing makes no content-provider calls');
    $work = $storage->workspace(1); file_put_contents($work . '/frame-001.jpg', 'fixture'); touch($work, time() - 90000); $check($storage->cleanupTemporary(1) === 1 && !file_exists($work), 'Crashed native workspaces expire without blind recursive removal');
    echo json_encode(['native_media_assertions' => $passed, 'php' => PHP_VERSION], JSON_THROW_ON_ERROR) . PHP_EOL;
} finally { $storage->purgeTenant(1); rmdir($root . '/private'); foreach (glob($root . '/*') ?: [] as $file) { if (is_file($file)) { unlink($file); } } rmdir($root); }
