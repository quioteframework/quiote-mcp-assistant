<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Context;
use Quiote\Renderer\Phptal\PhptalRenderer;
use Quiote\Renderer\Renderer;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ScaffoldAction;
use ReflectionProperty;

/** See ScaffoldModuleTest's docblock for why this only ever previews. */
final class ScaffoldActionTest extends TestCase
{
    #[Test]
    public function previewsAnActionAndItsHtmlViewAndTemplate(): void
    {
        $result = ScaffoldAction::run(
            'web',
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
        self::assertArrayNotHasKey('skipped_templates', $result);
    }

    #[Test]
    public function reportsAMissingOutputTypeAsAReadyToPasteSnippetInsteadOfEditingTheFile(): void
    {
        // This app's own Config/output_types.xml only declares "html".
        $result = ScaffoldAction::run(
            'web',
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

    /**
     * Bug B: this app's "html" output type normally renders through the
     * native `Quiote\Renderer\PhpRenderer` (see Config/output_types.xml).
     * When it's configured with anything else -- PHPTAL, Twig, XSLT, ... --
     * this tool must not write a `.php` template the app's real template
     * resolution would never look at. Swaps the live Controller's cached
     * "html" renderer instance for a real `Quiote\Renderer\Phptal\PhptalRenderer`
     * (`quioteframework/phptal`, a require-dev dependency) to exercise that
     * path against the real, bootstrapped app rather than a guess -- the
     * fix only ever calls `Renderer::getDefaultExtension()`, so PHPTAL's
     * own template engine never actually needs to run.
     */
    #[Test]
    public function skipsTheTemplateWhenHtmlRendersThroughAnEngineThisToolCannotAuthor(): void
    {
        $controller = Context::getInstance('web')->getController();
        $outputTypesProp = new ReflectionProperty($controller, 'outputTypes');
        /** @var array<string, object> $outputTypes */
        $outputTypes = $outputTypesProp->getValue($controller);
        $htmlOutputType = $outputTypes['html'];

        $phptalRenderer = new PhptalRenderer();

        $rendererProp = new ReflectionProperty($htmlOutputType, 'renderers');
        /** @var array<string, array{instance: ?Renderer, parameters: array<string, mixed>}> $rendererConfig */
        $rendererConfig = $rendererProp->getValue($htmlOutputType);
        $restore = $rendererConfig;

        try {
            $rendererConfig['php']['instance'] = $phptalRenderer;
            $rendererProp->setValue($htmlOutputType, $rendererConfig);

            $result = ScaffoldAction::run(
                'web',
                '/irrelevant-app-dir',
                'Default',
                'PhpunitCapabilityPreview',
                verbs: ['read'],
                formats: ['html'],
                dryRun: true,
            );

            self::assertIsArray($result['files']);
            self::assertCount(2, $result['files']); // action + view, no template
            self::assertArrayHasKey('skipped_templates', $result);
            $skippedTemplates = $result['skipped_templates'];
            self::assertIsArray($skippedTemplates);
            self::assertArrayHasKey(0, $skippedTemplates);
            $skipped = $skippedTemplates[0];
            self::assertIsArray($skipped);
            self::assertSame('html', $skipped['format']);
            self::assertIsString($skipped['expected_file']);
            self::assertStringEndsWith('PhpunitCapabilityPreviewSuccess.tal', $skipped['expected_file']);
            self::assertIsString($skipped['reason']);
            self::assertStringContainsString('.tal', $skipped['reason']);
        } finally {
            $rendererProp->setValue($htmlOutputType, $restore);
        }
    }

    #[Test]
    public function rejectsAnInvalidVerb(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid verb(s)');

        ScaffoldAction::run('web', '/irrelevant-app-dir', 'Default', 'Post', verbs: ['delete'], formats: ['html'], dryRun: true);
    }

    #[Test]
    public function rejectsAnInvalidFormat(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid format');

        ScaffoldAction::run('web', '/irrelevant-app-dir', 'Default', 'Post', verbs: ['read'], formats: ['NotAFormat!'], dryRun: true);
    }

    #[Test]
    public function rejectsANonPascalCaseActionName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid action name');

        ScaffoldAction::run('web', '/irrelevant-app-dir', 'Default', 'not-pascal-case', verbs: ['read'], formats: ['html'], dryRun: true);
    }
}
