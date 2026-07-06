<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;
use QuioteMcpAssistant\Mcp\Tools\DescribeActionTool;

final class DescribeActionToolTest extends TestCase
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
    public function splitsModuleDotActionAndDelegates(): void
    {
        $tool = new DescribeActionTool(new TargetAppIntrospector());

        $result = $tool->describe('Default.Contact');

        self::assertSame('QuioteMcpAssistant\Modules\Default\Actions\ContactAction', $result['class']);
    }

    #[Test]
    public function rejectsAnActionArgumentWithNoDot(): void
    {
        $tool = new DescribeActionTool(new TargetAppIntrospector());

        $result = $tool->describe('JustAnAction');

        self::assertIsString($result['error']);
        self::assertStringContainsString('Expected "Module.Action"', $result['error']);
    }
}
