<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Reflection\FrameworkApi;
use QuioteMcpAssistant\Mcp\Tools\ListApiTool;

final class ListApiToolTest extends TestCase
{
    private ListApiTool $tool;

    protected function setUp(): void
    {
        $this->tool = new ListApiTool(new FrameworkApi());
    }

    #[Test]
    public function withNoNamespaceListsTopLevelNamespaces(): void
    {
        $result = $this->tool->list();

        self::assertNull($result['namespace']);
        self::assertIsArray($result['namespaces']);
        self::assertArrayHasKey('Quiote\Action', $result['namespaces']);
        self::assertArrayHasKey('hint', $result);
    }

    #[Test]
    public function withANamespaceListsSummarizedClasses(): void
    {
        $result = $this->tool->list('Quiote\Action');

        self::assertSame('Quiote\Action', $result['namespace']);
        self::assertGreaterThan(0, $result['count']);
        self::assertFalse($result['truncated']);
        self::assertIsArray($result['classes']);
        foreach ($result['classes'] as $class) {
            self::assertIsArray($class);
            self::assertArrayHasKey('fqcn', $class);
        }
    }

    #[Test]
    public function rejectsANamespaceOutsideTheFramework(): void
    {
        $result = $this->tool->list('Symfony\Component\Routing');

        self::assertIsString($result['error']);
        self::assertStringContainsString('outside the Quiote', $result['error']);
    }

    #[Test]
    public function clampsTheLimitToTheConfiguredMaximum(): void
    {
        $result = $this->tool->list('Quiote', 100_000);

        self::assertLessThanOrEqual(200, $result['count']);
    }

    #[Test]
    public function reportsTruncationWhenMoreClassesExistThanTheLimit(): void
    {
        $result = $this->tool->list('Quiote', 1);

        self::assertTrue($result['truncated']);
        self::assertLessThanOrEqual(1, $result['count']);
    }
}
