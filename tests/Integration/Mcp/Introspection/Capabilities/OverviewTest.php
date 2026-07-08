<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\Overview;

final class OverviewTest extends TestCase
{
    #[Test]
    public function compilesRoutesModulesTriadsAndDiagnosticsInOneCall(): void
    {
        $result = Overview::run('web');

        self::assertSame(1, $result['_schema_version']);
        self::assertNotEmpty($result['modules']);
        self::assertNotEmpty($result['routes']);
        self::assertNotEmpty($result['triads']);
        self::assertNotEmpty($result['dependencies']);

        // This app's own demo "Boom" action deliberately declares a view
        // that has no backing class/file -- a known, stable MISSING_VIEW
        // fixture to assert the diagnostic pipeline actually runs.
        $codes = array_column($result['diagnostics'], 'code');
        self::assertContains('MISSING_VIEW', $codes);
    }
}
