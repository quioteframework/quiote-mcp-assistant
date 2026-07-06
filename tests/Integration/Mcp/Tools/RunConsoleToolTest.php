<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\ConsoleRunner;
use QuioteMcpAssistant\Mcp\Tools\RunConsoleTool;

final class RunConsoleToolTest extends TestCase
{
    protected function setUp(): void
    {
        Config::set('assistant.target_app_dir', dirname(__DIR__, 4) . '/app');
    }

    protected function tearDown(): void
    {
        Config::remove('assistant.target_app_dir');
    }

    #[Test]
    public function refusesAnUnlistedCommandBeforeEverInvokingTheRunner(): void
    {
        $tool = new RunConsoleTool(new ConsoleRunner());

        $result = $tool->run('migrate');

        self::assertIsString($result['error']);
        self::assertStringContainsString('not a whitelisted command', $result['error']);
        self::assertArrayHasKey('allowed_commands', $result);
    }

    #[Test]
    public function runsARealWhitelistedCommand(): void
    {
        $tool = new RunConsoleTool(new ConsoleRunner());

        $result = $tool->run('about');

        self::assertSame('about', $result['command']);
        self::assertSame(0, $result['exit_code']);
    }
}
