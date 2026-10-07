<?php
declare(strict_types=1);
namespace ContentFirewall\Admin;
final class App
{
    private array $mediaStates = [];
    /** @param callable():\ContentFirewall\Bootstrap\Services $factory */
    public function __construct(private string $file, private $factory) {}
    public function register(): void
    {
        add_action('admin_menu', function (): void { add_menu_page(__('Content Firewall', 'content-firewall'), __('Content Firewall', 'content-firewall'), 'read', 'content-firewall', [$this, 'render'], 'dashicons-shield-alt', 58); });
        add_action('admin_enqueue_scripts', [$this, 'assets']);
        add_filter('the_posts', function (array $posts): array {
            $ids = []; foreach ($posts as $post) { if ($post instanceof \WP_Post && $post->post_type === 'attachment') { $ids[] = (int)$post->ID; } }
            if ($ids && count($ids) <= 1000) { try { $site = get_current_blog_id(); $rows = (($this->factory)())->scans->latestMany($ids); foreach ($ids as $id) { $this->mediaStates[$site][$id] = $rows[$id] ?? null; } } catch (\Throwable) {} }
            return $posts;
        });
        add_filter('manage_media_columns', static function (array $columns): array { $columns['content_firewall'] = __('Moderation', 'content-firewall'); return $columns; });
        add_action('manage_media_custom_column', function (string $column, int $id): void { if ($column !== 'content_firewall') { return; } try { $site = get_current_blog_id(); $row = array_key_exists($id, $this->mediaStates[$site] ?? []) ? $this->mediaStates[$site][$id] : (($this->factory)())->scans->latest($id); echo esc_html($row['state'] ?? __('Unscanned', 'content-firewall')); } catch (\Throwable) { echo esc_html__('Unavailable', 'content-firewall'); } }, 10, 2);
        add_filter('attachment_fields_to_edit', function (array $fields, \WP_Post $post): array { if (!current_user_can('review_content_firewall_queue')) { return $fields; } try { $row = (($this->factory)())->scans->latest($post->ID); $fields['cf_state'] = ['label' => __('Content Firewall', 'content-firewall'), 'input' => 'html', 'html' => esc_html($row['state'] ?? __('Unscanned', 'content-firewall'))]; } catch (\Throwable) {} return $fields; }, 10, 2);
    }
    public function render(): void
    {
        if (!current_user_can('read')) { return; }
        echo '<div class="wrap"><div id="cf-app"><p>' . esc_html__('Loading Content Firewall…', 'content-firewall') . '</p></div></div>';
    }
    public function assets(string $hook): void
    {
        if ($hook !== 'toplevel_page_content-firewall') { return; }
        $base = plugin_dir_url($this->file);
        wp_enqueue_style('cf-admin', $base . 'assets/css/admin.css', ['wp-components'], '0.1.0');
        wp_enqueue_script('cf-admin', $base . 'assets/js/admin.js', ['wp-element', 'wp-components', 'wp-i18n', 'wp-api-fetch'], '0.1.0', true);
        $caps = []; foreach (\ContentFirewall\WordPress\Lifecycle::CAPS as $cap) { $caps[$cap] = current_user_can($cap); }
        wp_add_inline_script('cf-admin', 'window.CFConfig=' . wp_json_encode(['root' => rest_url('content-firewall/v1'), 'nonce' => wp_create_nonce('wp_rest'), 'caps' => $caps, 'locale' => get_locale(), 'timezone' => wp_timezone_string(), 'rtl' => is_rtl()]) . ';', 'before');
        wp_set_script_translations('cf-admin', 'content-firewall', dirname($this->file) . '/languages');
    }
}
