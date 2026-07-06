<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;

/**
 * `scaffold_plugin(name)` -- a new plugin class only. Never edits the
 * target's `Config/settings.*` to add it to the `plugins` key -- that file
 * already exists in virtually every real app, and this tool never modifies
 * existing files (see {@see ScaffoldWriter}). The response's `next_step`
 * tells the caller the one line to add by hand.
 */
final class ScaffoldPlugin
{
    /** @return array<string, mixed> */
    public static function run(string $appDir, string $name, bool $dryRun): array
    {
        ScaffoldTemplates::assertValidName($name, 'plugin');

        $namespacePrefix = trim(Config::getString('core.namespace_prefix', 'App'), '\\');
        $slug = strtolower((string) preg_replace('/(?<!^)[A-Z]/', '-$0', $name));

        $content = <<<PHP
            <?php
            namespace {$namespacePrefix}\\Plugin;

            use Quiote\\Plugin\\PluginInterface;
            use Quiote\\Plugin\\PluginRegistrar;

            final class {$name}Plugin implements PluginInterface
            {
                public function name(): string
                {
                    return '{$slug}';
                }

                public function register(PluginRegistrar \$registrar): void
                {
                    // TODO: contribute config defaults, services, middleware, commands, etc.
                    // via \$registrar -- see quiote-docs://architecture/plugins.
                }
            }

            PHP;

        $path = rtrim(Config::getString('core.app_dir'), '/') . "/Plugin/{$name}Plugin.php";

        $result = ScaffoldWriter::apply($appDir, [['path' => $path, 'content' => $content]], $dryRun);

        return array_merge($result, [
            'plugin' => $name,
            'next_step' => sprintf(
                'Add \\%s\\Plugin\\%sPlugin::class to the "plugins" key in Config/settings.* to enable it.',
                $namespacePrefix,
                $name,
            ),
        ]);
    }
}
