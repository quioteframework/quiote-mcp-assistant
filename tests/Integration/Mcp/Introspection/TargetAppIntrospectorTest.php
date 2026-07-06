<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/**
 * `assistant.target_app_dir` is the one Config key this app touches that
 * *isn't* readonly-locked (unlike `core.app_dir`/`core.config_dir`), so
 * -- unlike those -- it can be pointed at a different target for the
 * duration of one test and reset afterwards. Self-targets this app's own
 * `app/`, the same pattern `tools/mcp-smoke-client.php` already relies on,
 * and drives a real `probe.php` subprocess -- not a mock.
 */
final class TargetAppIntrospectorTest extends TestCase
{
    private TargetAppIntrospector $introspector;

    protected function setUp(): void
    {
        $this->introspector = new TargetAppIntrospector();
        Config::remove('assistant.target_app_dir');
    }

    protected function tearDown(): void
    {
        Config::remove('assistant.target_app_dir');
    }

    #[Test]
    public function reportsAConfigurationErrorWhenNoTargetIsSet(): void
    {
        $result = $this->introspector->run('project_info');

        self::assertArrayHasKey('error', $result);
        self::assertIsString($result['error']);
        self::assertStringContainsString('No target app configured', $result['error']);
    }

    #[Test]
    public function reportsAConfigurationErrorWhenTheTargetDirDoesNotExist(): void
    {
        Config::set('assistant.target_app_dir', '/nonexistent/path/whatever');

        $result = $this->introspector->run('project_info');

        self::assertArrayHasKey('error', $result);
        self::assertIsString($result['error']);
        self::assertStringContainsString('does not exist', $result['error']);
    }

    #[Test]
    public function runsARealProbeSubprocessAgainstTheSelfTargetedApp(): void
    {
        Config::set('assistant.target_app_dir', dirname(__DIR__, 4) . '/app');

        $result = $this->introspector->run('project_info');

        self::assertArrayNotHasKey('error', $result);
        self::assertSame('QuioteMcpAssistant', $result['app_name']);
    }

    #[Test]
    public function passesExtraArgsThroughToTheProbeAsCliOptions(): void
    {
        Config::set('assistant.target_app_dir', dirname(__DIR__, 4) . '/app');

        $result = $this->introspector->run('routes', ['module' => 'Default', 'action' => 'Contact']);

        self::assertArrayNotHasKey('error', $result);
        self::assertSame(1, $result['count']);
    }
}
