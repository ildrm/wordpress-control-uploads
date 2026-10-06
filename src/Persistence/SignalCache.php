<?php
declare(strict_types=1);
namespace ContentFirewall\Persistence;
use ContentFirewall\Domain\{Finding, ProviderResult};
final class SignalCache
{
    public function __construct(private \wpdb $db, private Tables $tables) {}
    public function key(string $hash, string $provider, string $model, string $configuration): string { return hash('sha256', implode('|', [$hash, $provider, $model, 'taxonomy-1', 'signals-1', $configuration])); }
    public function get(string $key): ?ProviderResult
    {
        $payload = $this->db->get_var($this->db->prepare('SELECT payload FROM %i WHERE cache_key=%s AND expires_at>UTC_TIMESTAMP()', $this->tables->name('cache'), $key));
        if (!$payload) { return null; } $v = json_decode($payload, true, 16, JSON_THROW_ON_ERROR);
        return new ProviderResult($v['provider'], $v['model'], array_map([Finding::class, 'fromArray'], $v['findings']));
    }
    public function put(string $key, ProviderResult $result, int $ttl = 86400): void
    {
        // Do not cache OCR, raw responses, QR payloads, or errors.
        if ($result->error || $result->text !== '' || $result->codes) { return; }
        $this->db->replace($this->tables->name('cache'), ['cache_key' => $key, 'payload' => json_encode(['provider' => $result->provider, 'model' => $result->model, 'findings' => $result->findings], JSON_THROW_ON_ERROR), 'expires_at' => gmdate('Y-m-d H:i:s', time() + min(86400, $ttl))]);
    }
}
