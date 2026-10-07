<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
if (wp_get_environment_type() !== 'development') { throw new RuntimeException('Development only'); }
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Domain\UploadContext;
use ContentFirewall\Application\{Publisher, ReviewService};
use ContentFirewall\Policy\Presets;
global $wpdb; wp_set_current_user(1); $settings = get_option('cf_settings', []); $policy = get_option('cf_active_policy'); $posts = []; $passed = 0; $attachment = 0;
$check = static function (bool $ok, string $name) use (&$passed): void { if (!$ok) { throw new RuntimeException('FAIL: ' . $name); } $passed++; echo 'PASS: ' . $name . PHP_EOL; };
$root = sys_get_temp_dir() . '/cf-gate-' . bin2hex(random_bytes(6)); mkdir($root, 0700); $im = imagecreatetruecolor(12, 12); imagepng($im, $root . '/image.png'); unset($im);
try {
    update_option('cf_settings', array_merge($settings, ['publication_gate' => true])); $s = new Services($wpdb); $s->tables->migrate(); $s->policies->save((new Presets())->make('Security Only')->toArray(), 1);
    $r = $s->scanner->receive($root . '/image.png', 'image.png', 'image/png', new UploadContext($s->siteId, 1)); $row = $s->scans->get($r['id']); $attachment = (new Publisher($s))->publish($r['id'], (int)$row['revision']);
    $make = static function (array $value) use (&$posts): int { $id = wp_insert_post(['post_title' => 'Synthetic publication gate'] + $value, true); if (is_wp_error($id)) { throw new RuntimeException($id->get_error_code()); } $posts[] = $id; return $id; };
    $good = $make(['post_status' => 'publish', 'post_content' => '<img class="wp-image-' . $attachment . '">']); $check(get_post_status($good) === 'publish', 'Ordinary WordPress saves publish approved referenced media');
    $held = $make(['post_status' => 'publish', 'post_content' => '<img class="wp-image-999999999">']); $check(get_post_status($held) === 'draft', 'Ordinary WordPress saves retain unapproved references as draft');
    $check(get_post_field('post_content', $held) === '<img class="wp-image-999999999">', 'Holding publication preserves the editorial content');
    $gallery = $make(['post_status' => 'publish', 'post_content' => '[gallery ids="999999999"]']); $check(get_post_status($gallery) === 'draft', 'Classic gallery shortcodes use the same approval gate');
    $playlist = $make(['post_status' => 'publish', 'post_content' => '[playlist ids="999999999"]']); $check(get_post_status($playlist) === 'draft', 'Classic playlist shortcodes use the same approval gate');
    $meta = $make(['post_status' => 'publish', 'meta_input' => ['_thumbnail_id' => 999999999]]); $check(get_post_status($meta) === 'draft', 'Featured-media meta supplied during save is validated before publication');
    $later = $make(['post_status' => 'publish', 'post_content' => 'Text-only publication']); update_post_meta($later, '_thumbnail_id', 999999999);
    $check(get_post_status($later) === 'draft' && (int)get_post_meta($later, '_thumbnail_id', true) === 999999999, 'Featured media added after save holds publication before storing the reference');
    $scheduled = $make(['post_status' => 'future', 'post_date' => gmdate('Y-m-d H:i:s', time() + 3600), 'post_content' => '<img class="wp-image-' . $attachment . '">']); $check(get_post_status($scheduled) === 'future', 'Approved media may be scheduled');
    $row = $s->scans->get($r['id']); (new ReviewService($s))->act($r['id'], (int)$row['revision'], 'reject', 'Synthetic rejection before scheduled publication', 1);
    do_action('publish_future_post', $scheduled); $check(get_post_status($scheduled) === 'draft', 'Scheduled publication rechecks media after a later moderation decision');
    $check(wp_next_scheduled('publish_future_post', [$scheduled]) === false, 'Held schedules are removed and await an explicit editorial decision');
    $notice = get_transient('cf_publication_notice_' . get_current_blog_id() . '_1'); $check(is_string($notice) && str_contains($notice, 'approved'), 'Holding publication records an actionable editor notice');
    update_option('cf_settings', array_merge($settings, ['publication_gate' => false])); $disabled = $make(['post_status' => 'publish', 'post_content' => '<img class="wp-image-999999999">']); $check(get_post_status($disabled) === 'publish', 'Explicitly disabled optional publication gate preserves normal WordPress saves');
    echo json_encode(['publication_gate_assertions' => $passed, 'wordpress' => $GLOBALS['wp_version'], 'php' => PHP_VERSION], JSON_THROW_ON_ERROR) . PHP_EOL;
} finally {
    update_option('cf_settings', $settings); update_option('cf_active_policy', $policy); delete_transient('cf_publication_notice_' . get_current_blog_id() . '_1');
    foreach ($posts as $id) { wp_delete_post($id, true); } if ($attachment) { wp_delete_attachment($attachment, true); } unlink($root . '/image.png'); rmdir($root);
}
