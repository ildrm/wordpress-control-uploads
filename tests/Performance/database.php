<?php
declare(strict_types=1);
require (getenv('CF_WP_ROOT') ?: '/var/www/html') . '/wp-load.php';
if (wp_get_environment_type() !== 'development' || getenv('CF_ALLOW_BENCHMARK') !== '1') { throw new RuntimeException('Requires explicit isolated development benchmark permission.'); }
global $wpdb; $table = $wpdb->prefix . 'cf_bench_scans'; $source = (new ContentFirewall\Persistence\Tables($wpdb))->name('scans');
$wpdb->query($wpdb->prepare('DROP TABLE IF EXISTS %i', $table)); $wpdb->query($wpdb->prepare('CREATE TABLE %i LIKE %i', $table, $source));
$numbers = '(SELECT 0 n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9)'; $inserted = 0;
try {
    $results = [];
    foreach ([100,10000,100000,1000000] as $target) {
        while ($inserted < $target) {
            $count = min(1000, $target - $inserted);
            $sql = "INSERT INTO %i (site_id,correlation,state,sha256,file_name,mime,bytes,policy_id,policy_version,context_json,signals_json,decision_json,created_at,updated_at,expires_at) SELECT 1,LPAD(HEX(%d+a.n+b.n*10+c.n*100),32,'0'),IF(MOD(a.n+b.n*10+c.n*100,10)=0,'REVIEW_REQUIRED','ALLOWED'),REPEAT('a',64),'synthetic.png','image/png',1024,'benchmark',1,'{}','{}','{}',UTC_TIMESTAMP(),UTC_TIMESTAMP(),DATE_ADD(UTC_TIMESTAMP(),INTERVAL 7 DAY) FROM $numbers a CROSS JOIN $numbers b CROSS JOIN $numbers c LIMIT %d";
            if ($wpdb->query($wpdb->prepare($sql,$table,$inserted,$count)) === false) { throw new RuntimeException('Benchmark insertion failed'); } $inserted += $count;
        }
        $samples = []; $query = $wpdb->prepare("SELECT id,state,risk,policy_id,updated_at FROM %i WHERE site_id=1 AND state='REVIEW_REQUIRED' AND id>%d ORDER BY id LIMIT 30",$table,(int)($target/2));
        for ($i=0;$i<50;$i++) { $start=hrtime(true); $wpdb->get_results($query); $samples[]=(hrtime(true)-$start)/1000000; }
        sort($samples); $plan=$wpdb->get_results('EXPLAIN ' . $query,ARRAY_A);
        $results[]=['rows'=>$target,'filtered_scan_p95_ms'=>$samples[47],'explain'=>$plan];
    }
    echo json_encode(['database'=>$wpdb->db_version(),'results'=>$results,'peak_memory_bytes'=>memory_get_peak_usage(true),'limitations'=>['Synthetic one-tenant data, warm-cache queries, no concurrent writers, queue jobs table not benchmarked']],JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR) . PHP_EOL;
} finally { $wpdb->query($wpdb->prepare('DROP TABLE IF EXISTS %i',$table)); }
