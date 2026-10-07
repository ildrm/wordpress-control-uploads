<?php
declare(strict_types=1);
namespace ContentFirewall\Providers;
use ContentFirewall\Domain\{FileDescriptor, ProviderResult};
final class OpenAiTranscription extends JsonProvider
{
    public function __construct(\ContentFirewall\Infrastructure\HttpClient $http, string $key) { parent::__construct($http, $key, 'https://api.openai.com/v1/audio/transcriptions', 15000); }
    public function id(): string { return 'openai-transcription'; }
    public function capabilities(): array { return ['features' => ['audio', 'transcription', 'language'], 'mimes' => ['audio/mpeg', 'audio/wav', 'audio/x-wav', 'audio/mp4', 'audio/ogg'], 'regions' => [], 'model' => 'whisper-1', 'cacheable' => false]; }
    public function build(FileDescriptor $file): array
    {
        $content = base64_decode($this->bytes($file), true); if ($content === false) { throw new \RuntimeException('PROVIDER.INPUT_LIMIT'); }
        $boundary = 'cf-' . bin2hex(random_bytes(16)); $body = '';
        foreach (['model' => 'whisper-1', 'response_format' => 'verbose_json'] as $name => $value) { $body .= '--' . $boundary . "\r\nContent-Disposition: form-data; name=\"" . $name . "\"\r\n\r\n" . $value . "\r\n"; }
        $body .= '--' . $boundary . "\r\nContent-Disposition: form-data; name=\"file\"; filename=\"clip.mp3\"\r\nContent-Type: " . $file->mime . "\r\n\r\n" . $content . "\r\n--" . $boundary . "--\r\n";
        return ['url' => $this->endpoint, 'headers' => ['Authorization: Bearer ' . $this->key, 'Content-Type: multipart/form-data; boundary=' . $boundary], 'body' => $body];
    }
    public function parse(array $data): ProviderResult
    {
        if (!is_string($data['text'] ?? null) || !is_string($data['language'] ?? null) || strlen($data['language']) > 80 || !mb_check_encoding($data['language'], 'UTF-8')) { throw new \RuntimeException('PROVIDER.SCHEMA'); }
        $languages = ['english' => 'en', 'persian' => 'fa', 'arabic' => 'ar', 'spanish' => 'es', 'french' => 'fr', 'german' => 'de', 'italian' => 'it', 'portuguese' => 'pt', 'russian' => 'ru', 'turkish' => 'tr', 'chinese' => 'zh', 'japanese' => 'ja', 'korean' => 'ko', 'hindi' => 'hi', 'urdu' => 'ur', 'dutch' => 'nl', 'polish' => 'pl', 'ukrainian' => 'uk', 'swedish' => 'sv', 'hebrew' => 'he', 'indonesian' => 'id', 'vietnamese' => 'vi', 'thai' => 'th'];
        $language = $languages[strtolower($data['language'])] ?? 'und';
        return new ProviderResult($this->id(), 'whisper-1', [], text: $data['text'], language: $language);
    }
}
