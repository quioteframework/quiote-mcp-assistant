<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Search\DocIndex;

/**
 * `search_docs` -- ranked full-text search over the Quiote documentation.
 * Returns structured hits (uri + title + score + excerpt); each `uri` is a
 * real MCP resource the client can `resources/read` for the full doc, so the
 * agent can cite authoritative text.
 */
final class SearchDocsTool
{
    public function __construct(private readonly DocIndex $index) {}

    /**
     * @return array{query: string, count: int, results: list<array{uri: string, title: string, score: float, excerpt: string}>}
     */
    public function search(string $query, int $limit = 5): array
    {
        $results = $this->index->search($query, $limit);

        return [
            'query' => $query,
            'count' => count($results),
            'results' => $results,
        ];
    }
}
