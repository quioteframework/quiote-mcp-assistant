<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Context;
use Quiote\Controller\Controller;
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
     * resolution would never look at, and it now doesn't have to guess at
     * that renderer's syntax either: `Renderer::getStarterTemplate()` lets
     * each renderer author its own minimal starter. Swaps the live
     * Controller's cached "html" renderer instance for a real
     * `Quiote\Renderer\Phptal\PhptalRenderer` (`quioteframework/phptal`, a
     * require-dev dependency) to exercise that path against the real,
     * bootstrapped app rather than a guess.
     */
    #[Test]
    public function writesThePhptalAuthoredTemplateWhenHtmlRendersThroughPhptal(): void
    {
        $result = self::withHtmlRenderer(new PhptalRenderer(), function () {
            return ScaffoldAction::run(
                'web',
                '/irrelevant-app-dir',
                'Default',
                'PhpunitCapabilityPreview',
                verbs: ['read'],
                formats: ['html'],
                dryRun: true,
            );
        });

        self::assertIsArray($result);
        self::assertIsArray($result['files']);
        self::assertCount(3, $result['files']); // action + view + .tal template
        self::assertArrayNotHasKey('skipped_templates', $result);
        $files = $result['files'];
        $template = $files[2];
        self::assertIsArray($template);
        self::assertIsString($template['path']);
        self::assertStringEndsWith('PhpunitCapabilityPreviewSuccess.tal', $template['path']);
        self::assertIsString($template['diff']);
        self::assertStringContainsString('tal:content', $template['diff']);
    }

    /**
     * A renderer with no starter to offer (the base `Renderer` class's
     * `getStarterTemplate()` default) must still be reported back via
     * `skipped_templates` rather than silently producing no template and no
     * explanation.
     */
    #[Test]
    public function skipsTheTemplateWhenTheRendererHasNoStarterToOffer(): void
    {
        $noStarterRenderer = new class extends Renderer {
            public function render($layer, array &$attributes = [], array &$slots = [], array &$moreAssigns = [])
            {
                return '';
            }
        };

        $result = self::withHtmlRenderer($noStarterRenderer, function () {
            return ScaffoldAction::run(
                'web',
                '/irrelevant-app-dir',
                'Default',
                'PhpunitCapabilityPreview',
                verbs: ['read'],
                formats: ['html'],
                dryRun: true,
            );
        });

        self::assertIsArray($result);
        self::assertIsArray($result['files']);
        self::assertCount(2, $result['files']); // action + view, no template
        self::assertArrayHasKey('skipped_templates', $result);
        $skippedTemplates = $result['skipped_templates'];
        self::assertIsArray($skippedTemplates);
        self::assertArrayHasKey(0, $skippedTemplates);
        $skipped = $skippedTemplates[0];
        self::assertIsArray($skipped);
        self::assertSame('html', $skipped['format']);
        self::assertIsString($skipped['reason']);
        self::assertStringContainsString('no starter template to offer', $skipped['reason']);
    }

    /**
     * Swaps this app's live "html" output type's cached renderer instance
     * for `$renderer` for the duration of `$callback`, then restores it --
     * lets tests exercise `ScaffoldTemplateResolver` against the real,
     * bootstrapped app without needing a second target app fixture per
     * renderer.
     */
    private static function withHtmlRenderer(Renderer $renderer, callable $callback): mixed
    {
        $controller = Context::getInstance('web')->getContainer()->get(Controller::class);
        $outputTypesProp = new ReflectionProperty($controller, 'outputTypes');
        /** @var array<string, object> $outputTypes */
        $outputTypes = $outputTypesProp->getValue($controller);
        $htmlOutputType = $outputTypes['html'];

        $rendererProp = new ReflectionProperty($htmlOutputType, 'renderers');
        /** @var array<string, array{instance: ?Renderer, parameters: array<string, mixed>}> $rendererConfig */
        $rendererConfig = $rendererProp->getValue($htmlOutputType);
        $restore = $rendererConfig;

        try {
            $rendererConfig['php']['instance'] = $renderer;
            $rendererProp->setValue($htmlOutputType, $rendererConfig);

            return $callback();
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
