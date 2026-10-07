<?php
declare(strict_types=1);
namespace ContentFirewall\Media;
use ContentFirewall\Domain\ProviderResult;
final class ResultAccumulator
{
    /** @param list<ProviderResult> $results @return list<ProviderResult> */
    public static function merge(array $results): array
    {
        $groups = [];
        foreach ($results as $result) {
            $key = $result->provider . ':' . $result->model . ':' . ($result->error ?? '') . ':' . $result->language;
            $group = $groups[$key] ?? ['result' => $result, 'findings' => [], 'texts' => [], 'codes' => [], 'duration' => 0.0, 'cost' => 0.0];
            foreach ($result->findings as $finding) { $category = $finding->category . ':' . $finding->scale . ':' . json_encode($finding->region, JSON_THROW_ON_ERROR); if (!isset($group['findings'][$category]) || $finding->confidence > $group['findings'][$category]->confidence) { $group['findings'][$category] = $finding; } }
            if ($result->text !== '') { $group['texts'][hash('sha256', $result->text)] = $result->text; }
            foreach ($result->codes as $code) { $group['codes'][hash('sha256', $code)] = $code; }
            $group['duration'] += $result->durationMs; $group['cost'] += $result->estimatedCost; $groups[$key] = $group;
        }
        $merged = [];
        foreach ($groups as $group) { $r = $group['result']; $merged[] = new ProviderResult($r->provider, $r->model, array_values($group['findings']), $r->error, $r->retryable, $group['duration'], $group['cost'], implode("\n", array_values($group['texts'])), array_values($group['codes']), $r->language); }
        return $merged;
    }
}
