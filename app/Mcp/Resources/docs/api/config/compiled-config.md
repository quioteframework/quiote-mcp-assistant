# CompiledConfig

> Reads the value of a compiled configuration through whichever cache implementation is active.

Reads the value of a compiled configuration through whichever cache implementation is active.

A caller wants the value, not the storage: whether the compiled configuration lives in a file on disk or as a value in shared memory is the cache's business, and reading it should not require the caller to know which.

The choice of implementation lives here so the cache classes stay unaware of each other: [`ConfigCache`](/api/config/config-cache/) does not name its APCu subclass, and the subclass overrides one method rather than reimplementing the selection.

## Synopsis

`final class CompiledConfig`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `Config/CompiledConfig.php` |

## Methods

| Method | Description |
|---|---|
| [`value(string $config, string|null $context = null): mixed`](#value) | The value a compiled configuration returns. |

### value()

`public static function value(string $config, string|null $context = null): mixed`

The value a compiled configuration returns.

An optional context name.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `string` | An absolute or relative filesystem path to a configuration file. |
| `$context` | `string``|``null` | An optional context name. |

Returns `mixed` — The compiled configuration's return value.
