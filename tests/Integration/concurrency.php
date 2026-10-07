<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
if (wp_get_environment_type() !== 'development') { throw new RuntimeException('Development only'); }

use ContentFirewall\Persistence\Tables;
use ContentFirewall\Queue\JobRepository;

final class CfConcurrencyFixtureDatabase extends wpdb
{
    public bool $failStart = false;
    public function query($query)
    {
        if ($this->failStart && $query === 'START TRANSACTION') { $this->last_error = 'Synthetic transaction failure'; return false; }
        return parent::query($query);
    }
}

global $wpdb;
$prefix = 'cf_concurrency_fixture_' . bin2hex(random_bytes(8)) . '_';
$fixture = new CfConcurrencyFixtureDatabase(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
$fixture->set_prefix($prefix);
$fixture->set_blog_id(1);
$tables = new Tables($fixture);
$site = get_current_blog_id();
$jobs = new JobRepository($fixture, $tables, $site);
$table = $tables->name('jobs');
$source = (new Tables($wpdb))->name('jobs');
$processes = [];
try {
    if ($fixture->query($fixture->prepare('CREATE TABLE %i LIKE %i', $table, $source)) === false) { throw new RuntimeException('Fixture creation failed'); }
    for ($i = 0; $i < 100; $i++) { $jobs->enqueue('retention', ['concurrency' => $prefix], $prefix . $i); }
    $expected = array_map('intval', $fixture->get_col($fixture->prepare('SELECT id FROM %i ORDER BY id', $table)));
    $fixture->failStart = true;
    try { $jobs->claim(); throw new RuntimeException('Failed transaction start was accepted'); }
    catch (RuntimeException $error) { if ($error->getMessage() !== 'DATABASE.CLAIM') { throw $error; } }
    finally { $fixture->failStart = false; }
    if ((int)$fixture->get_var($fixture->prepare("SELECT COUNT(*) FROM %i WHERE status<>'ready' OR attempts<>0", $table)) !== 0) { throw new RuntimeException('Failed transaction leased work'); }

    for ($i = 0; $i < 2; $i++) {
        $pipes = [];
        $process = proc_open([PHP_BINARY, __DIR__ . '/concurrency-worker.php', $prefix, (string)$site], [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);
        if (!is_resource($process)) { throw new RuntimeException('Child failed'); }
        fclose($pipes[0]);
        $processes[] = [$process, $pipes];
    }
    $outputs = []; $errors = [];
    foreach ($processes as [$process, $pipes]) {
        $out = stream_get_contents($pipes[1]); $err = stream_get_contents($pipes[2]);
        fclose($pipes[1]); fclose($pipes[2]);
        $code = proc_close($process);
        if ($code !== 0 || $err !== '') { $errors[] = 'Worker failed: ' . $err; continue; }
        $outputs[] = json_decode($out, true, 16, JSON_THROW_ON_ERROR);
    }
    if ($errors) { throw new RuntimeException(implode('; ', $errors)); }
    $claimed = array_merge(...$outputs); sort($claimed);
    if (count($outputs) !== 2 || array_intersect($outputs[0], $outputs[1]) || $claimed !== $expected || $jobs->depth() !== 0) { throw new RuntimeException('Duplicate or missed claims'); }
    echo json_encode(['workers' => 2, 'distinct_claims' => count($claimed), 'duplicate_claims' => 0, 'transaction_assertions' => 1, 'isolated_fixture' => true], JSON_THROW_ON_ERROR) . PHP_EOL;
} finally {
    foreach ($processes as [$process, $pipes]) {
        if (!is_resource($process)) { continue; }
        if (proc_get_status($process)['running']) { proc_terminate($process); }
        foreach ($pipes as $pipe) { if (is_resource($pipe)) { fclose($pipe); } }
        proc_close($process);
    }
    $fixture->query($fixture->prepare('DROP TABLE IF EXISTS %i', $table));
    $fixture->close();
}
