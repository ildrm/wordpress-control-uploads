<?php
declare(strict_types=1);
namespace ContentFirewall\Configuration;

/** One validation boundary for REST, persisted configuration and runtime defaults. */
final class Settings
{
    public const RETENTION = ['private_files_days' => 7, 'safe_metadata_days' => 90, 'blocked_metadata_days' => 30, 'audit_days' => 180, 'analytics_days' => 365, 'job_days' => 7];
    public const PROCESSING = ['max_duration' => 300, 'max_frames' => 12, 'max_pages' => 20, 'sampling' => 'uniform'];
    public const DEFAULTS = ['require_malware' => false, 'max_bytes' => 52428800, 'max_pixels' => 24000000, 'monthly_cap' => 10000, 'upload_per_hour' => 100, 'delete_on_uninstall' => false, 'publication_gate' => false, 'privacy_retain_audit' => true, 'onboarding_complete' => false, 'sla_hours' => 24, 'retention' => self::RETENTION, 'processing' => self::PROCESSING, 'enable_documents' => false, 'enable_temporal' => false, 'enable_provenance' => false];

    public function parse(array $values): array
    {
        if (array_diff(array_keys($values), array_merge(array_keys(self::DEFAULTS), ['allowed_extensions']))) { throw new \InvalidArgumentException('VALIDATION.SETTINGS'); }
        foreach ($values as $key => $value) {
            if (in_array($key, ['require_malware', 'delete_on_uninstall', 'publication_gate', 'privacy_retain_audit', 'onboarding_complete', 'enable_documents', 'enable_temporal', 'enable_provenance'], true) && !is_bool($value)) { throw new \InvalidArgumentException('VALIDATION.SETTINGS'); }
        }
        foreach (['max_bytes' => 104857600, 'max_pixels' => 24000000, 'monthly_cap' => 1000000, 'upload_per_hour' => 100000, 'sla_hours' => 8760] as $key => $max) {
            if (array_key_exists($key, $values) && (!is_int($values[$key]) || $values[$key] < 1 || $values[$key] > $max)) { throw new \InvalidArgumentException('VALIDATION.SETTINGS'); }
        }
        if (array_key_exists('retention', $values)) {
            if (!is_array($values['retention']) || array_diff(array_keys($values['retention']), array_keys(self::RETENTION))) { throw new \InvalidArgumentException('VALIDATION.RETENTION'); }
            foreach ($values['retention'] as $days) { if (!is_int($days) || $days < 1 || $days > 3650) { throw new \InvalidArgumentException('VALIDATION.RETENTION'); } }
            $values['retention'] = array_merge(self::RETENTION, $values['retention']);
        }
        if (array_key_exists('processing', $values)) {
            if (!is_array($values['processing']) || array_diff(array_keys($values['processing']), array_keys(self::PROCESSING)) || in_array(null, $values['processing'], true)) { throw new \InvalidArgumentException('VALIDATION.PROCESSING'); }
            foreach (['max_duration' => 600, 'max_frames' => 32, 'max_pages' => 100] as $key => $maximum) { if (array_key_exists($key, $values['processing']) && (!is_int($values['processing'][$key]) || $values['processing'][$key] < 1 || $values['processing'][$key] > $maximum)) { throw new \InvalidArgumentException('VALIDATION.PROCESSING'); } }
            if (isset($values['processing']['sampling']) && !in_array($values['processing']['sampling'], ['uniform', 'scene', 'adaptive'], true)) { throw new \InvalidArgumentException('VALIDATION.PROCESSING'); }
            $values['processing'] = array_merge(self::PROCESSING, $values['processing']);
        }
        if (array_key_exists('allowed_extensions', $values)) {
            $extensions = $values['allowed_extensions'];
            if (!is_array($extensions) || !array_is_list($extensions) || !$extensions || count($extensions) > 20) { throw new \InvalidArgumentException('VALIDATION.SETTINGS'); }
            foreach ($extensions as $extension) {
                if (!is_string($extension) || !in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif', 'svg', 'pdf', 'txt', 'zip', 'docx', 'xlsx', 'pptx', 'mp3', 'wav', 'ogg', 'm4a', 'mp4', 'webm'], true)) { throw new \InvalidArgumentException('VALIDATION.SETTINGS'); }
            }
        }
        return array_merge(self::DEFAULTS, $values);
    }
}
