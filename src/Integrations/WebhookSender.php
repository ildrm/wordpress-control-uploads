<?php
declare(strict_types=1);
namespace ContentFirewall\Integrations;
use ContentFirewall\Bootstrap\Services;
final class WebhookSender
{
    public function __construct(private Services $s) {}
    public function enqueue(int $scanId, \ContentFirewall\Domain\Decision $decision): void
    {
        if (Services::secret('CF_WEBHOOK_URL') === '' || strlen(Services::secret('CF_WEBHOOK_SECRET')) < 32) { return; }
        $event = ['schema' => 1, 'event_id' => bin2hex(random_bytes(16)), 'event' => 'scan.completed', 'site_id' => $this->s->siteId, 'scan_id' => $scanId, 'decision' => $decision->action->value, 'shadow' => $decision->shadow, 'enforced_action' => $decision->shadow ? 'ALLOW' : $decision->action->value, 'policy' => $decision->policyId, 'version' => $decision->policyVersion];
        $this->s->jobs->enqueue('webhook', $event, 'webhook:' . $event['event_id']);
    }
    public function send(array $payload): void
    {
        $url = Services::secret('CF_WEBHOOK_URL'); $secret = Services::secret('CF_WEBHOOK_SECRET');
        if (!$url || strlen($secret) < 32) { throw new \RuntimeException('CONFIGURATION.WEBHOOK'); }
        $body = json_encode($payload, JSON_THROW_ON_ERROR); $timestamp = time(); $signature = (new WebhookSignature())->sign($body, $timestamp, $payload['event_id'], $secret);
        $reply = (new \ContentFirewall\Infrastructure\PinnedHttpClient(new \ContentFirewall\Security\UrlGuard()))->request($url, ['Content-Type: application/json', 'X-CF-Event: ' . $payload['event_id'], 'X-CF-Timestamp: ' . $timestamp, 'X-CF-Signature: ' . $signature], $body, 3000);
        if ($reply['status'] < 200 || $reply['status'] >= 300) { throw new \RuntimeException($reply['status'] === 429 || $reply['status'] >= 500 ? 'PROVIDER.TRANSPORT' : 'PROVIDER.WEBHOOK_REJECTED'); }
        $this->s->audit->record('webhook.delivered', (int)($payload['scan_id'] ?? 0), 0);
    }
}
