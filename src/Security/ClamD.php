<?php
declare(strict_types=1);
namespace ContentFirewall\Security;
final class ClamD implements MalwareScanner
{
    public function __construct(private string $socket = 'unix:///run/clamav/clamd.ctl', private int $timeout = 5) {}
    public function scan(string $path): string
    {
        // Only explicitly configured local Unix sockets; uploaded paths never become commands.
        if (!str_starts_with($this->socket, 'unix:///')) { return 'SCANNER_ERROR'; }
        $stream = @stream_socket_client($this->socket, $errno, $error, $this->timeout);
        $file = @fopen($path, 'rb');
        if (!$stream || !$file) { if (is_resource($stream)) { fclose($stream); } if (is_resource($file)) { fclose($file); } return 'SCANNER_ERROR'; }
        stream_set_timeout($stream, $this->timeout); $deadline = microtime(true) + $this->timeout;
        try {
            if (!$this->write($stream, "zINSTREAM\0")) { return 'SCANNER_ERROR'; }
            while (!feof($file)) {
                if (microtime(true) > $deadline) { return 'SCANNER_ERROR'; }
                $chunk = fread($file, 65536);
                if ($chunk === false || !$this->write($stream, pack('N', strlen($chunk)) . $chunk)) { return 'SCANNER_ERROR'; }
            }
            if (!$this->write($stream, pack('N', 0))) { return 'SCANNER_ERROR'; }
            $reply = stream_get_line($stream, 4096, "\0");
            if (!is_string($reply) || stream_get_meta_data($stream)['timed_out']) { return 'SCANNER_ERROR'; }
            if (str_ends_with(trim($reply), 'FOUND')) { return 'INFECTED'; }
            return preg_match('/^stream: OK$/D', trim($reply)) ? 'CLEAN' : 'SCANNER_ERROR';
        } finally { fclose($file); fclose($stream); }
    }
    /** @param resource $stream */
    private function write($stream, string $bytes): bool
    {
        $offset = 0;
        while ($offset < strlen($bytes)) { $n = fwrite($stream, substr($bytes, $offset)); if ($n === false || $n === 0) { return false; } $offset += $n; }
        return true;
    }
}
