<?php
declare(strict_types=1);
namespace ContentFirewall\Domain;
final readonly class Decision implements \JsonSerializable
{
    /** @param list<string> $reasons @param list<string> $rules @param list<string> $effects */
    public function __construct(public Action $action, public array $reasons, public array $rules, public string $policyId, public int $policyVersion, public float $risk, public bool $shadow = false, public array $effects = []) {}
    public function jsonSerialize(): array { return ['action' => $this->action->value, 'reasons' => $this->reasons, 'rules' => $this->rules, 'policy_id' => $this->policyId, 'policy_version' => $this->policyVersion, 'risk' => $this->risk, 'shadow' => $this->shadow, 'effects' => $this->effects]; }
}
