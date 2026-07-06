<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;
use QuioteMcpAssistant\Mcp\Tools\ListModulesTool;

final class ListModulesToolTest extends TestCase
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
    public function delegatesToTheListModulesCapability(): void
    {
        $tool = new ListModulesTool(new TargetAppIntrospector());

        $result = $tool->list();

        self::assertIsArray($result['modules']);
        self::assertContains('Default', $result['modules']);
    }
}
