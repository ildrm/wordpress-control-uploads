<?php
declare(strict_types=1);
namespace ContentFirewall\Persistence;
use ContentFirewall\Domain\Policy;
use ContentFirewall\Policy\{Presets, Schema};
final class PolicyRepository
{
    public function __construct(private \wpdb $db, private Tables $tables) {}
    public function save(array $data, int $actorId): Policy
    {
        $policy = (new Schema())->parse($data);
        $version = (int)$this->db->get_var($this->db->prepare('SELECT MAX(version) FROM %i WHERE policy_id=%s', $this->tables->name('policies'), $policy->id)) + 1;
        // Unique key rejects concurrent version creation; caller retries after reloading.
        $data = $policy->toArray(); $data['version'] = $version; $policy = (new Schema())->parse($data);
        if ($this->db->insert($this->tables->name('policies'), ['policy_id' => $policy->id, 'version' => $version, 'name' => $policy->name, 'payload' => json_encode($data, JSON_THROW_ON_ERROR), 'actor_id' => $actorId, 'created_at' => gmdate('Y-m-d H:i:s')]) === false) { throw new \RuntimeException('DATABASE.POLICY_CONFLICT'); }
        update_option('cf_active_policy', ['id' => $policy->id, 'version' => $version], false); return $policy;
    }
    public function get(string $id, int $version): Policy
    {
        $payload = $this->db->get_var($this->db->prepare('SELECT payload FROM %i WHERE policy_id=%s AND version=%d', $this->tables->name('policies'), $id, $version));
        if (!$payload) { throw new \RuntimeException('POLICY.NOT_FOUND'); }
        return (new Schema())->parse(json_decode($payload, true, 32, JSON_THROW_ON_ERROR));
    }
    public function active(): Policy
    {
        // A network-enforced snapshot is authoritative; site administrators cannot relax it.
        $network = is_multisite() ? get_site_option('cf_enforced_policy', null) : null;
        if (is_array($network)) { $policy = (new Schema())->parse($network); $this->pin($policy); return $policy; }
        $ref = get_option('cf_active_policy');
        if (is_array($ref)) { return $this->get($ref['id'], (int)$ref['version']); }
        $policy = (new Presets())->make('Security Only'); $this->pin($policy); return $policy;
    }
    private function pin(Policy $policy): void
    {
        $payload = json_encode($policy->toArray(), JSON_THROW_ON_ERROR);
        $existing = $this->db->get_var($this->db->prepare('SELECT payload FROM %i WHERE policy_id=%s AND version=%d', $this->tables->name('policies'), $policy->id, $policy->version));
        if ($existing && $existing !== $payload) { throw new \RuntimeException('POLICY.NETWORK_SNAPSHOT_CONFLICT'); }
        if (!$existing && $this->db->insert($this->tables->name('policies'), ['policy_id' => $policy->id, 'version' => $policy->version, 'name' => $policy->name, 'payload' => $payload, 'actor_id' => 0, 'created_at' => gmdate('Y-m-d H:i:s')]) === false) { throw new \RuntimeException('DATABASE.POLICY_SNAPSHOT'); }
    }
    public function page(int $after = 0): array { return $this->db->get_results($this->db->prepare('SELECT id,policy_id,version,name,created_at FROM %i WHERE id>%d ORDER BY id LIMIT 100', $this->tables->name('policies'), $after), ARRAY_A); }
}
