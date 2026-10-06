<?php
declare(strict_types=1);
require (getenv('CF_WP_ROOT') ?: '/var/www/html') . '/wp-load.php';
if (wp_get_environment_type() !== 'development') { exit(2); }
global $wpdb; $s = new ContentFirewall\Bootstrap\Services($wpdb); $claimed = [];
while ($job = $s->jobs->claim()) {
    $claimed[] = (int)$job['id']; usleep(random_int(1000, 5000));
    if (!$s->jobs->finish((int)$job['id'], $job['lease_token'])) { exit(3); }
}
echo json_encode($claimed, JSON_THROW_ON_ERROR);
