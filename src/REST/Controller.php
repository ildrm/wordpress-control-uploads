<?php
declare(strict_types=1);
namespace ContentFirewall\REST;
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Application\{ReviewService, ScanService};
use ContentFirewall\Domain\Finding;
use ContentFirewall\Policy\{Engine, Presets, Schema};
final class Controller
{
    /** @param callable():Services $factory */
    public function __construct(private $factory) {}
    public function register(): void
    {
        $routes = [
            '/scans' => ['GET', 'review_content_firewall_queue', 'scans'],
            '/scans/(?P<id>\d+)' => ['GET', 'review_content_firewall_queue', 'scan'],
            '/scans/(?P<id>\d+)/action' => ['POST', 'review_content_firewall_queue', 'act'],
            '/scans/(?P<id>\d+)/preview' => ['GET', 'reveal_sensitive_content', 'preview'],
            '/bulk' => ['POST', 'review_content_firewall_queue', 'bulk'],
            '/policies' => ['GET', 'manage_content_firewall_policies', 'policies'],
            '/policy' => ['GET', 'manage_content_firewall_policies', 'policy'],
            '/policy/save' => ['POST', 'manage_content_firewall_policies', 'savePolicy'],
            '/presets' => ['GET', 'manage_content_firewall_policies', 'presets'],
            '/simulation' => ['POST', 'manage_content_firewall_policies', 'simulate'],
            '/simulation/history' => ['POST', 'manage_content_firewall_policies', 'simulateHistory'],
            '/analytics' => ['GET', 'view_content_firewall_analytics', 'analytics'],
            '/health' => ['GET', 'manage_content_firewall', 'health'],
            '/providers' => ['GET', 'manage_content_firewall_providers', 'providers'],
            '/audit' => ['GET', 'view_content_firewall_audit', 'audit'],
            '/library' => ['POST', 'manage_content_firewall', 'library'],
            '/settings' => ['GET', 'manage_content_firewall', 'settings'],
            '/settings/save' => ['POST', 'manage_content_firewall', 'saveSettings'],
            '/network-policy' => ['POST', 'manage_network_options', 'networkPolicy'],
            '/worker' => ['POST', 'manage_content_firewall', 'worker'],
            '/my-uploads' => ['GET', 'read', 'ownScans'],
            '/scans/(?P<id>\d+)/appeal' => ['POST', 'read', 'appeal'],
        ];
        foreach ($routes as $route => [$method, $cap, $handler]) {
            $args = ['after' => ['type' => 'integer', 'minimum' => 0, 'default' => 0], 'limit' => ['type' => 'integer', 'minimum' => 1, 'maximum' => 100, 'default' => 30], 'state' => ['type' => 'string', 'default' => '']];
            if (str_contains($route, '(?P<id>')) { $args['id'] = ['type' => 'integer', 'minimum' => 1]; }
            register_rest_route('content-firewall/v1', $route, ['methods' => $method, 'permission_callback' => static fn(): bool => current_user_can($cap), 'callback' => function (\WP_REST_Request $request) use ($handler) {
                try { return rest_ensure_response($this->$handler($request)); }
                catch (\Throwable $e) { $code = ScanService::errorCode($e); $status = str_contains($code, 'STALE') || str_contains($code, 'CONFLICT') ? 409 : (str_starts_with($code, 'SECURITY.') ? 403 : (str_contains($code, 'NOT_FOUND') ? 404 : 400)); return new \WP_Error(strtolower(str_replace('.', '_', $code)), __('The operation could not be completed. Refresh the record and check the configuration.', 'content-firewall'), ['status' => $status, 'code' => $code]); }
            }, 'args' => $args]);
        }
    }
    private function s(): Services { return ($this->factory)(); }
    private function body(\WP_REST_Request $r): array
    {
        if (strlen($r->get_body()) > 262144) { throw new \InvalidArgumentException('VALIDATION.JSON'); } $body = $r->get_json_params(); if (!is_array($body)) { throw new \InvalidArgumentException('VALIDATION.JSON'); } return $body;
    }
    public function scans(\WP_REST_Request $r): array { return $this->s()->scans->page((int)$r['after'], (int)$r['limit'], $r['state'] ?? '', isset($r['owner']) ? (int)$r['owner'] : -1); }
    public function ownScans(\WP_REST_Request $r): array
    {
        $rows = $this->s()->scans->page((int)$r['after'], (int)$r['limit'], '', -1, get_current_user_id());
        return array_map(static fn(array $row): array => array_intersect_key($row, array_flip(['id', 'state', 'created_at', 'updated_at', 'attachment_id'])), $rows);
    }
    public function scan(\WP_REST_Request $r): array
    {
        $s = $this->s(); $row = $s->scans->get((int)$r['id']);
        unset($row['private_key'], $row['sha256']); $row['findings'] = $s->scans->findings((int)$row['id']); $row['decision'] = json_decode($row['decision_json'], true, 16, JSON_THROW_ON_ERROR); unset($row['decision_json']);
        $row['notes'] = $s->db->get_results($s->db->prepare('SELECT actor_id,action,reason,created_at FROM %i WHERE scan_id=%d ORDER BY id DESC LIMIT 100', $s->tables->name('case_notes'), (int)$row['id']), ARRAY_A);
        return $row;
    }
    public function act(\WP_REST_Request $r): array
    {
        $v = $this->body($r); if (!is_int($v['revision'] ?? null) || !is_string($v['action'] ?? null) || !is_string($v['reason'] ?? null)) { throw new \InvalidArgumentException('VALIDATION.ACTION'); }
        if ($v['action'] === 'delete' && ($v['confirm'] ?? false) !== true) { throw new \InvalidArgumentException('VALIDATION.CONFIRM'); }
        return (new ReviewService($this->s()))->act((int)$r['id'], $v['revision'], $v['action'], $v['reason'], get_current_user_id(), (int)($v['owner_id'] ?? 0));
    }
    public function bulk(\WP_REST_Request $r): array
    {
        $v = $this->body($r); if (!is_array($v['items'] ?? null) || !array_is_list($v['items']) || count($v['items']) < 1 || count($v['items']) > 50 || !is_string($v['action'] ?? null) || !is_string($v['reason'] ?? null) || ($v['action'] === 'delete' && ($v['confirm'] ?? false) !== true)) { throw new \InvalidArgumentException('VALIDATION.BULK'); }
        $results = []; $service = new ReviewService($this->s());
        foreach ($v['items'] as $item) {
            if (!is_int($item['id'] ?? null) || !is_int($item['revision'] ?? null)) { throw new \InvalidArgumentException('VALIDATION.BULK_ITEM'); }
            try { $results[] = $service->act($item['id'], $item['revision'], $v['action'], $v['reason'], get_current_user_id(), (int)($v['owner_id'] ?? 0)); }
            catch (\Throwable $e) { $results[] = ['id' => $item['id'], 'error' => ScanService::errorCode($e)]; }
        }
        return $results;
    }
    public function appeal(\WP_REST_Request $r): array { $v = $this->body($r); if (!is_string($v['reason'] ?? null)) { throw new \InvalidArgumentException('VALIDATION.REASON'); } (new ReviewService($this->s()))->appeal((int)$r['id'], $v['reason'], get_current_user_id()); return ['accepted' => true]; }
    public function preview(\WP_REST_Request $r): array
    {
        $s = $this->s(); $row = $s->scans->get((int)$r['id']);
        if (array_filter($s->scans->findings((int)$row['id']), static fn(Finding $f): bool => $f->hardSecurity)) { throw new \RuntimeException('SECURITY.PREVIEW_DENIED'); }
        $file = $s->inspector->inspect($s->storage->path($row['private_key'], $s->siteId), $row['file_name'], $row['mime']);
        if (!$file->width) { throw new \RuntimeException('SECURITY.PREVIEW_UNSUPPORTED'); }
        $temp = $s->storage->temporary($s->siteId);
        try { (new \ContentFirewall\Media\ImageProcessor())->reencode($file, $temp, 800); if (filesize($temp) > 2097152) { throw new \RuntimeException('VALIDATION.PREVIEW_LIMIT'); } $s->audit->record('review.reveal', (int)$row['id'], get_current_user_id()); return ['mime' => $file->mime, 'content' => base64_encode((string)file_get_contents($temp))]; }
        finally { if (is_file($temp)) { unlink($temp); } }
    }
    public function policies(\WP_REST_Request $r): array { return $this->s()->policies->page((int)$r['after']); }
    public function policy(\WP_REST_Request $r): array { return $this->s()->policies->active()->toArray(); }
    public function savePolicy(\WP_REST_Request $r): array
    {
        if (is_multisite() && get_site_option('cf_enforced_policy') && !current_user_can('manage_network_options')) { throw new \RuntimeException('SECURITY.NETWORK_POLICY'); }
        $p = $this->s()->policies->save($this->body($r), get_current_user_id()); $this->s()->audit->record('policy.saved', 0, get_current_user_id(), ['policy' => $p->id, 'version' => $p->version]); return $p->toArray();
    }
    public function networkPolicy(\WP_REST_Request $r): array
    {
        if (!is_multisite()) { throw new \RuntimeException('CONFIGURATION.MULTISITE_REQUIRED'); }
        $p = (new Schema())->parse($this->body($r)); update_site_option('cf_enforced_policy', $p->toArray()); return $p->toArray();
    }
    public function presets(\WP_REST_Request $r): array { return array_map(static fn(string $name): array => (new Presets())->make($name)->toArray(), Presets::NAMES); }
    public function simulate(\WP_REST_Request $r): array
    {
        $v = $this->body($r); $policy = (new Schema())->parse($v['policy'] ?? []); $findings = array_map([Finding::class, 'fromArray'], $v['findings'] ?? []);
        if (count($findings) > 256 || !is_array($v['signals'] ?? [])) { throw new \InvalidArgumentException('VALIDATION.SIMULATION'); }
        return (new Engine())->decide($policy, $v['signals'] ?? [], $findings)->jsonSerialize();
    }
    public function simulateHistory(\WP_REST_Request $r): array
    {
        $v = $this->body($r); $policy = (new Schema())->parse($v['policy'] ?? []); $s = $this->s(); $counts = ['ALLOW' => 0, 'SANITIZE' => 0, 'REVIEW' => 0, 'QUARANTINE' => 0, 'BLOCK' => 0]; $last = (int)($v['after'] ?? 0);
        foreach ($s->scans->page($last, 100) as $summary) { $row = $s->scans->get((int)$summary['id']); $decision = (new Engine())->decide($policy, json_decode($row['signals_json'], true, 16, JSON_THROW_ON_ERROR), $s->scans->findings((int)$row['id'])); $counts[$decision->action->value]++; $last = (int)$row['id']; }
        return ['counts' => $counts, 'after' => $last, 'external_requests' => 0, 'limitations' => ['expired_or_unretained_signals_are_not_reconstructed']];
    }
    public function analytics(\WP_REST_Request $r): array { return (new \ContentFirewall\Analytics\Reports($this->s()))->dashboard(); }
    public function health(\WP_REST_Request $r): array { return (new \ContentFirewall\Health\Diagnostics($this->s()))->report(); }
    public function providers(\WP_REST_Request $r): array { return $this->s()->router->status(); }
    public function audit(\WP_REST_Request $r): array { return $this->s()->audit->page((int)$r['after']); }
    public function library(\WP_REST_Request $r): array { $batch = bin2hex(random_bytes(16)); $this->s()->jobs->enqueue('library', ['after' => 0, 'batch' => $batch], 'library:' . $batch); return ['queued' => true, 'batch' => $batch]; }
    public function worker(\WP_REST_Request $r): array { return (new \ContentFirewall\Queue\Worker($this->s()))->run(5, 10); }
    public function settings(\WP_REST_Request $r): array { return $this->s()->settings; }
    public function saveSettings(\WP_REST_Request $r): array
    {
        $v = $this->body($r); $allowed = ['require_malware', 'max_bytes', 'max_pixels', 'monthly_cap', 'upload_per_hour', 'delete_on_uninstall', 'publication_gate'];
        if (array_diff(array_keys($v), $allowed)) { throw new \InvalidArgumentException('VALIDATION.SETTINGS'); }
        foreach (['require_malware', 'delete_on_uninstall', 'publication_gate'] as $key) { if (isset($v[$key]) && !is_bool($v[$key])) { throw new \InvalidArgumentException('VALIDATION.SETTINGS'); } }
        foreach (['max_bytes' => 104857600, 'max_pixels' => 24000000, 'monthly_cap' => 1000000, 'upload_per_hour' => 100000] as $key => $max) { if (isset($v[$key]) && (!is_int($v[$key]) || $v[$key] < 1 || $v[$key] > $max)) { throw new \InvalidArgumentException('VALIDATION.SETTINGS'); } }
        $new = array_merge($this->s()->settings, $v); update_option('cf_settings', $new, false); $this->s()->audit->record('settings.saved', 0, get_current_user_id()); return $new;
    }
}
