<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;
use QuioteMcpAssistant\Mcp\Tools\ListDbConnectionsTool;

final class ListDbConnectionsToolTest extends TestCase
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
    public function delegatesToTheListDbConnectionsCapabilityAndNeverLeaksValues(): void
    {
        $tool = new ListDbConnectionsTool(new TargetAppIntrospector());

        $result = $tool->list();

        self::assertTrue($result['found']);
        self::assertIsArray($result['databases']);
        self::assertArrayHasKey('default', $result['databases']);
        $default = $result['databases']['default'];
        self::assertIsArray($default);
        // Safety-critical: only parameter *names*, never values (DSNs/credentials).
        self::assertArrayHasKey('parameter_keys', $default);
        self::assertArrayNotHasKey('parameters', $default);
    }
}
