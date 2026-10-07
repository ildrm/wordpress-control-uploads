<?php
declare(strict_types=1);
namespace ContentFirewall\Tests\Unit;
use ContentFirewall\Application\CaseAssignment;
use PHPUnit\Framework\TestCase;
final class CaseAssignmentTest extends TestCase
{
    public function testValidTeamDeadlineAndPriority(): void
    {
        $value = ['team' => 'Trust and Safety', 'priority' => 100, 'sla_at' => gmdate('Y-m-d H:i:s', time() + 3600)]; self::assertSame($value, CaseAssignment::parse($value));
    }
    public function testInvalidDateIsRejected(): void
    {
        $this->expectException(\InvalidArgumentException::class); CaseAssignment::parse(['sla_at' => '2027-02-31 00:00:00']);
    }
    public function testPastDeadlineIsRejected(): void
    {
        $this->expectException(\InvalidArgumentException::class); CaseAssignment::parse(['sla_at' => '2000-01-01 00:00:00']);
    }
    public function testTeamMarkupIsRejected(): void
    {
        $this->expectException(\InvalidArgumentException::class); CaseAssignment::parse(['team' => '<script>']);
    }
    public function testStringPriorityIsRejected(): void
    {
        $this->expectException(\InvalidArgumentException::class); CaseAssignment::parse(['priority' => '100']);
    }
    public function testUnknownAssignmentFieldIsRejected(): void
    {
        $this->expectException(\InvalidArgumentException::class); CaseAssignment::parse(['scan_id' => 1]);
    }
}
