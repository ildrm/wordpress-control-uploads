<?php
declare(strict_types=1);
namespace ContentFirewall\Application;
final class CaseAssignment
{
    public static function parse(array $value): array
    {
        if (array_diff(array_keys($value), ['team', 'priority', 'sla_at'])) { throw new \InvalidArgumentException('VALIDATION.ASSIGNMENT'); }
        if (array_key_exists('team', $value) && (!is_string($value['team']) || !preg_match('/^[a-zA-Z0-9 _.-]{0,64}$/D', $value['team']))) { throw new \InvalidArgumentException('VALIDATION.TEAM'); }
        if (array_key_exists('priority', $value) && (!is_int($value['priority']) || $value['priority'] < 0 || $value['priority'] > 1000)) { throw new \InvalidArgumentException('VALIDATION.PRIORITY'); }
        if (array_key_exists('sla_at', $value) && $value['sla_at'] !== null) {
            if (!is_string($value['sla_at'])) { throw new \InvalidArgumentException('VALIDATION.SLA'); }
            $time = \DateTimeImmutable::createFromFormat('!Y-m-d H:i:s', $value['sla_at'], new \DateTimeZone('UTC'));
            if (!$time || $time->format('Y-m-d H:i:s') !== $value['sla_at'] || $time->getTimestamp() < time() || $time->getTimestamp() > time() + 366 * 86400) { throw new \InvalidArgumentException('VALIDATION.SLA'); }
        }
        return $value;
    }
}
