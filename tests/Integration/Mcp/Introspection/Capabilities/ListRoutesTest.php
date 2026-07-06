<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ListRoutes;

/**
 * Integration, not unit: runs against this app's own live, bootstrapped
 * RouteCollection (tests/bootstrap.php bootstraps this app the same way
 * bin/quiote-assistant does), the same self-target dogfooding
 * tools/mcp-smoke-client.php already relies on -- not a fake Routing.
 */
final class ListRoutesTest extends TestCase
{
    #[Test]
    public function listsEveryRouteWithNoFilter(): void
    {
        $result = ListRoutes::run('web');

        self::assertNull($result['module_filter']);
        self::assertNull($result['action_filter']);
        $names = array_column($result['routes'], 'name');
        // index/about/boom are declared programmatically in AppRouting;
        // contact is #[Route]-attributed -- both styles must show up.
        self::assertContains('index', $names);
        self::assertContains('about', $names);
        self::assertContains('boom', $names);
        self::assertContains('contact', $names);
        self::assertSame(count($result['routes']), $result['count']);
    }

    #[Test]
    public function filtersByModuleCaseInsensitively(): void
    {
        $result = ListRoutes::run('web', module: 'default');

        self::assertNotEmpty($result['routes']);
        foreach ($result['routes'] as $route) {
            self::assertSame('Default', $route['defaults']['_module']);
        }
    }

    #[Test]
    public function filtersByModuleAndActionTogether(): void
    {
        $result = ListRoutes::run('web', module: 'Default', action: 'Contact');

        self::assertSame(1, $result['count']);
        self::assertSame('Contact', $result['routes'][0]['defaults']['_action']);
    }

    #[Test]
    public function returnsNoRoutesForAModuleThatDoesNotExist(): void
    {
        $result = ListRoutes::run('web', module: 'NonexistentModule');

        self::assertSame(0, $result['count']);
        self::assertSame([], $result['routes']);
    }

    #[Test]
    public function everyRouteReportsItsMethodsAndPath(): void
    {
        $result = ListRoutes::run('web', module: 'Default', action: 'Contact');

        self::assertNotEmpty($result['routes'][0]['path']);
        self::assertNotEmpty($result['routes'][0]['methods']);
    }
}
