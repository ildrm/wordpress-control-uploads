<?php
declare(strict_types=1);
namespace ContentFirewall\Policy;
use ContentFirewall\Domain\{Finding, Policy, Taxonomy};
final class EvidenceCoverage
{
    /** @param list<Finding> $findings @return list<string> */
    public static function missing(Policy $policy, array $findings, array $signals = []): array
    {
        $scores = []; foreach ($findings as $finding) { $scores[$finding->category] = $finding->confidence; }
        $scores = (new Taxonomy())->expand($scores) + $signals; $missing = []; $categories = array_keys($policy->bands);
        foreach ($policy->rules as $rule) { if ($rule['enabled'] ?? true) { $categories = array_merge($categories, self::fields($rule['condition'])); } }
        foreach (array_unique($categories) as $category) {
            if (self::requiresEvidence($category) && !array_key_exists($category, $scores)) { $missing[] = $category; }
        }
        return $missing;
    }
    public static function requiresEvidence(string $field): bool
    {
        return !in_array($field, ['context', 'site_id', 'network_id', 'user_id', 'roles', 'post_type', 'terms', 'trust', 'mime', 'extension', 'bytes', 'width', 'height', 'pixels', 'aspect_ratio', 'duration', 'pages', 'has_audio', 'has_video', 'document_cdr', 'sample_count', 'sampling'], true) && !str_starts_with($field, 'security.') && !str_starts_with($field, 'fingerprint.');
    }
    public static function requiresOnlyProvenance(Policy $policy): bool
    {
        $fields = array_keys($policy->bands);
        foreach ($policy->rules as $rule) { if ($rule['enabled'] ?? true) { $fields = array_merge($fields, self::fields($rule['condition'])); } }
        $fields = array_filter($fields, [self::class, 'requiresEvidence']);
        return $fields && !array_filter($fields, static fn(string $field): bool => !str_starts_with($field, 'provenance.') && $field !== 'authenticity.ai_declared') && !($policy->options['consensus'] ?? false) && !($policy->options['requires_text'] ?? false);
    }
    /** Two distinct adapters must supply each required content field; repeated frames cannot agree with themselves. */
    public static function consensusIncomplete(Policy $policy, array $results): bool
    {
        if (!($policy->options['consensus'] ?? false)) { return false; }
        $fields = array_keys($policy->bands);
        foreach ($policy->rules as $rule) { if ($rule['enabled'] ?? true) { $fields = array_merge($fields, self::fields($rule['condition'])); } }
        $required = array_unique(array_filter($fields, static fn(string $field): bool => self::requiresEvidence($field) && !str_starts_with($field, 'provenance.') && $field !== 'authenticity.ai_declared'));
        $coverage = []; $providers = [];
        foreach ($results as $result) {
            if ($result->error || str_starts_with($result->provider, 'local-')) { continue; } $providers[$result->provider] = true; $scores = [];
            foreach ($result->findings as $finding) { $scores[$finding->category] = $finding->confidence; }
            if ($result->text !== '') {
                $scores['ocr_text'] = 1;
                foreach ((new \ContentFirewall\Privacy\TextInspector())->inspect($result->text, $policy->options['patterns'] ?? []) as $finding) { $scores[$finding->category] = $finding->confidence; }
            }
            foreach ((new Taxonomy())->expand($scores) as $field => $value) { $coverage[$field][$result->provider] = true; }
        }
        if (count($providers) < 2) { return true; }
        foreach ($required as $field) { if (count($coverage[$field] ?? []) < 2) { return true; } }
        return false;
    }
    /** @return list<string> */
    public static function fields(array $condition): array
    {
        if (!isset($condition['children'])) { return [$condition['field']]; }
        $fields = []; foreach ($condition['children'] as $child) { $fields = array_merge($fields, self::fields($child)); } return $fields;
    }
}
