<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Resources;

use Mcp\Exception\ResourceNotFoundException;

/**
 * The single MCP resource handler serving *every* bundled Quiote doc. Each doc
 * is registered as its own resource (distinct `quiote-docs://…` URI) by
 * {@see \QuioteMcpAssistant\Mcp\AssistantPlugin}, but they all point here: the
 * SDK passes the requested `uri` into the handler, so one method resolves the
 * right file from the manifest.
 *
 * Returning a string lets the SDK's `ResourceResultFormatter` wrap it as
 * `TextResourceContents` with the declared `text/markdown` MIME type.
 */
final class DocsResource
{
    public function __construct(private readonly DocLibrary $library) {}

    public function read(string $uri): string
    {
        $body = $this->library->body($uri);
        if ($body === null) {
            throw new ResourceNotFoundException($uri);
        }

        return $body;
    }
}
