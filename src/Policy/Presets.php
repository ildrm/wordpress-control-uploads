<?php
declare(strict_types=1);
namespace ContentFirewall\Policy;
use ContentFirewall\Domain\{Action, Policy};
final class Presets
{
    public const NAMES = ['Family Friendly', 'Corporate', 'Community', 'Forum', 'Marketplace', 'Classifieds', 'Dating', 'Gaming', 'News / Editorial', 'Education', 'Healthcare', 'Strict UGC', 'Security Only', 'Monitor Only', 'Custom'];
    public function make(string $name): Policy
    {
        if (!in_array($name, self::NAMES, true)) { throw new \InvalidArgumentException('POLICY.PRESET'); }
        $bands = [];
        if (!in_array($name, ['Security Only', 'Custom'], true)) {
            foreach (['sexual.explicit', 'violence.graphic', 'hate.symbol', 'self_harm.graphic', 'weapon.threatening'] as $category) { $bands[$category] = ['review' => $name === 'Strict UGC' ? 0.35 : 0.65, 'block' => 0.98, 'calibrated' => false]; }
            if (in_array($name, ['Family Friendly', 'Corporate', 'Education'], true)) { $bands['sexual.suggestive'] = ['review' => 0.6, 'block' => 0.98, 'calibrated' => false]; }
            if (in_array($name, ['Marketplace', 'Classifieds', 'Corporate', 'Healthcare'], true)) {
                foreach (['pii.email', 'pii.phone', 'pii.credit_card'] as $category) { $bands[$category] = ['review' => 0.5, 'block' => 1, 'calibrated' => false]; }
            }
        }
        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $name), '-'));
        return new Policy($slug, 1, $name, [], Action::Allow, $name === 'Monitor Only', $bands, ['failure_mode' => 'QUARANTINE', 'metadata' => 'Privacy Safe', 'requires_content' => !in_array($name, ['Security Only', 'Custom'], true)]);
    }
}
