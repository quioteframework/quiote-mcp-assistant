<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ScaffoldPlugin;

/** See ScaffoldModuleTest's docblock for why this only ever previews. */
final class ScaffoldPluginTest extends TestCase
{
    #[Test]
    public function previewsThePluginClassAndNeverAutoRegistersIt(): void
    {
        $result = ScaffoldPlugin::run('/irrelevant-app-dir', 'PhpunitCapabilityPreview', dryRun: true);

        self::assertSame('PhpunitCapabilityPreview', $result['plugin']);
        self::assertTrue($result['dry_run']);
        self::assertIsArray($result['files']);
        self::assertCount(1, $result['files']);
        $file = $result['files'][0];
        self::assertIsArray($file);
        self::assertSame('would_create', $file['status']);
        self::assertIsString($result['next_step']);
        self::assertStringContainsString('PhpunitCapabilityPreviewPlugin::class', $result['next_step']);
        self::assertStringContainsString('Config/plugins.php', $result['next_step']);
        self::assertFileDoesNotExist(dirname(__DIR__, 5) . '/app/Plugin/PhpunitCapabilityPreviewPlugin.php');

        self::assertIsString($file['diff'] ?? null);
        self::assertStringContainsString('#[Plugin(', $file['diff']);
    }

    #[Test]
    public function rejectsANonPascalCasePluginName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid plugin name');

        ScaffoldPlugin::run('/irrelevant-app-dir', 'not-pascal-case', dryRun: true);
    }
}
