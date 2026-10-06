<?php
declare(strict_types=1);
namespace ContentFirewall\WordPress;
final class PrivacyTools
{
    /** @param callable():\ContentFirewall\Bootstrap\Services $factory */
    public function __construct(private $factory) {}
    public function register(): void
    {
        add_filter('wp_privacy_personal_data_exporters', function (array $exporters): array { $exporters['content-firewall'] = ['exporter_friendly_name' => __('Content Firewall upload records', 'content-firewall'), 'callback' => [$this, 'export']]; return $exporters; });
        add_filter('wp_privacy_personal_data_erasers', function (array $erasers): array { $erasers['content-firewall'] = ['eraser_friendly_name' => __('Content Firewall upload records', 'content-firewall'), 'callback' => [$this, 'erase']]; return $erasers; });
    }
    public function export(string $email, int $page = 1): array
    {
        $user = get_user_by('email', $email); if (!$user) { return ['data' => [], 'done' => true]; } $s = ($this->factory)();
        $rows = $s->db->get_results($s->db->prepare('SELECT id,state,created_at,policy_id,policy_version FROM %i WHERE site_id=%d AND user_id=%d ORDER BY id LIMIT 100 OFFSET %d', $s->tables->name('scans'), $s->siteId, $user->ID, max(0, $page - 1) * 100), ARRAY_A);
        $items = []; foreach ($rows as $row) { $items[] = ['group_id' => 'content-firewall', 'group_label' => __('Upload moderation', 'content-firewall'), 'item_id' => 'cf-' . $row['id'], 'data' => [['name' => __('State', 'content-firewall'), 'value' => $row['state']], ['name' => __('Created', 'content-firewall'), 'value' => $row['created_at']], ['name' => __('Policy', 'content-firewall'), 'value' => $row['policy_id']]]]; }
        return ['data' => $items, 'done' => count($rows) < 100];
    }
    public function erase(string $email, int $page = 1): array
    {
        $user = get_user_by('email', $email); if (!$user) { return ['items_removed' => false, 'items_retained' => false, 'messages' => [], 'done' => true]; }
        // Metadata erasure is not implemented; disclose retention without claiming a configured expiry.
        return ['items_removed' => false, 'items_retained' => true, 'messages' => [__('Security and moderation records remain subject to the site retention policy. Contact the administrator for a reviewed erasure request.', 'content-firewall')], 'done' => true];
    }
}
