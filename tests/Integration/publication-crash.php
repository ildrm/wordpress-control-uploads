<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
if (wp_get_environment_type() !== 'development' || !function_exists('posix_kill')) { throw new RuntimeException('Requires disposable POSIX development environment.'); }
wp_set_current_user(1); global $wpdb; $s = new ContentFirewall\Bootstrap\Services($wpdb);
$saved = get_option('cf_active_policy'); $s->policies->save((new ContentFirewall\Policy\Presets())->make('Security Only')->toArray(), 1); $passed = 0;
$check = static function (bool $ok, string $label) use (&$passed): void { if (!$ok) { throw new RuntimeException('FAIL: ' . $label); } $passed++; echo 'PASS: ' . $label . PHP_EOL; };
$input = tempnam(sys_get_temp_dir(), 'cf-crash-'); $im = imagecreatetruecolor(40, 20); imagepng($im, $input);
try {
    foreach (['copied', 'committed'] as $checkpoint) {
        $result = $s->scanner->receive($input, 'crash.png', 'image/png', new ContentFirewall\Domain\UploadContext($s->siteId, 1)); $row = $s->scans->get($result['id']); $pipes = [];
        $process = proc_open([PHP_BINARY, __DIR__ . '/publication-crash-worker.php', (string)$row['id'], (string)$row['revision'], $checkpoint], [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);
        if (!is_resource($process)) { throw new RuntimeException('Crash worker unavailable'); }
        fclose($pipes[0]); $out = stream_get_contents($pipes[1]); $error = stream_get_contents($pipes[2]); fclose($pipes[1]); fclose($pipes[2]); $exit = proc_close($process);
        $check($exit !== 0 && $error === '', 'Publication worker was killed at ' . $checkpoint);
        $journal = new ContentFirewall\Application\MediaJournal($s); $intent = $journal->read('publish', $result['id']);
        $check($intent !== null && is_file($journal->publicPath($intent['path'])), 'Durable publication intent survives ' . $checkpoint);
        $path = $journal->publicPath($intent['path']); $row = $s->scans->get($result['id']);
        if ($checkpoint === 'copied') {
            $check((int)$row['attachment_id'] === 0, 'Killed uncommitted publication rolls back its attachment');
            // Retry directly, without a prior worker tick: it must recover the old intent first.
            $deadline = microtime(true) + 5;
            while (true) {
                try { $attachment = (new ContentFirewall\Application\Publisher($s))->publish($result['id'], (int)$row['revision']); break; }
                catch (RuntimeException $e) { if ($e->getMessage() !== 'QUEUE.PUBLICATION_BUSY' || microtime(true) >= $deadline) { throw $e; } usleep(25000); }
            }
            $check(!is_file($path) && is_file(get_attached_file($attachment, true)), 'Retry removes the orphan before creating a new derivative');
        } else {
            $check((int)$row['attachment_id'] > 0, 'Committed attachment survives process death');
            // Process exit can precede the DB server noticing the closed connection and releasing its lock.
            $deadline = microtime(true) + 5;
            do {
                $recovery = $journal->recover(1, $result['id']);
                if ($recovery['failed'] || $recovery['recovered']) { break; }
                usleep(25000);
            } while (microtime(true) < $deadline);
            $check($recovery['failed'] === 0 && $recovery['recovered'] === 1 && is_file($path) && !get_post_meta((int)$row['attachment_id'], '_cf_pending', true), 'Restart completes committed attachment metadata');
        }
        $check($journal->read('publish', $result['id']) === null, 'Recovered intent is acknowledged once');
    }
    echo json_encode(['publication_crash_assertions' => $passed, 'wordpress' => $GLOBALS['wp_version']], JSON_THROW_ON_ERROR) . PHP_EOL;
} finally { unlink($input); if ($saved) { update_option('cf_active_policy', $saved); } else { delete_option('cf_active_policy'); } }
