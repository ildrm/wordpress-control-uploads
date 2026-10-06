<?php
declare(strict_types=1);
namespace ContentFirewall\Persistence;
final class AuditRepository
{
    private const SAFE_FIELDS = ['correlation', 'code', 'action', 'state', 'rule', 'policy', 'version', 'provider', 'model', 'duration_ms', 'job_id', 'revision', 'owner_id', 'count', 'reason_code', 'shadow', 'effects'];
    public function __construct(private \wpdb $db, private Tables $tables, private int $siteId, private string $key) {}
    public function record(string $event, int $objectId, int $actorId, array $metadata = []): void
    {
        if (!preg_match('/^[a-z][a-z0-9_.]{1,79}$/D', $event)) { throw new \InvalidArgumentException('VALIDATION.EVENT'); }
        $clean = array_intersect_key($metadata, array_flip(self::SAFE_FIELDS)); $json = json_encode($clean, JSON_THROW_ON_ERROR); $time = gmdate('Y-m-d H:i:s');
        $mac = hash_hmac('sha256', implode('|', [$this->siteId, $actorId, $objectId, $event, $time, $json]), $this->key);
        if ($this->db->insert($this->tables->name('audit'), ['site_id' => $this->siteId, 'actor_id' => $actorId, 'object_id' => $objectId, 'event' => $event, 'metadata' => $json, 'integrity' => $mac, 'created_at' => $time]) === false) { throw new \RuntimeException('DATABASE.AUDIT'); }
    }
    public function page(int $after = 0): array { return $this->db->get_results($this->db->prepare('SELECT id,actor_id,object_id,event,metadata,created_at FROM %i WHERE site_id=%d AND id>%d ORDER BY id LIMIT 100', $this->tables->name('audit'), $this->siteId, $after), ARRAY_A); }
    public function verify(array $row): bool { return hash_equals($row['integrity'], hash_hmac('sha256', implode('|', [$row['site_id'], $row['actor_id'], $row['object_id'], $row['event'], $row['created_at'], $row['metadata']]), $this->key)); }
}
