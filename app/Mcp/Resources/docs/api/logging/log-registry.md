# LogRegistry

> Process-global store of logging configuration: the default minimum level, the per-category minimum levels, and the registered sinks.

Process-global store of logging configuration: the default minimum level, the per-category minimum levels, and the registered sinks.

Deliberately free of any dependency on Config / the context / bootstrap, so it can be configured in index.php BEFORE Kernel::run() and is usable during bootstrap itself. Configuration is set once at worker startup and is immutable for the worker lifetime (the only per-request logging state lives in [`LogContext`](/api/logging/log-context/)). [`Log`](/api/logging/log/) is the public facade over this store.

## Synopsis

`final class LogRegistry`

|  |  |
|---|---|
| Source | `Logging/LogRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`addSink(SinkInterface $sink): void`](#addsink) | Appends a sink to the process-global sink list, in registration order. |
| [`generation(): int`](#generation) | The current configuration generation, for consumers that memoize a resolved level or sink decision of their own. |
| [`hasSinks(): bool`](#hassinks) | Reports whether any sink is registered. |
| [`reset(): void`](#reset) | Reset all configuration and drop sinks. |
| [`resolveLevel(string $category): Level`](#resolvelevel) | Resolve the minimum level for a category: the level of the longest configured prefix that matches on a dot boundary, else the default. |
| [`setDefaultLevel(Level $level): void`](#setdefaultlevel) | Sets the minimum level applied to categories with no matching prefix rule. |
| [`setLevel(string $categoryPrefix, Level $level): void`](#setlevel) | Sets the minimum level for one dotted category prefix, replacing any level already stored for that exact prefix. |
| [`setLevels(array<string, Level> $map): void`](#setlevels) |  |
| [`sinks(): list<SinkInterface>`](#sinks) |  |

### addSink()

`public static function addSink(SinkInterface $sink): void`

Appends a sink to the process-global sink list, in registration order.

No de-duplication is performed: registering the same sink twice makes it receive every record twice.

| Parameter | Type | Description |
|---|---|---|
| `$sink` | [`SinkInterface`](/api/logging/sink/sink-interface/) |  |

### generation()

`public static function generation(): int`

The current configuration generation, for consumers that memoize a resolved level or sink decision of their own.

Returns `int`

### hasSinks()

`public static function hasSinks(): bool`

Reports whether any sink is registered.

False means every record is discarded regardless of level, so callers can skip building a record at all.

Returns `bool`

### reset()

`public static function reset(): void`

Reset all configuration and drop sinks.

For test isolation and reconfiguration; not used on the request path.

### resolveLevel()

`public static function resolveLevel(string $category): Level`

Resolve the minimum level for a category: the level of the longest configured prefix that matches on a dot boundary, else the default.

Memoized per exact category string.

| Parameter | Type | Description |
|---|---|---|
| `$category` | `string` |  |

Returns [`Level`](/api/logging/level/)

### setDefaultLevel()

`public static function setDefaultLevel(Level $level): void`

Sets the minimum level applied to categories with no matching prefix rule.

Discards the resolved-threshold memo, so categories that had fallen through to the previous default are re-resolved on their next log call.

| Parameter | Type | Description |
|---|---|---|
| `$level` | [`Level`](/api/logging/level/) |  |

### setLevel()

`public static function setLevel(string $categoryPrefix, Level $level): void`

Sets the minimum level for one dotted category prefix, replacing any level already stored for that exact prefix.

Discards the resolved-threshold memo so existing categories re-resolve against the new rule; see [`LogRegistry::resolveLevel()`](/api/logging/log-registry/#resolvelevel) for how competing prefixes are ranked.

| Parameter | Type | Description |
|---|---|---|
| `$categoryPrefix` | `string` |  |
| `$level` | [`Level`](/api/logging/level/) |  |

### setLevels()

`public static function setLevels(array<string, Level> $map): void`

category-prefix => Level

| Parameter | Type | Description |
|---|---|---|
| `$map` | `array``<``string``, `[`Level`](/api/logging/level/)`>` | category-prefix => Level |

### sinks()

`public static function sinks(): list<SinkInterface>`

Returns `list``<`[`SinkInterface`](/api/logging/sink/sink-interface/)`>`
