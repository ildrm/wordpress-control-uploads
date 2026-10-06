<?php
declare(strict_types=1);
namespace ContentFirewall\Domain;
final readonly class ProviderResult
{
    /** @param list<Finding> $findings */
    public function __construct(public string $provider, public string $model, public array $findings, public ?string $error = null, public bool $retryable = false, public float $durationMs = 0, public float $estimatedCost = 0, public string $text = '', public array $codes = []) {}
}
