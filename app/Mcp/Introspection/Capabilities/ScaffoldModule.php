<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;

/**
 * `scaffold_module(module)` -- a new module skeleton: one `Index` action
 * (read-only, `isSimple()`) plus its view and template, following the same
 * shape `quiote new` generates for the default module.
 */
final class ScaffoldModule
{
    /** @return array<string, mixed> */
    public static function run(string $appDir, string $module, bool $dryRun): array
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
            [
                'path' => "{$moduleDir}/{$module}/Templates/IndexSuccess.php",
                'content' => ScaffoldTemplates::templateContent('Index'),
            ],
        ];

        return array_merge(
            ['module' => $module],
            ScaffoldWriter::apply($appDir, $files, $dryRun),
        );
    }
}
