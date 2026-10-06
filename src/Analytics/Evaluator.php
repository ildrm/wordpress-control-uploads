<?php
declare(strict_types=1);
namespace ContentFirewall\Analytics;
final class Evaluator
{
    /** An independently labeled corpus is required; overrides alone are not a representative sample. */
    public function evaluate(array $examples, float $threshold = 0.98): array
    {
        $tp = $fp = $tn = $fn = $unknown = 0;
        foreach ($examples as $example) {
            if (!isset($example['label']) || !is_bool($example['label'])) { throw new \InvalidArgumentException('VALIDATION.LABEL'); }
            if (!isset($example['score'])) { $unknown++; continue; }
            if (!is_numeric($example['score']) || $example['score'] < 0 || $example['score'] > 1) { throw new \InvalidArgumentException('VALIDATION.SCORE'); }
            $predicted = $example['score'] >= $threshold;
            if ($predicted && $example['label']) { $tp++; } elseif ($predicted) { $fp++; } elseif ($example['label']) { $fn++; } else { $tn++; }
        }
        $precision = $tp + $fp ? $tp / ($tp + $fp) : null; $recall = $tp + $fn ? $tp / ($tp + $fn) : null;
        return ['tp' => $tp, 'fp' => $fp, 'tn' => $tn, 'fn' => $fn, 'precision' => $precision, 'recall' => $recall, 'f1' => $precision !== null && $recall !== null && $precision + $recall > 0 ? 2 * $precision * $recall / ($precision + $recall) : null, 'false_positive_rate' => $fp + $tn ? $fp / ($fp + $tn) : null, 'false_negative_rate' => $fn + $tp ? $fn / ($fn + $tp) : null, 'coverage' => count($examples) ? 1 - $unknown / count($examples) : null, 'uncertainty_rate' => count($examples) ? $unknown / count($examples) : null];
    }
}
