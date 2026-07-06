<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;
use QuioteMcpAssistant\Mcp\Tools\ScaffoldActionTool;

/** See ScaffoldModuleToolTest's docblock for why this only ever previews. */
final class ScaffoldActionToolTest extends TestCase
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
    public function buildsCommaJoinedVerbsAndFormatsForThePreview(): void
    {
        $tool = new ScaffoldActionTool(new TargetAppIntrospector());

        $result = $tool->scaffold('Default', 'PhpunitPreviewOnly', verbs: ['read', 'write'], formats: ['html', 'json']);

        self::assertTrue($result['dry_run']);
        self::assertSame(['read', 'write'], $result['verbs']);
        self::assertSame(['html', 'json'], $result['formats']);
        self::assertFileDoesNotExist(dirname(__DIR__, 4) . '/app/Modules/Default/Actions/PhpunitPreviewOnlyAction.php');
    }
}
