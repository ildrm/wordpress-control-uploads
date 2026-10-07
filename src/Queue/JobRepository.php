<?php
declare(strict_types=1);
namespace ContentFirewall\Queue;
use ContentFirewall\Persistence\Tables;
final class JobRepository
{
    public function __construct(private \wpdb $db, private Tables $tables, private int $siteId, private int $leaseSeconds = 120) {}
    public function enqueue(string $kind, array $payload, string $idempotency, int $priority = 0): void
    {
        $json = json_encode($payload, JSON_THROW_ON_ERROR);
        if (strlen($json) > 16384 || !in_array($kind, ['scan', 'library', 'webhook', 'rescan', 'retention'], true)) { throw new \InvalidArgumentException('QUEUE.PAYLOAD'); }
        if ($this->depth() >= 10000) { throw new \RuntimeException('QUEUE.BACKPRESSURE'); }
        $now = gmdate('Y-m-d H:i:s');
        if ($this->db->query($this->db->prepare('INSERT IGNORE INTO %i (site_id,idempotency,kind,payload,priority,available_at,created_at) VALUES (%d,%s,%s,%s,%d,%s,%s)', $this->tables->name('jobs'), $this->siteId, hash('sha256', $idempotency), $kind, $json, $priority, $now, $now)) === false) { throw new \RuntimeException('DATABASE.ENQUEUE'); }
    }
    public function claim(): ?array
    {
        $table = $this->tables->name('jobs');
        $previous = $this->db->suppress_errors(true);
        try {
            for ($attempt = 0; $attempt < 5; $attempt++) {
                // Reclaim only expired ownership, never an active lease.
                $ok = $this->db->query($this->db->prepare("UPDATE %i SET status=IF(attempts>=5,'dead','ready'),error_code=IF(attempts>=5,'QUEUE.LEASE_EXHAUSTED',error_code),lease_token=NULL,lease_until=NULL WHERE site_id=%d AND status='leased' AND lease_until<UTC_TIMESTAMP() LIMIT 1000", $table, $this->siteId));
                if ($ok === false) { if ($this->retryableDbError()) { usleep(random_int(10000, 50000)); continue; } throw new \RuntimeException('DATABASE.CLAIM'); }
                if ($this->db->query('START TRANSACTION') === false) { throw new \RuntimeException('DATABASE.CLAIM'); }
                try {
                    $job = $this->db->get_row($this->db->prepare("SELECT id,kind,payload,attempts FROM %i WHERE site_id=%d AND status='ready' AND available_at<=UTC_TIMESTAMP() ORDER BY priority DESC,id ASC LIMIT 1 FOR UPDATE SKIP LOCKED", $table, $this->siteId), ARRAY_A);
                    if ($this->db->last_error !== '') { throw new \RuntimeException($this->retryableDbError() ? 'DATABASE.RETRY' : 'DATABASE.CLAIM'); }
                    if (!$job) { if ($this->db->query('COMMIT') === false) { throw new \RuntimeException('DATABASE.COMMIT'); } return null; }
                    $token = bin2hex(random_bytes(16));
                    $changed = $this->db->query($this->db->prepare("UPDATE %i SET status='leased',lease_token=%s,lease_until=DATE_ADD(UTC_TIMESTAMP(),INTERVAL %d SECOND),attempts=attempts+1 WHERE site_id=%d AND id=%d AND status='ready'", $table, $token, $this->leaseSeconds, $this->siteId, $job['id']));
                    if ($changed !== 1) { throw new \RuntimeException($this->retryableDbError() ? 'DATABASE.RETRY' : 'DATABASE.CLAIM'); }
                    if ($this->db->query('COMMIT') === false) { throw new \RuntimeException('DATABASE.COMMIT'); } $job['lease_token'] = $token; $job['attempts'] = (int)$job['attempts'] + 1; return $job;
                } catch (\Throwable $e) {
                    $this->db->query('ROLLBACK');
                    if ($e->getMessage() !== 'DATABASE.RETRY') { throw $e; }
                    usleep(random_int(10000, 50000));
                }
            }
            throw new \RuntimeException('DATABASE.CLAIM');
        } finally { $this->db->suppress_errors($previous); }
    }
    private function retryableDbError(): bool { return preg_match('/Deadlock|Lock wait timeout/i', $this->db->last_error) === 1; }
    public function finish(int $id, string $token): bool { return $this->db->query($this->db->prepare("UPDATE %i SET status='done',lease_token=NULL,lease_until=NULL WHERE site_id=%d AND id=%d AND lease_token=%s AND status='leased' AND lease_until>UTC_TIMESTAMP()", $this->tables->name('jobs'), $this->siteId, $id, $token)) === 1; }
    public function renew(int $id, string $token): void
    {
        $result = $this->db->query($this->db->prepare("UPDATE %i SET lease_until=DATE_ADD(UTC_TIMESTAMP(),INTERVAL %d SECOND) WHERE site_id=%d AND id=%d AND lease_token=%s AND status='leased' AND lease_until>UTC_TIMESTAMP()", $this->tables->name('jobs'), $this->leaseSeconds, $this->siteId, $id, $token));
        if ($result === false) { throw new \RuntimeException('DATABASE.LEASE'); }
        // A renewal in the same second may report zero changed rows; confirm live ownership.
        if ($result === 0 && !$this->db->get_var($this->db->prepare("SELECT id FROM %i WHERE site_id=%d AND id=%d AND lease_token=%s AND status='leased' AND lease_until>UTC_TIMESTAMP()", $this->tables->name('jobs'), $this->siteId, $id, $token))) { throw new \RuntimeException('QUEUE.LEASE_EXPIRED'); }
    }
    public function fail(int $id, string $token, int $attempt, string $code, bool $retryable): bool
    {
        $dead = !$retryable || $attempt >= 5; $delay = min(3600, 2 ** min(10, $attempt) * 5) + random_int(0, 10);
        return $this->db->query($this->db->prepare('UPDATE %i SET status=%s,available_at=DATE_ADD(UTC_TIMESTAMP(),INTERVAL %d SECOND),lease_token=NULL,lease_until=NULL,error_code=%s WHERE site_id=%d AND id=%d AND lease_token=%s AND lease_until>UTC_TIMESTAMP()', $this->tables->name('jobs'), $dead ? 'dead' : 'ready', $delay, $code, $this->siteId, $id, $token)) === 1;
    }
    public function depth(): int { return (int)$this->db->get_var($this->db->prepare("SELECT COUNT(*) FROM %i WHERE site_id=%d AND status IN ('ready','leased')", $this->tables->name('jobs'), $this->siteId)); }
    public function status(): array { return $this->db->get_results($this->db->prepare('SELECT status,COUNT(*) AS count,MIN(created_at) AS oldest FROM %i WHERE site_id=%d GROUP BY status', $this->tables->name('jobs'), $this->siteId), ARRAY_A); }
    public function exhausted(int $limit = 20): array
    {
        return $this->db->get_results($this->db->prepare("SELECT id,payload FROM %i WHERE site_id=%d AND status='dead' AND kind IN ('scan','rescan') AND error_code='QUEUE.LEASE_EXHAUSTED' ORDER BY id LIMIT %d", $this->tables->name('jobs'), $this->siteId, min(100, max(1, $limit))), ARRAY_A);
    }
    public function reconciled(int $id): void
    {
        if ($this->db->query($this->db->prepare("UPDATE %i SET error_code='QUEUE.LEASE_RECONCILED' WHERE site_id=%d AND id=%d AND status='dead' AND error_code='QUEUE.LEASE_EXHAUSTED'", $this->tables->name('jobs'), $this->siteId, $id)) === false) { throw new \RuntimeException('DATABASE.TRANSITION'); }
    }
}
