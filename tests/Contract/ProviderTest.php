<?php
declare(strict_types=1);
namespace ContentFirewall\Tests\Contract;
use ContentFirewall\Domain\FileDescriptor;
use ContentFirewall\Infrastructure\HttpClient;
use ContentFirewall\Providers\{AwsRekognition, AzureSafety, CustomScanner, GoogleVision, OpenAiModeration, Sightengine};
use PHPUnit\Framework\TestCase;
final class ProviderTest extends TestCase
{
    private function http(int $status = 200, string $body = '{}'): HttpClient { return new class($status, $body) implements HttpClient { public function __construct(private int $status, private string $body) {} public function request(string $url, array $headers, string $body, int $timeoutMs = 1500): array { return ['status' => $this->status, 'body' => $this->body, 'headers' => []]; } }; }
    private function file(): FileDescriptor { $path = tempnam(sys_get_temp_dir(), 'cf-contract-'); file_put_contents($path, 'harmless-contract-bytes'); return new FileDescriptor($path, 'image.jpg', 'image/jpeg', filesize($path), hash_file('sha256', $path)); }
    public function testAwsRequestSignatureAndPercentNormalization(): void
    {
        $p = new AwsRekognition($this->http(), 'test-access', 'test-secret'); $file = $this->file(); try { $request = $p->build($file); self::assertStringContainsString('AWS4-HMAC-SHA256', implode(' ', $request['headers'])); self::assertStringContainsString('RekognitionService.DetectModerationLabels', implode(' ', $request['headers'])); } finally { unlink($file->path); }
        $r = $p->parse(['ModerationLabels' => [['Name' => 'Explicit Nudity', 'Confidence' => 94]], 'ModerationModelVersion' => '7']); self::assertSame(0.94, $r->findings[0]->confidence); self::assertSame('sexual.explicit', $r->findings[0]->category);
    }
    public function testGoogleOrdinalAndOcr(): void { $p = new GoogleVision($this->http(), 'test-token', ''); $r = $p->parse(['responses' => [['safeSearchAnnotation' => ['adult' => 'VERY_LIKELY', 'racy' => 'POSSIBLE', 'violence' => 'UNLIKELY'], 'fullTextAnnotation' => ['text' => 'Harmless synthetic text']]]]); self::assertSame('ordinal', $r->findings[0]->scale); self::assertSame('Harmless synthetic text', $r->text); }
    public function testGoogleUnknownEvidenceFails(): void { $this->expectException(\RuntimeException::class); (new GoogleVision($this->http(), 'test-token', ''))->parse(['responses' => [['safeSearchAnnotation' => ['adult' => 'UNKNOWN']]]]); }
    public function testAzureSeverityIsNotAProbability(): void { $p = new AzureSafety($this->http(), 'test-key', 'https://example.org'); $r = $p->parse(['categoriesAnalysis' => array_map(static fn(string $c): array => ['category' => $c, 'severity' => 6], ['Hate','SelfHarm','Sexual','Violence'])]); self::assertSame('severity', $r->findings[0]->scale); self::assertSame(1.0, $r->findings[0]->confidence); }
    public function testOpenAiUnsupportedImageCategoriesExcluded(): void { $p = new OpenAiModeration($this->http(), 'test-key', ''); $r = $p->parse(['model' => 'omni-moderation-2024-09-26', 'results' => [['category_scores' => ['sexual' => 0.2, 'hate' => 0], 'category_applied_input_types' => ['sexual' => ['image'], 'hate' => []]]]]); self::assertCount(1, $r->findings); }
    public function testSightengineBinaryAndModelContract(): void { $p = new Sightengine($this->http(), 'test-user', 'test-secret'); $file = $this->file(); try { $request = $p->build($file); self::assertStringContainsString('name="media"', $request['body']); self::assertStringContainsString('filename="scan.bin"', $request['body']); } finally { unlink($file->path); } $r = $p->parse(['status' => 'success', 'nudity' => ['sexual_activity'=>0.1,'sexual_display'=>0.1,'erotica'=>0.1,'very_suggestive'=>0.1,'suggestive'=>0.1], 'gore' => ['prob'=>0.1]]); self::assertCount(6, $r->findings); }
    public function testHttpErrorsRetryOnlyTemporaryFailures(): void { $file = $this->file(); try { foreach ([429=>true,500=>true,401=>false,400=>false] as $status=>$retryable) { $r = (new OpenAiModeration($this->http($status), 'test-key', ''))->scan($file); self::assertSame($retryable, $r->retryable); self::assertSame('PROVIDER.HTTP_' . $status, $r->error); } } finally { unlink($file->path); } }
    public function testMalformedResponseHasStableError(): void { $file = $this->file(); try { $r = (new OpenAiModeration($this->http(200, 'not-json'), 'test-key', ''))->scan($file); self::assertSame('PROVIDER.SCHEMA', $r->error); self::assertFalse($r->retryable); } finally { unlink($file->path); } }
    public function testCustomScannerCannotSetHardSecurityFalseNegatives(): void { $p = new CustomScanner($this->http(), 'test-key', 'https://example.org'); $r = $p->parse(['schema'=>1,'model'=>'custom-v1','findings'=>[['category'=>'sexual.explicit','confidence'=>0.9,'hard_security'=>true]]]); self::assertFalse($r->findings[0]->hardSecurity); }
    public function testTextModerationUsesSupportedTextCategories(): void
    {
        $reply = json_encode(['model'=>'omni-moderation-test','results'=>[['category_scores'=>['hate'=>0.9],'category_applied_input_types'=>['hate'=>['text']]]]]);
        $p = new OpenAiModeration($this->http(200,$reply),'test-key',''); $r=$p->scanText('Harmless synthetic contract fixture'); self::assertNull($r->error); self::assertSame('hate.speech',$r->findings[0]->category);
    }
}
