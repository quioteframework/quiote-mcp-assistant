<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;
use QuioteMcpAssistant\Mcp\Tools\OverviewTool;

final class OverviewToolTest extends TestCase
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
    public function compilesTheRealTargetAppThroughTheFullProbeSubprocess(): void
    {
        $tool = new OverviewTool(new TargetAppIntrospector());

        $result = $tool->overview();

        self::assertSame(1, $result['_schema_version']);
        self::assertNotEmpty($result['routes']);
        self::assertNotEmpty($result['modules']);
    }
}
