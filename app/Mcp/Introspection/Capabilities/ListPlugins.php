<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Plugin\Attribute\Plugin;
use Quiote\Plugin\NamedPlugin;
use Quiote\Plugin\PluginManager;

/** `list_plugins` -- every plugin registered during the target app's bootstrap. */
final class ListPlugins
{
    /** @return array{_schema_version: int, count: int, plugins: list<array{class: string, name: string}>} */
    public static function run(): array
    {
        $plugins = [];
        foreach (PluginManager::registeredPlugins() as $class => $instance) {
            $plugins[] = ['class' => $class, 'name' => self::resolveName($instance)];
        }

        return ['_schema_version' => 1, 'count' => count($plugins), 'plugins' => $plugins];
    }

    /**
     * `PluginInterface` itself declares no `name()` -- a plugin's diagnostics
     * name comes from either implementing {@see NamedPlugin} or the
     * `#[Plugin]` attribute's `name` argument, mirroring (this app has no
     * access to) `PluginManager::resolveName()`'s own private resolution.
     * The null-name fallback below can't actually happen for anything in
     * registeredPlugins(): PluginManager::instantiate() already refuses to
     * register a class-string-activated plugin with no resolvable name, and
     * an already-constructed instance passed to add() is exempt from that
     * check but was still named by the caller's own code.
     */
    private static function resolveName(object $instance): string
    {
        if ($instance instanceof NamedPlugin) {
            return $instance->name();
        }

        $attributes = (new \ReflectionClass($instance))->getAttributes(Plugin::class);
        $name = $attributes === [] ? null : $attributes[0]->newInstance()->name;

        return $name ?? $instance::class;
    }
}
