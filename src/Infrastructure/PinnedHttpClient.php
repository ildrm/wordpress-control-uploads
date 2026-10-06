<?php
declare(strict_types=1);
namespace ContentFirewall\Infrastructure;
use ContentFirewall\Security\UrlGuard;
final class PinnedHttpClient implements HttpClient
{
    public function __construct(private UrlGuard $guard, private array $allowedHosts = []) {}
    public function request(string $url, array $headers, string $body, int $timeoutMs = 1500): array
    {
        if (!extension_loaded('curl') || strlen($body) > 16777216) { throw new \RuntimeException('CONFIGURATION.HTTP'); }
        $target = $this->guard->validate($url, $this->allowedHosts); $curl = curl_init($url);
        $response = ''; $responseHeaders = []; $limit = false; $headerBytes = 0;
        curl_setopt_array($curl, [CURLOPT_POST => true, CURLOPT_POSTFIELDS => $body, CURLOPT_HTTPHEADER => $headers, CURLOPT_RETURNTRANSFER => false, CURLOPT_FOLLOWLOCATION => false, CURLOPT_PROTOCOLS => CURLPROTO_HTTPS, CURLOPT_CONNECTTIMEOUT_MS => min(500, $timeoutMs), CURLOPT_TIMEOUT_MS => $timeoutMs, CURLOPT_SSL_VERIFYPEER => true, CURLOPT_SSL_VERIFYHOST => 2, CURLOPT_PROXY => '', CURLOPT_RESOLVE => [$target['host'] . ':443:' . implode(',', array_map(static fn(string $ip): string => str_contains($ip, ':') ? '[' . $ip . ']' : $ip, $target['ips']))], CURLOPT_WRITEFUNCTION => static function ($handle, string $chunk) use (&$response, &$limit): int { if (strlen($response) + strlen($chunk) > 1048576) { $limit = true; return 0; } $response .= $chunk; return strlen($chunk); }, CURLOPT_HEADERFUNCTION => static function ($handle, string $line) use (&$responseHeaders, &$headerBytes, &$limit): int { $headerBytes += strlen($line); if ($headerBytes > 65536) { $limit = true; return 0; } $parts = explode(':', $line, 2); if (count($parts) === 2) { $responseHeaders[strtolower(trim($parts[0]))] = trim($parts[1]); } return strlen($line); }]);
        try {
            $ok = curl_exec($curl); $status = (int)curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($ok === false) { throw new \RuntimeException($limit ? 'PROVIDER.RESPONSE_LIMIT' : 'PROVIDER.TRANSPORT'); }
            return ['status' => $status, 'body' => $response, 'headers' => $responseHeaders];
        } finally { curl_close($curl); }
    }
}
