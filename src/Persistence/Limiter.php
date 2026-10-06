<?php
declare(strict_types=1);
namespace ContentFirewall\Persistence;
final class Limiter
{
    public function __construct(private \wpdb $db, private Tables $tables) {}
    public function consume(string $scope, int $maximum, int $window): bool
    {
        if ($maximum < 1 || $window < 1) { return false; }
        $bucket = hash('sha256', $scope . ':' . intdiv(time(), $window)); $expiry = gmdate('Y-m-d H:i:s', (intdiv(time(), $window) + 1) * $window);
        return $this->consumeBucket($bucket, $maximum, $expiry);
    }
    public function consumeMonth(string $scope, int $maximum): bool
    {
        if ($maximum < 1) { return false; }
        $start = new \DateTimeImmutable('first day of next month 00:00:00', new \DateTimeZone('UTC'));
        return $this->consumeBucket(hash('sha256', $scope . ':' . gmdate('Y-m')), $maximum, $start->format('Y-m-d H:i:s'));
    }
    private function consumeBucket(string $bucket, int $maximum, string $expiry): bool
    {
        $this->db->query($this->db->prepare('INSERT IGNORE INTO %i (bucket,uses,expires_at) VALUES (%s,0,%s)', $this->tables->name('limits'), $bucket, $expiry));
        return $this->db->query($this->db->prepare('UPDATE %i SET uses=uses+1 WHERE bucket=%s AND uses<%d', $this->tables->name('limits'), $bucket, $maximum)) === 1;
    }
}
