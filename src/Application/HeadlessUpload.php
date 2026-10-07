<?php
declare(strict_types=1);
namespace ContentFirewall\Application;
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Domain\UploadContext;
final class HeadlessUpload
{
    public function __construct(private Services $s) {}
    public function receive(string $path, string $name, string $mime): array
    {
        if ($this->s->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        $user = wp_get_current_user(); if (!$user->ID || !current_user_can('upload_files')) { throw new \RuntimeException('SECURITY.UPLOAD_PERMISSION'); }
        if (get_user_meta($user->ID, 'cf_upload_suspended', true)) { throw new \RuntimeException('SECURITY.UPLOAD_SUSPENDED'); }
        if (!is_file($path) || filesize($path) > wp_max_upload_size() || (is_multisite() && upload_is_user_over_quota(false))) { throw new \RuntimeException('SECURITY.UPLOAD_LIMIT'); }
        $allowed = wp_check_filetype_and_ext($path, $name);
        if (empty($allowed['ext']) || empty($allowed['type'])) { throw new \RuntimeException('SECURITY.UPLOAD_TYPE'); }
        if (!$this->s->limiter->consume('upload:user:' . $user->ID, $this->s->settings['upload_per_hour'], 3600)) { throw new \RuntimeException('SECURITY.RATE_LIMIT'); }
        $context = new UploadContext($this->s->siteId, $user->ID, 'headless', array_values($user->roles), networkId: is_multisite() ? get_current_network_id() : 0);
        $received = $this->s->scanner->receive($path, $name, $mime, $context);
        return $this->status($received['id']);
    }
    public function status(int $id): array
    {
        if ($this->s->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        $row = $this->s->scans->get($id);
        if ((int)$row['user_id'] !== get_current_user_id() && !current_user_can('review_content_firewall_queue')) { throw new \RuntimeException('SECURITY.OWNER'); }
        $attachment = (int)$row['attachment_id']; $stage = match ($row['state']) {
            'ALLOWED', 'SANITIZED', 'SANITIZING' => 'pending_publication', 'RECEIVED' => 'uploading', 'PREFLIGHT', 'SECURITY_SCANNING' => 'security_check',
            'CONTENT_SCANNING', 'PENDING_PROVIDER' => 'content_check', 'REVIEW_REQUIRED', 'APPEALED' => 'pending_review', 'BLOCKED' => 'rejected', 'FAILED' => 'failed', 'DELETED' => 'expired', default => 'held',
        };
        if ($attachment && in_array($row['state'], ['ALLOWED', 'SANITIZED'], true)) {
            if ((int)($this->s->scans->latest($attachment)['id'] ?? 0) !== $id) { $stage = 'superseded'; }
            elseif (!get_post_meta($attachment, '_cf_pending', true) && is_file(get_attached_file($attachment, true) ?: '')) { $stage = 'approved'; }
        }
        return ['id' => $id, 'state' => $row['state'], 'stage' => $stage, 'attachment_id' => $stage === 'approved' ? $attachment : 0, 'updated_at' => $row['updated_at'], 'review_available' => in_array($row['state'], ['BLOCKED', 'QUARANTINED', 'REVIEW_REQUIRED'], true)];
    }
}
