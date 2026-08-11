# NamedPlugin

> Opt-in for a plugin whose diagnostics/logging name can't be a compile-time constant (e.g.

Opt-in for a plugin whose diagnostics/logging name can't be a compile-time constant (e.g.

it's computed from config, an environment value, or an instance the plugin was constructed with). Most plugins don't need this — naming the plugin via [`Plugin`](/api/plugin/attribute/plugin/)'s `name` argument is enough. [`PluginManager`](/api/plugin/plugin-manager/) prefers this interface's [`NamedPlugin::name()`](/api/plugin/named-plugin/#name) over the attribute's name when a plugin implements both.

## Synopsis

`interface NamedPlugin extends PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `Plugin/NamedPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`name(): string`](#name) | A stable, human-readable identifier for diagnostics/logging. |

### name()

`abstract public function name(): string`

A stable, human-readable identifier for diagnostics/logging.

Returns `string`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `register()` | [`PluginInterface`](/api/plugin/plugin-interface/) | Contribute to the framework. |
