<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use QuioteMcpAssistant\Mcp\Support\Cfg;

/** `list_modules` -- immediate subdirectories of `core.module_dir` (one per module, by convention). */
final class ListModules
{
    /** @return array{module_dir: string, modules: list<string>} */
    public static function run(): array
    {
        $moduleDir = Cfg::string('core.module_dir');
        if ($moduleDir === '' || !is_dir($moduleDir)) {
            return ['module_dir' => $moduleDir, 'modules' => []];
        }

        $modules = [];
        foreach (scandir($moduleDir) ?: [] as $entry) {
            if ($entry === '.' || $entry === '..' || !is_dir($moduleDir . '/' . $entry)) {
                continue;
            }
            $modules[] = $entry;
        }
        sort($modules);

        return ['module_dir' => $moduleDir, 'modules' => $modules];
    }
}
