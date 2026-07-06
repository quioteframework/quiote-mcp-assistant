<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Tools\GetConventionTool;

final class GetConventionToolTest extends TestCase
{
    private GetConventionTool $tool;

    protected function setUp(): void
    {
        $this->tool = new GetConventionTool();
    }

    #[Test]
    public function returnsARealCard(): void
    {
        $result = $this->tool->get('actions');

        self::assertSame('actions', $result['topic']);
        self::assertArrayHasKey('title', $result);
        self::assertArrayHasKey('body', $result);
    }

    #[Test]
    public function offersTheTopicListInsteadOfFailingOutrightForAnUnknownTopic(): void
    {
        $result = $this->tool->get('nonexistent-topic');

        self::assertArrayHasKey('error', $result);
        self::assertArrayHasKey('available_topics', $result);
        self::assertContains('actions', $result['available_topics']);
    }
}
