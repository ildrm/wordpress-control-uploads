<?php
declare(strict_types=1);
namespace ContentFirewall\WordPress;
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Privacy\RecordLifecycle;

final class PrivacyTools
{
    /** @param callable():Services $factory */
    public function __construct(private $factory) {}
    public function register(): void
    {
        add_filter('wp_privacy_personal_data_exporters', function (array $exporters): array { $exporters['content-firewall'] = ['exporter_friendly_name' => __('Content Firewall upload records', 'content-firewall'), 'callback' => [$this, 'export']]; return $exporters; });
        add_filter('wp_privacy_personal_data_erasers', function (array $erasers): array { $erasers['content-firewall'] = ['eraser_friendly_name' => __('Content Firewall upload records', 'content-firewall'), 'callback' => [$this, 'erase']]; return $erasers; });
        add_action('admin_init', static function (): void {
            if (function_exists('wp_add_privacy_policy_content')) { wp_add_privacy_policy_content(__('Content Firewall', 'content-firewall'), '<p>' . esc_html__('We inspect uploads under the site content and security policies. Configured scanning providers may receive private metadata-reduced derivatives. Pending originals, moderation metadata and audit records expire under the configured retention limits. You can request review, access or erasure through the site administrator. Identify the enabled providers and processing regions in this disclosure before publishing it.', 'content-firewall') . '</p>'); }
        });
    }

    private function services(): Services
    {
        $s = ($this->factory)(); if ($s->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); } return $s;
    }

    /** @phpstan-impure */
    private function ids(Services $s, string $query): array
    {
        $ids = $s->db->get_col($query);
        if ($s->db->last_error !== '') { throw new \RuntimeException('DATABASE.ERASURE'); }
        return $ids;
    }

    public function export(string $email, int $page = 1): array
    {
        $user = get_user_by('email', $email); if (!$user) { return ['data' => [], 'done' => true]; }
        $s = $this->services(); $offset = min(10000000, max(0, $page - 1)) * 100; $db = $s->db; $uid = (int)$user->ID; $items = []; $done = true;
        $queries = [
            'scans' => $db->prepare('SELECT id,correlation,attachment_id,state,file_name,mime,bytes,sha256,policy_id,policy_version,risk,context_json,signals_json,decision_json,created_at,updated_at,expires_at FROM %i WHERE site_id=%d AND user_id=%d ORDER BY id LIMIT 100 OFFSET %d', $s->tables->name('scans'), $s->siteId, $uid, $offset),
            'findings' => $db->prepare('SELECT t.id,t.scan_id,t.category,t.provider,t.model,t.confidence,t.payload FROM %i t JOIN %i s ON s.id=t.scan_id WHERE s.site_id=%d AND s.user_id=%d ORDER BY t.id LIMIT 100 OFFSET %d', $s->tables->name('findings'), $s->tables->name('scans'), $s->siteId, $uid, $offset),
            'cases' => $db->prepare('SELECT t.scan_id id,t.owner_id,t.team,t.priority,t.sla_at FROM %i t JOIN %i s ON s.id=t.scan_id WHERE s.site_id=%d AND (s.user_id=%d OR t.owner_id=%d) ORDER BY t.scan_id LIMIT 100 OFFSET %d', $s->tables->name('cases'), $s->tables->name('scans'), $s->siteId, $uid, $uid, $offset),
            'notes' => $db->prepare('SELECT t.id,t.scan_id,t.actor_id,t.action,t.reason,t.created_at FROM %i t JOIN %i s ON s.id=t.scan_id WHERE s.site_id=%d AND (s.user_id=%d OR t.actor_id=%d) ORDER BY t.id LIMIT 100 OFFSET %d', $s->tables->name('case_notes'), $s->tables->name('scans'), $s->siteId, $uid, $uid, $offset),
            'appeals' => $db->prepare('SELECT id,scan_id,user_id,reason,status,reviewer_id,resolution,created_at,resolved_at FROM %i WHERE user_id=%d OR reviewer_id=%d ORDER BY id LIMIT 100 OFFSET %d', $s->tables->name('appeals'), $uid, $uid, $offset),
            'audit' => $db->prepare("SELECT t.id,t.actor_id,t.object_id,t.event,t.metadata,t.created_at FROM %i t LEFT JOIN %i s ON s.id=t.object_id AND s.site_id=t.site_id WHERE t.site_id=%d AND (t.actor_id=%d OR s.user_id=%d OR JSON_UNQUOTE(JSON_EXTRACT(t.metadata,'$.owner_id'))=%s) ORDER BY t.id LIMIT 100 OFFSET %d", $s->tables->name('audit'), $s->tables->name('scans'), $s->siteId, $uid, $uid, (string)$uid, $offset),
            'policy-authorship' => $db->prepare('SELECT id,policy_id,version,name,created_at FROM %i WHERE actor_id=%d ORDER BY id LIMIT 100 OFFSET %d', $s->tables->name('policies'), $uid, $offset),
            'feedback' => $db->prepare('SELECT id,scan_id,category,predicted,observed,provider,model,actor_id,created_at FROM %i WHERE actor_id=%d ORDER BY id LIMIT 100 OFFSET %d', $s->tables->name('evaluations'), $uid, $offset),
        ];
        foreach ($queries as $group => $query) {
            $rows = $db->get_results($query, ARRAY_A); if ($db->last_error !== '') { throw new \RuntimeException('DATABASE.PRIVACY_EXPORT'); }
            if (count($rows) === 100) { $done = false; }
            foreach ($rows as $row) { $items[] = ['group_id' => 'cf-' . $group, 'group_label' => __('Content Firewall records', 'content-firewall') . ' (' . $group . ')', 'item_id' => 'cf-' . $group . '-' . $row['id'], 'data' => [['name' => __('Record', 'content-firewall'), 'value' => json_encode($row, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)]]]; }
        }
        if ($page <= 1) {
            $preferences = get_user_meta($uid, 'cf_queue_views_' . $s->siteId, true); if (is_array($preferences) && $preferences) { $items[] = ['group_id' => 'cf-preferences', 'group_label' => __('Content Firewall preferences', 'content-firewall'), 'item_id' => 'cf-preferences', 'data' => [['name' => __('Saved queue views', 'content-firewall'), 'value' => json_encode($preferences, JSON_THROW_ON_ERROR)]]]; }
            if (get_user_meta($uid, 'cf_upload_suspended', true)) { $items[] = ['group_id' => 'cf-upload-control', 'group_label' => __('Content Firewall upload control', 'content-firewall'), 'item_id' => 'cf-upload-control', 'data' => [['name' => __('Upload suspension', 'content-firewall'), 'value' => __('Active', 'content-firewall')]]]; }
        }
        return ['data' => $items, 'done' => $done];
    }

    public function erase(string $email, int $page = 1): array
    {
        $user = get_user_by('email', $email); if (!$user) { return ['items_removed' => false, 'items_retained' => false, 'messages' => [], 'done' => true]; }
        $s = $this->services(); $db = $s->db; $uid = (int)$user->ID; $keepAudit = $s->settings['privacy_retain_audit'];
        $audits = $this->ids($s, $db->prepare("SELECT t.id FROM %i t LEFT JOIN %i s ON s.id=t.object_id AND s.site_id=t.site_id WHERE t.site_id=%d AND (t.actor_id=%d OR s.user_id=%d OR JSON_UNQUOTE(JSON_EXTRACT(t.metadata,'$.owner_id'))=%s) ORDER BY t.id LIMIT 100", $s->tables->name('audit'), $s->tables->name('scans'), $s->siteId, $uid, $uid, (string)$uid));
        // Always consume the first remaining batch: OFFSET would skip records as they disappear.
        $ids = $this->ids($s, $db->prepare('SELECT id FROM %i WHERE site_id=%d AND user_id=%d ORDER BY id LIMIT 100', $s->tables->name('scans'), $s->siteId, $uid));
        $removed = delete_user_meta($uid, 'cf_queue_views_' . $s->siteId); $done = count($ids) < 100;
        foreach ($ids as $id) { $removed = (new RecordLifecycle($s))->eraseScan((int)$id, $keepAudit) || $removed; }
        $updates = [
            ['cases', ['owner_id' => 0], 'owner_id'], ['case_notes', ['actor_id' => 0, 'reason' => ''], 'actor_id'],
            ['appeals', ['user_id' => 0, 'reason' => ''], 'user_id'], ['appeals', ['reviewer_id' => 0, 'resolution' => ''], 'reviewer_id'],
            ['policies', ['actor_id' => 0], 'actor_id'], ['evaluations', ['actor_id' => 0], 'actor_id'],
        ];
        foreach ($updates as [$table, $values, $field]) {
            $set = []; $args = [$s->tables->name($table)];
            foreach ($values as $key => $value) { $set[] = '%i=%s'; $args[] = $key; $args[] = (string)$value; }
            $args[] = $field; $args[] = $uid;
            $changed = $db->query($db->prepare('UPDATE %i SET ' . implode(',', $set) . ' WHERE %i=%d LIMIT 100', ...$args));
            if ($changed === false) { throw new \RuntimeException('DATABASE.ERASURE'); }
            $removed = $changed > 0 || $removed; if ($changed === 100) { $done = false; }
        }
        if (!$keepAudit) {
            foreach ($audits as $id) { if ($db->delete($s->tables->name('audit'), ['id' => (int)$id, 'site_id' => $s->siteId]) === false) { throw new \RuntimeException('DATABASE.ERASURE'); } }
            $removed = count($audits) > 0 || $removed; if (count($audits) === 100) { $done = false; }
        }
        $suspended = (bool)get_user_meta($uid, 'cf_upload_suspended', true); $messages = [];
        if ($keepAudit && $audits) { $messages[] = __('Signed audit records are retained until the configured audit retention limit. Private originals and identifying moderation metadata have been erased. Published WordPress media is handled separately by WordPress privacy tools.', 'content-firewall'); }
        if ($suspended) { $messages[] = __('The administrator-managed upload suspension is retained. Erasing upload records does not remove that security restriction; contact the site administrator to review it.', 'content-firewall'); }
        return ['items_removed' => $removed, 'items_retained' => ($keepAudit && count($audits) > 0) || $suspended, 'messages' => $messages, 'done' => $done];
    }
}
