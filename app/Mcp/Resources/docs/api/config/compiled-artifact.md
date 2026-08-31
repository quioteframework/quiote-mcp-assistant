# CompiledArtifact

> Serializes a config handler's declaration into the PHP file the on-disk cache holds.

Serializes a config handler's declaration into the PHP file the on-disk cache holds.

A handler produces data; how that data is stored is the cache's business, and this is the one place that turns it into source. The file is a header comment plus a single `return <literal>;`, so the only thing including it can ever do is hand back a value -- and, unlike an `eval()`'d string, it is opcache-cacheable, so an unchanged config costs nothing to read again.

The single exception is a declaration holding a `%env(...)%` placeholder, where the literal is wrapped in one [`EnvPlaceholder::resolve()`](/api/config/env-placeholder/#resolve) call so the environment is read at load rather than baked in at compile time -- see [`CompiledArtifact::expression()`](/api/config/compiled-artifact/#expression).

## Synopsis

`final class CompiledArtifact`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `Config/CompiledArtifact.php` |

## Methods

| Method | Description |
|---|---|
| [`source(mixed $value, ?string $path = null, ?string $generatedBy = null): string`](#source) | The PHP source for a compiled configuration file. |

### source()

`public static function source(mixed $value, ?string $path = null, ?string $generatedBy = null): string`

The PHP source for a compiled configuration file.

The handler class that compiled it, for the header comment.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `mixed` | The declaration the handler compiled. |
| `$path` | `?``string` | The configuration file it came from, for the header comment. |
| `$generatedBy` | `?``string` | The handler class that compiled it, for the header comment. |

Returns `string` — PHP source that returns $value.

| Throws | When |
|---|---|
| `CacheException` | If the declaration contains something no PHP literal can express. |
