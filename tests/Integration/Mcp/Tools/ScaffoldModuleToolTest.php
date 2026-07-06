<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;
use QuioteMcpAssistant\Mcp\Tools\ScaffoldModuleTool;

/**
 * Deliberately never passes dry_run: false here -- self-targeting this
 * app's own app/Modules with a *real* write would pollute this repo's own
 * source. Real-write behavior is covered by tools/mcp-smoke-client-scaffold.php
 * against a disposable scratch app instead. This only verifies the tool
 * correctly builds the probe request and returns its dry-run preview.
 */
final class ScaffoldModuleToolTest extends TestCase
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
    public function dryRunDefaultsTrueAndPreviewsWithoutWriting(): void
    {
        $tool = new ScaffoldModuleTool(new TargetAppIntrospector());

        $result = $tool->scaffold('PhpunitScaffoldPreviewOnly');

        self::assertTrue($result['dry_run']);
        self::assertIsArray($result['files']);
        $file = $result['files'][0];
        self::assertIsArray($file);
        self::assertSame('would_create', $file['status']);
        self::assertFileDoesNotExist(dirname(__DIR__, 4) . '/app/Modules/PhpunitScaffoldPreviewOnly');
    }
}
