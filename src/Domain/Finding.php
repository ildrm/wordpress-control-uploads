<?php
declare(strict_types=1);
namespace ContentFirewall\Domain;
final readonly class Finding implements \JsonSerializable
{
    public function __construct(public string $category, public float $confidence, public string $provider = 'local', public string $model = '1', public bool $hardSecurity = false, public string $scale = 'probability', public ?array $region = null)
    {
        if (!preg_match('/^[a-z][a-z0-9_.-]{1,95}$/D', $category) || !is_finite($confidence) || $confidence < 0 || $confidence > 1 || !in_array($scale, ['probability', 'ordinal', 'severity', 'deterministic'], true) || !preg_match('/^[a-z][a-z0-9_-]{0,63}$/D', $provider) || $model === '' || strlen($model) > 120 || !mb_check_encoding($model, 'UTF-8')) { throw new \InvalidArgumentException('PROVIDER.INVALID_FINDING'); }
        if ($region !== null) {
            if (!array_is_list($region) || count($region) !== 4) { throw new \InvalidArgumentException('PROVIDER.INVALID_FINDING'); }
            foreach ($region as $coordinate) { if ((!is_int($coordinate) && !is_float($coordinate)) || !is_finite((float)$coordinate) || $coordinate < 0 || $coordinate > 1) { throw new \InvalidArgumentException('PROVIDER.INVALID_FINDING'); } }
            if ($region[0] + $region[2] > 1 || $region[1] + $region[3] > 1) { throw new \InvalidArgumentException('PROVIDER.INVALID_FINDING'); }
        }
    }
    public function jsonSerialize(): array { return ['category' => $this->category, 'confidence' => $this->confidence, 'provider' => $this->provider, 'model' => $this->model, 'hard_security' => $this->hardSecurity, 'scale' => $this->scale, 'region' => $this->region]; }
    public static function fromArray(array $v): self
    {
        if (!is_string($v['category'] ?? null) || (!is_int($v['confidence'] ?? null) && !is_float($v['confidence'] ?? null)) || (array_key_exists('hard_security', $v) && !is_bool($v['hard_security']))) { throw new \InvalidArgumentException('PROVIDER.INVALID_FINDING'); }
        return new self($v['category'], (float)$v['confidence'], $v['provider'] ?? 'local', $v['model'] ?? '1', $v['hard_security'] ?? false, $v['scale'] ?? 'probability', $v['region'] ?? null);
    }
}
