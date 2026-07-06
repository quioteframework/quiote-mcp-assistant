<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ListDbConnections;

final class ListDbConnectionsTest extends TestCase
{
    #[Test]
    public function findsTheRealDefaultConnectionAndNeverLeaksValues(): void
    {
        $result = ListDbConnections::run();

        self::assertTrue($result['found']);
        self::assertSame('default', $result['default']);
        self::assertIsArray($result['databases']);
        self::assertArrayHasKey('default', $result['databases']);
        $default = $result['databases']['default'];
        self::assertIsArray($default);
        self::assertSame('Quiote\Database\PdoDatabase', $default['class']);
        // Safety-critical: only parameter *names*, never values (DSNs/credentials).
        self::assertSame(['dsn'], $default['parameter_keys']);
        self::assertArrayNotHasKey('parameters', $default);
    }
}
