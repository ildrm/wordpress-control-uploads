<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/autoload.php';
use ContentFirewall\Domain\Finding;
use ContentFirewall\Policy\{Engine, Presets};
$engine = new Engine(); $policy = (new Presets())->make('Community'); $findings = [new Finding('sexual.explicit', 0.7)]; $samples = [];
for ($i = 0; $i < 10000; $i++) { $start = hrtime(true); $engine->decide($policy, ['context' => 'avatar'], $findings); $samples[] = (hrtime(true) - $start) / 1000000; }
sort($samples); $report = ['php' => PHP_VERSION, 'policy_iterations' => count($samples), 'policy_p50_ms' => $samples[5000], 'policy_p95_ms' => $samples[9500], 'peak_memory_bytes' => memory_get_peak_usage(true), 'admin_bundle_bytes' => filesize(dirname(__DIR__,2) . '/assets/admin.js'), 'limitations' => ['No remote provider latency or large-database performance measured']];
echo json_encode($report, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR) . PHP_EOL;
if ($samples[9500] > 100) { exit(1); }
