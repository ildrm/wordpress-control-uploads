<?php
declare(strict_types=1);
$root = $argv[1] ?? ''; if (!is_file($root . '/content-firewall.php')) { throw new RuntimeException('Invalid package root'); }
require $root . '/includes/autoload.php'; $count = 0;
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root . '/src', FilesystemIterator::SKIP_DOTS)) as $file) {
    if ($file->getExtension() !== 'php') { continue; }
    $relative = substr($file->getPathname(), strlen($root . '/src/'), -4); $class = 'ContentFirewall\\' . str_replace('/', '\\', $relative);
    if (!class_exists($class) && !interface_exists($class) && !enum_exists($class)) { throw new RuntimeException('Autoload failed: ' . $class); } $count++;
}
$policy = (new ContentFirewall\Policy\Presets())->make('Community'); $decision = (new ContentFirewall\Policy\Engine())->decide($policy, [], [new ContentFirewall\Domain\Finding('sexual.explicit', 0.9)]);
if ($decision->action !== ContentFirewall\Domain\Action::Review) { throw new RuntimeException('Packaged policy smoke test failed'); }
echo json_encode(['packaged_symbols_loaded' => $count, 'vendor_required' => false, 'policy_smoke' => 'passed'], JSON_THROW_ON_ERROR) . PHP_EOL;
