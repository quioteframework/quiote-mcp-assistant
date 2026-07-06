<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;
use QuioteMcpAssistant\Mcp\Tools\ScaffoldDbConnectionTool;

final class ScaffoldDbConnectionToolTest extends TestCase
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
    public function refusesToTouchThisAppsOwnExistingDatabasesXml(): void
    {
        // This app's own Config/databases.xml already exists, so this is
        // safe to call regardless of dry_run -- the never-edit-an-existing
        // file guarantee applies unconditionally, not just in preview mode.
        $tool = new ScaffoldDbConnectionTool(new TargetAppIntrospector());

        $result = $tool->scaffold('phpunittestconnection');

        self::assertSame('exists_manual_edit_required', $result['status']);
        self::assertArrayHasKey('snippet', $result);
    }
}
