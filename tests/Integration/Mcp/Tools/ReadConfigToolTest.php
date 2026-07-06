<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;
use QuioteMcpAssistant\Mcp\Tools\ReadConfigTool;

final class ReadConfigToolTest extends TestCase
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
    public function omittingTheKeyReturnsTheAllowlist(): void
    {
        $tool = new ReadConfigTool(new TargetAppIntrospector());

        $result = $tool->read();

        self::assertIsArray($result['allowed_keys']);
        self::assertContains('core.app_name', $result['allowed_keys']);
    }

    #[Test]
    public function readsARealAllowlistedValue(): void
    {
        $tool = new ReadConfigTool(new TargetAppIntrospector());

        $result = $tool->read('core.app_name');

        self::assertSame('QuioteMcpAssistant', $result['value']);
    }

    #[Test]
    public function stillRefusesASecretKeyThroughTheFullToolChain(): void
    {
        $tool = new ReadConfigTool(new TargetAppIntrospector());

        $result = $tool->read('mcp.auth_token');

        self::assertIsString($result['error']);
        self::assertStringContainsString('Not a whitelisted key', $result['error']);
    }
}
