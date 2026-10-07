<?php
declare(strict_types=1);
namespace ContentFirewall\Tests\Unit;
use ContentFirewall\Infrastructure\ProcessRunner;
use PHPUnit\Framework\TestCase;
final class ProcessRunnerTest extends TestCase
{
    public function testArgumentsAreLiteralAndSecretsAreNotInherited(): void
    {
        putenv('CF_PROCESS_TEST_SECRET=private-test-value');
        try { $literal = '$(echo unsafe); `id`'; $result = (new ProcessRunner())->run([PHP_BINARY, '-r', 'echo json_encode([$argv[1], getenv("CF_PROCESS_TEST_SECRET")]);', $literal], sys_get_temp_dir()); self::assertSame([$literal, false], json_decode($result['stdout'], true)); self::assertSame(0, $result['exit_code']); }
        finally { putenv('CF_PROCESS_TEST_SECRET'); }
    }
    public function testNonZeroExitIsPreserved(): void
    {
        self::assertSame(7, (new ProcessRunner())->run([PHP_BINARY, '-r', 'exit(7);'], sys_get_temp_dir())['exit_code']);
    }
    public function testTimeoutTerminatesChild(): void
    {
        $this->expectExceptionMessage('PROCESS.TIMEOUT'); (new ProcessRunner())->run([PHP_BINARY, '-r', 'usleep(500000);'], sys_get_temp_dir(), 30);
    }
    public function testOutputLimitTerminatesChild(): void
    {
        $this->expectExceptionMessage('PROCESS.OUTPUT_LIMIT'); (new ProcessRunner())->run([PHP_BINARY, '-r', 'echo str_repeat("x", 10000);'], sys_get_temp_dir(), 10000, 100);
    }
    public function testPathLookupIsRejected(): void
    {
        $this->expectExceptionMessage('CONFIGURATION.PROCESSOR'); (new ProcessRunner())->run(['php', '-r', 'exit(0);'], sys_get_temp_dir());
    }
}
