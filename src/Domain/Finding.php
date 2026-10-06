<?php
declare(strict_types=1);
namespace ContentFirewall\Domain;
final readonly class Finding implements \JsonSerializable
{
    public function __construct(public string $category, public float $confidence, public string $provider = 'local', public string $model = '1', public bool $hardSecurity = false, public string $scale = 'probability', public ?array $region = null)
    {
        if (!preg_match('/^[a-z][a-z0-9_.-]{1,95}$/D', $category) || !is_finite($confidence) || $confidence < 0 || $confidence > 1 || !in_array($scale, ['probability', 'ordinal', 'severity', 'deterministic'], true)) { throw new \InvalidArgumentException('PROVIDER.INVALID_FINDING'); }
    }
    public function jsonSerialize(): array { return ['category' => $this->category, 'confidence' => $this->confidence, 'provider' => $this->provider, 'model' => $this->model, 'hard_security' => $this->hardSecurity, 'scale' => $this->scale, 'region' => $this->region]; }
    public static function fromArray(array $v): self { return new self($v['category'], (float)$v['confidence'], $v['provider'] ?? 'local', $v['model'] ?? '1', $v['hard_security'] ?? false, $v['scale'] ?? 'probability', $v['region'] ?? null); }
}
