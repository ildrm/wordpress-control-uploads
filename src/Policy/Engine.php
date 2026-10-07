<?php
declare(strict_types=1);
namespace ContentFirewall\Policy;
use ContentFirewall\Domain\{Action, Decision, Finding, Policy};
final class Engine
{
    /** @param list<Finding> $findings */
    public function decide(Policy $policy, array $signals, array $findings): Decision
    {
        $risk = 0.0; $hard = [];
        foreach ($findings as $finding) {
            $signals[$finding->category] = max($signals[$finding->category] ?? 0, $finding->confidence);
            $risk = max($risk, $finding->confidence);
            if ($finding->hardSecurity) { $hard[] = $finding->category; }
        }
        if ($hard) { return new Decision(Action::Block, $hard, [], $policy->id, $policy->version, 1); }
        if (array_filter($findings, static fn(Finding $f): bool => $f->category === 'qr.prohibited' && $f->confidence > 0)) { return new Decision(Action::Block, ['qr.prohibited'], [], $policy->id, $policy->version, $risk, $policy->shadow); }
        if (($policy->options['qr_mode'] ?? 'review') === 'review' && array_filter($findings, static fn(Finding $f): bool => str_starts_with($f->category, 'qr.') && $f->confidence > 0)) { return new Decision(Action::Review, ['qr.requires_review'], [], $policy->id, $policy->version, $risk, $policy->shadow); }
        $signals = (new \ContentFirewall\Domain\Taxonomy())->expand($signals);
        if (isset($signals['provider.unknown'])) { return new Decision(Action::Review, ['provider.unknown_category'], [], $policy->id, $policy->version, $risk, $policy->shadow); }
        $rules = $policy->rules;
        usort($rules, static fn(array $a, array $b): int => ($b['priority'] ?? 0) <=> ($a['priority'] ?? 0) ?: strcmp($a['id'], $b['id']));
        foreach ($rules as $rule) {
            if (!($rule['enabled'] ?? true)) { continue; }
            $match = (new Condition($rule['condition']))->evaluateEvidence($signals);
            if ($match === null) { return new Decision(Action::Review, ['policy.evidence_unavailable'], [$rule['id']], $policy->id, $policy->version, $risk, $policy->shadow); }
            if ($match) {
                return new Decision(Action::from($rule['action']), ['policy.rule_match'], [$rule['id']], $policy->id, $policy->version, $risk, $policy->shadow, $rule['effects'] ?? []);
            }
        }
        $action = $policy->defaultAction; $reasons = ['policy.default'];
        foreach ($policy->bands as $category => $band) {
            $score = $signals[$category] ?? null;
            if (!is_numeric($score) || $score < $band['review']) { continue; }
            $evidence = array_filter($findings, static fn(Finding $f): bool => $f->category === $category || (\ContentFirewall\Domain\Taxonomy::PARENTS[$f->category] ?? '') === $category);
            $probability = $evidence && !array_filter($evidence, static fn(Finding $f): bool => $f->scale !== 'probability');
            $candidate = ($probability && ($band['calibrated'] ?? false) && $score >= $band['block']) ? Action::Block : Action::Review;
            if ($candidate === Action::Block || $action !== Action::Block) { $action = $candidate; }
            $reasons[] = $category;
        }
        return new Decision($action, array_values(array_unique($reasons)), [], $policy->id, $policy->version, $risk, $policy->shadow);
    }
}
