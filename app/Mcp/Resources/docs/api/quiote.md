# Quiote

> Main framework class used for autoloading and initial bootstrapping of Quiote.

Main framework class used for autoloading and initial bootstrapping of Quiote.

## Synopsis

`final class Quiote`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Quiote.php` |

## Methods

| Method | Description |
|---|---|
| [`bootstrap(string|null $environment = null, string|array<int, string>|null $contexts = null, array<string, mixed> $options = []): array{contexts: array<string, \Quiote\Context>}`](#bootstrap) | Bootstrap the Quiote core (environment + optional context pre-initialization). |
| [`context(string|null $name = null, bool $prime = false): Context`](#context) | Retrieve (and optionally prime) a context instance. |
| [`prewarm(string|null $context = null): void`](#prewarm) | Prewarm APCu configuration and translation caches to avoid first-request latency. |

### bootstrap()

`public static function bootstrap(string|null $environment = null, string|array<int, string>|null $contexts = null, array<string, mixed> $options = []): array{contexts: array<string, \Quiote\Context>}`

Bootstrap the Quiote core (environment + optional context pre-initialization).

['prewarm' => bool] force prewarm

| Parameter | Type | Description |
|---|---|---|
| `$environment` | `string``|``null` | Environment name (core.environment) |
| `$contexts` | `string``|``array``<``int``, ``string``>``|``null` | One or multiple context names to pre-create |
| `$options` | `array``<``string``, ``mixed``>` | ['prewarm' => bool] force prewarm |

Returns `array{contexts: array<string, \Quiote\Context>}` — Context map (may be empty)

### context()

`public static function context(string|null $name = null, bool $prime = false): Context`

Retrieve (and optionally prime) a context instance.

Prime controller/output types immediately

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``null` | Context name (defaults to core.default_context) |
| `$prime` | `bool` | Prime controller/output types immediately |

Returns [`Context`](/api/context/)

### prewarm()

`public static function prewarm(string|null $context = null): void`

Prewarm APCu configuration and translation caches to avoid first-request latency.

Context name for context-specific caches (routing, factories)

| Parameter | Type | Description |
|---|---|---|
| `$context` | `string``|``null` | Context name for context-specific caches (routing, factories) |
