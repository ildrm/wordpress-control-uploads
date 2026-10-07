<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
if (wp_get_environment_type() !== 'development') { throw new RuntimeException('Disposable development installation required.'); }
require_once ABSPATH . 'wp-admin/includes/image.php';
use ContentFirewall\Application\{MediaJournal, MediaWithdrawal, Publisher, ReviewService};
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Domain\{Action, Decision, FileDescriptor, Finding, ProviderResult, State, UploadContext};
use ContentFirewall\Policy\Presets;
use ContentFirewall\Providers\Provider;
wp_set_current_user(1); global $wpdb; $passed = 0;
$check = static function (bool $ok, string $label) use (&$passed): void { if (!$ok) { throw new RuntimeException('FAIL: ' . $label); } $passed++; echo 'PASS: ' . $label . PHP_EOL; };
$throws = static function (callable $operation, string $code) use ($check): void { try { $operation(); } catch (Throwable $e) { $check($e->getMessage() === $code, $code); return; } throw new RuntimeException('Expected ' . $code); };
$dir = sys_get_temp_dir() . '/cf-hardening-' . bin2hex(random_bytes(6)); mkdir($dir, 0700);
$image = static function (string $name) use ($dir): string { $path = $dir . '/' . $name; $im = imagecreatetruecolor(40, 20); imagefill($im, 0, 0, imagecolorallocate($im, 220, 220, 220)); imagepng($im, $path); return $path; };
$request = static function (array $body): WP_REST_Request { $r = new WP_REST_Request('POST'); $r->set_header('content-type', 'application/json'); $r->set_body(json_encode($body, JSON_THROW_ON_ERROR)); return $r; };
$settings = get_option('cf_settings', []); $policyRef = get_option('cf_active_policy');
$s = new Services($wpdb); $s->tables->migrate(); $context = new UploadContext($s->siteId, 1); $controller = new ContentFirewall\REST\Controller(static fn(): Services => new Services($wpdb));
$receive = static fn(string $name): array => $s->scanner->receive($image($name), $name, 'image/png', $context);
try {
    $s->policies->save((new Presets())->make('Security Only')->toArray(), 1);
    $r = $receive('bulk.png'); $row = $s->scans->get($r['id']);
    $throws(fn() => $controller->bulk($request(['action' => 'reject', 'reason' => 'Synthetic invalid batch', 'items' => [['id' => $r['id'], 'revision' => (int)$row['revision']], ['id' => 123]]])), 'VALIDATION.BULK_ITEM');
    $check($s->scans->get($r['id'])['state'] === 'ALLOWED', 'Malformed bulk batch does not mutate its valid first item');
    $throws(fn() => $controller->saveSettings($request(['require_malware' => null])), 'VALIDATION.SETTINGS');
    $check(get_option('cf_settings') === $settings, 'Rejected settings do not change stored configuration');
    $p = (new Presets())->make('Custom')->toArray(); $p['options'] = ['requires_content' => true, 'requires_text' => true, 'failure_mode' => 'FAIL_OPEN']; $s->policies->save($p, 1);
    $r = $receive('required-text.png'); $row = $s->scans->get($r['id']);
    $check($s->scanner->process($r['id'], (int)$row['revision'])->action === Action::Review, 'Fail-open cannot override explicitly required text evidence');
    $p['options']['requires_text']=false; $s->policies->save($p,1); $rollback=$receive('outbox-rollback.png'); $before=$s->scans->get($rollback['id']);
    $scanner=new ContentFirewall\Application\ScanService($s->inspector,$s->security,$s->storage,$s->scans,$s->policies,$s->audit,$s->router,$s->jobs,$s->siteId,static function(){throw new RuntimeException('DATABASE.ENQUEUE');});
    $throws(fn()=>$scanner->process($rollback['id'],(int)$before['revision']),'DATABASE.ENQUEUE');
    $check($s->scans->get($rollback['id'])['revision']===$before['revision'] && $s->scans->get($rollback['id'])['state']==='PENDING_PROVIDER','Outbox failure rolls back the decision and preserves its retry revision');
    $p = (new Presets())->make('Custom')->toArray(); $p['rules'] = [['id' => 'redact', 'action' => 'SANITIZE', 'condition' => ['field' => 'pii.email', 'op' => 'gte', 'value' => 0.5]]]; $s->policies->save($p, 1);
    $text = $dir . '/redact.txt'; file_put_contents($text, 'Contact test@example.org.');
    $r = $s->scanner->receive($text, 'redact.txt', 'text/plain', $context); $row = $s->scans->get($r['id']);
    $check($s->scanner->process($r['id'], (int)$row['revision'])->action === Action::Sanitize, 'Plain text receives local DLP without an image provider');
    $row = $s->scans->get($r['id']); $attachment = (new Publisher($s))->publish($r['id'], (int)$row['revision']);
    $check(!str_contains(file_get_contents(get_attached_file($attachment, true)), 'example.org') && $s->scans->get($r['id'])['state'] === 'SANITIZED', 'SANITIZE publishes redacted text');
    $check(str_contains(file_get_contents($s->storage->path($row['private_key'], $s->siteId)), 'example.org'), 'Private original survives redaction');
    $check(!str_contains($row['signals_json'], 'example.org'), 'Raw DLP text is not persisted in scan signals');
    $factory = static fn(string $id, array $findings): Provider => new class($id, $findings) implements Provider {
        public int $calls = 0;
        public function __construct(private string $name, private array $findings) {}
        public function id(): string { return $this->name; }
        public function capabilities(): array { return ['model' => 'fixture-v1', 'features' => ['image'], 'mimes' => ['image/png'], 'regions' => ['test']]; }
        public function scan(FileDescriptor $file): ProviderResult { $this->calls++; return new ProviderResult($this->name, 'fixture-v1', $this->findings); }
    };
    $providers = [$factory('first', [new Finding('sexual.explicit', 0)]), $factory('second', [new Finding('sexual.explicit', 0)]), $factory('third', [new Finding('drug.recreational', 0)])];
    $inject = static fn(array $current): array => $providers; add_filter('cf_register_providers', $inject);
    try {
        $configured = new Services($wpdb); $p = (new Presets())->make('Custom')->toArray(); $p['bands'] = ['sexual.explicit' => ['review' => 0.5, 'block' => 0.9, 'calibrated' => false], 'drug.recreational' => ['review' => 0.5, 'block' => 0.9, 'calibrated' => false]]; $configured->policies->save($p, 1);
        $r = $configured->scanner->receive($image('coverage.png'), 'coverage.png', 'image/png', $context); $row = $configured->scans->get($r['id']);
        $check($configured->scanner->process($r['id'], (int)$row['revision'])->action === Action::Allow && $providers[2]->calls === 1, 'Routing reaches a third provider when two results leave missing evidence');
    } finally { remove_filter('cf_register_providers', $inject); }
    $provider = $factory('redaction', [new Finding('pii.email', 1, region: [0, 0, 0.5, 0.5])]); $inject = static fn(array $current): array => [$provider]; add_filter('cf_register_providers', $inject);
    try {
        $configured = new Services($wpdb); $p = (new Presets())->make('Custom')->toArray(); $p['rules'] = [['id' => 'redact', 'action' => 'SANITIZE', 'condition' => ['field' => 'pii.email', 'op' => 'gte', 'value' => 0.5]]]; $configured->policies->save($p, 1);
        $r = $configured->scanner->receive($image('region.png'), 'region.png', 'image/png', $context); $row = $configured->scans->get($r['id']); $configured->scanner->process($r['id'], (int)$row['revision']); $row = $configured->scans->get($r['id']);
        $a = (new Publisher($configured))->publish($r['id'], (int)$row['revision']); $im = imagecreatefrompng(get_attached_file($a, true));
        $check(imagecolorat($im, 2, 2) === 0 && imagecolorat($im, 35, 15) !== 0, 'Image SANITIZE applies normalized regions before publication');
    } finally { remove_filter('cf_register_providers', $inject); }
    $provider = $factory('no-region', [new Finding('pii.email', 1)]); $inject = static fn(array $current): array => [$provider]; add_filter('cf_register_providers', $inject);
    try { $configured = new Services($wpdb); $r = $configured->scanner->receive($image('no-region.png'), 'no-region.png', 'image/png', $context); $row = $configured->scans->get($r['id']); $check($configured->scanner->process($r['id'], (int)$row['revision'])->action === Action::Review, 'Unlocated sensitive image content requires review instead of false sanitation'); }
    finally { remove_filter('cf_register_providers', $inject); }
    $s->policies->save((new Presets())->make('Security Only')->toArray(), 1);
    $r = $receive('editorial.png'); $row = $s->scans->get($r['id']); $publisher = new Publisher($s); $a = $publisher->publish($r['id'], (int)$row['revision']);
    $parent = wp_insert_post(['post_type' => 'post', 'post_title' => 'Editorial parent', 'post_status' => 'draft']); wp_update_post(['ID' => $a, 'post_parent' => $parent, 'post_title' => 'Editorial title', 'post_excerpt' => 'Editorial caption']);
    $review = new ReviewService($s); $row = $s->scans->get($r['id']); $review->act($r['id'], (int)$row['revision'], 'reject', 'Synthetic reject for metadata preservation', 1); $row = $s->scans->get($r['id']); $review->act($r['id'], (int)$row['revision'], 'approve', 'Synthetic reapproval', 1);
    $check(get_post_field('post_parent', $a) == $parent && get_the_title($a) === 'Editorial title' && get_post_field('post_excerpt', $a) === 'Editorial caption', 'Reapproval preserves parent, title and caption');
    $listener=static function(){throw new RuntimeException('Synthetic notification failure');}; add_action('cf_scan_completed',$listener);
    try {$isolated=$receive('listener.png'); $check($isolated['decision']->action===Action::Allow,'A failed extension listener cannot revoke a committed decision');} finally {remove_action('cf_scan_completed',$listener);}
    $journal = new MediaJournal($s); $uploads = wp_upload_dir(); $orphan = $uploads['path'] . '/cf-' . bin2hex(random_bytes(12)) . '-orphan.png'; copy($image('orphan.png'), $orphan);
    $row = $s->scans->get($r['id']); $journal->write('publish', $r['id'], ['path' => $journal->relative($orphan), 'revision' => (int)$row['revision']]); $journal->recover();
    $check(!is_file($orphan) && is_file(get_attached_file($a, true)), 'Recovery removes an uncommitted derivative without deleting the committed file');
    $original = get_attached_file($a, true); $companion = dirname($original) . '/cf-hardening-companion-' . bin2hex(random_bytes(4)) . '.png'; copy($original, $companion);
    $journal->write('withdraw', $a, ['source' => $journal->relative($original), 'paths' => [$journal->relative($original), $journal->relative($companion)], 'hashes'=>[$journal->relative($original)=>hash_file('sha256',$original),$journal->relative($companion)=>hash_file('sha256',$companion)]]); unlink($original);
    (new MediaWithdrawal($s))->withdraw($a, $r['id']); $check(!is_file($companion) && get_post_meta($a, '_cf_local_withdrawn', true), 'Interrupted withdrawal resumes after the primary file has gone');
    $row = $s->scans->get($r['id']); $publisher->publish($r['id'], (int)$row['revision']); $check(is_file(get_attached_file($a, true)), 'Partially withdrawn accepted media can be rebuilt from the private snapshot');
    $current=get_attached_file($a,true); $bytes=file_get_contents($current); $relative=$journal->relative($current); $intent=['source'=>$relative,'paths'=>[$relative],'hashes'=>[$relative=>hash_file('sha256',$current)]];
    file_put_contents($current,'Synthetic replacement content');
    $throws(fn()=>(new MediaWithdrawal($s))->removePlanned($a,$intent),'SECURITY.MEDIA_CHANGED');
    $check(file_get_contents($current)==='Synthetic replacement content','Recovery cannot delete a file that replaced the original path'); file_put_contents($current,$bytes);
    $metadataFailure = static function () { throw new RuntimeException('Synthetic extension metadata failure'); }; add_filter('wp_generate_attachment_metadata', $metadataFailure);
    $r2 = $receive('metadata-recovery.png'); $row2 = $s->scans->get($r2['id']);
    try { $a2 = $publisher->publish($r2['id'], (int)$row2['revision']); } finally { remove_filter('wp_generate_attachment_metadata', $metadataFailure); }
    $check($journal->read('publish', $r2['id']) !== null && get_post_meta($a2, '_cf_pending', true), 'Metadata failure leaves a durable recovery intent and pending flag');
    $journal->recover(); $check($journal->read('publish', $r2['id']) === null && !get_post_meta($a2, '_cf_pending', true) && is_file(get_attached_file($a2, true)), 'Recovery completes committed attachment metadata');
    update_option('cf_settings', array_merge($settings, ['publication_gate' => true])); $gate = new ContentFirewall\WordPress\PublicationGate(static fn(): Services => $s);
    wp_update_post(['ID' => $parent, 'post_status' => 'publish', 'post_content' => '<img class="wp-image-' . $a . '">']); update_post_meta($a, '_cf_pending', 1);
    $check(is_wp_error($gate->check((object)['ID' => $parent], new WP_REST_Request('POST'))), 'Editing a published post validates media even when status is omitted'); delete_post_meta($a, '_cf_pending'); update_option('cf_settings', $settings);
    $row2 = $s->scans->get($r2['id']); $s->scans->complete($r2['id'], (int)$row2['revision'], State::Review, new Decision(Action::Review, ['fixture.pending'], [], $row2['policy_id'], (int)$row2['policy_version'], 0), [], []);
    $wpdb->update($s->tables->name('scans'), ['expires_at' => gmdate('Y-m-d H:i:s', time() - 10)], ['id' => $r2['id']]); (new ContentFirewall\Application\Retention($s))->run();
    $check(!is_file(get_attached_file($a2, true)) && $s->scans->get($r2['id'])['state'] === 'DELETED', 'Retention withdraws public derivatives of expired held scans');
    $p=(new Presets())->make('Security Only')->toArray(); $s->policies->save($p,1);
    $old=$s->scans->get($r['id']); $new=$s->scanner->receive($image('new-association.png'),'new-association.png','image/png',new UploadContext($s->siteId,1,'library')); $s->scans->associate($new['id'],$a);
    $throws(fn()=>$publisher->publish($r['id'],(int)$old['revision']),'QUEUE.STALE_RESULT');
    $throws(fn()=>$review->act($r['id'],(int)$old['revision'],'reject','Obsolete scan cannot remove current media',1),'QUEUE.STALE_RESULT');
    $check(is_file(get_attached_file($a,true)),'An obsolete scan cannot withdraw a newer attachment association');
    $p=(new Presets())->make('Custom')->toArray(); $p['options']['requires_content']=true; $s->policies->save($p,1);
    $exhausted=$receive('lease-exhaustion.png'); $lease=$s->jobs->claim();
    while($lease && json_decode($lease['payload'],true)['scan_id']!==$exhausted['id']) { $s->jobs->finish((int)$lease['id'],$lease['lease_token']); $lease=$s->jobs->claim(); }
    if(!$lease) { throw new RuntimeException('Lease fixture was not queued'); }
    $wpdb->update($s->tables->name('jobs'),['attempts'=>5,'lease_until'=>gmdate('Y-m-d H:i:s',time()-10)],['id'=>$lease['id']]);
    (new ContentFirewall\Queue\Worker($s))->run(1,1);
    $check($s->scans->get($exhausted['id'])['state']==='FAILED','Repeated expired leases produce a visible failed scan instead of permanent pending state');
    $s->policies->save((new Presets())->make('Security Only')->toArray(), 1);
    $wpdb->query($wpdb->prepare("UPDATE %i SET status='done' WHERE status='ready'", $s->tables->name('jobs')));
    echo json_encode(['hardening_regressions' => $passed, 'wordpress' => $GLOBALS['wp_version'], 'php' => PHP_VERSION], JSON_THROW_ON_ERROR) . PHP_EOL;
} finally {
    update_option('cf_settings', $settings); if ($policyRef) { update_option('cf_active_policy', $policyRef); } else { delete_option('cf_active_policy'); }
    foreach (glob($dir . '/*') ?: [] as $path) { unlink($path); } rmdir($dir);
}
