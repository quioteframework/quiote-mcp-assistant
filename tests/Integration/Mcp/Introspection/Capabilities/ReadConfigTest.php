<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ReadConfig;

final class ReadConfigTest extends TestCase
{
    #[Test]
    public function omittingTheKeyReturnsTheAllowlistItself(): void
    {
        $result = ReadConfig::run('');

        self::assertContains('core.app_name', $result['allowed_keys'] ?? []);
    }

    #[Test]
    public function returnsTheRealValueForAnAllowlistedKey(): void
    {
        $result = ReadConfig::run('core.app_name');

        self::assertSame('core.app_name', $result['key'] ?? null);
        self::assertSame('QuioteMcpAssistant', $result['value'] ?? null);
        self::assertArrayNotHasKey('error', $result);
    }

    #[Test]
    public function refusesASecretKeyEvenThoughItLooksLikeAConfigKey(): void
    {
        // The one security-critical failure path: this must never leak
        // mcp.auth_token, regardless of whether it happens to be set.
        $result = ReadConfig::run('mcp.auth_token');

        self::assertSame('Not a whitelisted key.', $result['error'] ?? null);
        self::assertArrayNotHasKey('value', $result);
    }

    #[Test]
    public function refusesAnArbitraryUnknownKey(): void
    {
        $result = ReadConfig::run('some.made.up.key');

        self::assertSame('Not a whitelisted key.', $result['error'] ?? null);
        self::assertArrayNotHasKey('value', $result);
    }

    #[Test]
    public function refusalStillIncludesTheAllowlistForDiscoverability(): void
    {
        $result = ReadConfig::run('mcp.auth_token');

        self::assertNotEmpty($result['allowed_keys'] ?? []);
    }
}
