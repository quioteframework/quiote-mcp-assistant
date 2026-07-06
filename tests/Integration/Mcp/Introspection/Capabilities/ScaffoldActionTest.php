<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ScaffoldAction;

/** See ScaffoldModuleTest's docblock for why this only ever previews. */
final class ScaffoldActionTest extends TestCase
{
    #[Test]
    public function previewsAnActionAndItsHtmlViewAndTemplate(): void
    {
        $result = ScaffoldAction::run(
            '/irrelevant-app-dir',
            'Default',
            'PhpunitCapabilityPreview',
            verbs: ['read', 'write'],
            formats: ['html'],
            dryRun: true,
        );

        self::assertSame(['read', 'write'], $result['verbs']);
        self::assertSame(['html'], $result['formats']);
        self::assertIsArray($result['files']);
        self::assertCount(3, $result['files']); // action + view + html template
        self::assertArrayNotHasKey('missing_output_types', $result);
    }

    #[Test]
    public function reportsAMissingOutputTypeAsAReadyToPasteSnippetInsteadOfEditingTheFile(): void
    {
        // This app's own Config/output_types.xml only declares "html".
        $result = ScaffoldAction::run(
            '/irrelevant-app-dir',
            'Default',
            'PhpunitCapabilityPreview',
            verbs: ['read'],
            formats: ['json'],
            dryRun: true,
        );

        self::assertArrayHasKey('missing_output_types', $result);
        self::assertIsArray($result['missing_output_types']);
        $missing = $result['missing_output_types'][0];
        self::assertIsArray($missing);
        self::assertSame('json', $missing['format']);
        self::assertSame('Config/output_types.xml', $missing['file']);
        // No html format requested -- no template file, just action + view.
        self::assertIsArray($result['files']);
        self::assertCount(2, $result['files']);
    }

    #[Test]
    public function rejectsAnInvalidVerb(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid verb(s)');

        ScaffoldAction::run('/irrelevant-app-dir', 'Default', 'Post', verbs: ['delete'], formats: ['html'], dryRun: true);
    }

    #[Test]
    public function rejectsAnInvalidFormat(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid format');

        ScaffoldAction::run('/irrelevant-app-dir', 'Default', 'Post', verbs: ['read'], formats: ['NotAFormat!'], dryRun: true);
    }

    #[Test]
    public function rejectsANonPascalCaseActionName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid action name');

        ScaffoldAction::run('/irrelevant-app-dir', 'Default', 'not-pascal-case', verbs: ['read'], formats: ['html'], dryRun: true);
    }
}
