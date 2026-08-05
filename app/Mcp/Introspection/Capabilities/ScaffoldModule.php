<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;

/**
 * `scaffold_module(module)` -- a new module skeleton: one `Index` action
 * (read-only, `isSimple()`) plus its view and template, following the same
 * shape `quiote new` generates for the default module. The template is
 * authored by the target app's own "html" renderer via
 * {@see ScaffoldTemplateResolver} -- a renderer with no starter to offer is
 * reported back under `skipped_templates` instead of guessing at PHP syntax
 * that may not even be the app's configured engine.
 */
final class ScaffoldModule
{
    /** @return array<string, mixed> */
    public static function run(string $contextName, string $appDir, string $module, bool $dryRun): array
    {
        ScaffoldTemplates::assertValidName($module, 'module');

        $namespacePrefix = trim(Config::getString('core.namespace_prefix', 'App'), '\\');
        $moduleDir = rtrim(Config::getString('core.module_dir'), '/');

        $files = [
            [
                'path' => "{$moduleDir}/{$module}/Actions/IndexAction.php",
                'content' => ScaffoldTemplates::actionContent($namespacePrefix, $module, 'Index', ['read']),
            ],
            [
                'path' => "{$moduleDir}/{$module}/Views/IndexSuccessView.php",
                'content' => ScaffoldTemplates::viewContent($namespacePrefix, $module, 'Index', ['html']),
            ],
        ];

        $expectedPath = "{$moduleDir}/{$module}/Templates/IndexSuccess";
        $templateFile = ScaffoldTemplateResolver::fileFor($contextName, 'html', $expectedPath);

        $result = array_merge(
            ['module' => $module],
            ScaffoldWriter::apply($appDir, $templateFile !== null ? [...$files, $templateFile] : $files, $dryRun),
        );

        if ($templateFile === null) {
            $result['skipped_templates'] = [ScaffoldTemplateResolver::skippedEntryFor($contextName, 'html', $expectedPath)];
        }

        return $result;
    }
}
