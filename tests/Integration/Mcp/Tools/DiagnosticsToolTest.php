<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;
use QuioteMcpAssistant\Mcp\Tools\DiagnosticsTool;

final class DiagnosticsToolTest extends TestCase
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
    public function findsTheKnownMissingViewDiagnosticThroughTheFullProbeSubprocess(): void
    {
        $tool = new DiagnosticsTool(new TargetAppIntrospector());

        $result = $tool->diagnostics();

        self::assertSame(1, $result['_schema_version']);
        self::assertIsArray($result['diagnostics']);
        $codes = array_column($result['diagnostics'], 'code');
        self::assertContains('MISSING_VIEW', $codes);
    }
}
