<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Tools\GetRecipeTool;

final class GetRecipeToolTest extends TestCase
{
    private GetRecipeTool $tool;

    protected function setUp(): void
    {
        $this->tool = new GetRecipeTool();
    }

    #[Test]
    public function returnsARealRecipe(): void
    {
        $result = $this->tool->get('add-plugin');

        self::assertSame('add-plugin', $result['task']);
        self::assertArrayHasKey('title', $result);
        self::assertNotEmpty($result['steps'] ?? []);
    }

    #[Test]
    public function offersTheTaskListInsteadOfFailingOutrightForAnUnknownTask(): void
    {
        $result = $this->tool->get('nonexistent-task');

        self::assertArrayHasKey('error', $result);
        self::assertContains('add-plugin', $result['available_tasks'] ?? []);
    }
}
