<?php
declare(strict_types=1);
namespace ContentFirewall\Tests\Contract;
use ContentFirewall\Providers\OpenAiTranscription;
use ContentFirewall\Infrastructure\HttpClient;
use ContentFirewall\Domain\FileDescriptor;
use PHPUnit\Framework\TestCase;
final class TranscriptionTest extends TestCase
{
    private function provider(): OpenAiTranscription
    {
        return new OpenAiTranscription(new class implements HttpClient { public function request(string $url, array $headers, string $body, int $timeoutMs = 1500): array { return ['status' => 200, 'body' => '{"text":"Harmless example","language":"english"}', 'headers' => []]; } }, 'test-key');
    }
    public function testMultipartUsesReducedFileAndNoUploaderMetadata(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'cf-audio-contract-'); file_put_contents($path, 'synthetic audio bytes');
        try { $request = $this->provider()->build(new FileDescriptor($path, 'private-original-name.mp3', 'audio/mpeg', 21, hash_file('sha256', $path))); self::assertStringContainsString('name="model"', $request['body']); self::assertStringContainsString('verbose_json', $request['body']); self::assertStringContainsString('filename="clip.mp3"', $request['body']); self::assertStringNotContainsString('private-original-name', $request['body']); self::assertStringNotContainsString('user_id', $request['body']); }
        finally { unlink($path); }
    }
    public function testMeasuredLanguageAndTextRemainEphemeralResult(): void
    {
        $r = $this->provider()->parse(['text' => 'Harmless example', 'language' => 'persian']); self::assertSame('fa', $r->language); self::assertSame('Harmless example', $r->text); self::assertFalse($this->provider()->capabilities()['cacheable']);
    }
    public function testUnknownLanguageIsExplicit(): void
    {
        self::assertSame('und', $this->provider()->parse(['text' => '', 'language' => 'unknown'])->language);
    }
    public function testMalformedTranscriptCannotBecomeAResult(): void
    {
        $this->expectExceptionMessage('PROVIDER.SCHEMA'); $this->provider()->parse(['text' => [], 'language' => 'english']);
    }
}
