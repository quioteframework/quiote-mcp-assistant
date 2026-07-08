<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\Diagnostics;

final class DiagnosticsTest extends TestCase
{
    #[Test]
    public function aggregatesRouteTriadAndConfigDiagnosticsIntoOneSharedShape(): void
    {
        $result = Diagnostics::run('web');

        self::assertSame(1, $result['_schema_version']);

        // The known MISSING_VIEW fixture (see OverviewTest) proves the
        // route/triad half made it through.
        $codes = array_column($result['diagnostics'], 'code');
        self::assertContains('MISSING_VIEW', $codes);

        // This app's own Config/ is clean (see ValidateConfigTest), so the
        // config half should contribute nothing beyond the route/triad
        // diagnostics Overview::run() already reports on its own.
        $overview = \QuioteMcpAssistant\Mcp\Introspection\Capabilities\Overview::run('web');
        self::assertSame($overview['diagnostics'], $result['diagnostics']);
    }
}
