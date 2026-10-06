<?php
declare(strict_types=1);
namespace ContentFirewall\Providers;
use ContentFirewall\Domain\{FileDescriptor, Finding, ProviderResult};
final class Sightengine extends JsonProvider
{
    public function __construct(\ContentFirewall\Infrastructure\HttpClient $http, string $user, private string $secret) { parent::__construct($http, $user, 'https://api.sightengine.com/1.0/check.json'); }
    public function id(): string { return 'sightengine'; }
    public function capabilities(): array { return ['features' => ['image'], 'mimes' => ['image/jpeg', 'image/png', 'image/webp'], 'regions' => ['account-contract'], 'model' => 'nudity-2.1,gore-2.0']; }
    public function build(FileDescriptor $file): array
    {
        $binary = base64_decode($this->bytes($file), true); $boundary = 'cf-' . bin2hex(random_bytes(24)); $body = '';
        foreach (['models' => 'nudity-2.1,gore-2.0', 'api_user' => $this->key, 'api_secret' => $this->secret] as $name => $value) { $body .= '--' . $boundary . "\r\nContent-Disposition: form-data; name=\"" . $name . "\"\r\n\r\n" . $value . "\r\n"; }
        $body .= '--' . $boundary . "\r\nContent-Disposition: form-data; name=\"media\"; filename=\"scan.bin\"\r\nContent-Type: " . $file->mime . "\r\n\r\n" . $binary . "\r\n--" . $boundary . "--\r\n";
        return ['url' => $this->endpoint, 'headers' => ['Content-Type: multipart/form-data; boundary=' . $boundary], 'body' => $body];
    }
    public function parse(array $data): ProviderResult
    {
        if (($data['status'] ?? '') !== 'success' || !is_array($data['nudity'] ?? null) || !is_array($data['gore'] ?? null)) { throw new \RuntimeException('PROVIDER.SCHEMA'); }
        $map = ['nudity.sexual_activity' => 'sexual.activity', 'nudity.sexual_display' => 'sexual.explicit', 'nudity.erotica' => 'sexual.erotic', 'nudity.very_suggestive' => 'sexual.suggestive', 'nudity.suggestive' => 'sexual.suggestive', 'gore.prob' => 'violence.graphic']; $findings = [];
        foreach ($map as $path => $category) {
            [$a, $b] = explode('.', $path); $v = $data[$a][$b] ?? null;
            if (!is_numeric($v)) { throw new \RuntimeException('PROVIDER.SCHEMA'); }
            $findings[] = new Finding($category, (float)$v, $this->id(), $this->capabilities()['model']);
        }
        return new ProviderResult($this->id(), $this->capabilities()['model'], $findings);
    }
}
