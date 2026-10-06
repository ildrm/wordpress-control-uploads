<?php
declare(strict_types=1);
namespace ContentFirewall\Providers;
use ContentFirewall\Domain\{FileDescriptor, Finding, ProviderResult};
final class AwsRekognition extends JsonProvider
{
    public function __construct(\ContentFirewall\Infrastructure\HttpClient $http, string $accessKey, private string $secret, private string $region = 'us-east-1', private string $sessionToken = '')
    {
        if (!preg_match('/^[a-z]{2}-[a-z]+-\d$/D', $region)) { throw new \InvalidArgumentException('CONFIGURATION.REGION'); }
        parent::__construct($http, $accessKey, 'https://rekognition.' . $region . '.amazonaws.com');
    }
    public function id(): string { return 'aws-rekognition'; }
    public function capabilities(): array { return ['features' => ['image'], 'mimes' => ['image/jpeg', 'image/png'], 'regions' => [$this->region], 'model' => 'rekognition-moderation']; }
    public function build(FileDescriptor $file): array
    {
        $body = json_encode(['Image' => ['Bytes' => $this->bytes($file)], 'MinConfidence' => 0], JSON_THROW_ON_ERROR);
        $date = gmdate('Ymd\THis\Z'); $day = substr($date, 0, 8); $host = (string)parse_url($this->endpoint, PHP_URL_HOST);
        $headers = ['content-type' => 'application/x-amz-json-1.1', 'host' => $host, 'x-amz-date' => $date, 'x-amz-target' => 'RekognitionService.DetectModerationLabels'];
        if ($this->sessionToken !== '') { $headers['x-amz-security-token'] = $this->sessionToken; }
        ksort($headers); $canonical = ''; foreach ($headers as $name => $value) { $canonical .= $name . ':' . trim($value) . "\n"; }
        $signed = implode(';', array_keys($headers)); $scope = $day . '/' . $this->region . '/rekognition/aws4_request';
        $request = "POST\n/\n\n" . $canonical . "\n" . $signed . "\n" . hash('sha256', $body);
        $toSign = "AWS4-HMAC-SHA256\n" . $date . "\n" . $scope . "\n" . hash('sha256', $request);
        $key = hash_hmac('sha256', $day, 'AWS4' . $this->secret, true);
        foreach ([$this->region, 'rekognition', 'aws4_request'] as $part) { $key = hash_hmac('sha256', $part, $key, true); }
        $headers['Authorization'] = 'AWS4-HMAC-SHA256 Credential=' . $this->key . '/' . $scope . ', SignedHeaders=' . $signed . ', Signature=' . hash_hmac('sha256', $toSign, $key);
        $lines = []; foreach ($headers as $name => $value) { $lines[] = $name . ': ' . $value; }
        return ['url' => $this->endpoint . '/', 'headers' => $lines, 'body' => $body];
    }
    public function parse(array $data): ProviderResult
    {
        if (!is_array($data['ModerationLabels'] ?? null) || !is_string($data['ModerationModelVersion'] ?? null)) { throw new \RuntimeException('PROVIDER.SCHEMA'); }
        $map = ['Explicit Nudity' => 'sexual.explicit', 'Explicit Sexual Activity' => 'sexual.activity', 'Non-Explicit Nudity' => 'sexual.implied', 'Suggestive' => 'sexual.suggestive', 'Violence' => 'violence.physical', 'Graphic Violence' => 'violence.graphic', 'Visually Disturbing' => 'violence.disturbing', 'Weapons' => 'weapon.firearm', 'Drugs' => 'drug.recreational', 'Tobacco' => 'tobacco.smoking', 'Alcohol' => 'alcohol.presence', 'Hate Symbols' => 'hate.symbol'];
        $findings = [];
        foreach ($data['ModerationLabels'] as $label) {
            if (!isset($label['Name'], $label['Confidence']) || !is_numeric($label['Confidence']) || $label['Confidence'] < 0 || $label['Confidence'] > 100) { throw new \RuntimeException('PROVIDER.SCHEMA'); }
            $category = $map[$label['Name']] ?? $map[$label['ParentName'] ?? ''] ?? 'provider.unknown';
            $findings[] = new Finding($category, (float)$label['Confidence'] / 100, $this->id(), $data['ModerationModelVersion']);
        }
        return new ProviderResult($this->id(), $data['ModerationModelVersion'], $findings);
    }
}
