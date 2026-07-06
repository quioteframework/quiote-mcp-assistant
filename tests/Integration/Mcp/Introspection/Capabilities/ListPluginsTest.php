<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ListPlugins;

final class ListPluginsTest extends TestCase
{
    #[Test]
    public function listsThisAppsOwnRegisteredPlugins(): void
    {
        $result = ListPlugins::run();

        self::assertSame(count($result['plugins']), $result['count']);
        $names = array_column($result['plugins'], 'name');
        self::assertContains('quiote/assistant', $names);
    }

    #[Test]
    public function everyPluginReportsItsClassAndName(): void
    {
        $result = ListPlugins::run();

        self::assertNotEmpty($result['plugins']);
        foreach ($result['plugins'] as $plugin) {
            self::assertTrue(class_exists($plugin['class']), "{$plugin['class']} should be a real, loadable class.");
            self::assertNotSame('', $plugin['name']);
        }
    }
}
