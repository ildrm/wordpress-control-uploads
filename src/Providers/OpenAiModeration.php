<?php
declare(strict_types=1);
namespace ContentFirewall\Providers;
use ContentFirewall\Domain\{FileDescriptor, Finding, ProviderResult};
final class OpenAiModeration extends JsonProvider implements TextProvider
{
    public function id(): string { return 'openai'; }
    public function capabilities(): array { return ['features' => ['image', 'text'], 'mimes' => ['image/jpeg', 'image/png', 'image/webp'], 'regions' => ['configured-account'], 'model' => 'omni-moderation-latest']; }
    public function build(FileDescriptor $file): array { return ['url' => 'https://api.openai.com/v1/moderations', 'headers' => ['Authorization: Bearer ' . $this->key, 'Content-Type: application/json'], 'body' => json_encode(['model' => 'omni-moderation-latest', 'input' => [['type' => 'image_url', 'image_url' => ['url' => 'data:' . $file->mime . ';base64,' . $this->bytes($file)]]]], JSON_THROW_ON_ERROR)]; }
    public function parse(array $data): ProviderResult
    {
        return $this->parseInput($data, 'image');
    }
    public function scanText(string $text): ProviderResult
    {
        if (strlen($text) > 16384 || !mb_check_encoding($text, 'UTF-8')) { return new ProviderResult($this->id(), 'omni-moderation-latest', [], 'PROVIDER.TEXT_LIMIT'); }
        try {
            $r = $this->http->request('https://api.openai.com/v1/moderations', ['Authorization: Bearer ' . $this->key, 'Content-Type: application/json'], json_encode(['model' => 'omni-moderation-latest', 'input' => $text], JSON_THROW_ON_ERROR), $this->timeoutMs);
            if ($r['status'] !== 200) { return new ProviderResult($this->id(), 'omni-moderation-latest', [], 'PROVIDER.HTTP_' . $r['status'], $r['status'] === 429 || $r['status'] >= 500); }
            return $this->parseInput(json_decode($r['body'], true, 32, JSON_THROW_ON_ERROR), 'text');
        } catch (\Throwable) { return new ProviderResult($this->id(), 'omni-moderation-latest', [], 'PROVIDER.TEXT_FAILURE'); }
    }
    private function parseInput(array $data, string $inputType): ProviderResult
    {
        $result = $data['results'][0] ?? null; $model = $data['model'] ?? null;
        if (!is_array($result) || !is_string($model) || !isset($result['category_scores'], $result['category_applied_input_types'])) { throw new \RuntimeException('PROVIDER.SCHEMA'); }
        $map = ['sexual' => 'sexual.explicit', 'violence' => 'violence.physical', 'violence/graphic' => 'violence.graphic', 'self-harm' => 'self_harm.graphic', 'self-harm/intent' => 'self_harm.intent', 'self-harm/instructions' => 'self_harm.instructions', 'hate' => 'hate.speech', 'harassment' => 'text.harassment', 'harassment/threatening' => 'text.threat']; $findings = [];
        foreach ($map as $vendor => $category) {
            // An unsupported image category's zero is NOT evidence that it is absent.
            if (!in_array($inputType, $result['category_applied_input_types'][$vendor] ?? [], true)) { continue; }
            if (!isset($result['category_scores'][$vendor]) || !is_numeric($result['category_scores'][$vendor])) { throw new \RuntimeException('PROVIDER.SCHEMA'); }
            $findings[] = new Finding($category, (float)$result['category_scores'][$vendor], $this->id(), $model);
        }
        if (!$findings) { throw new \RuntimeException('PROVIDER.UNKNOWN_EVIDENCE'); }
        return new ProviderResult($this->id(), $model, $findings);
    }
}
