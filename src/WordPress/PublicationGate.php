<?php
declare(strict_types=1);
namespace ContentFirewall\WordPress;
use ContentFirewall\Bootstrap\Services;
final class PublicationGate
{
    /** @param callable():Services $factory */
    public function __construct(private $factory) {}
    public function check(\stdClass|\WP_Error $post, \WP_REST_Request $request): \stdClass|\WP_Error
    {
        if (is_wp_error($post) || !in_array($post->post_status ?? '', ['publish', 'future'], true)) { return $post; }
        $settings = get_option('cf_settings', []); if (!($settings['publication_gate'] ?? false)) { return $post; }
        $ids = []; $featured = (int)($request['featured_media'] ?? (!empty($post->ID) ? get_post_thumbnail_id((int)$post->ID) : 0)); if ($featured) { $ids[] = $featured; }
        $visit = function (array $blocks) use (&$visit, &$ids): void { foreach ($blocks as $block) { if (in_array($block['blockName'], ['core/image', 'core/video', 'core/audio', 'core/file', 'core/cover'], true) && isset($block['attrs']['id'])) { $ids[] = (int)$block['attrs']['id']; } if ($block['blockName'] === 'core/gallery') { foreach ($block['attrs']['ids'] ?? [] as $galleryId) { $ids[] = (int)$galleryId; } } if (!empty($block['innerBlocks'])) { $visit($block['innerBlocks']); } } };
        $content = $post->post_content ?? (!empty($post->ID) ? get_post_field('post_content', (int)$post->ID) : '');
        $visit(parse_blocks($content));
        preg_match_all('/wp-image-(\d+)/', $content, $matches); $ids = array_merge($ids, array_map('intval', $matches[1]));
        if (count(array_unique($ids)) > 100) { return new \WP_Error('cf_media_limit', __('Too many media references to validate in one publication.', 'content-firewall'), ['status' => 409]); }
        foreach (array_unique($ids) as $id) {
            $summary = (($this->factory)())->scans->latest($id);
            if (get_post_meta($id, '_cf_pending', true) || !$summary || !in_array($summary['state'], ['ALLOWED', 'SANITIZED'], true)) { return new \WP_Error('cf_pending_media', __('Referenced media must be approved before publishing.', 'content-firewall'), ['status' => 409]); }
        }
        return $post;
    }
}
