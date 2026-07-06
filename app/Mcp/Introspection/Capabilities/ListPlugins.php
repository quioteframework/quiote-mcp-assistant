<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Plugin\PluginManager;

/** `list_plugins` -- every plugin registered during the target app's bootstrap. */
final class ListPlugins
{
    /** @return array{count: int, plugins: list<array{class: string, name: string}>} */
    public static function run(): array
    {
        $plugins = [];
        foreach (PluginManager::registeredPlugins() as $class => $instance) {
            $plugins[] = ['class' => $class, 'name' => $instance->name()];
        }

        return ['count' => count($plugins), 'plugins' => $plugins];
    }
}
