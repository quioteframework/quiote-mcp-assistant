# APCuConfigCache

> APCu-based configuration cache with warmup for Kubernetes/FrankenPHP deployments This class provides both warmup functionality and drop-in replacement methods for ConfigCache.

APCu-based configuration cache with warmup for Kubernetes/FrankenPHP deployments This class provides both warmup functionality and drop-in replacement methods for ConfigCache.

It combines the benefits of APCu caching with the standard config cache interface. Benefits: - Zero file I/O after warmup - Pre-compiled configurations stored in memory - Routing trees cached and ready - Drop-in replacement for ConfigCache - Uses igbinary for better serialization performance when available

## Synopsis

`class APCuConfigCache extends ConfigCache`

|  |  |
|---|---|
| Extends | [`ConfigCache`](/api/config/config-cache/) |
| Since | `1.0.0` |
| Source | `Config/APCuConfigCache.php` |

## Methods

| Method | Description |
|---|---|
| [`checkConfig(mixed $config, mixed $context = null): mixed`](#checkconfig) | Not a path on this cache: a compiled configuration is a value in shared memory here, so there is no file to hand back and nothing sensible to return. |
| [`clear(): void`](#clear) | Clear all APCu cached data |
| [`configure(array<string, mixed> $options): void`](#configure) | Configure APCu cache settings |
| [`getDefaultConfigs(): array<int, string>`](#getdefaultconfigs) | The core config files, in dependency order, that a cold worker will load. |
| [`getStatus(): array<string, mixed>`](#getstatus) | Get warmup status and statistics |
| [`isAvailable(): bool`](#isavailable) | Check if APCu is available and enabled |
| [`isIgbinaryAvailable(): bool`](#isigbinaryavailable) | Check if igbinary is available for better serialization |
| [`isWarmedUp(): bool`](#iswarmedup) | Check if APCu cache is warmed up |
| [`loadValue(string $config, string|null $context = null): mixed`](#loadvalue) | The value a compiled configuration returns, served from shared memory. |
| [`warmup(array<int, string> $configs = [], string $context = null): array<string, mixed>`](#warmup) | Warm up all configurations and routing data into APCu |
| [`writeCacheFile(string $config, string $cache, mixed $value, ?string $generatedBy = null): void`](#writecachefile) | Keep the compiled configuration's value in shared memory instead of writing a file. |

### checkConfig()

`public static function checkConfig(mixed $config, mixed $context = null): mixed`

Not a path on this cache: a compiled configuration is a value in shared memory here, so there is no file to hand back and nothing sensible to return.

The base implementation's contract -- "returns the path of the compiled cache file" -- cannot be honoured, and returning a path that was never written would fail later as a missing include. [`APCuConfigCache::loadValue()`](/api/config/apcu-config-cache/#loadvalue), reached through [`CompiledConfig::value()`](/api/config/compiled-config/#value), is the read path.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `mixed` |  |
| `$context` | `mixed` |  |

Returns `mixed`

| Throws | When |
|---|---|
| `CacheException` | Always, while APCu is in use. |

### clear()

`public static function clear(): void`

Clear all APCu cached data

### configure()

`public static function configure(array<string, mixed> $options): void`

Configure APCu cache settings

| Parameter | Type | Description |
|---|---|---|
| `$options` | `array``<``string``, ``mixed``>` |  |

### getDefaultConfigs()

`public static function getDefaultConfigs(): array<int, string>`

The core config files, in dependency order, that a cold worker will load.

Public so the `cache:warmup` command can compile the same set into the on-disk cache for the non-APCu backend (single source of truth).

Returns `array``<``int``, ``string``>`

### getStatus()

`public static function getStatus(): array<string, mixed>`

Get warmup status and statistics

Returns `array``<``string``, ``mixed``>`

### isAvailable()

`public static function isAvailable(): bool`

Check if APCu is available and enabled

Returns `bool`

### isIgbinaryAvailable()

`public static function isIgbinaryAvailable(): bool`

Check if igbinary is available for better serialization

Returns `bool`

### isWarmedUp()

`public static function isWarmedUp(): bool`

Check if APCu cache is warmed up

Returns `bool`

### loadValue()

`public static function loadValue(string $config, string|null $context = null): mixed`

The value a compiled configuration returns, served from shared memory.

An optional context name.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `string` | An absolute or relative filesystem path to a configuration file. |
| `$context` | `string``|``null` | An optional context name. |

Returns `mixed` — The compiled configuration's return value.

### warmup()

`public static function warmup(array<int, string> $configs = [], string $context = null): array<string, mixed>`

Warm up all configurations and routing data into APCu

The context to warm up for

| Parameter | Type | Description |
|---|---|---|
| `$configs` | `array``<``int``, ``string``>` | Array of config files to warm up (relative to config_dir) |
| `$context` | `string` | The context to warm up for |

Returns `array``<``string``, ``mixed``>` — Warmup statistics

### writeCacheFile()

`public static function writeCacheFile(string $config, string $cache, mixed $value, ?string $generatedBy = null): void`

Keep the compiled configuration's value in shared memory instead of writing a file.

The handler class that compiled it; only the file cache records it.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `string` |  |
| `$cache` | `string` |  |
| `$value` | `mixed` | The declaration the handler compiled. |
| `$generatedBy` | `?``string` | The handler class that compiled it; only the file cache records it. |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `addConfigHandlersFile()` | [`ConfigCache`](/api/config/config-cache/) | Schedules a config handlers file to be loaded. |
| `describeConfigCandidates()` | [`ConfigCache`](/api/config/config-cache/) | Full-candidate-list counterpart to resolveConfigFormat(): reports not just the physical file that would be loaded, but every sibling that exists and why it lost, so callers building diagnostics (e.g. |
| `describeShadowedConfigDiagnostics()` | [`ConfigCache`](/api/config/config-cache/) | Diagnostic-object counterpart to describeConfigCandidates(), for callers (console, probe, the future extension) that want to surface "this config is shadowed" the same way every other framework diagnostic is reported, rather than re-deriving a message from the raw {winner, shadowed} shape themselves. |
| `exists()` | [`ConfigCache`](/api/config/config-cache/) | Whether a config file exists in any supported format, given its canonical (typically `.xml`) logical path -- e.g. |
| `frameworkFingerprint()` | [`ConfigCache`](/api/config/config-cache/) | A short token identifying the framework build that compiles a config cache. |
| `getCacheName()` | [`ConfigCache`](/api/config/config-cache/) | Convert a normal filename into a cache filename. |
| `isModified()` | [`ConfigCache`](/api/config/config-cache/) | Check if the cached version of a file is up to date. |
| `load()` | [`ConfigCache`](/api/config/config-cache/) | Apply a configuration file to runtime state. |
| `parseConfig()` | [`ConfigCache`](/api/config/config-cache/) | Parses a config file with the ConfigParser for the extension of the given file. |
| `resetAppliedConfigs()` | [`ConfigCache`](/api/config/config-cache/) | Test isolation and [`APCuConfigCache::clear()`](/api/config/apcu-config-cache/#clear): forget which configs [`APCuConfigCache::load()`](/api/config/apcu-config-cache/#load) has applied. |
| `resetFrameworkFingerprint()` | [`ConfigCache`](/api/config/config-cache/) | Drop the memoized framework fingerprint. |
| `resetWorldWritableWarnings()` | [`ConfigCache`](/api/config/config-cache/) | Test isolation: re-arm the once-per-directory world-writable warning. |
