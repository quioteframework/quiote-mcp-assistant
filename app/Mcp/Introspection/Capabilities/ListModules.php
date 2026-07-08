<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;

/** `list_modules` -- immediate subdirectories of `core.module_dir` (one per module, by convention). */
final class ListModules
{
    /** @return array{_schema_version: int, module_dir: string, modules: list<string>} */
    public static function run(): array
    {
        $moduleDir = Config::getString('core.module_dir');
        if ($moduleDir === '' || !is_dir($moduleDir)) {
            return ['_schema_version' => 1, 'module_dir' => $moduleDir, 'modules' => []];
        }

        $modules = [];
        foreach (scandir($moduleDir) ?: [] as $entry) {
            if ($entry === '.' || $entry === '..' || !is_dir($moduleDir . '/' . $entry)) {
                continue;
            }
            $modules[] = $entry;
        }
        sort($modules);

        return ['_schema_version' => 1, 'module_dir' => $moduleDir, 'modules' => $modules];
    }
}
