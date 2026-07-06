<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;
use Quiote\Plugin\PluginManager;

/** `project_info` -- a one-call overview: env, default context, enabled plugins, module list. */
final class ProjectInfo
{
    /** @return array<string, mixed> */
    public static function run(string $contextName): array
    {
        return [
            '_source' => 'target-app-untrusted',
            'app_name' => Config::get('core.app_name'),
            'namespace_prefix' => Config::get('core.namespace_prefix'),
            'environment' => Config::get('core.environment'),
            'default_context' => $contextName,
            'use_database' => (bool) Config::get('core.use_database', false),
            'use_security' => (bool) Config::get('core.use_security', false),
            'plugins' => array_map(
                static fn (object $instance) => $instance->name(),
                array_values(PluginManager::registeredPlugins()),
            ),
            'modules' => ListModules::run()['modules'],
        ];
    }
}
