<?php
declare(strict_types=1);
namespace ContentFirewall\Tests\Unit;
use ContentFirewall\Analytics\Evaluator;
use ContentFirewall\Configuration\Settings;
use ContentFirewall\Domain\{Action, Finding};
use ContentFirewall\Policy\{Condition, Engine, EvidenceCoverage, Presets, Schema};
use ContentFirewall\Privacy\TextInspector;
use PHPUnit\Framework\TestCase;

final class HardeningTest extends TestCase
{
    private function rejects(callable $operation): void
    {
        try { $operation(); self::fail('Malformed input was accepted'); } catch (\InvalidArgumentException $e) { self::assertNotSame('', $e->getMessage()); }
    }
    public function testSettingsRejectNullAndTypeConfusion(): void
    {
        foreach (array_keys(Settings::DEFAULTS) as $key) { $this->rejects(fn() => (new Settings())->parse([$key => null])); }
        foreach (['false', 0, [], 'true'] as $value) { $this->rejects(fn() => (new Settings())->parse(['require_malware' => $value])); }
        foreach ([0, -1, 1.5, '100', 104857601] as $value) { $this->rejects(fn() => (new Settings())->parse(['max_bytes' => $value])); }
    }
    public function testSettingsSupplyConsistentRuntimeDefaults(): void
    {
        self::assertSame(Settings::DEFAULTS, (new Settings())->parse([])); self::assertFalse((new Settings())->parse([])['publication_gate']);
        $this->rejects(fn() => (new Settings())->parse(['unknown' => true]));
        $this->rejects(fn() => (new Settings())->parse(['allowed_extensions' => ['php']]));
    }
    public function testPolicyRejectsUnknownAndNullOptions(): void
    {
        foreach (['consensus', 'requires_content', 'requires_text', 'metadata', 'failure_mode', 'qr_mode', 'region', 'patterns', 'domains'] as $option) {
            $p = (new Presets())->make('Custom')->toArray(); $p['options'][$option] = null; $this->rejects(fn() => (new Schema())->parse($p));
        }
        $p = (new Presets())->make('Custom')->toArray(); $p['options']['failure_mod'] = 'FAIL_OPEN'; $this->rejects(fn() => (new Schema())->parse($p));
    }
    public function testEveryScannerFieldRequiresEvidenceAndProcessing(): void
    {
        foreach (['drug.recreational', 'alcohol.presence', 'text.threat', 'custom.brand', 'c2pa.signature_valid'] as $field) {
            $p = (new Presets())->make('Custom')->toArray(); $p['rules'][] = ['id' => 'signal', 'action' => 'BLOCK', 'condition' => ['field' => $field, 'op' => 'gte', 'value' => 0.8]];
            $policy = (new Schema())->parse($p); self::assertTrue($policy->options['requires_content']); self::assertSame([$field], EvidenceCoverage::missing($policy, []));
            self::assertSame(Action::Review, (new Engine())->decide($policy, [], [])->action);
        }
    }
    public function testDisabledRulesDoNotRequestPaidScanning(): void
    {
        $p = (new Presets())->make('Custom')->toArray(); $p['rules'][] = ['id' => 'signal', 'enabled' => false, 'action' => 'BLOCK', 'condition' => ['field' => 'drug.recreational', 'op' => 'gte', 'value' => 0.8]];
        self::assertFalse((new Schema())->parse($p)->options['requires_content']);
    }
    public function testConsensusEnablesProcessing(): void
    {
        $p = (new Presets())->make('Custom')->toArray(); $p['options']['consensus'] = true; self::assertTrue((new Schema())->parse($p)->options['requires_content']);
    }
    public function testMissingHigherPriorityEvidenceCannotAllowByLaterRule(): void
    {
        $p = (new Presets())->make('Custom')->toArray();
        $p['rules'] = [['id' => 'first', 'priority' => 20, 'action' => 'BLOCK', 'condition' => ['field' => 'text.threat', 'op' => 'gte', 'value' => 0.8]], ['id' => 'last', 'priority' => 10, 'action' => 'ALLOW', 'condition' => ['field' => 'context', 'op' => 'eq', 'value' => 'media']]];
        self::assertSame(Action::Review, (new Engine())->decide((new Schema())->parse($p), ['context' => 'media'], [])->action);
    }
    public function testQrModesActuallyEnforce(): void
    {
        $p = (new Presets())->make('Custom'); $engine = new Engine();
        self::assertSame(Action::Review, $engine->decide($p, [], [new Finding('qr.contact', 1)])->action);
        self::assertSame(Action::Block, $engine->decide($p, [], [new Finding('qr.prohibited', 1)])->action);
    }
    public function testConditionRejectsAssociativeRangesAndHiddenChildren(): void
    {
        $this->rejects(fn() => new Condition(['field' => 'bytes', 'op' => 'between', 'value' => ['a' => 1, 'b' => 2]]));
        $this->rejects(fn() => new Condition(['field' => 'bytes', 'op' => 'exists', 'children' => [['field' => 'drug.recreational']]]));
        $this->rejects(fn() => new Condition(['field' => 'context', 'op' => 'in', 'value' => [['nested']]]));
    }
    public function testRegexResourceFailureRemainsUnknown(): void
    {
        $condition = new Condition(['field' => 'text', 'op' => 'regex', 'value' => '(a+)+$']);
        self::assertNull($condition->evaluateEvidence(['text' => str_repeat('a', 10000) . '!']));
        self::assertNull($condition->evaluateEvidence(['text' => str_repeat('a', 20000)]));
        $this->expectException(\RuntimeException::class); (new TextInspector())->inspect(str_repeat('a', 10000) . '!', ['custom.pattern' => '(a+)+$']);
    }
    public function testDlpIncludesMeasuredNegativeEvidence(): void
    {
        $findings = (new TextInspector())->inspect('Harmless text.', ['custom.brand' => 'ExampleBrand']);
        $scores = array_column(array_map(static fn(Finding $f): array => $f->jsonSerialize(), $findings), 'confidence', 'category');
        self::assertSame(0.0, $scores['pii.email']); self::assertSame(0.0, $scores['pii.credit_card']); self::assertSame(0.0, $scores['custom.brand']);
    }
    public function testTextRedactionRemovesValuesAndKeepsOriginal(): void
    {
        $source = 'Email test@example.org; card 4111 1111 1111 1111; ExampleBrand.';
        $redacted = (new TextInspector())->sanitize($source, ['custom.brand' => 'ExampleBrand']);
        self::assertStringNotContainsString('example.org', $redacted); self::assertStringNotContainsString('4111', $redacted); self::assertStringNotContainsString('ExampleBrand', $redacted); self::assertStringContainsString('example.org', $source);
    }
    public function testMalformedFindingCannotInventCleanConfidence(): void
    {
        foreach (['not-a-score', null, false, []] as $score) { $this->rejects(fn() => Finding::fromArray(['category' => 'sexual.explicit', 'confidence' => $score])); }
        $this->rejects(fn() => new Finding('sexual.explicit', 0.5, region: [0, 0, 1.2, 1]));
        $this->rejects(fn() => new Finding('sexual.explicit', 0.5, model: str_repeat('m', 121)));
    }
    public function testEvaluationRejectsNonfiniteDataAndThresholds(): void
    {
        foreach ([NAN, INF, -0.1, 1.1] as $threshold) { $this->rejects(fn() => (new Evaluator())->evaluate([], $threshold)); }
        $this->rejects(fn() => (new Evaluator())->evaluate([['label' => true, 'score' => NAN]]));
    }
}
