<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ScaffoldOutputTypes;

final class ScaffoldOutputTypesTest extends TestCase
{
    #[Test]
    public function snippetUsesTheKnownContentTypeForAFormat(): void
    {
        $snippet = ScaffoldOutputTypes::snippet('json');

        self::assertStringContainsString('name="json"', $snippet);
        self::assertStringContainsString('application/json; charset=UTF-8', $snippet);
    }

    #[Test]
    public function snippetFallsBackToPlainTextForAnUnknownFormat(): void
    {
        $snippet = ScaffoldOutputTypes::snippet('pdf');

        self::assertStringContainsString('name="pdf"', $snippet);
        self::assertStringContainsString('text/plain; charset=UTF-8', $snippet);
    }

    #[Test]
    public function snippetIsWellFormedXmlOnceWrappedInARootElement(): void
    {
        $snippet = ScaffoldOutputTypes::snippet('json');

        $document = new \DOMDocument();
        $loaded = @$document->loadXML("<root>{$snippet}</root>");

        self::assertTrue($loaded, 'Generated snippet is not well-formed XML');
    }
}
