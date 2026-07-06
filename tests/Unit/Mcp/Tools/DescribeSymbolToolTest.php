<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Reflection\FrameworkApi;
use QuioteMcpAssistant\Mcp\Tools\DescribeSymbolTool;

final class DescribeSymbolToolTest extends TestCase
{
    private DescribeSymbolTool $tool;

    protected function setUp(): void
    {
        $this->tool = new DescribeSymbolTool(new FrameworkApi());
    }

    #[Test]
    public function describesABareClass(): void
    {
        $result = $this->tool->describe('Quiote\Action\Action');

        self::assertArrayNotHasKey('error', $result);
        self::assertSame('Quiote\Action\Action', $result['fqcn']);
        self::assertArrayHasKey('methods', $result);
    }

    #[Test]
    public function describesOneMethodWhenGivenClassDoubleColonMethod(): void
    {
        $result = $this->tool->describe('Quiote\Action\Action::getDefaultViewName');

        self::assertArrayNotHasKey('error', $result);
        self::assertIsArray($result['method']);
        self::assertSame('getDefaultViewName', $result['method']['name']);
    }

    #[Test]
    public function rejectsASymbolOutsideTheFrameworkNamespace(): void
    {
        $result = $this->tool->describe('QuioteMcpAssistant\Mcp\AssistantPlugin');

        self::assertIsString($result['error']);
        self::assertStringContainsString('outside the Quiote', $result['error']);
    }

    #[Test]
    public function rejectsAnUnknownClass(): void
    {
        $result = $this->tool->describe('Quiote\NoSuchClassAtAll');

        self::assertIsString($result['error']);
        self::assertStringContainsString('Unknown class', $result['error']);
    }

    #[Test]
    public function rejectsAnUnknownMethodOnARealClass(): void
    {
        $result = $this->tool->describe('Quiote\Action\Action::noSuchMethodAtAll');

        self::assertIsString($result['error']);
        self::assertStringContainsString('has no method', $result['error']);
    }

    #[Test]
    public function tolerantOfALeadingBackslash(): void
    {
        $result = $this->tool->describe('\Quiote\Action\Action');

        self::assertArrayNotHasKey('error', $result);
    }
}
