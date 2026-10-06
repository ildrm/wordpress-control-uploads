<?php
declare(strict_types=1);
// Execute inside an isolated real WordPress installation; never on production data.
if (!defined('ABSPATH')) { require (getenv('CF_WP_ROOT') ?: '/var/www/html') . '/wp-load.php'; }
if (wp_get_environment_type() !== 'development') { throw new RuntimeException('Integration tests require development environment.'); }
require_once ABSPATH . 'wp-admin/includes/file.php'; require_once ABSPATH . 'wp-admin/includes/media.php'; require_once ABSPATH . 'wp-admin/includes/image.php';
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Domain\{State, UploadContext};
use ContentFirewall\Policy\Presets;
use ContentFirewall\Application\{Publisher, ReviewService};
wp_set_current_user(1); global $wpdb; $passed = 0;
$check = static function (bool $condition, string $name) use (&$passed): void { if (!$condition) { throw new RuntimeException('FAIL: ' . $name); } $passed++; echo 'PASS: ' . $name . PHP_EOL; };
$s = new Services($wpdb); $s->tables->migrate(); $s->tables->migrate(); $check((int)get_option('cf_schema_version') === 1, 'Repeatable migration');
$s->policies->save((new Presets())->make('Security Only')->toArray(), 1);
$dir = sys_get_temp_dir() . '/cf-integration-' . bin2hex(random_bytes(6)); mkdir($dir, 0700);
$image = static function (string $name = 'image.png') use ($dir): string { $path = $dir . '/' . $name; $im = imagecreatetruecolor(40,20); imagefill($im,0,0,imagecolorallocate($im,24,120,160)); imagepng($im,$path); return $path; };
try {
    $path = $image(); $result = $s->scanner->receive($path,'image.png','image/png',new UploadContext(get_current_blog_id(),1)); $id = $result['id']; $row = $s->scans->get($id);
    $check($row['state'] === 'ALLOWED' && $row['attachment_id'] === '0', 'Security-only decision leaves attachment creation to gateway');
    $check($s->scans->transition($id,(int)$row['revision'],State::Allowed), 'Idempotent transition');
    $check(!$s->scans->transition($id,0,State::Blocked), 'Stale revision rejected');
    $attachment = (new Publisher($s))->publish($id,(int)$row['revision']); $check($attachment > 0 && get_post_type($attachment)==='attachment', 'Approved derivative published');
    $check((new Publisher($s))->publish($id,(int)$s->scans->get($id)['revision']) === $attachment, 'Publication retry reuses attachment');
    $path = $image('sideload.png'); $file = ['name'=>'sideload.png','tmp_name'=>$path,'type'=>'image/png','error'=>0,'size'=>filesize($path)]; $upload = wp_handle_sideload($file, ['test_form'=>false]);
    $check(!isset($upload['error']) && is_file($upload['file']), 'WordPress sideload gateway accepts clean image');
    $s->policies->save((new Presets())->make('Community')->toArray(),1);
    $path = $image('pending.png'); $file = ['name'=>'pending.png','tmp_name'=>$path,'type'=>'image/png','error'=>0,'size'=>filesize($path)]; $upload = wp_handle_sideload($file, ['test_form'=>false]);
    $check(isset($upload['error']), 'Async upload rejected before public move');
    $pending = $wpdb->get_row($wpdb->prepare("SELECT id,revision,private_key FROM %i WHERE state='PENDING_PROVIDER' ORDER BY id DESC LIMIT 1",$s->tables->name('scans')),ARRAY_A);
    $check($pending && is_file($s->storage->path($pending['private_key'],get_current_blog_id())), 'Pending original stored privately');
    (new ContentFirewall\Queue\Worker($s))->run(20,20); $row=$s->scans->get((int)$pending['id']); $check($row['state']==='QUARANTINED', 'Provider outage quarantines content');
    (new ReviewService($s))->act((int)$row['id'],(int)$row['revision'],'approve','Harmless synthetic fixture',1); $check($s->scans->get((int)$row['id'])['state']==='ALLOWED','Human review publishes checked derivative');
    $check($wpdb->get_var($wpdb->prepare('SELECT reason FROM %i WHERE scan_id=%d ORDER BY id DESC LIMIT 1',$s->tables->name('case_notes'),(int)$row['id']))==='Harmless synthetic fixture','Moderator rationale survives approval');
    $subscriber = username_exists('cf-subscriber') ?: wp_create_user('cf-subscriber','cf-test-only','subscriber@example.test'); $user = new WP_User($subscriber); $user->set_role('subscriber');
    $server = rest_get_server(); wp_set_current_user($subscriber); $request = new WP_REST_Request('GET','/content-firewall/v1/scans'); $response = $server->dispatch($request); $check($response->get_status()===403, 'REST queue requires review capability');
    $request = new WP_REST_Request('GET','/content-firewall/v1/scans/' . $id . '/preview'); $response=$server->dispatch($request); $check($response->get_status()===403,'Sensitive preview capability enforced');
    wp_set_current_user(1); $request=new WP_REST_Request('GET','/content-firewall/v1/health'); $response=$server->dispatch($request); $check($response->get_status()===200,'Authenticated health route');
    $jobKey='integration:' . bin2hex(random_bytes(4)); $s->jobs->enqueue('retention',[],$jobKey); $s->jobs->enqueue('retention',[],$jobKey); $count=$wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM %i WHERE idempotency=%s',$s->tables->name('jobs'),hash('sha256',$jobKey))); $check((int)$count===1,'Queue idempotency');
    $job=$s->jobs->claim(); $check($job!==null,'Queue lease claim'); if ($job) { $check(!$s->jobs->finish((int)$job['id'],str_repeat('0',32)),'Lease owner mismatch rejected'); $check($s->jobs->finish((int)$job['id'],$job['lease_token']),'Lease owner acknowledges'); }
    $audit=$wpdb->get_row($wpdb->prepare('SELECT * FROM %i ORDER BY id DESC LIMIT 1',$s->tables->name('audit')),ARRAY_A); $check($s->audit->verify($audit),'Audit integrity signature');
    $expired = $s->scanner->receive($image('expire.png'),'expire.png','image/png',new UploadContext(get_current_blog_id(),1)); $expiredRow=$s->scans->get($expired['id']); $privatePath=$s->storage->path($expiredRow['private_key'],get_current_blog_id());
    $wpdb->update($s->tables->name('scans'),['expires_at'=>'2000-01-01 00:00:00'],['id'=>$expired['id']]); (new ContentFirewall\Application\Retention($s))->run(); $check(!is_file($privatePath) && $s->scans->get($expired['id'])['private_key']==='', 'Expired pending media is removed and cannot publish later');
    $s->policies->save((new Presets())->make('Security Only')->toArray(),1);
    echo json_encode(['integration_assertions'=>$passed,'wordpress'=>$GLOBALS['wp_version'],'php'=>PHP_VERSION],JSON_THROW_ON_ERROR) . PHP_EOL;
} finally { foreach (glob($dir . '/*') ?: [] as $file) { unlink($file); } rmdir($dir); }
