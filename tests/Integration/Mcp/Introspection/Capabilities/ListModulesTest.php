<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ListModules;

final class ListModulesTest extends TestCase
{
    #[Test]
    public function findsTheRealDefaultModule(): void
    {
        $result = ListModules::run();

        self::assertContains('Default', $result['modules']);
        self::assertStringEndsWith('Modules', $result['module_dir']);
    }

    #[Test]
    public function neverReturnsDotEntries(): void
    {
        $result = ListModules::run();

        self::assertNotContains('.', $result['modules']);
        self::assertNotContains('..', $result['modules']);
    }
}
