<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Context;
use Quiote\Controller\Controller;
use Quiote\Renderer\Renderer;

/**
 * Resolves the live renderer a target app actually configures for a given
 * output type, and asks it -- via `Renderer::getStarterTemplate()` -- for a
 * minimal, engine-correct starter template, so `scaffold_action`/`scaffold_module`
 * never hardcode a specific renderer's syntax (previously: always PHP,
 * wrong for a PHPTAL/Twig/XSLT-configured app -- see git history). A
 * renderer that has no sensible starter to offer returns null from
 * `getStarterTemplate()` (the base `Renderer` class's default), in which
 * case the caller should report the expected file back to the caller
 * instead of writing it -- see {@see skippedEntryFor()}.
 */
final class ScaffoldTemplateResolver
{
    /**
     * @return array{path: string, content: string}|null a file entry ready
     *     for {@see ScaffoldWriter::apply()}, or null if the resolved
     *     renderer has no starter template to offer
     */
    public static function fileFor(string $contextName, string $format, string $expectedPathWithoutExtension): ?array
    {
        $renderer = self::rendererFor($contextName, $format);
        $starter = $renderer?->getStarterTemplate();
        if ($starter === null) {
            return null;
        }

        return [
            'path' => $expectedPathWithoutExtension . self::extensionFor($renderer),
            'content' => $starter,
        ];
    }

    /** @return array{format: string, expected_file: string, reason: string} */
    public static function skippedEntryFor(string $contextName, string $format, string $expectedPathWithoutExtension): array
    {
        $renderer = self::rendererFor($contextName, $format);
        $extension = self::extensionFor($renderer);

        return [
            'format' => $format,
            'expected_file' => $expectedPathWithoutExtension . $extension,
            'reason' => sprintf(
                'This app renders "%s" via %s, which has no starter template to offer -- create the template yourself with the "%s" extension.',
                $format,
                $renderer !== null ? $renderer::class : 'a renderer this tool could not resolve',
                $extension,
            ),
        ];
    }

    private static function extensionFor(?Renderer $renderer): string
    {
        return $renderer?->getDefaultExtension() ?: '.php';
    }

    /**
     * The renderer the target app's live output-type configuration actually
     * resolves for `$format`, or null if that can't be determined (format
     * not declared, no renderer configured, ...) -- resolved against the
     * real, already-bootstrapped target app, the same way
     * `TriadViewResolver::templateExtensionFor()` does, so this never
     * guesses at a renderer client-side.
     */
    private static function rendererFor(string $contextName, string $format): ?Renderer
    {
        try {
            return Context::getInstance($contextName)->getContainer()->get(Controller::class)->getOutputType($format)->getRenderer();
        } catch (\Throwable) {
            return null;
        }
    }
}
