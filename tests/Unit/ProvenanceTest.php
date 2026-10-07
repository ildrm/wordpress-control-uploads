<?php
declare(strict_types=1);
namespace ContentFirewall\Tests\Unit;
use ContentFirewall\Authenticity\ContentCredentials;
use ContentFirewall\Security\PrivateStorage;
use PHPUnit\Framework\TestCase;
final class ProvenanceTest extends TestCase
{
    private array $roots = [];
    protected function tearDown(): void { foreach ($this->roots as $root) { rmdir($root); } }
    private function parser(): ContentCredentials
    {
        $root = sys_get_temp_dir() . '/cf-provenance-unit-' . bin2hex(random_bytes(5)); mkdir($root, 0700);
        $this->roots[] = $root;
        return new ContentCredentials('', new PrivateStorage($root), 1);
    }
    private function report(): array
    {
        return ['active_manifest' => 'test', 'validation_state' => 'Valid', 'manifests' => ['test' => ['signature_info' => ['issuer' => 'Synthetic issuer'], 'assertions' => []]], 'validation_results' => ['activeManifest' => ['success' => [['code' => 'claimSignature.validated'], ['code' => 'assertion.dataHash.match']], 'failure' => []]]];
    }
    public function testAbsentCredentialIsNotFakeOrInvalid(): void
    {
        $r = $this->parser()->absent(); self::assertNull($r['report']['signature_valid']); self::assertNull($r['report']['ai_declared']); self::assertCount(1, $r['findings']); self::assertSame('provenance.present', $r['findings'][0]->category); self::assertSame(0.0, $r['findings'][0]->confidence);
    }
    public function testValidSignatureDoesNotImplySignerTrust(): void
    {
        $r = $this->parser()->parse($this->report()); self::assertTrue($r['report']['signature_valid']); self::assertNull($r['report']['trusted']);
    }
    public function testTamperedBindingCannotBeValid(): void
    {
        $data = $this->report(); $data['validation_state'] = 'Invalid'; $data['validation_results']['activeManifest']['failure'][] = ['code' => 'assertion.dataHash.mismatch']; self::assertFalse($this->parser()->parse($data)['report']['signature_valid']);
    }
    public function testSignatureWithoutAssetBindingCannotBeValid(): void
    {
        $data = $this->report(); array_pop($data['validation_results']['activeManifest']['success']); self::assertFalse($this->parser()->parse($data)['report']['signature_valid']);
    }
    public function testAiDeclarationIsDistinctFromAClassificationModel(): void
    {
        $data = $this->report(); $data['manifests']['test']['assertions'] = [['label' => 'c2pa.actions.v2', 'data' => ['actions' => [['action' => 'c2pa.created', 'digitalSourceType' => 'http://cv.iptc.org/newscodes/digitalsourcetype/trainedAlgorithmicMedia']]]]];
        $r = $this->parser()->parse($data); self::assertTrue($r['report']['ai_declared']); self::assertSame('authenticity.ai_declared', $r['findings'][2]->category);
    }
    public function testMalformedStatusCannotEstablishEvidence(): void
    {
        $data = $this->report(); $data['validation_results']['activeManifest']['success'][] = ['code' => []]; $this->expectExceptionMessage('PROVIDER.C2PA_SCHEMA'); $this->parser()->parse($data);
    }
    public function testInvalidBindingCannotEstablishAnAiDeclaration(): void
    {
        $data = $this->report(); $data['validation_state'] = 'Invalid'; $data['validation_results']['activeManifest']['failure'][] = ['code' => 'assertion.dataHash.mismatch'];
        $r = $this->parser()->parse($data); self::assertNull($r['report']['ai_declared']); self::assertCount(2, $r['findings']);
    }
}
