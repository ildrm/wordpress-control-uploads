<?php
declare(strict_types=1);
namespace ContentFirewall\Domain;
final readonly class UploadContext
{
    /** @param list<string> $roles @param list<string> $terms */
    public function __construct(public int $siteId, public int $userId, public string $source = 'media', public array $roles = [], public string $postType = '', public array $terms = [], public string $trust = 'normal', public int $networkId = 0)
    {
        if ($siteId < 1 || $userId < 0 || !in_array($trust, ['new', 'normal', 'trusted', 'restricted'], true)) { throw new \InvalidArgumentException('VALIDATION.CONTEXT'); }
    }
    public function signals(): array { return ['context' => $this->source, 'site_id' => $this->siteId, 'network_id' => $this->networkId, 'user_id' => $this->userId, 'roles' => $this->roles, 'post_type' => $this->postType, 'terms' => $this->terms, 'trust' => $this->trust]; }
}
