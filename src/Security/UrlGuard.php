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
        // PHP's reserved-range flag does not exclude documentation, benchmark or transition networks.
        $v6 = str_contains($ip, ':');
        if ($v6 && !self::inRange($ip, '2000::', 3)) { return false; }
        $denied = $v6
            ? [['2001::', 23], ['2001:db8::', 32], ['2002::', 16], ['3fff::', 20]]
            : [['100.64.0.0', 10], ['192.0.0.0', 24], ['192.0.2.0', 24], ['192.88.99.0', 24], ['198.18.0.0', 15], ['198.51.100.0', 24], ['203.0.113.0', 24], ['224.0.0.0', 4]];
        foreach ($denied as [$network, $bits]) { if (self::inRange($ip, $network, $bits)) { return false; } }
        return true;
    }
    private static function inRange(string $ip, string $network, int $bits): bool
    {
        $address = inet_pton($ip); $prefix = inet_pton($network);
        if ($address === false || $prefix === false || strlen($address) !== strlen($prefix)) { return false; }
        $bytes = intdiv($bits, 8); $remaining = $bits % 8;
        return substr($address, 0, $bytes) === substr($prefix, 0, $bytes) && (!$remaining || (ord($address[$bytes]) & (255 << (8 - $remaining))) === (ord($prefix[$bytes]) & (255 << (8 - $remaining))));
    }
}
