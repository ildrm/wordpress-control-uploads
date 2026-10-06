<?php
declare(strict_types=1);
namespace ContentFirewall\Policy;
use ContentFirewall\Domain\{Action, Policy};
final class Schema
{
    public function parse(array $data): Policy
    {
        if (($data['schema'] ?? null) !== 1 || !isset($data['id'], $data['name'], $data['rules']) || !is_string($data['id']) || !preg_match('/^[a-zA-Z0-9_-]{1,64}$/D', $data['id']) || !is_string($data['name']) || strlen($data['name']) > 160 || !is_array($data['rules']) || count($data['rules']) > 128) { throw new \InvalidArgumentException('POLICY.SCHEMA'); }
        if (!is_bool($data['shadow'] ?? false) || !is_int($data['version'] ?? 1) || ($data['version'] ?? 1) < 1 || !is_array($data['bands'] ?? []) || !is_array($data['options'] ?? [])) { throw new \InvalidArgumentException('POLICY.SCHEMA'); }
        $ids = [];
        foreach ($data['rules'] as $rule) {
            if (!is_array($rule) || !isset($rule['id'], $rule['condition'], $rule['action']) || !is_string($rule['id']) || !preg_match('/^[a-zA-Z0-9_-]{1,64}$/D', $rule['id']) || isset($ids[$rule['id']]) || !is_int($rule['priority'] ?? 0) || !is_bool($rule['enabled'] ?? true)) { throw new \InvalidArgumentException('POLICY.RULE'); }
            $ids[$rule['id']] = true; new Condition($rule['condition']); Action::from($rule['action']);
            if (!is_array($rule['effects'] ?? []) || !empty($rule['effects'])) { throw new \InvalidArgumentException('POLICY.UNSUPPORTED_EFFECT'); }
        }
        foreach ($data['bands'] ?? [] as $category => $band) {
            if (!is_string($category) || !preg_match('/^[a-z][a-z0-9_.-]{0,95}$/D', $category) || !is_array($band) || !is_bool($band['calibrated'] ?? false) || !isset($band['review'], $band['block']) || !is_numeric($band['review']) || !is_numeric($band['block']) || !is_finite((float)$band['review']) || !is_finite((float)$band['block']) || $band['review'] < 0 || $band['block'] > 1 || $band['review'] >= $band['block']) { throw new \InvalidArgumentException('POLICY.BAND'); }
        }
        $options = $data['options'] ?? [];
        foreach (['requires_content', 'requires_text', 'consensus'] as $key) { if (isset($options[$key]) && !is_bool($options[$key])) { throw new \InvalidArgumentException('POLICY.OPTION'); } }
        foreach (['failure_mode' => ['QUARANTINE', 'FAIL_OPEN', 'FAIL_CLOSED'], 'qr_mode' => ['allow', 'review', 'block-all'], 'metadata' => ['Privacy Safe']] as $key => $values) { if (isset($options[$key]) && !in_array($options[$key], $values, true)) { throw new \InvalidArgumentException('POLICY.OPTION'); } }
        if (isset($options['region']) && (!is_string($options['region']) || strlen($options['region']) > 80)) { throw new \InvalidArgumentException('POLICY.OPTION'); }
        if (!is_array($options['patterns'] ?? []) || count($options['patterns'] ?? []) > 32 || !is_array($options['domains'] ?? []) || count($options['domains'] ?? []) > 100) { throw new \InvalidArgumentException('POLICY.OPTION'); }
        foreach ($options['patterns'] ?? [] as $category => $pattern) { new \ContentFirewall\Domain\Finding($category, 1); new Condition(['field' => 'text', 'op' => 'regex', 'value' => $pattern]); }
        foreach ($options['domains'] ?? [] as $domain) { if (!is_string($domain) || !preg_match('/^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z]{2,63}$/D', $domain)) { throw new \InvalidArgumentException('POLICY.OPTION'); } }
        $needsContent = !empty($data['bands']) || !empty($options['patterns']) || isset($options['qr_mode']) || !empty($options['requires_text']);
        foreach ($data['rules'] as $rule) { $needsContent = $needsContent || $this->usesContent($rule['condition']); }
        if ($needsContent) { $options['requires_content'] = true; }
        return new Policy($data['id'], max(1, (int)($data['version'] ?? 1)), $data['name'], $data['rules'], Action::from($data['default'] ?? 'ALLOW'), (bool)($data['shadow'] ?? false), $data['bands'] ?? [], $options);
    }
    private function usesContent(array $condition): bool
    {
        if (isset($condition['children'])) { foreach ($condition['children'] as $child) { if ($this->usesContent($child)) { return true; } } return false; }
        return preg_match('/^(sexual|violence|hate|self_harm|weapon|pii|qr|ocr_text|authenticity|deepfake)(\.|$)/', $condition['field']) === 1;
    }
}
