# PluginInterface

> A Quiote plugin: a self-contained bundle that contributes to the framework through the seams that already exist (config defaults, DI services, middleware, event listeners, routes/modules, output types, commands, HTTP clients) via a single PluginInterface::register() lifecycle call — this is the mechanism the framework's \"unopinionated core + opinionated drop-ins\" philosophy is built on.

A Quiote plugin: a self-contained bundle that contributes to the framework through the seams that already exist (config defaults, DI services, middleware, event listeners, routes/modules, output types, commands, HTTP clients) via a single [`PluginInterface::register()`](/api/plugin/plugin-interface/#register) lifecycle call — this is the mechanism the framework's "unopinionated core + opinionated drop-ins" philosophy is built on.

Plugins are registered either programmatically ([`PluginManager::add()`](/api/plugin/plugin-manager/#add) before bootstrap) or declaratively via the `plugins` config key (a list of plugin class-strings), and [`PluginInterface::register()`](/api/plugin/plugin-interface/#register) is invoked once during [`Quiote::bootstrap()`](/api/quiote/#bootstrap) — after settings load, before contexts are created — in deterministic order.

A diagnostics/logging name for the plugin comes from either [`Plugin`](/api/plugin/attribute/plugin/)'s `name` argument or, for a plugin whose name can't be a compile-time constant, from implementing [`NamedPlugin`](/api/plugin/named-plugin/) instead — see [`PluginManager`](/api/plugin/plugin-manager/) for how the two are resolved.

## Synopsis

`interface PluginInterface`

|  |  |
|---|---|
| Implemented by | [`CyclePlugin`](/api/database/adapter/cycle/cycle-plugin/), [`DoctrinePlugin`](/api/database/adapter/doctrine/doctrine-plugin/), [`EloquentPlugin`](/api/database/adapter/eloquent/eloquent-plugin/), [`PropulsionPlugin`](/api/database/adapter/propulsion/propulsion-plugin/), [`WhoopsPlugin`](/api/exception/rendering/whoops/whoops-plugin/), [`AzureFilesystemPlugin`](/api/filesystem/azure/azure-filesystem-plugin/), [`FilesystemPlugin`](/api/filesystem/filesystem-plugin/), [`GcsFilesystemPlugin`](/api/filesystem/gcs/gcs-filesystem-plugin/), [`S3FilesystemPlugin`](/api/filesystem/s3/s3-filesystem-plugin/), [`McpPlugin`](/api/mcp/mcp-plugin/), [`NamedPlugin`](/api/plugin/named-plugin/), [`QueueDbPlugin`](/api/queue/db/queue-db-plugin/), [`QueuePlugin`](/api/queue/queue-plugin/), [`QueueRedisPlugin`](/api/queue/redis/queue-redis-plugin/), [`ReplayCyclePlugin`](/api/replay/adapter/cycle/replay-cycle-plugin/), [`ReplayDoctrinePlugin`](/api/replay/adapter/doctrine/replay-doctrine-plugin/), [`ReplayEloquentPlugin`](/api/replay/adapter/eloquent/replay-eloquent-plugin/), [`ReplayPropulsionPlugin`](/api/replay/adapter/propulsion/replay-propulsion-plugin/), [`ReplayPlugin`](/api/replay/replay-plugin/), [`ReplayAzurePlugin`](/api/replay/store/azure/replay-azure-plugin/), [`ReplayPdoPlugin`](/api/replay/store/pdo/replay-pdo-plugin/), [`WorkerRoadRunnerPlugin`](/api/runtime/road-runner/worker-road-runner-plugin/), [`WorkerSwoolePlugin`](/api/runtime/swoole/worker-swoole-plugin/), [`SchedulerPlugin`](/api/scheduler/scheduler-plugin/), [`AuthPlugin`](/api/security/auth/auth-plugin/), [`JwtAuthPlugin`](/api/security/auth/jwt-auth-plugin/), [`CorsPlugin`](/api/security/cors/cors-plugin/), [`CsrfPlugin`](/api/security/csrf/csrf-plugin/), [`SecurityHeadersPlugin`](/api/security/headers/security-headers-plugin/), [`RateLimitPlugin`](/api/security/rate-limit/rate-limit-plugin/), [`TelemetryPlugin`](/api/telemetry/telemetry-plugin/) |
| Source | `Plugin/PluginInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Contribute to the framework. |

### register()

`abstract public function register(PluginRegistrar $registrar): void`

Contribute to the framework.

Called exactly once at boot. Every contribution routes through [`PluginRegistrar`](/api/plugin/plugin-registrar/) to an existing seam; a plugin does not touch framework internals directly.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
