<?php
declare(strict_types=1);
namespace ContentFirewall\Domain;
final readonly class ProviderResult
{
    /** @var list<Finding> */
    public array $findings;
    /** @param list<mixed> $findings */
    public function __construct(public string $provider, public string $model, array $findings, public ?string $error = null, public bool $retryable = false, public float $durationMs = 0, public float $estimatedCost = 0, public string $text = '', public array $codes = [], public string $language = '')
    {
        if (!preg_match('/^[a-z][a-z0-9_-]{0,63}$/D', $provider) || $model === '' || strlen($model) > 120 || !is_finite($durationMs) || $durationMs < 0 || !is_finite($estimatedCost) || $estimatedCost < 0 || !array_is_list($findings) || count($findings) > 256 || strlen($text) > 65536 || !mb_check_encoding($text, 'UTF-8') || !array_is_list($codes) || count($codes) > 100) { throw new \InvalidArgumentException('PROVIDER.INVALID_RESULT'); }
        $validated = [];
        foreach ($findings as $finding) { if (!$finding instanceof Finding) { throw new \InvalidArgumentException('PROVIDER.INVALID_RESULT'); } $validated[] = $finding; }
        $this->findings = $validated;
        if ($language !== '' && !preg_match('/^[a-z]{2,3}$/D', $language)) { throw new \InvalidArgumentException('PROVIDER.INVALID_RESULT'); }
        foreach ($codes as $code) { if (!is_string($code) || strlen($code) > 4096) { throw new \InvalidArgumentException('PROVIDER.INVALID_RESULT'); } }
    }
}
