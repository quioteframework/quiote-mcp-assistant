<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Resources\DocLibrary;
use QuioteMcpAssistant\Mcp\Search\DocIndex;
use QuioteMcpAssistant\Mcp\Tools\SearchDocsTool;

final class SearchDocsToolTest extends TestCase
{
    private SearchDocsTool $tool;

    protected function setUp(): void
    {
        $this->tool = new SearchDocsTool(new DocIndex(new DocLibrary()));
    }

    #[Test]
    public function wrapsResultsWithTheQueryAndACount(): void
    {
        $result = $this->tool->search('routing');

        self::assertSame('routing', $result['query']);
        self::assertSame(count($result['results']), $result['count']);
        self::assertGreaterThan(0, $result['count']);
    }

    #[Test]
    public function reportsAZeroCountForAQueryWithNoMatches(): void
    {
        $result = $this->tool->search('xyznonexistentqueryterm');

        self::assertSame(0, $result['count']);
        self::assertSame([], $result['results']);
    }
}
