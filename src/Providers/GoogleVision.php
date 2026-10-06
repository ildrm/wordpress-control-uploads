<?php
declare(strict_types=1);
namespace ContentFirewall\Providers;
use ContentFirewall\Domain\{FileDescriptor, Finding, ProviderResult};
final class GoogleVision extends JsonProvider
{
    public function id(): string { return 'google-vision'; }
    public function capabilities(): array { return ['features' => ['image', 'ocr', 'logo', 'face'], 'mimes' => ['image/jpeg', 'image/png', 'image/webp'], 'regions' => ['global'], 'model' => 'vision-v1']; }
    public function build(FileDescriptor $file): array { return ['url' => 'https://vision.googleapis.com/v1/images:annotate', 'headers' => ['Authorization: Bearer ' . $this->key, 'Content-Type: application/json'], 'body' => json_encode(['requests' => [['image' => ['content' => $this->bytes($file)], 'features' => [['type' => 'SAFE_SEARCH_DETECTION'], ['type' => 'TEXT_DETECTION']]]]], JSON_THROW_ON_ERROR)]; }
    public function parse(array $data): ProviderResult
    {
        $r = $data['responses'][0] ?? null;
        if (!is_array($r) || isset($r['error']) || !isset($r['safeSearchAnnotation'])) { throw new \RuntimeException('PROVIDER.SCHEMA'); }
        $map = ['adult' => 'sexual.explicit', 'racy' => 'sexual.suggestive', 'violence' => 'violence.graphic'];
        $scale = ['VERY_UNLIKELY' => 0.05, 'UNLIKELY' => 0.25, 'POSSIBLE' => 0.5, 'LIKELY' => 0.75, 'VERY_LIKELY' => 0.95]; $findings = [];
        foreach ($map as $vendor => $category) {
            $v = $r['safeSearchAnnotation'][$vendor] ?? 'UNKNOWN';
            if (!isset($scale[$v])) { throw new \RuntimeException('PROVIDER.UNKNOWN_EVIDENCE'); }
            $findings[] = new Finding($category, $scale[$v], $this->id(), 'vision-v1', false, 'ordinal');
        }
        $text = $r['fullTextAnnotation']['text'] ?? $r['textAnnotations'][0]['description'] ?? '';
        if (!is_string($text) || strlen($text) > 65536) { throw new \RuntimeException('PROVIDER.OCR_LIMIT'); }
        return new ProviderResult($this->id(), 'vision-v1', $findings, text: $text);
    }
}
