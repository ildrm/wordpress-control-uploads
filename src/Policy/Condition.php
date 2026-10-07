<?php
declare(strict_types=1);
namespace ContentFirewall\Policy;
final readonly class Condition
{
    private const OPS = ['eq', 'ne', 'gt', 'gte', 'lt', 'lte', 'in', 'contains', 'between', 'exists', 'domain', 'regex'];
    public function __construct(private array $node, int $depth = 0)
    {
        if ($depth === 0) {
            try { $json = json_encode($node, JSON_THROW_ON_ERROR); } catch (\JsonException) { throw new \InvalidArgumentException('POLICY.VALUE'); }
            if (strlen($json) > 16384 || substr_count($json, '"field"') + substr_count($json, '"group"') > 256) { throw new \InvalidArgumentException('POLICY.CONDITION_LIMIT'); }
        }
        if ($depth > 8 || count($node) > 8) { throw new \InvalidArgumentException('POLICY.CONDITION_LIMIT'); }
        $group = $node['group'] ?? null;
        if ($group !== null) {
            if (array_diff(array_keys($node), ['group', 'children']) || !in_array($group, ['AND', 'OR', 'NOT'], true) || !isset($node['children']) || !is_array($node['children']) || !array_is_list($node['children']) || count($node['children']) < 1 || count($node['children']) > 32 || ($group === 'NOT' && count($node['children']) !== 1)) { throw new \InvalidArgumentException('POLICY.GROUP'); }
            foreach ($node['children'] as $child) { if (!is_array($child)) { throw new \InvalidArgumentException('POLICY.GROUP'); } new self($child, $depth + 1); }
        } else {
            if (array_diff(array_keys($node), ['field', 'op', 'value']) || !isset($node['field'], $node['op']) || !is_string($node['field']) || !preg_match('/^[a-z][a-z0-9_.-]{0,95}$/D', $node['field']) || !in_array($node['op'], self::OPS, true)) { throw new \InvalidArgumentException('POLICY.CONDITION'); }
            if ($node['op'] !== 'exists' && !array_key_exists('value', $node)) { throw new \InvalidArgumentException('POLICY.VALUE'); }
            $value = $node['value'] ?? null;
            if (in_array($node['op'], ['gt', 'gte', 'lt', 'lte'], true) && ((!is_int($value) && !is_float($value)) || !is_finite((float)$value))) { throw new \InvalidArgumentException('POLICY.VALUE'); }
            if (in_array($node['op'], ['domain', 'regex'], true) && !is_string($value)) { throw new \InvalidArgumentException('POLICY.VALUE'); }
            if (is_string($value) && strlen($value) > 512) { throw new \InvalidArgumentException('POLICY.VALUE_LIMIT'); }
            if (in_array($node['op'], ['in', 'between'], true) && (!is_array($value) || !array_is_list($value) || count($value) > 100 || ($node['op'] === 'between' && (count($value) !== 2 || !is_numeric($value[0]) || !is_numeric($value[1]) || $value[0] > $value[1])))) { throw new \InvalidArgumentException('POLICY.RANGE'); }
            foreach (is_array($value) ? $value : [$value] as $item) { if ((!is_scalar($item) && $item !== null) || (is_string($item) && strlen($item) > 512) || (is_float($item) && !is_finite($item))) { throw new \InvalidArgumentException('POLICY.VALUE'); } }
            if ($node['op'] === 'regex' && (!is_string($value) || @preg_match(self::pattern($value), '') === false)) { throw new \InvalidArgumentException('POLICY.REGEX'); }
        }
    }
    public function evaluate(array $signals): bool
    {
        return $this->evaluateEvidence($signals) === true;
    }
    /** Null distinguishes unavailable or failed evidence from an evaluated negative. */
    public function evaluateEvidence(array $signals): ?bool
    {
        if (isset($this->node['group'])) {
            $matches = array_map(static fn(array $c): ?bool => (new self($c))->evaluateEvidence($signals), $this->node['children']);
            return match ($this->node['group']) {
                'AND' => in_array(false, $matches, true) ? false : (in_array(null, $matches, true) ? null : true),
                'OR' => in_array(true, $matches, true) ? true : (in_array(null, $matches, true) ? null : false),
                'NOT' => $matches[0] === null ? null : !$matches[0], default => false,
            };
        }
        $field = $this->node['field']; $op = $this->node['op'];
        if ($op === 'exists') { return array_key_exists($field, $signals); }
        // Missing scanner evidence is not a negative result, including for NE.
        if (!array_key_exists($field, $signals)) { return null; }
        $actual = $signals[$field]; $expected = $this->node['value'];
        return match ($op) {
            'eq' => $actual === $expected,
            'ne' => $actual !== $expected,
            'gt' => is_numeric($actual) && is_numeric($expected) && $actual > $expected,
            'gte' => is_numeric($actual) && is_numeric($expected) && $actual >= $expected,
            'lt' => is_numeric($actual) && is_numeric($expected) && $actual < $expected,
            'lte' => is_numeric($actual) && is_numeric($expected) && $actual <= $expected,
            'in' => in_array($actual, $expected, true),
            'contains' => is_array($actual) ? in_array($expected, $actual, true) : (is_string($actual) && is_string($expected) && str_contains($actual, $expected)),
            'between' => is_numeric($actual) && $actual >= $expected[0] && $actual <= $expected[1],
            'domain' => is_string($actual) && is_string($expected) && self::domain($actual, $expected),
            'regex' => is_string($actual) ? self::regex($expected, $actual) : null,
            default => false,
        };
    }
    private static function regex(string $pattern, string $text): ?bool
    {
        if (strlen($text) > 16384) { return null; }
        $result = @preg_match(self::pattern($pattern), $text);
        return $result === false ? null : $result === 1;
    }
    private static function pattern(string $regex): string { return '~(*LIMIT_MATCH=10000)(*LIMIT_DEPTH=100)' . str_replace('~', '\\~', $regex) . '~u'; }
    public static function domain(string $url, string $domain): bool
    {
        $host = strtolower(rtrim((string)parse_url($url, PHP_URL_HOST), '.')); $domain = strtolower(rtrim($domain, '.'));
        return $domain !== '' && ($host === $domain || str_ends_with($host, '.' . $domain));
    }
}
