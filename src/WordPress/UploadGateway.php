<?php
declare(strict_types=1);
namespace ContentFirewall\WordPress;
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Domain\{Action, State, UploadContext};
use ContentFirewall\Media\ImageProcessor;
final class UploadGateway
{
    private array $accepted = [];
    private array $pathScans = [];
    /** @param callable():Services $services */
    public function __construct(private $services) {}
    public function register(): void
    {
        add_filter('wp_handle_upload_prefilter', [$this, 'filter'], PHP_INT_MAX);
        add_filter('wp_handle_sideload_prefilter', [$this, 'filter'], PHP_INT_MAX);
        add_filter('wp_handle_upload', [$this, 'uploaded'], PHP_INT_MAX, 2);
        add_action('add_attachment', [$this, 'attachment']);
        add_filter('upload_mimes', static function (array $mimes): array {
            if (in_array('svg', get_option('cf_settings', [])['allowed_extensions'] ?? [], true)) { $mimes['svg'] = 'image/svg+xml'; }
            return $mimes;
        });
    }
    public function filter(array $file): array
    {
        if (!empty($file['error'])) { return $file; }
        $s = null;
        try {
            $s = ($this->services)(); $user = wp_get_current_user();
            if (get_user_meta($user->ID, 'cf_upload_suspended', true)) { throw new \RuntimeException('SECURITY.UPLOAD_SUSPENDED'); }
            $identity = $user->ID ? 'user:' . $user->ID : 'anonymous:' . hash_hmac('sha256', $_SERVER['REMOTE_ADDR'] ?? 'unknown', wp_salt());
            if (!$s->limiter->consume('upload:' . $identity, (int)($s->settings['upload_per_hour'] ?? 100), 3600)) { throw new \RuntimeException('SECURITY.RATE_LIMIT'); }
            $context = new UploadContext($s->siteId, $user->ID, defined('REST_REQUEST') && REST_REQUEST ? 'rest' : (current_filter() === 'wp_handle_sideload_prefilter' ? 'sideload' : 'media'), array_values($user->roles), networkId: is_multisite() ? get_current_network_id() : 0);
            $context = apply_filters('cf_upload_context', $context, $file);
            if (!$context instanceof UploadContext) { throw new \RuntimeException('VALIDATION.CONTEXT'); }
            $result = $s->scanner->receive($file['tmp_name'], $file['name'], $file['type'] ?? '', $context);
            $id = $result['id']; $decision = $result['decision'];
            if (!$decision->action->publishable() && !$decision->shadow) {
                /* translators: %d: private moderation case number. */
                $file['error'] = sprintf(__('This upload is held by the content policy. Reference: %d. Contact the site moderator for review.', 'content-firewall'), $id); return $file;
            }
            $row = $s->scans->get($id);
            $descriptor = $s->inspector->inspect($s->storage->path($row['private_key'], $s->siteId), $row['file_name'], $row['mime']);
            if (!hash_equals($row['sha256'], $descriptor->sha256)) { throw new \RuntimeException('STORAGE.HASH_CHANGED'); }
            $temp = $s->storage->temporary($s->siteId); $policy = $s->policies->get($row['policy_id'], (int)$row['policy_version']);
            try {
                $builder = new \ContentFirewall\Media\DerivativeBuilder($s->documents, $s->temporal);
                $builder->build($descriptor, $temp, $row['state'] === State::Sanitizing->value, $s->scans->findings($id), $policy->options['patterns'] ?? [], $builder->categories($policy, $decision->rules));
                if (!copy($temp, $file['tmp_name'])) { throw new \RuntimeException('STORAGE.DERIVATIVE'); } $file['size'] = filesize($file['tmp_name']);
            } finally { if (is_file($temp)) { unlink($temp); } }
            $this->accepted[hash_file('sha256', $file['tmp_name'])][] = $id;
        } catch (\Throwable $e) {
            if ($s) { try { $s->audit->record('upload.failure', 0, get_current_user_id(), ['code' => \ContentFirewall\Application\ScanService::errorCode($e)]); } catch (\Throwable) {} }
            $file['error'] = __('This file could not pass the required safety checks. Contact the site administrator.', 'content-firewall');
        }
        return $file;
    }
    public function uploaded(array $upload, string $context): array
    {
        if (!empty($upload['file']) && is_file($upload['file'])) { $hash = hash_file('sha256', $upload['file']); if (isset($this->accepted[$hash])) { $this->pathScans[$upload['file']] = array_shift($this->accepted[$hash]); if (!$this->accepted[$hash]) { unset($this->accepted[$hash]); } } }
        return $upload;
    }
    public function attachment(int $attachmentId): void
    {
        $path = get_attached_file($attachmentId, true); if (!$path) { return; }
        try {
            $s = ($this->services)();
            if (isset($this->pathScans[$path])) {
                $id = $this->pathScans[$path]; $row = $s->scans->get($id);
                if ($row['state'] === State::Sanitizing->value) {
                    if (!$s->scans->transition($id, (int)$row['revision'], State::Sanitized, ['attachment_id' => $attachmentId])) { throw new \RuntimeException('QUEUE.STALE_RESULT'); }
                } else { $s->scans->associate($id, $attachmentId); }
                update_post_meta($attachmentId, '_cf_scan_id', $id);
            } elseif (!get_post_meta($attachmentId, '_cf_scan_id', true)) {
                $s->jobs->enqueue('library', ['after' => 0, 'attachment_id' => $attachmentId], 'attachment:' . $attachmentId);
                update_post_meta($attachmentId, '_cf_pending', 1);
            }
        } catch (\Throwable) { update_post_meta($attachmentId, '_cf_pending', 1); }
    }
}
