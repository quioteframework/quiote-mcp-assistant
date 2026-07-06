<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ProjectInfo;

final class ProjectInfoTest extends TestCase
{
    #[Test]
    public function reportsTheRealBootstrappedAppsIdentity(): void
    {
        $info = ProjectInfo::run('web');

        self::assertSame('QuioteMcpAssistant', $info['app_name']);
        self::assertSame('web', $info['default_context']);
        self::assertSame('target-app-untrusted', $info['_source']);
    }

    #[Test]
    public function listsThePluginsActuallyRegisteredAtBootstrap(): void
    {
        $info = ProjectInfo::run('web');

        self::assertContains('quiote/assistant', $info['plugins']);
    }

    #[Test]
    public function listsTheRealModuleDirectory(): void
    {
        $info = ProjectInfo::run('web');

        self::assertContains('Default', $info['modules']);
    }
}
