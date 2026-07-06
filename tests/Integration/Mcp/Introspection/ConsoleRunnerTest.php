<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\ConsoleRunner;

final class ConsoleRunnerTest extends TestCase
{
    private ConsoleRunner $runner;

    protected function setUp(): void
    {
        $this->runner = new ConsoleRunner();
        Config::remove('assistant.target_app_dir');
    }

    protected function tearDown(): void
    {
        Config::remove('assistant.target_app_dir');
    }

    #[Test]
    public function reportsAConfigurationErrorWhenNoTargetIsSet(): void
    {
        $result = $this->runner->run('about');

        self::assertIsString($result['error']);
        self::assertStringContainsString('No target app configured', $result['error']);
    }

    #[Test]
    public function reportsAConfigurationErrorWhenTheTargetDirDoesNotExist(): void
    {
        Config::set('assistant.target_app_dir', '/nonexistent/path/whatever');

        $result = $this->runner->run('about');

        self::assertIsString($result['error']);
        self::assertStringContainsString('does not exist', $result['error']);
    }

    #[Test]
    public function refusesACommandNotOnTheWhitelist(): void
    {
        Config::set('assistant.target_app_dir', dirname(__DIR__, 4) . '/app');

        $result = $this->runner->run('migrate');

        self::assertIsString($result['error']);
        self::assertStringContainsString('not a whitelisted command', $result['error']);
        self::assertArrayHasKey('allowed_commands', $result);
    }

    #[Test]
    public function refusesAnOptionNotAllowedForTheCommand(): void
    {
        Config::set('assistant.target_app_dir', dirname(__DIR__, 4) . '/app');

        $result = $this->runner->run('cache:warmup', ['env' => 'production']);

        self::assertIsString($result['error']);
        self::assertStringContainsString('Unsupported option(s)', $result['error']);
    }

    #[Test]
    public function runsARealWhitelistedCommandAgainstTheSelfTargetedApp(): void
    {
        Config::set('assistant.target_app_dir', dirname(__DIR__, 4) . '/app');

        $result = $this->runner->run('routes:list', ['json' => true]);

        self::assertArrayNotHasKey('error', $result);
        self::assertSame('routes:list', $result['command']);
        self::assertSame(0, $result['exit_code']);
        self::assertNotSame('', $result['output']);
    }
}
