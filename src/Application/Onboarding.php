<?php
declare(strict_types=1);
namespace ContentFirewall\Application;
use ContentFirewall\Bootstrap\Services;
use ContentFirewall\Configuration\Settings;
use ContentFirewall\Policy\Presets;
final class Onboarding
{
    public function __construct(private Services $s) {}
    public function status(): array
    {
        if ($this->s->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        return ['step' => (int)get_option('cf_onboarding_step', 0), 'complete' => $this->s->settings['onboarding_complete'], 'network_enforced' => is_multisite() && (bool)get_site_option('cf_enforced_policy'), 'policy' => $this->s->policies->active()->toArray(), 'settings' => $this->s->settings, 'health' => (new \ContentFirewall\Health\Diagnostics($this->s))->report()];
    }
    public function save(array $value, int $actor): array
    {
        if ($this->s->siteId !== get_current_blog_id()) { throw new \RuntimeException('SECURITY.TENANT'); }
        if (array_diff(array_keys($value), ['step', 'preset', 'settings', 'complete']) || !is_int($value['step'] ?? null) || $value['step'] < 0 || $value['step'] > 3 || $value['step'] > (int)get_option('cf_onboarding_step', 0) + 1 || !is_bool($value['complete'] ?? false)) { throw new \InvalidArgumentException('VALIDATION.ONBOARDING'); }
        if (isset($value['preset']) && (!is_string($value['preset']) || !in_array($value['preset'], Presets::NAMES, true))) { throw new \InvalidArgumentException('VALIDATION.PRESET'); }
        $settings = $this->s->settings;
        if (array_key_exists('settings', $value)) {
            if (!is_array($value['settings']) || array_diff(array_keys($value['settings']), ['require_malware', 'publication_gate', 'privacy_retain_audit', 'retention', 'processing', 'max_bytes', 'max_pixels', 'monthly_cap', 'upload_per_hour', 'sla_hours', 'enable_documents', 'enable_temporal', 'enable_provenance'])) { throw new \InvalidArgumentException('VALIDATION.SETTINGS'); }
            $changes = $value['settings']; foreach (['retention', 'processing'] as $group) { if (isset($changes[$group]) && is_array($changes[$group])) { $changes[$group] = array_merge($settings[$group], $changes[$group]); } }
            $settings = (new Settings())->parse(array_merge($settings, $changes));
        }
        if ($value['complete'] ?? false) {
            if ($value['step'] !== 3 || (wp_get_environment_type() === 'production' && !defined('CF_PRIVATE_DIR')) || ($settings['require_malware'] && Services::secret('CF_CLAMD_SOCKET') === '')) { throw new \RuntimeException('CONFIGURATION.ONBOARDING_INCOMPLETE'); }
            foreach (['enable_documents' => ['CF_PDFINFO_BIN', 'CF_PDFTOPPM_BIN', 'CF_PDFTOTEXT_BIN'], 'enable_temporal' => ['CF_FFMPEG_BIN', 'CF_FFPROBE_BIN'], 'enable_provenance' => ['CF_C2PA_BIN']] as $flag => $binaries) {
                foreach ($binaries as $name) { if ($settings[$flag] && !is_executable(Services::secret($name))) { throw new \RuntimeException('CONFIGURATION.PROCESSOR_REQUIRED'); } }
            }
            $settings['onboarding_complete'] = true;
        }
        if (isset($value['preset'])) {
            if (!current_user_can('manage_content_firewall_policies')) { throw new \RuntimeException('SECURITY.POLICY_PERMISSION'); }
            $this->s->policies->save((new Presets())->make($value['preset'])->toArray(), $actor);
        }
        update_option('cf_settings', $settings, false); update_option('cf_onboarding_step', $value['step'], false);
        $this->s->audit->record('onboarding.saved', 0, $actor, ['count' => $value['step']]);
        // Reflect writes without returning the request's older immutable Services settings snapshot.
        $result = $this->status(); $result['settings'] = $settings; $result['complete'] = $settings['onboarding_complete']; return $result;
    }
}
