<?php
declare(strict_types=1);
namespace ContentFirewall\Infrastructure;

/** No shell, inherited secrets or unbounded output; OS isolation belongs to deployment. */
final class ProcessRunner
{
    private ?\Closure $heartbeat;
    /** @param null|callable():void $heartbeat */
    public function __construct(?callable $heartbeat = null) { $this->heartbeat = $heartbeat === null ? null : \Closure::fromCallable($heartbeat); }
    /** @param list<string> $command @return array{stdout:string,stderr:string,exit_code:int} */
    public function run(array $command, string $directory, int $milliseconds = 30000, int $maximumOutput = 1048576): array
    {
        if (!$command || !array_is_list($command) || count($command) > 100 || !str_starts_with($command[0], '/') || !is_file($command[0]) || !is_executable($command[0]) || !is_dir($directory) || is_link($directory) || $milliseconds < 1 || $milliseconds > 120000 || $maximumOutput < 1 || $maximumOutput > 4194304 || !function_exists('proc_open')) { throw new \RuntimeException('CONFIGURATION.PROCESSOR'); }
        foreach ($command as $argument) { if (!is_string($argument) || str_contains($argument, "\0") || strlen($argument) > 32768) { throw new \InvalidArgumentException('VALIDATION.PROCESS'); } }
        $process = proc_open($command, [0 => ['file', '/dev/null', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, $directory, ['PATH' => '/usr/bin:/bin', 'LANG' => 'C', 'LC_ALL' => 'C', 'TMPDIR' => $directory, 'TMP' => $directory, 'TEMP' => $directory], ['bypass_shell' => true]);
        if (!is_resource($process)) { throw new \RuntimeException('CONFIGURATION.PROCESSOR'); }
        stream_set_blocking($pipes[1], false); stream_set_blocking($pipes[2], false);
        $output = ''; $errors = ''; $exit = -1; $deadline = microtime(true) + $milliseconds / 1000; $nextHeartbeat = microtime(true);
        try {
            while (true) {
                if ($this->heartbeat && microtime(true) >= $nextHeartbeat) { ($this->heartbeat)(); $nextHeartbeat = microtime(true) + 10; }
                foreach ([1, 2] as $index) {
                    $chunk = stream_get_contents($pipes[$index], 65536); if ($chunk === false) { throw new \RuntimeException('PROCESS.IO'); }
                    if ($index === 1) { $output .= $chunk; } else { $errors .= $chunk; }
                }
                if (strlen($output) > $maximumOutput || strlen($errors) > 32768) { throw new \RuntimeException('PROCESS.OUTPUT_LIMIT'); }
                $status = proc_get_status($process);
                if (!$status['running']) { $exit = $status['exitcode']; break; }
                if (microtime(true) >= $deadline) { throw new \RuntimeException('PROCESS.TIMEOUT'); }
                usleep(20000);
            }
            foreach ([1, 2] as $index) {
                $remaining = stream_get_contents($pipes[$index], 65536);
                if ($remaining === false) { throw new \RuntimeException('PROCESS.IO'); }
                if ($index === 1) { $output .= $remaining; } else { $errors .= $remaining; }
            }
            if (strlen($output) > $maximumOutput || strlen($errors) > 32768) { throw new \RuntimeException('PROCESS.OUTPUT_LIMIT'); }
        } catch (\Throwable $e) { proc_terminate($process, 9); throw $e; }
        finally { foreach ($pipes as $pipe) { fclose($pipe); } $closed = proc_close($process); }
        return ['stdout' => $output, 'stderr' => $errors, 'exit_code' => $exit >= 0 ? $exit : $closed];
    }
}
