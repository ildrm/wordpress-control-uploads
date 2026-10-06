<?php
declare(strict_types=1);
namespace ContentFirewall\Domain;
enum Action: string
{
    case Allow = 'ALLOW'; case Sanitize = 'SANITIZE'; case Review = 'REVIEW';
    case Quarantine = 'QUARANTINE'; case Block = 'BLOCK';
    public function publishable(): bool { return $this === self::Allow || $this === self::Sanitize; }
}
