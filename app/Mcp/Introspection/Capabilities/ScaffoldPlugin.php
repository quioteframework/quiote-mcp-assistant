<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;

/**
 * `scaffold_plugin(name)` -- a new plugin class only. Never edits/creates the
 * target's `Config/plugins.*` to activate it -- that file (if PHP-format)
 * already exists in virtually every real app once it has one plugin, and
 * this tool never modifies existing files (see {@see ScaffoldWriter}). The
 * response's `next_step` tells the caller the one line to add by hand.
 *
 * The generated class carries `#[Plugin]` -- required as of
 * quioteframework/quiote's newer PluginManager: a class named via a
 * class-string activation source (`plugins.*` or `PluginManager::add()`
 * passed a string) is silently refused (logged, not thrown) unless it
 * deliberately opts in with this attribute. `PluginInterface` itself
 * declares no `name()` -- the attribute's `name` argument is what
 * `PluginManager::resolveName()` reads for diagnostics/logging, so the
 * generated class doesn't also define one (that would just be maintaining
 * the same string twice).
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

            use Quiote\\Plugin\\Attribute\\Plugin;
            use Quiote\\Plugin\\PluginInterface;
            use Quiote\\Plugin\\PluginRegistrar;

            #[Plugin(name: '{$slug}')]
            final class {$name}Plugin implements PluginInterface
            {
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
                'Add \\%s\\Plugin\\%sPlugin::class to Config/plugins.php\'s list (create it -- return [[\'class\' => \\%s\\Plugin\\%sPlugin::class]]; -- if this app has no plugins yet) to enable it.',
                $namespacePrefix,
                $name,
                $namespacePrefix,
                $name,
            ),
        ]);
    }
}
