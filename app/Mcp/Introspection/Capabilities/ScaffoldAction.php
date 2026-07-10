<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;
use Quiote\Context;
use Quiote\Renderer\PhpRenderer;
use Quiote\Renderer\Renderer;

/**
 * `scaffold_action(module, action, verbs, formats)` -- one new action + its
 * view + template(s).
 *
 * `formats` (default `["html"]`) is one or more output type names the view
 * should serve -- see `quiote-docs://basics/output-types-and-content-negotiation`.
 * Each gets its own `execute<Format>()` method on the view; `html` also gets
 * a template -- but only when the target app actually renders `html` through
 * the native PHP renderer. This tool only knows how to author that engine's
 * syntax; for anything else (PHPTAL, Twig, XSLT, ...) writing a `.php` file
 * would create a file the app's real template resolution never looks at (it
 * resolves the renderer's own extension, e.g. `.tal`), so the template is
 * skipped and reported back under `skipped_templates` with the extension the
 * caller needs to author by hand instead. A requested format not yet
 * declared in `Config/output_types.xml` is reported back as a ready-to-paste
 * snippet -- this tool never edits that file, since it already exists in
 * virtually every real app (see {@see ScaffoldWriter}).
 */
final class ScaffoldAction
{
    private const VALID_VERBS = ['read', 'write', 'update', 'remove'];
    private const VALID_FORMAT = '/^[a-z][a-z0-9_]*$/';

    /**
     * @param list<string> $verbs
     * @param list<string> $formats
     * @return array<string, mixed>
     */
    public static function run(string $contextName, string $appDir, string $module, string $action, array $verbs, array $formats, bool $dryRun): array
    {
        ScaffoldTemplates::assertValidName($module, 'module');
        ScaffoldTemplates::assertValidName($action, 'action');

        $verbs = array_values(array_unique(array_map('strtolower', $verbs))) ?: ['read'];
        $invalid = array_diff($verbs, self::VALID_VERBS);
        if ($invalid !== []) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid verb(s): %s. Expected one or more of: %s.',
                implode(', ', $invalid),
                implode(', ', self::VALID_VERBS),
            ));
        }

        $formats = array_values(array_unique(array_map('strtolower', $formats))) ?: ['html'];
        foreach ($formats as $format) {
            if (!preg_match(self::VALID_FORMAT, $format)) {
                throw new \InvalidArgumentException(sprintf(
                    'Invalid format "%s": expected a lowercase output type name, e.g. "html" or "json" (matching %s).',
                    $format,
                    self::VALID_FORMAT,
                ));
            }
        }

        $namespacePrefix = trim(Config::getString('core.namespace_prefix', 'App'), '\\');
        $moduleDir = rtrim(Config::getString('core.module_dir'), '/');

        $files = [
            [
                'path' => "{$moduleDir}/{$module}/Actions/{$action}Action.php",
                'content' => ScaffoldTemplates::actionContent($namespacePrefix, $module, $action, $verbs),
            ],
            [
                'path' => "{$moduleDir}/{$module}/Views/{$action}SuccessView.php",
                'content' => ScaffoldTemplates::viewContent($namespacePrefix, $module, $action, $formats),
            ],
        ];

        $declared = ScaffoldOutputTypes::declared();
        $missingFormats = $declared === [] ? [] : array_values(array_diff($formats, $declared));

        $skippedTemplates = [];
        if (in_array('html', $formats, true) && !in_array('html', $missingFormats, true)) {
            $renderer = self::rendererFor($contextName, 'html');
            if ($renderer instanceof PhpRenderer) {
                $files[] = [
                    'path' => "{$moduleDir}/{$module}/Templates/{$action}Success.php",
                    'content' => ScaffoldTemplates::templateContent($action),
                ];
            } else {
                $extension = $renderer?->getDefaultExtension() ?: '.php';
                $skippedTemplates[] = [
                    'format' => 'html',
                    'expected_file' => "{$moduleDir}/{$module}/Templates/{$action}Success{$extension}",
                    'reason' => sprintf(
                        'This app renders "html" via %s, which this tool does not know how to author -- create the template yourself with the "%s" extension.',
                        $renderer !== null ? $renderer::class : 'a renderer this tool could not resolve',
                        $extension,
                    ),
                ];
            }
        }

        $result = array_merge(
            ['module' => $module, 'action' => $action, 'verbs' => $verbs, 'formats' => $formats],
            ScaffoldWriter::apply($appDir, $files, $dryRun),
        );

        if ($missingFormats !== []) {
            $result['missing_output_types'] = array_map(
                static fn (string $format) => [
                    'format' => $format,
                    'file' => 'Config/output_types.xml',
                    'snippet' => ScaffoldOutputTypes::snippet($format),
                ],
                $missingFormats,
            );
            $result['next_step'] = 'Paste the missing_output_types snippet(s) inside the existing <output_types> '
                . 'element in Config/output_types.xml -- this tool never edits an existing file.';
        }

        if ($skippedTemplates !== []) {
            $result['skipped_templates'] = $skippedTemplates;
        }

        return $result;
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
            return Context::getInstance($contextName)->getController()->getOutputType($format)->getRenderer();
        } catch (\Throwable) {
            return null;
        }
    }
}
