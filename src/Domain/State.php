<?php
declare(strict_types=1);
namespace ContentFirewall\Domain;
enum State: string
{
    case Received = 'RECEIVED'; case Preflight = 'PREFLIGHT'; case Security = 'SECURITY_SCANNING';
    case Content = 'CONTENT_SCANNING'; case Sanitizing = 'SANITIZING'; case Pending = 'PENDING_PROVIDER';
    case Quarantined = 'QUARANTINED'; case Review = 'REVIEW_REQUIRED'; case Allowed = 'ALLOWED';
    case Sanitized = 'SANITIZED'; case Blocked = 'BLOCKED'; case Failed = 'FAILED';
    case Appealed = 'APPEALED'; case Deleted = 'DELETED';
    public function canTransition(self $to): bool
    {
        if ($this === $to) { return true; }
        return in_array($to, match ($this) {
            self::Received => [self::Preflight, self::Blocked, self::Failed, self::Deleted],
            self::Preflight => [self::Security, self::Blocked, self::Failed, self::Deleted],
            self::Security => [self::Content, self::Blocked, self::Quarantined, self::Failed, self::Deleted],
            self::Content => [self::Sanitizing, self::Pending, self::Quarantined, self::Review, self::Allowed, self::Blocked, self::Failed, self::Deleted],
            self::Sanitizing => [self::Sanitized, self::Content, self::Review, self::Quarantined, self::Blocked, self::Failed, self::Deleted],
            self::Pending => [self::Content, self::Review, self::Quarantined, self::Blocked, self::Failed, self::Deleted],
            self::Quarantined, self::Review, self::Failed => [self::Content, self::Allowed, self::Sanitizing, self::Quarantined, self::Blocked, self::Appealed, self::Deleted],
            self::Allowed, self::Sanitized => [self::Content, self::Quarantined, self::Review, self::Blocked, self::Deleted],
            self::Blocked => [self::Appealed, self::Content, self::Allowed, self::Deleted],
            self::Appealed => [self::Content, self::Review, self::Quarantined, self::Allowed, self::Blocked, self::Deleted],
            self::Deleted => [],
        }, true);
    }
}
