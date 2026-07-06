<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;
use QuioteMcpAssistant\Mcp\Tools\ListPluginsTool;

final class ListPluginsToolTest extends TestCase
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
    public function delegatesToTheListPluginsCapability(): void
    {
        $tool = new ListPluginsTool(new TargetAppIntrospector());

        $result = $tool->list();

        self::assertIsArray($result['plugins']);
        $names = array_column($result['plugins'], 'name');
        self::assertContains('quiote/assistant', $names);
    }
}
