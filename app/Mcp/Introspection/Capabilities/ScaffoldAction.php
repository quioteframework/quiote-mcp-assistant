<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use QuioteMcpAssistant\Mcp\Support\Cfg;

/**
 * `scaffold_action(module, action, verbs, formats)` -- one new action + its
 * view + template(s).
 *
 * `formats` (default `["html"]`) is one or more output type names the view
 * should serve -- see `quiote-docs://basics/output-types-and-content-negotiation`.
 * Each gets its own `execute<Format>()` method on the view; `html` also gets
 * a `Templates/{action}Success.php` template (every other format returns its
 * body directly, no template needed). A requested format not yet declared in
 * `Config/output_types.xml` is reported back as a ready-to-paste snippet --
 * this tool never edits that file, since it already exists in virtually
 * every real app (see {@see ScaffoldWriter}).
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
    public static function run(string $appDir, string $module, string $action, array $verbs, array $formats, bool $dryRun): array
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

        $namespacePrefix = trim(Cfg::string('core.namespace_prefix', 'App'), '\\');
        $moduleDir = rtrim(Cfg::string('core.module_dir'), '/');

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

        if (in_array('html', $formats, true)) {
            $files[] = [
                'path' => "{$moduleDir}/{$module}/Templates/{$action}Success.php",
                'content' => ScaffoldTemplates::templateContent($action),
            ];
        }

        $declared = ScaffoldOutputTypes::declared();
        $missingFormats = $declared === [] ? [] : array_values(array_diff($formats, $declared));

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

        return $result;
    }
}
