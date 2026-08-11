# PluginManager

> Process-global registry + lifecycle for PluginInterfaces, mirroring the static, worker-lifetime pattern of MiddlewareCatalog and Events: plugins are registered once and their contributions persist for the life of the process.

Process-global registry + lifecycle for [`PluginInterface`](/api/plugin/plugin-interface/)s, mirroring the static, worker-lifetime pattern of [`MiddlewareCatalog`](/api/middleware/middleware-catalog/) and [`Events`](/api/event/events/): plugins are registered once and their contributions persist for the life of the process.

Lifecycle: - [`PluginManager::add()`](/api/plugin/plugin-manager/#add) — programmatic registration (before bootstrap). - [`PluginManager::bootFromConfig()`](/api/plugin/plugin-manager/#bootfromconfig) — called by [`Quiote::bootstrap()`](/api/quiote/#bootstrap) after settings load and before contexts are created (the one seam between those steps): reads the `plugins` config key, instantiates + adds them, then calls [`PluginInterface::register()`](/api/plugin/plugin-interface/#register) on every plugin in deterministic order, de-duped by class. Idempotent. - [`PluginManager::configureContainer()`](/api/plugin/plugin-manager/#configurecontainer) — applies deferred DI-service contributions to a context's container (register-if-absent). - [`PluginManager::configureHttpClients()`](/api/plugin/plugin-manager/#configurehttpclients) — applies named-HTTP-client contributions to a container's [`HttpClientFactory`](/api/http/client/http-client-factory/). - [`PluginManager::moduleDirectories()`](/api/plugin/plugin-manager/#moduledirectories) / [`PluginManager::contributedCommands()`](/api/plugin/plugin-manager/#contributedcommands) — read by the attribute route scanner / console application.

## Synopsis

`final class PluginManager`

|  |  |
|---|---|
| Source | `Plugin/PluginManager.php` |

## Methods

| Method | Description |
|---|---|
| [`add(PluginInterface|string $plugin): void`](#add) | Register a plugin (instance or class-string). |
| [`addCommand(string $fqcn): void`](#addcommand) | Records a console command class a plugin contributes to the CLI application. |
| [`addContainerService(string $id, mixed $concrete, ?string $scope, list<string> $aliases): void`](#addcontainerservice) |  |
| [`addHttpClientConfig(string $name, callable $configurator): void`](#addhttpclientconfig) | Records a configurator for a named HTTP client, keyed by $name. |
| [`addModuleDirectory(string $dir): void`](#addmoduledirectory) | Records a directory a plugin contributes as a module search root. |
| [`addRequestEndClear(string $label, \Closure(): void $clear): void`](#addrequestendclear) | Contribute a clear that runs when a request on any context ends. |
| [`bootFromConfig(): void`](#bootfromconfig) | Boot phase: pull plugins from the `plugins` config key, then invoke register() on every plugin once, in order. |
| [`configureContainer(Container $container): void`](#configurecontainer) | Apply deferred DI-service contributions to a container, register-if-absent so app/core bindings (and the first contributing plugin) win. |
| [`configureHttpClients(HttpClientFactory $factory): void`](#configurehttpclients) | Apply named-HTTP-client contributions to a factory (does not overwrite an already-configured name). |
| [`configureLifecycle(ContextLifecycle $lifecycle): void`](#configurelifecycle) | Append plugin-contributed clears to a context's lifecycle, after the framework's own -- the identity clears must not be displaced by a plugin. |
| [`contributedCommands(): list<string>`](#contributedcommands) |  |
| [`isBooted(): bool`](#isbooted) | Reports whether plugin registration has already run in this process. |
| [`moduleDirectories(): list<string>`](#moduledirectories) |  |
| [`registeredPlugins(): array<class-string, PluginInterface>`](#registeredplugins) |  |
| [`reset(): void`](#reset) | Test isolation: clears every plugin + contribution and the booted flag. |

### add()

`public static function add(PluginInterface|string $plugin): void`

Register a plugin (instance or class-string).

De-duped by class; declared order preserved.

| Parameter | Type | Description |
|---|---|---|
| `$plugin` | [`PluginInterface`](/api/plugin/plugin-interface/)`|``string` |  |

### addCommand()

`public static function addCommand(string $fqcn): void`

Records a console command class a plugin contributes to the CLI application.

De-duplicated on the class name, so registering the same command twice adds it once. The class is not loaded or instantiated here; it is handed over when the console application reads [`PluginManager::contributedCommands()`](/api/plugin/plugin-manager/#contributedcommands).

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |

### addContainerService()

`public static function addContainerService(string $id, mixed $concrete, ?string $scope, list<string> $aliases): void`

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |
| `$concrete` | `mixed` |  |
| `$scope` | `?``string` |  |
| `$aliases` | `list``<``string``>` |  |

### addHttpClientConfig()

`public static function addHttpClientConfig(string $name, callable $configurator): void`

Records a configurator for a named HTTP client, keyed by $name.

Registering the same name twice replaces the earlier configurator rather than stacking. The configurator is only invoked when [`PluginManager::configureHttpClients()`](/api/plugin/plugin-manager/#configurehttpclients) applies it to a factory, and only for a name the factory has not already configured.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$configurator` | `callable` |  |

### addModuleDirectory()

`public static function addModuleDirectory(string $dir): void`

Records a directory a plugin contributes as a module search root.

De-duplicated on the exact string, so re-registering the same directory is a no-op. The contribution is stored statically and applied later by whoever reads [`PluginManager::moduleDirectories()`](/api/plugin/plugin-manager/#moduledirectories), not at the moment of the call.

| Parameter | Type | Description |
|---|---|---|
| `$dir` | `string` |  |

### addRequestEndClear()

`public static function addRequestEndClear(string $label, \Closure(): void $clear): void`

Contribute a clear that runs when a request on any context ends.

| Parameter | Type | Description |
|---|---|---|
| `$label` | `string` |  |
| `$clear` | `\Closure(): void` |  |

### bootFromConfig()

`public static function bootFromConfig(): void`

Boot phase: pull plugins from the `plugins` config key, then invoke register() on every plugin once, in order.

Called from Quiote::bootstrap() after settings load. Idempotent — safe if bootstrap runs more than once.

### configureContainer()

`public static function configureContainer(Container $container): void`

Apply deferred DI-service contributions to a container, register-if-absent so app/core bindings (and the first contributing plugin) win.

Safe to call repeatedly for the same container (idempotent).

| Parameter | Type | Description |
|---|---|---|
| `$container` | [`Container`](/api/di/container/) |  |

### configureHttpClients()

`public static function configureHttpClients(HttpClientFactory $factory): void`

Apply named-HTTP-client contributions to a factory (does not overwrite an already-configured name).

| Parameter | Type | Description |
|---|---|---|
| `$factory` | [`HttpClientFactory`](/api/http/client/http-client-factory/) |  |

### configureLifecycle()

`public static function configureLifecycle(ContextLifecycle $lifecycle): void`

Append plugin-contributed clears to a context's lifecycle, after the framework's own -- the identity clears must not be displaced by a plugin.

| Parameter | Type | Description |
|---|---|---|
| `$lifecycle` | [`ContextLifecycle`](/api/context-lifecycle/) |  |

### contributedCommands()

`public static function contributedCommands(): list<string>`

Returns `list``<``string``>`

### isBooted()

`public static function isBooted(): bool`

Reports whether plugin registration has already run in this process.

The flag guards registration against running twice per worker; [`PluginManager::reset()`](/api/plugin/plugin-manager/#reset) clears it along with the contributions.

Returns `bool`

### moduleDirectories()

`public static function moduleDirectories(): list<string>`

Returns `list``<``string``>`

### registeredPlugins()

`public static function registeredPlugins(): array<class-string, PluginInterface>`

Returns `array``<``class-string``, `[`PluginInterface`](/api/plugin/plugin-interface/)`>`

### reset()

`public static function reset(): void`

Test isolation: clears every plugin + contribution and the booted flag.

Middleware contributions are cleared with the rest. They live in their own registries rather than in this class, and leaving them behind produced a half-registered plugin: the pipeline still advertised the plugin's middleware while the container had lost the service that middleware's factory resolves, so the next dispatch died on a missing service rather than simply running without the plugin.
