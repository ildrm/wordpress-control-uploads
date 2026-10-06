<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { require (getenv('CF_WP_ROOT') ?: '/var/www/html') . '/wp-load.php'; }
if (wp_get_environment_type() !== 'development') { throw new RuntimeException('Disposable development installation required.'); }
require_once ABSPATH . 'wp-admin/includes/file.php'; require_once ABSPATH . 'wp-admin/includes/media.php'; require_once ABSPATH . 'wp-admin/includes/image.php';
use ContentFirewall\Application\{Publisher, ReviewService, ScanService, SecurityPipeline};
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Domain\{Action, FileDescriptor, Finding, ProviderResult, State, UploadContext};
use ContentFirewall\Policy\Presets;
use ContentFirewall\Security\MalwareScanner;
wp_set_current_user(1); global $wpdb; $passed = 0;
$check = static function (bool $ok, string $name) use (&$passed): void { if (!$ok) { throw new RuntimeException('FAIL: ' . $name); } $passed++; echo 'PASS: ' . $name . PHP_EOL; };
$throws = static function (callable $f, string $code) use ($check): void { try { $f(); } catch (Throwable $e) { $check($e->getMessage() === $code, $code); return; } throw new RuntimeException('Expected ' . $code); };
$dir = sys_get_temp_dir() . '/cf-review-' . bin2hex(random_bytes(6)); mkdir($dir, 0700);
$image = static function (string $name) use ($dir): string { $path = $dir . '/' . $name; $im = imagecreatetruecolor(40,20); imagepng($im, $path); return $path; };
$s = new Services($wpdb); $s->tables->migrate(); $context = new UploadContext(get_current_blog_id(), 1);
$policy = static function (string $mode = 'FAIL_OPEN', array $extra = []) use ($s) { $p = (new Presets())->make('Custom')->toArray(); $p['options'] = ['requires_content'=>true, 'failure_mode'=>$mode] + $extra; return $s->policies->save($p,1); };
$receive = static function (string $name) use ($s,$image,$context): array { return $s->scanner->receive($image($name),$name,'image/png',$context); };
try {
    delete_option('cf_active_policy'); $default = $s->policies->active(); $check($s->policies->get($default->id,$default->version)->id === $default->id,'Default policy snapshot is persisted');
    $s->policies->save((new Presets())->make('Security Only')->toArray(),1);
    $r=$receive('published.png'); $row=$s->scans->get($r['id']); $publisher=new Publisher($s); $attachment=$publisher->publish($r['id'],(int)$row['revision']);
    $throws(fn()=>$publisher->publish($r['id'],(int)$row['revision']),'QUEUE.STALE_RESULT');
    $public=get_attached_file($attachment,true); $thumb=dirname($public) . '/cf-review-thumb-' . bin2hex(random_bytes(4)) . '.png'; copy($public,$thumb);
    $meta=wp_get_attachment_metadata($attachment); $meta['sizes']['cf-review']=['file'=>basename($thumb),'width'=>40,'height'=>20,'mime-type'=>'image/png']; wp_update_attachment_metadata($attachment,$meta);
    $review=new ReviewService($s); $row=$s->scans->get($r['id']); $review->act($r['id'],(int)$row['revision'],'reject','Regression: rejected public fixture',1);
    $row=$s->scans->get($r['id']); $check(!is_file($public) && !is_file($thumb) && $row['state']==='BLOCKED','Rejection removes public original and thumbnail');
    $check(json_decode($row['decision_json'],true)['action']==='BLOCK','Moderator action updates recorded decision');
    $review->act($r['id'],(int)$row['revision'],'approve','Regression: reapproved private original',1); $row=$s->scans->get($r['id']);
    $check((int)$row['attachment_id']===$attachment && is_file(get_attached_file($attachment,true)) && $row['state']==='ALLOWED','Reapproval rebuilds derivative and preserves attachment ID');
    $check(json_decode($row['decision_json'],true)['action']==='ALLOW','Approval replaces stale blocked decision');
    $r2=$receive('metadata.png'); $row2=$s->scans->get($r2['id']);
    $metadataFailure=static function () { throw new RuntimeException('Extension metadata failure'); }; add_filter('wp_generate_attachment_metadata',$metadataFailure);
    try { $a2=$publisher->publish($r2['id'],(int)$row2['revision']); } finally { remove_filter('wp_generate_attachment_metadata',$metadataFailure); }
    $check(is_file(get_attached_file($a2,true)),'Metadata exception preserves committed public file');
    $many=$s->scans->latestMany([$attachment,$a2]); $check(count($many)===2 && $many[$attachment]['state']==='ALLOWED','Media summaries load in a batch');
    $oldPublic=get_attached_file($a2,true); $s->jobs->enqueue('library',['attachment_id'=>$a2],'review:library:' . bin2hex(random_bytes(4))); (new ContentFirewall\Queue\Worker($s))->run(5,10); $check(!is_file($oldPublic) && is_file(get_attached_file($a2,true)) && get_attached_file($a2,true)!==$oldPublic,'Allowed retrospective media gets a reconstructed derivative');
    $policy(); $hard=$receive('malware.png'); $hardRow=$s->scans->get($hard['id']);
    $infected=new class implements MalwareScanner { public function scan(string $path): string { return 'FOUND'; } };
    $scanner=new ScanService($s->inspector,new SecurityPipeline($infected),$s->storage,$s->scans,$s->policies,$s->audit,$s->router,$s->jobs,$s->siteId);
    $decision=$scanner->process($hard['id'],(int)$hardRow['revision']); $check($decision->action===Action::Block && !$decision->shadow,'Fail-open provider policy cannot replace queued malware block');
    $fp=$receive('fingerprint.png'); $fpRow=$s->scans->get($fp['id']); $s->scans->addFingerprint($fp['id'],'Regression fingerprint');
    $check($s->scanner->process($fp['id'],(int)$fpRow['revision'])->action===Action::Block,'Queued worker rechecks blocked fingerprints');
    // Images above share bytes; clear this test-only fingerprint before the other scenarios.
    $wpdb->delete($s->tables->name('fingerprints'),['sha256'=>$fpRow['sha256']]);
    $policy(); $retry=$receive('retry.png'); $retryRow=$s->scans->get($retry['id']);
    $flaky=new class implements MalwareScanner { public int $calls=0; public function scan(string $path): string { if (++$this->calls===1) { throw new RuntimeException('STORAGE.DERIVATIVE'); } return 'CLEAN'; } };
    $scanner=new ScanService($s->inspector,new SecurityPipeline($flaky),$s->storage,$s->scans,$s->policies,$s->audit,$s->router,$s->jobs,$s->siteId);
    $throws(fn()=>$scanner->process($retry['id'],(int)$retryRow['revision']),'STORAGE.DERIVATIVE');
    $check((int)$s->scans->get($retry['id'])['revision']===(int)$retryRow['revision'],'Failed scan attempt does not invalidate queued revision');
    $check($scanner->process($retry['id'],(int)$retryRow['revision'])->action===Action::Allow,'Same scan revision can be retried');
    $policy('FAIL_CLOSED'); $s->scanner->rescan($retry['id']); $newRow=$s->scans->get($retry['id']);
    $check((int)$newRow['policy_version']>(int)$retryRow['policy_version'],'Rescan pins current policy version');
    $check($s->scanner->process($retry['id'],(int)$newRow['revision'])->action===Action::Block,'Rescan evaluates changed failure policy');
    $before=$s->scans->get($retry['id']);
    $throws(fn()=>$s->scans->queueRescan($retry['id'],(int)$before['revision'],$s->policies->active(),static function () { throw new RuntimeException('DATABASE.ENQUEUE'); }),'DATABASE.ENQUEUE');
    $check($s->scans->get($retry['id'])['revision']===$before['revision'],'Enqueue failure rolls back rescan revision');
    // Drain obsolete fixture jobs, then simulate a crash between scan completion and publication.
    $wpdb->query($wpdb->prepare("UPDATE %i SET status='done' WHERE status='ready'",$s->tables->name('jobs')));
    $policy(); $resume=$receive('resume.png'); $resumeRow=$s->scans->get($resume['id']); $s->scanner->process($resume['id'],(int)$resumeRow['revision']);
    $worker=(new ContentFirewall\Queue\Worker($s))->run(5,10); $resumeRow=$s->scans->get($resume['id']);
    $check($worker['failed']===0 && (int)$resumeRow['attachment_id']>0,'Worker resumes publication after committed scan result');
    $policy(); $terminal=$receive('terminal.png'); $terminalRow=$s->scans->get($terminal['id']); file_put_contents($s->storage->path($terminalRow['private_key'],$s->siteId),'tampered');
    (new ContentFirewall\Queue\Worker($s))->run(5,10); $check($s->scans->get($terminal['id'])['state']==='FAILED','Terminal worker failure is visible in the review queue');
    $policy('FAIL_OPEN',['consensus'=>true]); $consensus=$receive('consensus.png'); $row=$s->scans->get($consensus['id']);
    $check($s->scanner->process($consensus['id'],(int)$row['revision'])->action===Action::Review,'Incomplete required consensus cannot allow');
    $provider=new class implements ContentFirewall\Providers\Provider {
        public function id(): string { return 'review-fixture'; }
        public function capabilities(): array { return ['model'=>'fixture-v1','features'=>['image'],'mimes'=>['image/png'],'regions'=>['test']]; }
        public function scan(FileDescriptor $file): ProviderResult { return new ProviderResult($this->id(),'fixture-v1',[new Finding('sexual.explicit',0.0,$this->id(),'fixture-v1')]); }
    };
    $inject=static fn(array $providers): array=>[$provider]; add_filter('cf_register_providers',$inject); $withProvider=new Services($wpdb);
    try { $p=(new Presets())->make('Community')->toArray(); $withProvider->policies->save($p,1); $coverage=$withProvider->scanner->receive($image('coverage.png'),'coverage.png','image/png',$context); $row=$withProvider->scans->get($coverage['id']); $decision=$withProvider->scanner->process($coverage['id'],(int)$row['revision']); $check($decision->action===Action::Review && in_array('provider.coverage_incomplete',$decision->reasons,true),'Missing category evidence requires review'); }
    finally { remove_filter('cf_register_providers',$inject); }
    update_option('cf_settings',array_merge($s->settings,['publication_gate'=>true])); $gate=new ContentFirewall\WordPress\PublicationGate(static fn():Services=>$s);
    $content=''; for($i=1;$i<=101;$i++) { $content.='<img class="wp-image-' . $i . '">'; }
    $post=(object)['post_status'=>'publish','post_content'=>$content]; $request=new WP_REST_Request('POST','/wp/v2/posts');
    $check(is_wp_error($gate->check($post,$request)),'Publication gate rejects oversized media sets');
    $postId=wp_insert_post(['post_status'=>'draft','post_title'=>'Review publication fixture','post_content'=>'']); set_post_thumbnail($postId,$attachment);
    update_post_meta($attachment,'_cf_pending',1); $check(is_wp_error($gate->check((object)['ID'=>$postId,'post_status'=>'publish'],$request)),'Pending attachment flag overrides an earlier allowed scan'); delete_post_meta($attachment,'_cf_pending');
    $row=$s->scans->get($r['id']); $review->act($r['id'],(int)$row['revision'],'quarantine','Regression: quarantined featured image',1);
    $check(is_wp_error($gate->check((object)['ID'=>$postId,'post_status'=>'publish'],$request)),'Publication update validates omitted existing featured image');
    update_option('cf_settings',$s->settings);
    $s->policies->save((new Presets())->make('Security Only')->toArray(),1);
    $sanitize=(new Presets())->make('Custom')->toArray(); $sanitize['default']='SANITIZE'; $s->policies->save($sanitize,1);
    $path=$image('sanitize.png'); $file=['name'=>'sanitize.png','tmp_name'=>$path,'type'=>'image/png','error'=>0,'size'=>filesize($path)]; $upload=wp_handle_sideload($file,['test_form'=>false]);
    $check(!isset($upload['error']),'Sanitize upload passes gateway');
    $a3=wp_insert_attachment(['post_mime_type'=>'image/png','post_status'=>'inherit'],$upload['file']);
    $check($s->scans->latest($a3)['state']==='SANITIZED','Gateway completes sanitizing state on attachment creation');
    $s->policies->save((new Presets())->make('Security Only')->toArray(),1);
    $wpdb->query($wpdb->prepare("UPDATE %i SET status='done' WHERE status='ready'",$s->tables->name('jobs')));
    echo json_encode(['review_regressions'=>$passed,'wordpress'=>$GLOBALS['wp_version'],'php'=>PHP_VERSION],JSON_THROW_ON_ERROR) . PHP_EOL;
} finally { foreach(glob($dir . '/*') ?: [] as $path) { unlink($path); } rmdir($dir); }
