<?php
declare(strict_types=1);
namespace ContentFirewall\Providers;
use ContentFirewall\Domain\{FileDescriptor, Finding, ProviderResult};
final class CustomScanner extends JsonProvider
{
    public function __construct(\ContentFirewall\Infrastructure\HttpClient $http, string $key, string $endpoint, private array $features = ['image'], private array $mimes = ['image/jpeg', 'image/png'], private string $model = 'custom-v1') { parent::__construct($http, $key, $endpoint, 5000); }
    public function id(): string { return 'custom'; }
    public function capabilities(): array { return ['features' => $this->features, 'mimes' => $this->mimes, 'regions' => ['self-hosted-configured'], 'model' => $this->model, 'cacheable' => true]; }
    public function build(FileDescriptor $file): array { return ['url' => $this->endpoint, 'headers' => ['Authorization: Bearer ' . $this->key, 'Content-Type: application/json'], 'body' => json_encode(['schema' => 1, 'sha256' => $file->sha256, 'mime' => $file->mime, 'content' => $this->bytes($file)], JSON_THROW_ON_ERROR)]; }
    public function parse(array $data): ProviderResult
    {
        if (($data['schema'] ?? 0) !== 1 || !is_string($data['model'] ?? null) || !is_array($data['findings'] ?? null) || count($data['findings']) > 256) { throw new \RuntimeException('PROVIDER.SCHEMA'); }
        if ($data['model'] !== $this->model) { throw new \RuntimeException('PROVIDER.MODEL_CHANGED'); }
        $findings = [];
        foreach ($data['findings'] as $v) {
            if (!isset($v['category'], $v['confidence']) || !is_numeric($v['confidence'])) { throw new \RuntimeException('PROVIDER.SCHEMA'); }
            $findings[] = new Finding($v['category'], (float)$v['confidence'], $this->id(), $data['model'], false, $v['scale'] ?? 'probability', $v['region'] ?? null);
        }
        $text = $data['text'] ?? ''; if (!is_string($text) || strlen($text) > 65536) { throw new \RuntimeException('PROVIDER.OCR_LIMIT'); }
        return new ProviderResult($this->id(), $data['model'], $findings, text: $text, codes: $data['codes'] ?? []);
    }
}
