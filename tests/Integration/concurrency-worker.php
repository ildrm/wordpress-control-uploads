<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
if (wp_get_environment_type() !== 'development' || !preg_match('/^cf_concurrency_fixture_[a-f0-9]{16}_$/D', $argv[1] ?? '') || !ctype_digit($argv[2] ?? '')) { exit(2); }
$fixture = new wpdb(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
$fixture->set_prefix($argv[1]);
$fixture->set_blog_id(1);
$jobs = new ContentFirewall\Queue\JobRepository($fixture, new ContentFirewall\Persistence\Tables($fixture), (int)$argv[2]);
$claimed = [];
while ($job = $jobs->claim()) {
    $claimed[] = (int)$job['id']; usleep(random_int(1000, 5000));
    if (!$jobs->finish((int)$job['id'], $job['lease_token'])) { exit(3); }
}
$fixture->close();
echo json_encode($claimed, JSON_THROW_ON_ERROR);
