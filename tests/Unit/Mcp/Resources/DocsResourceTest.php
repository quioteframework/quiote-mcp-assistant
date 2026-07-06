<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Resources;

use Mcp\Exception\ResourceNotFoundException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Resources\DocLibrary;
use QuioteMcpAssistant\Mcp\Resources\DocsResource;

final class DocsResourceTest extends TestCase
{
    private DocsResource $resource;

    protected function setUp(): void
    {
        $this->resource = new DocsResource(new DocLibrary());
    }

    #[Test]
    public function readsARealBundledDocsBody(): void
    {
        $body = $this->resource->read('quiote-docs://basics/routing');

        self::assertStringContainsString('#', $body);
    }

    #[Test]
    public function throwsResourceNotFoundForAnUnknownUri(): void
    {
        $this->expectException(ResourceNotFoundException::class);
        $this->expectExceptionMessage('quiote-docs://does/not/exist');

        $this->resource->read('quiote-docs://does/not/exist');
    }
}
