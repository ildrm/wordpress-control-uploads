<?php
declare(strict_types=1);
require (getenv('CF_WP_ROOT') ?: '/var/www/html') . '/wp-load.php';
if (wp_get_environment_type() !== 'development') { throw new RuntimeException('Development only'); }
global $wpdb; $s = new ContentFirewall\Bootstrap\Services($wpdb); if ($s->jobs->depth() !== 0) { throw new RuntimeException('Concurrency test requires an empty queue; do not acknowledge unrelated work.'); } $token = bin2hex(random_bytes(8));
for ($i=0;$i<100;$i++) { $s->jobs->enqueue('retention',['concurrency'=>$token],'concurrency:' . $token . ':' . $i); }
$processes=[]; $outputs=[];
for ($i=0;$i<2;$i++) { $pipes=[]; $process=proc_open([PHP_BINARY,__DIR__ . '/concurrency-worker.php'],[0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']],$pipes); if (!is_resource($process)) { throw new RuntimeException('Child failed'); } fclose($pipes[0]); $processes[]=[$process,$pipes]; }
foreach ($processes as [$process,$pipes]) { $out=stream_get_contents($pipes[1]); $err=stream_get_contents($pipes[2]); fclose($pipes[1]); fclose($pipes[2]); $code=proc_close($process); if ($code!==0) { throw new RuntimeException('Worker failed: ' . $err); } $outputs[]=json_decode($out,true,16,JSON_THROW_ON_ERROR); }
if (array_intersect($outputs[0],$outputs[1]) || count(array_unique(array_merge(...$outputs)))<100) { throw new RuntimeException('Duplicate or missed claims'); }
echo json_encode(['workers'=>2,'distinct_claims'=>count(array_unique(array_merge(...$outputs))),'duplicate_claims'=>0],JSON_THROW_ON_ERROR) . PHP_EOL;
