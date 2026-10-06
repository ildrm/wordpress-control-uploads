<?php
declare(strict_types=1);
namespace ContentFirewall\Tests\Unit;
use ContentFirewall\Domain\{Action, Finding, State};
use ContentFirewall\Policy\{Condition, Engine, Presets, Schema};
use PHPUnit\Framework\TestCase;
final class PolicyTest extends TestCase
{
    public function testSecurityCannotBeShadowedOrTrusted(): void
    {
        $p = (new Presets())->make('Monitor Only'); $decision = (new Engine())->decide($p, ['trust' => 'trusted', 'roles' => ['administrator']], [new Finding('security.malware', 1, hardSecurity: true)]);
        self::assertSame(Action::Block, $decision->action); self::assertFalse($decision->shadow);
    }
    public function testNestedConditionsAndMissingEvidence(): void
    {
        $c = new Condition(['group' => 'AND', 'children' => [['field' => 'sexual.explicit', 'op' => 'gte', 'value' => 0.85], ['group' => 'NOT', 'children' => [['field' => 'context', 'op' => 'eq', 'value' => 'editorial']]]]]);
        self::assertTrue($c->evaluate(['sexual.explicit' => 0.85, 'context' => 'avatar'])); self::assertFalse($c->evaluate(['sexual.explicit' => 0.8499, 'context' => 'avatar'])); self::assertFalse($c->evaluate(['sexual.explicit' => 0.9, 'context' => 'editorial']));
        self::assertFalse((new Condition(['field' => 'missing', 'op' => 'ne', 'value' => 0]))->evaluate([]));
        self::assertFalse((new Condition(['group' => 'NOT', 'children' => [['field' => 'missing', 'op' => 'eq', 'value' => 1]]]))->evaluate([]));
    }
    public function testOrdinalEvidenceNeverAutomaticallyHardBlocks(): void
    {
        $data = (new Presets())->make('Community')->toArray(); $data['bands']['sexual.explicit']['calibrated'] = true; $data['bands']['sexual.explicit']['block'] = 0.9; $p = (new Schema())->parse($data);
        self::assertSame(Action::Review, (new Engine())->decide($p, [], [new Finding('sexual.explicit', 0.99, scale: 'ordinal')])->action);
        self::assertSame(Action::Block, (new Engine())->decide($p, [], [new Finding('sexual.explicit', 0.99)])->action);
    }
    public function testPriorityAndExplicitContext(): void
    {
        $p = (new Presets())->make('Custom')->toArray(); $p['rules'] = [['id' => 'editorial', 'priority' => 100, 'action' => 'ALLOW', 'condition' => ['field' => 'context', 'op' => 'eq', 'value' => 'editorial']], ['id' => 'violence', 'priority' => 10, 'action' => 'REVIEW', 'condition' => ['field' => 'violence.graphic', 'op' => 'gte', 'value' => 0.7]]];
        $engine = new Engine(); $policy = (new Schema())->parse($p); self::assertSame(['editorial'], $engine->decide($policy, ['context' => 'editorial'], [new Finding('violence.graphic', 0.99)])->rules); self::assertSame(Action::Review, $engine->decide($policy, ['context' => 'avatar'], [new Finding('violence.graphic', 0.99)])->action);
    }
    public function testDomainBoundaryAndRegexBudget(): void
    {
        self::assertTrue(Condition::domain('https://sub.example.org/a', 'example.org')); self::assertFalse(Condition::domain('https://example.org.attacker.test/', 'example.org'));
        $c = new Condition(['field' => 'text', 'op' => 'regex', 'value' => '(a+)+$']); $start = microtime(true); self::assertFalse($c->evaluate(['text' => str_repeat('a', 10000) . '!'])); self::assertLessThan(0.1, microtime(true) - $start);
    }
    public function testDuplicateRuleIdsRejected(): void
    {
        $p = (new Presets())->make('Custom')->toArray(); $rule = ['id' => 'same', 'action' => 'ALLOW', 'condition' => ['field' => 'context', 'op' => 'eq', 'value' => 'media']]; $p['rules'] = [$rule, $rule]; $this->expectException(\InvalidArgumentException::class); (new Schema())->parse($p);
    }
    public function testStateMachineCannotResurrectDeletedContent(): void { self::assertFalse(State::Deleted->canTransition(State::Allowed)); self::assertFalse(State::Received->canTransition(State::Allowed)); self::assertTrue(State::Pending->canTransition(State::Content)); self::assertTrue(State::Allowed->canTransition(State::Allowed)); }
    public function testFindingRequiresFiniteConfidence(): void { $this->expectException(\InvalidArgumentException::class); new Finding('sexual.explicit', NAN); }
    public function testSpecificFindingContributesToParentBand(): void { $p = (new Presets())->make('Community'); self::assertSame(Action::Review, (new Engine())->decide($p, [], [new Finding('sexual.activity', 0.9)])->action); }
    public function testUnknownProviderCategoryRequiresReview(): void { self::assertSame(Action::Review, (new Engine())->decide((new Presets())->make('Community'), [], [new Finding('provider.unknown', 0.95)])->action); }
    public function testCoverageDoesNotTreatMissingProviderCategoriesAsClean(): void
    {
        $p = (new Presets())->make('Community');
        $missing = \ContentFirewall\Policy\EvidenceCoverage::missing($p, [new Finding('sexual.activity', 0.0)]);
        self::assertNotContains('sexual.explicit', $missing); self::assertContains('hate.symbol', $missing);
    }
    public function testSchemaRejectsTruthyCalibrationStrings(): void
    {
        $p = (new Presets())->make('Community')->toArray(); $p['bands']['sexual.explicit']['calibrated'] = 'false';
        $this->expectException(\InvalidArgumentException::class); (new Schema())->parse($p);
    }
    public function testSchemaRejectsNonfiniteThresholds(): void
    {
        $p = (new Presets())->make('Community')->toArray(); $p['bands']['sexual.explicit']['review'] = NAN;
        $this->expectException(\InvalidArgumentException::class); (new Schema())->parse($p);
    }
    public function testSchemaRejectsInvalidFailureMode(): void
    {
        $p = (new Presets())->make('Custom')->toArray(); $p['options']['failure_mode'] = 'false';
        $this->expectException(\InvalidArgumentException::class); (new Schema())->parse($p);
    }
    public function testUnimplementedEffectsCannotBeSavedAsWorkingRules(): void
    {
        $p = (new Presets())->make('Custom')->toArray(); $p['rules'][] = ['id'=>'test','action'=>'BLOCK','condition'=>['field'=>'context','op'=>'exists'],'effects'=>['DISABLE_UPLOAD_PRIVILEGE']];
        $this->expectException(\InvalidArgumentException::class); (new Schema())->parse($p);
    }
    public function testComparisonRejectsNonNumericValues(): void
    {
        $this->expectException(\InvalidArgumentException::class); new Condition(['field'=>'bytes','op'=>'gte','value'=>'']);
    }
    public function testModeratorCanQuarantineReviewAndSanitizingStates(): void
    {
        self::assertTrue(State::Review->canTransition(State::Quarantined)); self::assertTrue(State::Sanitizing->canTransition(State::Quarantined));
    }
    public function testContentRulesCannotSilentlySkipProviderScanning(): void
    {
        $p = (new Presets())->make('Custom')->toArray(); $p['rules'][] = ['id'=>'content','action'=>'REVIEW','condition'=>['field'=>'sexual.explicit','op'=>'gte','value'=>0.5]];
        self::assertTrue((new Schema())->parse($p)->options['requires_content']);
    }
    public function testMissingEvidenceInRulesAlsoRequiresCoverage(): void
    {
        $p = (new Presets())->make('Custom')->toArray(); $p['rules'][] = ['id'=>'content','action'=>'REVIEW','condition'=>['field'=>'violence.graphic','op'=>'gte','value'=>0.5]];
        self::assertContains('violence.graphic', \ContentFirewall\Policy\EvidenceCoverage::missing((new Schema())->parse($p), [new Finding('sexual.explicit', 0.0)]));
    }
}
