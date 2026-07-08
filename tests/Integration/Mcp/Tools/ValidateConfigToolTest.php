<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;
use QuioteMcpAssistant\Mcp\Tools\ValidateConfigTool;

final class ValidateConfigToolTest extends TestCase
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
    public function theRealTargetAppConfigsValidateCleanThroughTheFullProbeSubprocess(): void
    {
        $tool = new ValidateConfigTool(new TargetAppIntrospector());

        $result = $tool->validate();

        self::assertSame(1, $result['_schema_version']);
        self::assertSame([], $result['diagnostics']);
    }

    #[Test]
    public function anUnknownKeyIsRefusedThroughTheFullToolChain(): void
    {
        $tool = new ValidateConfigTool(new TargetAppIntrospector());

        $result = $tool->validate('not_a_real_config');

        self::assertIsString($result['error']);
        self::assertStringContainsString('Unknown config key', $result['error']);
    }
}
