<?php
declare(strict_types=1);
namespace ContentFirewall\WordPress;
use ContentFirewall\Bootstrap\Services;
final class PublicationGate
{
    /** @param callable():Services $factory */
    public function __construct(private $factory) {}
    public function register(): void
    {
        add_filter('wp_insert_post_data', [$this, 'save'], PHP_INT_MAX, 2);
        add_action('publish_future_post', [$this, 'scheduled'], 1);
        add_filter('add_post_metadata', [$this, 'thumbnail'], PHP_INT_MAX, 4);
        add_filter('update_post_metadata', [$this, 'thumbnail'], PHP_INT_MAX, 4);
        add_action('admin_notices', [$this, 'notice']);
    }
    /** WordPress's save filter returns data; unsafe publication is retained as a draft. */
    public function save(array $data, array $postarr): array
    {
        if (in_array($data['post_type'] ?? '', ['attachment', 'revision'], true)) { return $data; }
        $post = (object)wp_unslash($data); $post->ID = (int)($postarr['ID'] ?? 0);
        $request = new \WP_REST_Request('POST');
        if (isset($postarr['meta_input']['_thumbnail_id'])) { $request->set_param('featured_media', (int)$postarr['meta_input']['_thumbnail_id']); }
        $result = $this->check($post, $request);
        if (is_wp_error($result)) { $data['post_status'] = 'draft'; $this->held($post->ID, $result); }
        return $data;
    }
    public function scheduled(int $id): void
    {
        $post = get_post($id); if (!$post || $post->post_status !== 'future') { return; }
        $result = $this->check((object)$post->to_array(), new \WP_REST_Request('POST'));
        if (is_wp_error($result)) {
            $saved = wp_update_post(['ID' => $id, 'post_status' => 'draft'], true);
            if (is_wp_error($saved)) { throw new \RuntimeException('DATABASE.PUBLICATION_GATE'); }
            wp_clear_scheduled_hook('publish_future_post', [$id]); $this->held($id, $result);
        }
    }
    /** Featured media can be set after the post row has already been saved. */
    public function thumbnail(mixed $check, int $id, string $key, mixed $value): mixed
    {
        if ($check !== null || $key !== '_thumbnail_id' || !(int)$value || !($this->settings()['publication_gate'] ?? false) || !in_array(get_post_status($id), ['publish', 'future'], true)) { return $check; }
        $post = get_post($id); if (!$post || $post->post_type === 'attachment') { return $check; }
        $request = new \WP_REST_Request('POST'); $request->set_param('featured_media', (int)$value);
        $result = $this->check((object)$post->to_array(), $request);
        if (is_wp_error($result)) {
            $saved = wp_update_post(['ID' => $id, 'post_status' => 'draft'], true);
            if (is_wp_error($saved)) { return false; } $this->held($id, $result);
        }
        return $check;
    }
    private function held(int $id, \WP_Error $error): void
    {
        if (get_current_user_id()) { set_transient('cf_publication_notice_' . get_current_blog_id() . '_' . get_current_user_id(), $error->get_error_message(), 300); }
        try { (($this->factory)())->audit->record('publication.held', $id, get_current_user_id(), ['code' => 'SECURITY.MEDIA_APPROVAL_REQUIRED']); } catch (\Throwable) {}
    }
    public function notice(): void
    {
        $key = 'cf_publication_notice_' . get_current_blog_id() . '_' . get_current_user_id(); $message = get_transient($key);
        if (is_string($message) && $message !== '') { delete_transient($key); echo '<div class="notice notice-warning"><p>' . esc_html__('Publication was held. The post is saved as a draft.', 'content-firewall') . ' ' . esc_html($message) . '</p></div>'; }
    }
    private function settings(): array { return (new \ContentFirewall\Configuration\Settings())->parse(get_option('cf_settings', [])); }
    public function check(\stdClass|\WP_Error $post, \WP_REST_Request $request): \stdClass|\WP_Error
    {
        if (is_wp_error($post)) { return $post; }
        $status = $post->post_status ?? (!empty($post->ID) ? get_post_status((int)$post->ID) : '');
        if (!in_array($status, ['publish', 'future'], true)) { return $post; }
        try { $settings = $this->settings(); } catch (\Throwable) { return new \WP_Error('cf_media_unavailable', __('Media safety checks are unavailable. Try again after the administrator restores the service.', 'content-firewall'), ['status' => 503]); }
        if (!($settings['publication_gate'] ?? false)) { return $post; }
        $ids = []; $featured = (int)($request['featured_media'] ?? (!empty($post->ID) ? get_post_thumbnail_id((int)$post->ID) : 0)); if ($featured) { $ids[] = $featured; }
        $content = $post->post_content ?? (!empty($post->ID) ? get_post_field('post_content', (int)$post->ID) : '');
        $blocks = parse_blocks($content); $visited = 0;
        while ($blocks) {
            $block = array_pop($blocks); if (++$visited > 4096) { return new \WP_Error('cf_media_limit', __('Too many media references to validate in one publication.', 'content-firewall'), ['status' => 409]); }
            if (in_array($block['blockName'], ['core/image', 'core/video', 'core/audio', 'core/file', 'core/cover'], true) && isset($block['attrs']['id'])) { $ids[] = (int)$block['attrs']['id']; }
            if ($block['blockName'] === 'core/gallery') { foreach ($block['attrs']['ids'] ?? [] as $galleryId) { $ids[] = (int)$galleryId; } }
            if (!empty($block['innerBlocks'])) { $blocks = array_merge($blocks, $block['innerBlocks']); }
            if (count($ids) > 4096) { return new \WP_Error('cf_media_limit', __('Too many media references to validate in one publication.', 'content-firewall'), ['status' => 409]); }
        }
        preg_match_all('/wp-image-(\d+)/', $content, $matches); $ids = array_merge($ids, array_map('intval', $matches[1]));
        preg_match_all('/\[(?:gallery|playlist)\b[^\]]*\bids=["\x27]([0-9, ]+)["\x27]/i', $content, $shortcodes);
        foreach ($shortcodes[1] as $list) { foreach (explode(',', $list) as $id) { if ((int)$id > 0) { $ids[] = (int)$id; } } }
        if (count(array_unique($ids)) > 100) { return new \WP_Error('cf_media_limit', __('Too many media references to validate in one publication.', 'content-firewall'), ['status' => 409]); }
        $ids = array_values(array_unique($ids));
        try { $summaries = (($this->factory)())->scans->latestMany($ids); }
        catch (\Throwable) { return new \WP_Error('cf_media_unavailable', __('Media safety checks are unavailable. Try again after the administrator restores the service.', 'content-firewall'), ['status' => 503]); }
        foreach ($ids as $id) {
            $summary = $summaries[$id] ?? null;
            if (get_post_meta($id, '_cf_pending', true) || !$summary || !in_array($summary['state'], ['ALLOWED', 'SANITIZED'], true)) { return new \WP_Error('cf_pending_media', __('Referenced media must be approved before publishing.', 'content-firewall'), ['status' => 409]); }
        }
        return $post;
    }
}
