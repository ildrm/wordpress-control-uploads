<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
if (wp_get_environment_type() !== 'development') { throw new RuntimeException('Development only'); }
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Domain\UploadContext;
use ContentFirewall\Policy\Presets;
use ContentFirewall\Application\{ReviewService, Onboarding};
global $wpdb; wp_set_current_user(1); $passed = 0; $settings = get_option('cf_settings'); $policy = get_option('cf_active_policy'); $step = get_option('cf_onboarding_step'); $viewKey = 'cf_queue_views_' . get_current_blog_id(); $views = get_user_meta(1, $viewKey, true);
$check = static function (bool $ok, string $name) use (&$passed): void { if (!$ok) { throw new RuntimeException('FAIL: ' . $name); } $passed++; echo 'PASS: ' . $name . PHP_EOL; };
$request = static function (string $method, string $route, ?array $body = null): WP_REST_Response { $r = new WP_REST_Request($method, '/content-firewall/v1' . $route); if ($body !== null) { $r->set_header('Content-Type', 'application/json'); $r->set_body(json_encode($body, JSON_THROW_ON_ERROR)); } return rest_get_server()->dispatch($r); };
$dir = sys_get_temp_dir() . '/cf-workflow-' . bin2hex(random_bytes(6)); mkdir($dir, 0700); $path = $dir . '/fixture.png'; $im = imagecreatetruecolor(12, 12); imagepng($im, $path); unset($im);
try {
    $s = new Services($wpdb); $s->tables->migrate(); update_option('cf_onboarding_step', 0);
    $check($request('POST', '/onboarding/save', ['step' => 3, 'complete' => true])->get_status() === 400, 'Onboarding cannot skip unfinished steps');
    $check($request('POST', '/onboarding/save', ['step' => 1])->get_status() === 200, 'Onboarding progress persists');
    $check((new Onboarding(new Services($wpdb)))->status()['step'] === 1, 'A later request resumes saved onboarding');
    $check($request('POST', '/onboarding/save', ['step' => 2, 'preset' => 'Security Only'])->get_status() === 200, 'Onboarding creates an active preset snapshot');
    $check($request('POST', '/onboarding/save', ['step' => 3, 'settings' => ['retention' => ['audit_days' => 91]]])->get_status() === 200, 'Onboarding saves typed privacy limits');
    $check($request('POST', '/onboarding/save', ['step' => 3, 'complete' => true])->get_status() === 200 && get_option('cf_settings')['onboarding_complete'], 'Onboarding completes after environment and policy steps');
    $check($request('POST', '/settings/save', ['retention' => ['private_files_days' => 3]])->get_data()['retention']['audit_days'] === 91, 'Partial retention update preserves other customized classes');
    $s = new Services($wpdb); $s->policies->save((new Presets())->make('Community')->toArray(), 1);
    $scan = $s->scanner->receive($path, 'fixture.png', 'image/png', new UploadContext($s->siteId, 1)); $row = $s->scans->get($scan['id']);
    (new ReviewService($s))->act($scan['id'], (int)$row['revision'], 'note', 'Note on pending work', 1);
    $check($s->scans->get($scan['id'])['revision'] === $row['revision'], 'Pending annotation does not invalidate queued scanner revision');
    (new ContentFirewall\Queue\Worker($s))->run(100, 20); $row = $s->scans->get($scan['id']);
    $check($row['state'] === 'QUARANTINED', 'Annotated pending work reaches a visible decision');
    $invalid = $request('POST', '/bulk', ['items' => [['id' => $scan['id'], 'revision' => (int)$row['revision']]], 'action' => 'assign', 'reason' => 'Assignment fixture', 'owner_id' => 1, 'assignment' => ['priority' => '100']]);
    $check($invalid->get_status() === 400, 'Malformed assignment is rejected before bulk mutation');
    $body = ['revision' => (int)$row['revision'], 'action' => 'assign', 'reason' => 'Assign synthetic fixture', 'owner_id' => 1, 'assignment' => ['team' => 'Trust and Safety', 'priority' => 50, 'sla_at' => gmdate('Y-m-d H:i:s', time() + 3600)]];
    $check($request('POST', '/scans/' . $scan['id'] . '/action', $body)->get_status() === 200, 'Reviewer team priority and deadline assignment succeeds');
    $check($request('POST', '/scans/' . $scan['id'] . '/action', $body)->get_status() === 409, 'Stale assignment cannot overwrite a newer revision');
    $detail = $request('GET', '/scans/' . $scan['id'])->get_data(); $check($detail['case']['team'] === 'Trust and Safety' && (int)$detail['case']['owner_id'] === 1, 'Case detail exposes persisted assignment');
    $check(count($s->scans->page(0, 100, '', 1, -1, 'Trust and Safety')) >= 1, 'Queue filters apply reviewer and team together');
    $wpdb->update($s->tables->name('cases'), ['sla_at' => '2000-01-01 00:00:00'], ['scan_id' => $scan['id']]);
    (new ReviewService($s))->escalateDue(); $check((int)$wpdb->get_var($wpdb->prepare('SELECT priority FROM %i WHERE scan_id=%d', $s->tables->name('cases'), $scan['id'])) === 100, 'Overdue unresolved cases escalate automatically');
    $check(count($s->scans->page(0, 100, '', -1, -1, null, true)) >= 1, 'Overdue filter includes unresolved breached deadlines');
    $saved = ['id' => 'qa-view', 'name' => 'My team overdue', 'state' => '', 'owner' => 1, 'team' => 'Trust and Safety', 'overdue' => true];
    $check($request('POST', '/queue-views/save', ['views' => [$saved]])->get_status() === 200 && $request('GET', '/queue-views')->get_data() === [$saved], 'Saved queue views round-trip through scoped user preferences');
    $check($request('POST', '/queue-views/save', ['views' => [$saved, $saved]])->get_status() === 400, 'Duplicate saved-view identifiers are rejected');
    $check(count($request('GET', '/reviewers')->get_data()) >= 1, 'Reviewer directory includes eligible site administrators');
    $user = wp_create_user('cf-workflow-' . bin2hex(random_bytes(4)), wp_generate_password(), 'cf-workflow-' . bin2hex(random_bytes(4)) . '@example.test'); if (is_wp_error($user)) { throw new RuntimeException('Fixture user'); }
    wp_set_current_user($user); $check($request('GET', '/reviewers')->get_status() === 403 && $request('POST', '/onboarding/save', ['step' => 0])->get_status() === 403, 'Workflow endpoints enforce granular capabilities');
    echo json_encode(['workflow_assertions' => $passed, 'wordpress' => $GLOBALS['wp_version'], 'php' => PHP_VERSION], JSON_THROW_ON_ERROR) . PHP_EOL;
} finally { wp_set_current_user(1); update_option('cf_settings', $settings); update_option('cf_active_policy', $policy); update_option('cf_onboarding_step', $step); if ($views) { update_user_meta(1, $viewKey, $views); } else { delete_user_meta(1, $viewKey); } unlink($path); rmdir($dir); }
