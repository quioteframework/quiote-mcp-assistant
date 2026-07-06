<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;
use QuioteMcpAssistant\Mcp\Tools\ListRoutesTool;

final class ListRoutesToolTest extends TestCase
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
    public function listsEveryRouteWithNoFilter(): void
    {
        $tool = new ListRoutesTool(new TargetAppIntrospector());

        $result = $tool->list();

        self::assertIsArray($result['routes']);
        $names = array_column($result['routes'], 'name');
        self::assertContains('contact', $names);
    }

    #[Test]
    public function onlyBuildsFilterArgsThatWereActuallyPassed(): void
    {
        $tool = new ListRoutesTool(new TargetAppIntrospector());

        $result = $tool->list(module: 'Default', action: 'Contact');

        self::assertSame(1, $result['count']);
    }
}
