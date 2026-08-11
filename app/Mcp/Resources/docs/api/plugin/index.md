# Plugin

> The Quiote\\Plugin namespace — 5 documented types.

Everything under `Quiote\Plugin`.

## Classes

| Class | Description |
|---|---|
| [`PluginManager`](/api/plugin/plugin-manager/) | Process-global registry + lifecycle for [`PluginInterface`](/api/plugin/plugin-interface/)s, mirroring the static, worker-lifetime pattern of [`MiddlewareCatalog`](/api/middleware/middleware-catalog/) and [`Events`](/api/event/events/): plugins are registered once and their contributions persist for the life of the process. |
| [`PluginRegistrar`](/api/plugin/plugin-registrar/) | The fluent contribution API handed to [`PluginInterface::register()`](/api/plugin/plugin-interface/#register). |

## Interfaces

| Interface | Description |
|---|---|
| [`NamedPlugin`](/api/plugin/named-plugin/) | Opt-in for a plugin whose diagnostics/logging name can't be a compile-time constant (e.g. |
| [`PluginInterface`](/api/plugin/plugin-interface/) | A Quiote plugin: a self-contained bundle that contributes to the framework through the seams that already exist (config defaults, DI services, middleware, event listeners, routes/modules, output types, commands, HTTP clients) via a single [`PluginInterface::register()`](/api/plugin/plugin-interface/#register) lifecycle call — this is the mechanism the framework's "unopinionated core + opinionated drop-ins" philosophy is built on. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Attribute`](/api/plugin/attribute/) | 1 type |
