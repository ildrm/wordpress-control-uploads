<?php
declare(strict_types=1);
namespace ContentFirewall\Tests\Unit;
use ContentFirewall\Configuration\Settings;
use PHPUnit\Framework\TestCase;
final class SettingsTest extends TestCase
{
    public function testPartialRetentionMergesDefaults(): void
    {
        $value = (new Settings())->parse(['retention' => ['audit_days' => 90]]);
        self::assertSame(90, $value['retention']['audit_days']); self::assertSame(7, $value['retention']['private_files_days']); self::assertTrue($value['privacy_retain_audit']);
    }
    public function testUnknownRetentionClassIsRejected(): void
    {
        $this->expectException(\InvalidArgumentException::class); (new Settings())->parse(['retention' => ['raw_provider' => 1]]);
    }
    public function testUnboundedRetentionIsRejected(): void
    {
        $this->expectException(\InvalidArgumentException::class); (new Settings())->parse(['retention' => ['audit_days' => 99999]]);
    }
    public function testRetentionNullCannotDisableValidation(): void
    {
        $this->expectException(\InvalidArgumentException::class); (new Settings())->parse(['retention' => null]);
    }
}
