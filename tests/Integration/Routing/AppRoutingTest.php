<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Routing;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Context;
use QuioteMcpAssistant\Routing\AppRouting;

final class AppRoutingTest extends TestCase
{
    #[Test]
    public function exportRoutesReturnsTheLiveCollectionAndMeta(): void
    {
        $routing = Context::getInstance('web')->getRouting();
        self::assertInstanceOf(AppRouting::class, $routing);

        [$routes, $meta] = $routing->exportRoutes();

        self::assertArrayHasKey('index', $meta);
        self::assertSame('/', $meta['index']['path']);
        // exportRoutes() must reflect the same collection real requests are
        // matched against, not a fresh/stale copy.
        self::assertSame($routing->getRouteCollection(), $routes);
    }
}
