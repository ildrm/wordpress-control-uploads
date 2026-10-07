<?php
declare(strict_types=1);
// Optional offline official fixtures; configure paths explicitly. No binary or signing key is bundled.
require __DIR__ . '/../../autoload.php';
use ContentFirewall\Authenticity\ContentCredentials;
use ContentFirewall\Security\{FileInspector, PrivateStorage};
$root = sys_get_temp_dir() . '/cf-provenance-tool-' . bin2hex(random_bytes(6)); mkdir($root, 0700); $storage = new PrivateStorage($root); $passed = 0;
$check = static function (bool $ok, string $name) use (&$passed): void { if (!$ok) { throw new RuntimeException('FAIL: ' . $name); } $passed++; echo 'PASS: ' . $name . PHP_EOL; };
try {
    $tool = new ContentCredentials(getenv('CF_C2PA_BIN') ?: '', $storage, 1); $inspector = new FileInspector();
    $unsigned = $inspector->inspect(getenv('CF_C2PA_UNSIGNED_FIXTURE') ?: '', 'unsigned.jpg'); $signed = $inspector->inspect(getenv('CF_C2PA_SIGNED_FIXTURE') ?: '', 'signed.jpg');
    $absent = $tool->inspect($unsigned); $valid = $tool->inspect($signed);
    $check($absent['report']['state'] === 'absent' && $absent['report']['signature_valid'] === null && $absent['report']['ai_declared'] === null, 'Real unsigned image establishes absence without a fake-content judgment');
    $check($valid['report']['signature_valid'] === true && $valid['report']['trusted'] === null && $valid['report']['remote_fetch'] === false, 'Pinned offline tool verifies signed asset binding without claiming signer trust');
    $check(in_array('c2pa.created', $valid['report']['actions'], true), 'Declared signed actions normalize without retaining raw manifests');
    echo json_encode(['provenance_tool_assertions' => $passed, 'php' => PHP_VERSION], JSON_THROW_ON_ERROR) . PHP_EOL;
} finally { $storage->purgeTenant(1); rmdir($root); }
