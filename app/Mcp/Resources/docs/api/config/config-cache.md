# ConfigCache

> ConfigCache allows you to customize the format of a configuration file to make it easy-to-use, yet still provide a PHP formatted result for direct inclusion into your modules.

ConfigCache allows you to customize the format of a configuration file to make it easy-to-use, yet still provide a PHP formatted result for direct inclusion into your modules.

## Synopsis

`class ConfigCache`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/ConfigCache.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `CACHE_SUBDIR` | `'config'` |  |

## Methods

| Method | Description |
|---|---|
| [`addConfigHandlersFile(string $filename): void`](#addconfighandlersfile) | Schedules a config handlers file to be loaded. |
| [`checkConfig(string $config, string $context = null): string`](#checkconfig) | Check to see if a configuration file has been modified and if so recompile the cache file associated with it. |
| [`clear(): void`](#clear) | Clear all configuration cache files. |
| [`describeConfigCandidates(string $filename): array{winner: ?string, shadowed: list<array{path: string, reason: ('excluded_by_config_format' | 'lower_precedence')}>}`](#describeconfigcandidates) | Full-candidate-list counterpart to resolveConfigFormat(): reports not just the physical file that would be loaded, but every sibling that exists and why it lost, so callers building diagnostics (e.g. |
| [`describeShadowedConfigDiagnostics(string $filename): list<Diagnostic>`](#describeshadowedconfigdiagnostics) | Diagnostic-object counterpart to describeConfigCandidates(), for callers (console, probe, the future extension) that want to surface "this config is shadowed" the same way every other framework diagnostic is reported, rather than re-deriving a message from the raw {winner, shadowed} shape themselves. |
| [`exists(string $config): bool`](#exists) | Whether a config file exists in any supported format, given its canonical (typically `.xml`) logical path -- e.g. |
| [`frameworkFingerprint(): string`](#frameworkfingerprint) | A short token identifying the framework build that compiles a config cache. |
| [`getCacheName(string $config, string $context = null): string`](#getcachename) | Convert a normal filename into a cache filename. |
| [`isModified(string $filename, string $cachename): bool`](#ismodified) | Check if the cached version of a file is up to date. |
| [`load(string $config, string $context = null, bool $once = true): void`](#load) | Apply a configuration file to runtime state. |
| [`loadValue(string $config, string|null $context = null): mixed`](#loadvalue) | The value a compiled configuration returns. |
| [`parseConfig(string $config, bool $autoloadParser = true, string $validationFile = null, string $parserClass = null): ConfigValueHolder`](#parseconfig) | Parses a config file with the ConfigParser for the extension of the given file. |
| [`resetAppliedConfigs(): void`](#resetappliedconfigs) | Test isolation and [`ConfigCache::clear()`](/api/config/config-cache/#clear): forget which configs [`ConfigCache::load()`](/api/config/config-cache/#load) has applied. |
| [`resetFrameworkFingerprint(): void`](#resetframeworkfingerprint) | Drop the memoized framework fingerprint. |
| [`resetWorldWritableWarnings(): void`](#resetworldwritablewarnings) | Test isolation: re-arm the once-per-directory world-writable warning. |
| [`writeCacheFile(string $config, string $cache, mixed $value, ?string $generatedBy = null): void`](#writecachefile) | Write a compiled configuration to the cache. |

### addConfigHandlersFile()

`public static function addConfigHandlersFile(string $filename): void`

Schedules a config handlers file to be loaded.

The path to a config_handlers.xml file.

| Parameter | Type | Description |
|---|---|---|
| `$filename` | `string` | The path to a config_handlers.xml file. |

### checkConfig()

`public static function checkConfig(string $config, string $context = null): string`

Check to see if a configuration file has been modified and if so recompile the cache file associated with it.

An optional context name for which the config should be
                   read.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `string` | A filesystem path to a configuration file. |
| `$context` | `string` | An optional context name for which the config should be read. |

Returns `string` — An absolute filesystem path to the cache filename associated with this specified configuration file.

| Throws | When |
|---|---|
| `UnreadableException` | If a requested configuration file does not exist. |

### clear()

`public static function clear(): void`

Clear all configuration cache files.

### describeConfigCandidates()

`public static function describeConfigCandidates(string $filename): array{winner: ?string, shadowed: list<array{path: string, reason: ('excluded_by_config_format' | 'lower_precedence')}>}`

Full-candidate-list counterpart to resolveConfigFormat(): reports not just the physical file that would be loaded, but every sibling that exists and why it lost, so callers building diagnostics (e.g.

"this * settings.xml is shadowed by settings.php and will never be read") can surface the whole picture instead of just the winner.

| Parameter | Type | Description |
|---|---|---|
| `$filename` | `string` |  |

Returns `array{winner: ?string, shadowed: list<array{path: string, reason: ('excluded_by_config_format' | 'lower_precedence')}>}`

### describeShadowedConfigDiagnostics()

`public static function describeShadowedConfigDiagnostics(string $filename): list<Diagnostic>`

Diagnostic-object counterpart to describeConfigCandidates(), for callers (console, probe, the future extension) that want to surface "this config is shadowed" the same way every other framework diagnostic is reported, rather than re-deriving a message from the raw {winner, shadowed} shape themselves.

| Parameter | Type | Description |
|---|---|---|
| `$filename` | `string` |  |

Returns `list``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>`

### exists()

`public static function exists(string $config): bool`

Whether a config file exists in any supported format, given its canonical (typically `.xml`) logical path -- e.g.

`exists('%core.config_dir%/plugins.xml')` is true if `plugins.php`, `.yaml`, `.yml`, or `.xml` exists alongside it. Used for genuinely optional config files (unlike `settings.xml`, which is mandatory and so just lets [`ConfigCache::checkConfig()`](/api/config/config-cache/#checkconfig) throw if absent).

| Parameter | Type | Description |
|---|---|---|
| `$config` | `string` |  |

Returns `bool`

### frameworkFingerprint()

`public static function frameworkFingerprint(): string`

A short token identifying the framework build that compiles a config cache.

Part of every cache key, because otherwise nothing invalidates a compiled config when the framework changes. Freshness is decided by comparing the *source* config's mtime against the cache file's, and upgrading the framework changes neither -- so a cache compiled by an older version is reused indefinitely, even though the handler that produced it may now generate a completely different shape. That failure lands at boot, and reports whatever the stale cache's contents happen to break first rather than the staleness itself.

Composer's installed reference is the useful part: for a released install it is the dist reference, and for a `dev-` install it is the commit hash, so it changes on every framework commit. That covers developing against an unreleased framework, which a version string alone does not. It is asked of `quioteframework/quiote` whether the framework is a dependency or the root package.

`core.config_cache_fingerprint` is mixed in when set, so a build pipeline can force a rebuild without touching any config file.

Memoized: this is consulted for every config in every context.

Returns `string`

### getCacheName()

`public static function getCacheName(string $config, string $context = null): string`

Convert a normal filename into a cache filename.

A context name.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `string` | A normal filename. |
| `$context` | `string` | A context name. |

Returns `string` — An absolute filesystem path to a cache filename.

### isModified()

`public static function isModified(string $filename, string $cachename): bool`

Check if the cached version of a file is up to date.

The name of the cached version.

| Parameter | Type | Description |
|---|---|---|
| `$filename` | `string` | The source file. |
| `$cachename` | `string` | The name of the cached version. |

Returns `bool` — Whether or not the cached file must be updated.

### load()

`public static function load(string $config, string $context = null, bool $once = true): void`

Apply a configuration file to runtime state.

Only apply this configuration file once per request? Applying twice is
                   not generally harmless -- a contribution-style handler appends -- so this
                   defaults to true, as the include_once it replaces did.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `string` | A filesystem path to a configuration file. |
| `$context` | `string` | A context name. |
| `$once` | `bool` | Only apply this configuration file once per request? Applying twice is not generally harmless -- a contribution-style handler appends -- so this defaults to true, as the include_once it replaces did. |

| Throws | When |
|---|---|
| `ConfigurationException` | If the file's handler does not implement [`IDeclarationConfigHandler`](/api/config/i-declaration-config-handler/). |

### loadValue()

`public static function loadValue(string $config, string|null $context = null): mixed`

The value a compiled configuration returns.

An optional context name.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `string` | An absolute or relative filesystem path to a configuration file. |
| `$context` | `string``|``null` | An optional context name. |

Returns `mixed` — The compiled configuration's return value.

### parseConfig()

`public static function parseConfig(string $config, bool $autoloadParser = true, string $validationFile = null, string $parserClass = null): ConfigValueHolder`

Parses a config file with the ConfigParser for the extension of the given file.

A class name which specifies an parser to be used.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `string` | An absolute filesystem path to a configuration file. |
| `$autoloadParser` | `bool` | Whether the config parser class should be autoloaded if the class doesn't exist. |
| `$validationFile` | `string` | A path to a validation file for this config file. |
| `$parserClass` | `string` | A class name which specifies an parser to be used. |

Returns [`ConfigValueHolder`](/api/config/config-value-holder/) — An abstract representation of the config file.

| Throws | When |
|---|---|
| `ConfigurationException` | If the parser for the extension couldn't be found. |

### resetAppliedConfigs()

`public static function resetAppliedConfigs(): void`

Test isolation and [`ConfigCache::clear()`](/api/config/config-cache/#clear): forget which configs [`ConfigCache::load()`](/api/config/config-cache/#load) has applied.

### resetFrameworkFingerprint()

`public static function resetFrameworkFingerprint(): void`

Drop the memoized framework fingerprint.

For tests that change what it is derived from.

### resetWorldWritableWarnings()

`public static function resetWorldWritableWarnings(): void`

Test isolation: re-arm the once-per-directory world-writable warning.

### writeCacheFile()

`public static function writeCacheFile(string $config, string $cache, mixed $value, ?string $generatedBy = null): void`

Write a compiled configuration to the cache.

The handler class that compiled it, for the file's header.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `string` | An absolute filesystem path to a configuration file. |
| `$cache` | `string` | An absolute filesystem path to the cache file that will be written. |
| `$value` | `mixed` | The declaration the handler compiled. |
| `$generatedBy` | `?``string` | The handler class that compiled it, for the file's header. |

| Throws | When |
|---|---|
| `CacheException` | If the cache file cannot be written, or the declaration is not data a PHP literal can express. |
