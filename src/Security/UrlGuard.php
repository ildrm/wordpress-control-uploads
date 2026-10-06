<?php
declare(strict_types=1);
namespace ContentFirewall\Security;
final class UrlGuard
{
    /** @return array{host:string,port:int,ips:list<string>} */
    public function validate(string $url, array $allowedHosts = []): array
    {
        $parts = parse_url($url);
        if (!$parts || ($parts['scheme'] ?? '') !== 'https' || empty($parts['host']) || isset($parts['user']) || isset($parts['pass']) || isset($parts['fragment']) || ($parts['port'] ?? 443) !== 443 || preg_match('/[\x00-\x20\\\\]/', $url)) { throw new \RuntimeException('SECURITY.URL'); }
        $host = strtolower($parts['host']);
        if (!preg_match('/^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z]{2,63}$/D', $host) || ($allowedHosts && !in_array($host, $allowedHosts, true))) { throw new \RuntimeException('SECURITY.URL_HOST'); }
        $records = dns_get_record($host, DNS_A | DNS_AAAA);
        $ips = [];
        foreach ($records ?: [] as $record) {
            $ip = $record['ip'] ?? $record['ipv6'] ?? '';
            if ($ip === '') { continue; }
            if (!self::publicIp($ip)) { throw new \RuntimeException('SECURITY.URL_PRIVATE'); }
            $ips[] = $ip;
        }
        if (!$ips) { throw new \RuntimeException('SECURITY.URL_DNS'); }
        return ['host' => $host, 'port' => 443, 'ips' => array_values(array_unique($ips))];
    }
    public static function publicIp(string $ip): bool
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) { return false; }
        if (str_contains($ip, ':')) { return str_starts_with(strtolower($ip), '2') || str_starts_with(strtolower($ip), '3'); }
        $parts = array_map('intval', explode('.', $ip));
        return !($parts[0] === 100 && $parts[1] >= 64 && $parts[1] <= 127) && !str_starts_with($ip, '169.254.') && !str_starts_with($ip, '192.0.0.');
    }
}
