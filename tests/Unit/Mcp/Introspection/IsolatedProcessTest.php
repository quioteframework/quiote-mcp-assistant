<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Introspection;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\IsolatedProcess;

final class IsolatedProcessTest extends TestCase
{
    #[Test]
    public function runCapturesStdoutAndExitCodeOfARealCommand(): void
    {
        $result = IsolatedProcess::run(['php', '-r', 'echo "hello";']);

        self::assertSame('hello', $result['stdout']);
        self::assertSame(0, $result['exitCode']);
        self::assertFalse($result['timedOut']);
    }

    #[Test]
    public function runReportsANonZeroExitCode(): void
    {
        $result = IsolatedProcess::run(['php', '-r', 'exit(7);']);

        self::assertSame(7, $result['exitCode']);
    }

    #[Test]
    public function runTimesOutASlowCommand(): void
    {
        $result = IsolatedProcess::run(['php', '-r', 'sleep(5);'], timeoutSeconds: 0.2);

        self::assertTrue($result['timedOut']);
        self::assertSame(-1, $result['exitCode']);
    }

    #[Test]
    public function runReportsAnUnlaunchableCommandWithoutThrowing(): void
    {
        $result = IsolatedProcess::run(['/no/such/binary-' . uniqid()]);

        self::assertSame(-1, $result['exitCode']);
        self::assertStringContainsString('Could not launch process', $result['stderr']);
    }

    #[Test]
    public function scriptCommandBuildsAPlainPhpInvocationOutsideAPhar(): void
    {
        // \Phar::running(false) is '' in this test process (not running from
        // inside a .phar), so this always takes the plain-invocation branch;
        // the phar-wrapping branch is exercised for real by the release
        // workflow's built-PHAR smoke test instead (can't be entered from a
        // normal PHP process without actually running from inside a phar).
        $command = IsolatedProcess::scriptCommand('/path/to/probe.php', ['project_info']);

        self::assertSame(['php', '/path/to/probe.php', 'project_info'], $command);
    }
}
