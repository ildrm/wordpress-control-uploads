<?php
declare(strict_types=1);
namespace ContentFirewall\Integrations;
final class WebhookSignature
{
    public function sign(string $body, int $timestamp, string $eventId, string $secret): string { return hash_hmac('sha256', $timestamp . '.' . $eventId . '.' . $body, $secret); }
    public function verify(string $body, int $timestamp, string $eventId, string $signature, string $secret, ?int $now = null): bool
    {
        return strlen($body) <= 65536 && strlen($secret) >= 32 && abs(($now ?? time()) - $timestamp) <= 300 && preg_match('/^[a-f0-9]{32}$/D', $eventId) === 1 && preg_match('/^[a-f0-9]{64}$/D', $signature) === 1 && hash_equals($this->sign($body, $timestamp, $eventId, $secret), $signature);
    }
}
