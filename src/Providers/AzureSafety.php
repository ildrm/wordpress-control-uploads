<?php
declare(strict_types=1);
namespace ContentFirewall\Providers;
use ContentFirewall\Domain\{FileDescriptor, Finding, ProviderResult};
final class AzureSafety extends JsonProvider
{
    public function id(): string { return 'azure-safety'; }
    public function capabilities(): array { return ['features' => ['image'], 'mimes' => ['image/jpeg', 'image/png'], 'regions' => ['configured'], 'model' => '2024-09-01']; }
    public function build(FileDescriptor $file): array { return ['url' => rtrim($this->endpoint, '/') . '/contentsafety/image:analyze?api-version=2024-09-01', 'headers' => ['Ocp-Apim-Subscription-Key: ' . $this->key, 'Content-Type: application/json'], 'body' => json_encode(['image' => ['content' => $this->bytes($file)], 'categories' => ['Hate', 'SelfHarm', 'Sexual', 'Violence'], 'outputType' => 'FourSeverityLevels'], JSON_THROW_ON_ERROR)]; }
    public function parse(array $data): ProviderResult
    {
        $map = ['Hate' => 'hate.symbol', 'SelfHarm' => 'self_harm.graphic', 'Sexual' => 'sexual.explicit', 'Violence' => 'violence.graphic']; $findings = []; $seen = [];
        foreach ($data['categoriesAnalysis'] ?? [] as $item) {
            if (!isset($item['category'], $item['severity']) || !isset($map[$item['category']]) || !in_array($item['severity'], [0, 2, 4, 6], true)) { throw new \RuntimeException('PROVIDER.SCHEMA'); }
            $seen[$item['category']] = true; $findings[] = new Finding($map[$item['category']], $item['severity'] / 6, $this->id(), '2024-09-01', false, 'severity');
        }
        if (count($seen) !== 4) { throw new \RuntimeException('PROVIDER.SCHEMA'); }
        return new ProviderResult($this->id(), '2024-09-01', $findings);
    }
}
