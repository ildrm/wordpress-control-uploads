<?php
declare(strict_types=1);
namespace ContentFirewall\Tests\Unit;
use ContentFirewall\Privacy\{QrInspector, TextInspector};
use ContentFirewall\Analytics\Evaluator;
use ContentFirewall\Integrations\WebhookSignature;
use PHPUnit\Framework\TestCase;
final class PrivacyAndQualityTest extends TestCase
{
    public function testDlpRetainsNoSensitiveTextInFindings(): void { $findings = (new TextInspector())->inspect('Contact test@example.org +1 555 555 1212 card 4111 1111 1111 1111'); $json = json_encode($findings); self::assertStringContainsString('pii.email', $json); self::assertStringContainsString('pii.credit_card', $json); self::assertStringNotContainsString('example.org', $json); self::assertStringNotContainsString('4111', $json); }
    public function testLuhnRejectsFalseCandidates(): void { self::assertTrue(TextInspector::luhn('4111111111111111')); self::assertFalse(TextInspector::luhn('0000000000000000')); self::assertFalse(TextInspector::luhn('4111111111111112')); }
    public function testQrPayloadsAreNeverFetched(): void { $f = (new QrInspector())->inspect(['http://169.254.169.254/latest/meta-data/', 'BEGIN:VCARD', 'bitcoin:test']); self::assertSame(['qr.suspicious', 'qr.contact', 'qr.payment'], array_map(static fn($f) => $f->category, $f)); }
    public function testQualityReportsUndefinedDenominators(): void { $e = new Evaluator(); self::assertNull($e->evaluate([])['precision']); $r = $e->evaluate([['label'=>true,'score'=>1],['label'=>false,'score'=>1],['label'=>false,'score'=>0],['label'=>true,'score'=>0],['label'=>true]]); self::assertSame(0.5, $r['precision']); self::assertSame(0.5, $r['recall']); self::assertSame(0.8, $r['coverage']); }
    public function testWebhookTamperingAndExpiry(): void { $s = new WebhookSignature(); $key = str_repeat('k',32); $event = str_repeat('a',32); $sig = $s->sign('{}',1000,$event,$key); self::assertTrue($s->verify('{}',1000,$event,$sig,$key,1001)); self::assertFalse($s->verify('{"altered":true}',1000,$event,$sig,$key,1001)); self::assertFalse($s->verify('{}',1000,$event,$sig,$key,1400)); }
}
