<?php
declare(strict_types=1);
namespace ContentFirewall\Domain;
final readonly class Policy
{
    public function __construct(public string $id, public int $version, public string $name, public array $rules, public Action $defaultAction = Action::Allow, public bool $shadow = false, public array $bands = [], public array $options = []) {}
    public function toArray(): array { return ['schema' => 1, 'id' => $this->id, 'version' => $this->version, 'name' => $this->name, 'rules' => $this->rules, 'default' => $this->defaultAction->value, 'shadow' => $this->shadow, 'bands' => $this->bands, 'options' => $this->options]; }
}
