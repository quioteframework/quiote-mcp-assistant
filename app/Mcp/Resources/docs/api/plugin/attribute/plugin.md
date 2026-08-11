# Plugin

> Marks a class as a sanctioned plugin entry point.

Marks a class as a sanctioned plugin entry point.

Required on every class activated through a class-string -- `plugins.{xml,php,yaml,yml}` or [`PluginManager::add()`](/api/plugin/plugin-manager/#add) passed a string -- so that naming a class there is not, by itself, enough to make it run: the class must also have deliberately opted in by carrying this attribute. This is a defense-in-depth measure, not the activation mechanism itself -- the attribute makes a [`PluginInterface`](/api/plugin/plugin-interface/) class eligible; an explicit `plugins.*` entry (or an `add()` call) is still what turns it on. A composer package can ship a class carrying this attribute and it still does nothing until an app deliberately names that class in its own `plugins.*` file or code -- installing the package alone can't activate it, and merely being autoloadable is not activation.

[`PluginManager::add()`](/api/plugin/plugin-manager/#add) passed an already-constructed `PluginInterface` instance (`new SomePlugin()`) skips this check -- that call site already is the trust boundary, since the caller's own code named the class directly rather than routing it through a string that could come from a config file.

## Synopsis

`final class Plugin`

|  |  |
|---|---|
| Source | `Plugin/Attribute/Plugin.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$name` | `?``string` |  |

## Constructor

### __construct()

`public function __construct(?string $name = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `?``string` |  |

Returns `mixed`
