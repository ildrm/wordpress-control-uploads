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
            if (preg_match('/^(sexual|violence|hate|self_harm|weapon|pii|qr|authenticity|deepfake)(\.|$)|^ocr_text$/', $category) && !array_key_exists($category, $scores)) { $missing[] = $category; }
        }
        return $missing;
    }
    /** @return list<string> */
    private static function fields(array $condition): array
    {
        if (!isset($condition['children'])) { return [$condition['field']]; }
        $fields = []; foreach ($condition['children'] as $child) { $fields = array_merge($fields, self::fields($child)); } return $fields;
    }
}
