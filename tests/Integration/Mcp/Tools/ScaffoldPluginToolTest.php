<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;
use QuioteMcpAssistant\Mcp\Tools\ScaffoldPluginTool;

/** See ScaffoldModuleToolTest's docblock for why this only ever previews. */
final class ScaffoldPluginToolTest extends TestCase
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
        $tool = new ScaffoldPluginTool(new TargetAppIntrospector());

        $result = $tool->scaffold('PhpunitPreviewOnly');

        self::assertTrue($result['dry_run']);
        self::assertIsArray($result['files']);
        $file = $result['files'][0];
        self::assertIsArray($file);
        self::assertSame('would_create', $file['status']);
        self::assertFileDoesNotExist(dirname(__DIR__, 4) . '/app/Plugin/PhpunitPreviewOnlyPlugin.php');
    }
}
