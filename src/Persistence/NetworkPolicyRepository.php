<?php
declare(strict_types=1);
namespace ContentFirewall\Persistence;
use ContentFirewall\Domain\Policy;
use ContentFirewall\Policy\Schema;

/** Network snapshots have a reserved namespace and a network-wide monotonic version. */
final class NetworkPolicyRepository
{
    public function __construct(private \wpdb $db) {}
    public function save(array $data): Policy
    {
        if (!is_multisite() || !current_user_can('manage_network_options')) { throw new \RuntimeException('SECURITY.NETWORK_POLICY'); }
        $policy = (new Schema())->parse($data); $network = get_current_network_id(); $lock = 'cf-network-policy-' . $network;
        if ((int)$this->db->get_var($this->db->prepare('SELECT GET_LOCK(%s,0)', $lock)) !== 1) { throw new \RuntimeException('POLICY.NETWORK_BUSY'); }
        try {
            $current = get_site_option('cf_enforced_policy', []);
            $sequence = max((int)get_site_option('cf_network_policy_sequence', 0), (int)($current['version'] ?? 0)) + 1;
            if ($sequence > 4294967295) { throw new \RuntimeException('POLICY.VERSION_LIMIT'); }
            $data = $policy->toArray();
            $data['id'] = str_starts_with($policy->id, 'network-') ? $policy->id : 'network-' . substr(hash('sha256', $policy->id), 0, 40);
            $data['version'] = $sequence; $policy = (new Schema())->parse($data);
            // Persist the counter first: a failed snapshot write may leave a harmless version gap.
            if (!update_site_option('cf_network_policy_sequence', $sequence)) { throw new \RuntimeException('DATABASE.POLICY_SNAPSHOT'); }
            if (!update_site_option('cf_enforced_policy', $policy->toArray())) { throw new \RuntimeException('DATABASE.POLICY_SNAPSHOT'); }
            return $policy;
        } finally { $this->db->get_var($this->db->prepare('SELECT RELEASE_LOCK(%s)', $lock)); }
    }
}
