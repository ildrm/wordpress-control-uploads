<?php
declare(strict_types=1);
$_SERVER['HTTP_HOST'] = 'localhost:8887'; $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
require (getenv('CF_WP_ROOT') ?: '/var/www/html') . '/wp-load.php';
if (wp_get_environment_type() !== 'development' || !is_multisite()) { throw new RuntimeException('Requires isolated development multisite.'); }
global $wpdb; wp_set_current_user(1); $passed=0;
$check=static function(bool $ok,string $label)use(&$passed):void{if(!$ok)throw new RuntimeException('FAIL: '.$label);$passed++;echo 'PASS: '.$label.PHP_EOL;};
$first = new ContentFirewall\Bootstrap\Services($wpdb); $first->policies->save((new ContentFirewall\Policy\Presets())->make('Security Only')->toArray(),1);
$path=tempnam(sys_get_temp_dir(),'cf-tenant-');file_put_contents($path,'Harmless tenant fixture.');$result=$first->scanner->receive($path,'tenant.txt','text/plain',new ContentFirewall\Domain\UploadContext(get_current_blog_id(),1));$row=$first->scans->get($result['id']);
$blog=get_blog_id_from_url('localhost','/cf-tenant-two/') ?: wpmu_create_blog('localhost','/cf-tenant-two/','Tenant Two',1);
if(is_wp_error($blog))throw new RuntimeException('Site creation failed');
switch_to_blog((int)$blog);
try{
    $check($first->tables->name('scans') !== $wpdb->prefix . 'cf_scans','Existing tenant services retain their original table prefix');
    try{(new ContentFirewall\Application\Publisher($first))->publish((int)$row['id'],(int)$row['revision']);$check(false,'Publication cannot use another active tenant');}catch(RuntimeException $e){$check($e->getMessage()==='SECURITY.TENANT','Publication cannot use another active tenant');}
    ContentFirewall\WordPress\Lifecycle::site($wpdb);$second=new ContentFirewall\Bootstrap\Services($wpdb);
    try{$second->scans->get((int)$row['id']);$check(false,'Foreign scan denied');}catch(RuntimeException $e){$check($e->getMessage()==='DATABASE.NOT_FOUND','Foreign scan denied');}
    try{$second->storage->path($row['private_key'],get_current_blog_id());$check(false,'Foreign private file denied');}catch(RuntimeException $e){$check($e->getMessage()==='STORAGE.NOT_FOUND','Foreign private file denied');}
    $check($second->audit->page()===[],'Foreign audit hidden');
    $network=(new ContentFirewall\Policy\Presets())->make('Corporate')->toArray();$network['id']='network-corporate';update_site_option('cf_enforced_policy',$network);
    $active=$second->policies->active();$check($active->id==='network-corporate','Network policy is authoritative');$check($second->policies->get($active->id,$active->version)->toArray()===$active->toArray(),'Network snapshot pinned for async workers');
    $subscriber=username_exists('cf-subscriber');wp_set_current_user((int)$subscriber);$response=rest_get_server()->dispatch(new WP_REST_Request('POST','/content-firewall/v1/network-policy'));$check($response->get_status()===403,'Network policy mutation requires network permission');
}finally{delete_site_option('cf_enforced_policy');restore_current_blog();unlink($path);wp_set_current_user(1);}
echo json_encode(['multisite_assertions'=>$passed],JSON_THROW_ON_ERROR).PHP_EOL;
