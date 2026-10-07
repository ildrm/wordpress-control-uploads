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
        add_filter('rest_post_dispatch', static function ($response, $server, \WP_REST_Request $request) {
            if (str_starts_with($request->get_route(), '/content-firewall/v1/')) {
                $response->header('Cache-Control', 'private, no-store, max-age=0');
                $response->header('Pragma', 'no-cache');
                $response->header('Vary', 'Cookie, Authorization, X-WP-Nonce');
            }
            return $response;
        }, 10, 3);
        $routes = [
            '/scans' => ['GET', 'review_content_firewall_queue', 'scans'],
            '/uploads' => ['POST', 'upload_files', 'upload'],
            '/uploads/(?P<id>\d+)' => ['GET', 'read', 'uploadStatus'],
            '/scans/(?P<id>\d+)' => ['GET', 'review_content_firewall_queue', 'scan'],
            '/scans/(?P<id>\d+)/action' => ['POST', 'review_content_firewall_queue', 'act'],
            '/scans/(?P<id>\d+)/preview' => ['GET', 'reveal_sensitive_content', 'preview'],
            '/bulk' => ['POST', 'review_content_firewall_queue', 'bulk'],
            '/policies' => ['GET', 'manage_content_firewall_policies', 'policies'],
            '/policy' => ['GET', 'manage_content_firewall_policies', 'policy'],
            '/policy/save' => ['POST', 'manage_content_firewall_policies', 'savePolicy'],
            '/presets' => ['GET', 'manage_content_firewall_policies', 'presets'],
            '/simulation' => ['POST', 'manage_content_firewall_policies', 'simulate'],
            '/simulation/file' => ['POST', 'manage_content_firewall_policies', 'simulateFile'],
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
            '/reviewers' => ['GET', 'review_content_firewall_queue', 'reviewers'],
            '/queue-views' => ['GET', 'review_content_firewall_queue', 'queueViews'],
            '/queue-views/save' => ['POST', 'review_content_firewall_queue', 'saveQueueViews'],
            '/onboarding' => ['GET', 'manage_content_firewall', 'onboarding'],
            '/onboarding/save' => ['POST', 'manage_content_firewall', 'saveOnboarding'],
            '/scans/(?P<id>\d+)/appeal' => ['POST', 'read', 'appeal'],
        ];
        foreach ($routes as $route => [$method, $cap, $handler]) {
            $args = ['after' => ['type' => 'integer', 'minimum' => 0, 'default' => 0], 'limit' => ['type' => 'integer', 'minimum' => 1, 'maximum' => 100, 'default' => 30], 'state' => ['type' => 'string', 'enum' => array_merge([''], array_column(\ContentFirewall\Domain\State::cases(), 'value')), 'default' => '']];
            if ($handler === 'scans') { $args['owner'] = ['type' => 'integer', 'minimum' => 0]; $args['team'] = ['type' => 'string', 'maxLength' => 64]; $args['overdue'] = ['type' => 'boolean', 'default' => false]; }
            if (str_contains($route, '(?P<id>')) { $args['id'] = ['type' => 'integer', 'minimum' => 1]; }
            register_rest_route('content-firewall/v1', $route, ['methods' => $method, 'permission_callback' => static fn(): bool => current_user_can($cap), 'callback' => function (\WP_REST_Request $request) use ($handler) {
                try { return rest_ensure_response($this->$handler($request)); }
                catch (\Throwable $e) { $code = ScanService::errorCode($e); $status = str_contains($code, 'STALE') || str_contains($code, 'CONFLICT') ? 409 : (str_starts_with($code, 'SECURITY.') ? 403 : (str_contains($code, 'NOT_FOUND') ? 404 : 400)); return new \WP_Error(strtolower(str_replace('.', '_', $code)), __('The operation could not be completed. Refresh the record and check the configuration.', 'content-firewall'), ['status' => $status, 'code' => $code]); }
            }, 'args' => $args]);
        }
    }
    private function s(): Services { return ($this->factory)(); }
    public function upload(\WP_REST_Request $r): array
    {
        $file = \ContentFirewall\WordPress\UploadedFile::fromRequest($r);
        return (new \ContentFirewall\Application\HeadlessUpload($this->s()))->receive($file['path'], $file['name'], $file['mime']);
    }
    public function uploadStatus(\WP_REST_Request $r): array { return (new \ContentFirewall\Application\HeadlessUpload($this->s()))->status((int)$r['id']); }
    public function simulateFile(\WP_REST_Request $r): array
    {
        $s = $this->s(); $file = \ContentFirewall\WordPress\UploadedFile::fromRequest($r); $raw = $r->get_param('policy');
        if ($raw !== null && (!is_string($raw) || strlen($raw) > 262144)) { throw new \InvalidArgumentException('VALIDATION.POLICY'); }
        try { $value = $raw === null ? null : json_decode($raw, true, 32, JSON_THROW_ON_ERROR); }
        catch (\JsonException) { throw new \InvalidArgumentException('VALIDATION.POLICY'); }
        if ($raw !== null && !is_array($value)) { throw new \InvalidArgumentException('VALIDATION.POLICY'); }
        $policy = $value === null ? $s->policies->active() : (new Schema())->parse($value);
        if (!$s->limiter->consume('simulation:' . get_current_user_id(), $s->settings['upload_per_hour'], 3600)) { throw new \RuntimeException('SECURITY.RATE_LIMIT'); }
        return (new \ContentFirewall\Application\FileSimulator($s))->run($file['path'], $file['name'], $file['mime'], $policy);
    }
    private function body(\WP_REST_Request $r): array
    {
        if (strlen($r->get_body()) > 262144) { throw new \InvalidArgumentException('VALIDATION.JSON'); } $body = $r->get_json_params(); if (!is_array($body)) { throw new \InvalidArgumentException('VALIDATION.JSON'); } return $body;
    }
    public function scans(\WP_REST_Request $r): array { return $this->s()->scans->page((int)$r['after'], (int)$r['limit'], $r['state'] ?? '', isset($r['owner']) ? (int)$r['owner'] : -1, -1, $r['team'], (bool)$r['overdue']); }
    public function ownScans(\WP_REST_Request $r): array
    {
        $rows = $this->s()->scans->page((int)$r['after'], (int)$r['limit'], '', -1, get_current_user_id());
        return array_map(static fn(array $row): array => array_intersect_key($row, array_flip(['id', 'state', 'created_at', 'updated_at', 'attachment_id'])), $rows);
    }
    public function scan(\WP_REST_Request $r): array
    {
        $s = $this->s(); $row = $s->scans->get((int)$r['id']);
        if ((int)$row['metadata_erased'] === 1) { throw new \RuntimeException('DATABASE.NOT_FOUND'); }
        unset($row['private_key'], $row['sha256']); $row['findings'] = $s->scans->findings((int)$row['id']); $row['decision'] = json_decode($row['decision_json'], true, 16, JSON_THROW_ON_ERROR); unset($row['decision_json']);
        $row['notes'] = $s->db->get_results($s->db->prepare('SELECT actor_id,action,reason,created_at FROM %i WHERE scan_id=%d ORDER BY id DESC LIMIT 100', $s->tables->name('case_notes'), (int)$row['id']), ARRAY_A);
        $row['case'] = $s->db->get_row($s->db->prepare('SELECT owner_id,team,priority,sla_at FROM %i WHERE scan_id=%d', $s->tables->name('cases'), (int)$row['id']), ARRAY_A);
        $row['appeals'] = $s->db->get_results($s->db->prepare('SELECT id,reason,status,resolution,created_at,resolved_at FROM %i WHERE scan_id=%d ORDER BY id DESC LIMIT 100', $s->tables->name('appeals'), (int)$row['id']), ARRAY_A);
        return $row;
    }
    public function act(\WP_REST_Request $r): array
    {
        $v = $this->body($r); if (!is_int($v['revision'] ?? null) || $v['revision'] < 0 || !is_string($v['action'] ?? null) || !is_string($v['reason'] ?? null)) { throw new \InvalidArgumentException('VALIDATION.ACTION'); }
        $this->validateAction($v);
        return (new ReviewService($this->s()))->act((int)$r['id'], $v['revision'], $v['action'], $v['reason'], get_current_user_id(), (int)($v['owner_id'] ?? 0), $v['assignment'] ?? []);
    }
    public function bulk(\WP_REST_Request $r): array
    {
        $v = $this->body($r); if (!is_array($v['items'] ?? null) || !array_is_list($v['items']) || count($v['items']) < 1 || count($v['items']) > 50 || !is_string($v['action'] ?? null) || !is_string($v['reason'] ?? null) || ($v['action'] === 'delete' && ($v['confirm'] ?? false) !== true)) { throw new \InvalidArgumentException('VALIDATION.BULK'); }
        $this->validateAction($v);
        foreach ($v['items'] as $item) { if (!is_array($item) || !is_int($item['id'] ?? null) || $item['id'] < 1 || !is_int($item['revision'] ?? null) || $item['revision'] < 0) { throw new \InvalidArgumentException('VALIDATION.BULK_ITEM'); } }
        $results = []; $service = new ReviewService($this->s());
        foreach ($v['items'] as $item) {
            try { $results[] = $service->act($item['id'], $item['revision'], $v['action'], $v['reason'], get_current_user_id(), (int)($v['owner_id'] ?? 0), $v['assignment'] ?? []); }
            catch (\Throwable $e) { $results[] = ['id' => $item['id'], 'error' => ScanService::errorCode($e)]; }
        }
        return $results;
    }
    private function validateAction(array $v): void
    {
        if (!in_array($v['action'] ?? null, ['approve', 'reject', 'quarantine', 'delete', 'rescan', 'fingerprint', 'assign', 'note', 'escalate'], true) || !is_string($v['reason'] ?? null) || mb_strlen(trim($v['reason'])) < 3 || mb_strlen(trim($v['reason'])) > 2000 || (array_key_exists('owner_id', $v) && (!is_int($v['owner_id']) || $v['owner_id'] < 0))) { throw new \InvalidArgumentException('VALIDATION.ACTION'); }
        if ($v['action'] === 'delete' && ($v['confirm'] ?? false) !== true) { throw new \InvalidArgumentException('VALIDATION.CONFIRM'); }
        if (array_key_exists('assignment', $v) && (!is_array($v['assignment']) || $v['action'] !== 'assign')) { throw new \InvalidArgumentException('VALIDATION.ASSIGNMENT'); }
        \ContentFirewall\Application\CaseAssignment::parse($v['assignment'] ?? []);
    }
    public function appeal(\WP_REST_Request $r): array { $v = $this->body($r); if (!is_string($v['reason'] ?? null)) { throw new \InvalidArgumentException('VALIDATION.REASON'); } (new ReviewService($this->s()))->appeal((int)$r['id'], $v['reason'], get_current_user_id()); return ['accepted' => true]; }
    public function preview(\WP_REST_Request $r): array
    {
        $s = $this->s(); $row = $s->scans->get((int)$r['id']);
        if ($row['expires_at'] <= gmdate('Y-m-d H:i:s')) { throw new \RuntimeException('STORAGE.EXPIRED'); }
        if (array_filter($s->scans->findings((int)$row['id']), static fn(Finding $f): bool => $f->hardSecurity)) { throw new \RuntimeException('SECURITY.PREVIEW_DENIED'); }
        $file = $s->inspector->inspect($s->storage->path($row['private_key'], $s->siteId), $row['file_name'], $row['mime']);
        if (!hash_equals($row['sha256'], $file->sha256)) { throw new \RuntimeException('STORAGE.HASH_CHANGED'); }
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
        $p = (new \ContentFirewall\Persistence\NetworkPolicyRepository($this->s()->db))->save($this->body($r)); $this->s()->audit->record('policy.network_saved', 0, get_current_user_id(), ['policy' => $p->id, 'version' => $p->version]); return $p->toArray();
    }
    public function presets(\WP_REST_Request $r): array { return array_map(static fn(string $name): array => (new Presets())->make($name)->toArray(), Presets::NAMES); }
    public function simulate(\WP_REST_Request $r): array
    {
        $v = $this->body($r);
        if (!is_array($v['policy'] ?? null) || !is_array($v['findings'] ?? []) || !array_is_list($v['findings'] ?? []) || count($v['findings'] ?? []) > 256 || !is_array($v['signals'] ?? [])) { throw new \InvalidArgumentException('VALIDATION.SIMULATION'); }
        $policy = (new Schema())->parse($v['policy']); $findings = array_map([Finding::class, 'fromArray'], $v['findings'] ?? []);
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
        $v = $this->body($r); $s = $this->s();
        if (isset($v['retention']) && is_array($v['retention'])) { $v['retention'] = array_merge($s->settings['retention'], $v['retention']); }
        if (isset($v['processing']) && is_array($v['processing'])) { $v['processing'] = array_merge($s->settings['processing'], $v['processing']); }
        $new = (new \ContentFirewall\Configuration\Settings())->parse(array_merge($s->settings, $v));
        update_option('cf_settings', $new, false); $s->audit->record('settings.saved', 0, get_current_user_id()); return $new;
    }
    public function onboarding(\WP_REST_Request $r): array { return (new \ContentFirewall\Application\Onboarding($this->s()))->status(); }
    public function saveOnboarding(\WP_REST_Request $r): array { return (new \ContentFirewall\Application\Onboarding($this->s()))->save($this->body($r), get_current_user_id()); }
    public function reviewers(\WP_REST_Request $r): array
    {
        return array_map(static fn(\WP_User $user): array => ['id' => $user->ID, 'name' => $user->display_name], get_users(['blog_id' => get_current_blog_id(), 'capability' => 'review_content_firewall_queue', 'number' => 100, 'offset' => (int)$r['after'], 'orderby' => 'ID', 'order' => 'ASC']));
    }
    public function queueViews(\WP_REST_Request $r): array { $value = get_user_meta(get_current_user_id(), 'cf_queue_views_' . get_current_blog_id(), true); return is_array($value) ? $value : []; }
    public function saveQueueViews(\WP_REST_Request $r): array
    {
        $v = $this->body($r); $views = $v['views'] ?? null;
        if (array_diff(array_keys($v), ['views']) || !is_array($views) || !array_is_list($views) || count($views) > 10) { throw new \InvalidArgumentException('VALIDATION.QUEUE_VIEWS'); }
        $ids = [];
        foreach ($views as $view) {
            if (!is_array($view) || array_diff(array_keys($view), ['id', 'name', 'state', 'owner', 'team', 'overdue']) || !is_string($view['id'] ?? null) || !preg_match('/^[a-z0-9-]{1,64}$/D', $view['id']) || isset($ids[$view['id']]) || !is_string($view['name'] ?? null) || trim($view['name']) === '' || mb_strlen($view['name']) > 80 || !in_array($view['state'] ?? null, array_merge([''], array_column(\ContentFirewall\Domain\State::cases(), 'value')), true) || !is_int($view['owner'] ?? null) || $view['owner'] < -1 || !is_string($view['team'] ?? null) || !is_bool($view['overdue'] ?? null)) { throw new \InvalidArgumentException('VALIDATION.QUEUE_VIEWS'); }
            \ContentFirewall\Application\CaseAssignment::parse(['team' => $view['team']]); $ids[$view['id']] = true;
        }
        update_user_meta(get_current_user_id(), 'cf_queue_views_' . get_current_blog_id(), $views); return $views;
    }
}
