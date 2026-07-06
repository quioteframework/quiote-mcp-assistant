<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Resources;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Resources\DocLibrary;

final class DocLibraryTest extends TestCase
{
    private DocLibrary $library;

    protected function setUp(): void
    {
        $this->library = new DocLibrary();
    }

    #[Test]
    public function hasReturnsTrueForARealBundledDoc(): void
    {
        self::assertTrue($this->library->has('quiote-docs://basics/routing'));
    }

    #[Test]
    public function hasReturnsFalseForAnUnknownUri(): void
    {
        self::assertFalse($this->library->has('quiote-docs://does/not/exist'));
    }

    #[Test]
    public function bodyReturnsTheMarkdownForARealDoc(): void
    {
        $body = $this->library->body('quiote-docs://basics/routing');

        self::assertNotNull($body);
        self::assertStringContainsString('#', $body);
    }

    #[Test]
    public function bodyReturnsNullForAnUnknownUri(): void
    {
        self::assertNull($this->library->body('quiote-docs://does/not/exist'));
    }

    #[Test]
    public function manifestIsNonEmptyAndEveryEntryHasAReadableBody(): void
    {
        $manifest = $this->library->manifest();
        self::assertNotEmpty($manifest);

        foreach (array_keys($manifest) as $uri) {
            self::assertNotNull($this->library->body($uri), "Manifest entry \"{$uri}\" has no readable body file.");
        }
    }
}
