<?php
declare(strict_types=1);
namespace ContentFirewall\Tests\Unit;
use ContentFirewall\Domain\{Finding, Policy, ProviderResult};
use ContentFirewall\Policy\EvidenceCoverage;
use PHPUnit\Framework\TestCase;
final class ConsensusTest extends TestCase
{
    private function policy(): Policy { return new Policy('consensus', 1, 'Consensus', [], bands: ['sexual.explicit' => ['review' => 0.5, 'block' => 0.9]], options: ['consensus' => true]); }
    public function testDifferentModalitiesCannotProvideCategoryConsensus(): void
    {
        self::assertTrue(EvidenceCoverage::consensusIncomplete($this->policy(), [new ProviderResult('image', '1', [new Finding('sexual.explicit', 0)]), new ProviderResult('speech', '1', [], text: 'Harmless speech')]));
    }
    public function testTwoMeasuredCategoryResultsProvideConsensus(): void
    {
        self::assertFalse(EvidenceCoverage::consensusIncomplete($this->policy(), [new ProviderResult('first', '1', [new Finding('sexual.explicit', 0)]), new ProviderResult('second', '1', [new Finding('sexual.activity', 0)])]));
    }
    public function testRepeatedFramesAndLocalTextDoNotProvideIndependence(): void
    {
        $r = new ProviderResult('first', '1', [new Finding('sexual.explicit', 0)]);
        self::assertTrue(EvidenceCoverage::consensusIncomplete($this->policy(), [$r, $r, new ProviderResult('local-document', '1', [], text: 'Harmless words')]));
    }
    public function testMissingCategoryFromOneOfTwoProvidersStillRequiresReview(): void
    {
        $policy = new Policy('consensus', 1, 'Consensus', [], bands: ['sexual.explicit' => [], 'violence.graphic' => []], options: ['consensus' => true]);
        self::assertTrue(EvidenceCoverage::consensusIncomplete($policy, [new ProviderResult('first', '1', [new Finding('sexual.explicit', 0), new Finding('violence.graphic', 0)]), new ProviderResult('second', '1', [new Finding('sexual.explicit', 0)])]));
    }
}
