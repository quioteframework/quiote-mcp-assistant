# CategoryLogger

> A PSR-3 logger bound to a single category.

A PSR-3 logger bound to a single category.

The 8 level methods come from `LoggerTrait` and funnel into [`CategoryLogger::log()`](/api/logging/category-logger/#log); [`CategoryLogger::isEnabled()`](/api/logging/category-logger/#isenabled) is the cheap hot-path guard for callers to skip expensive message construction. The category threshold is resolved via [`LogRegistry`](/api/logging/log-registry/) and cached on the instance, along with the per-level isEnabled() answers.

Those caches are keyed to [`LogRegistry::generation()`](/api/logging/log-registry/#generation), which every configuration change bumps. Instances are shared per category and live for the worker's lifetime, so a level rule or sink registered after one was handed out would otherwise never be seen by it -- the hot path pays one integer comparison to make reconfiguration actually take effect.

## Synopsis

`final class CategoryLogger implements LoggerInterface`

|  |  |
|---|---|
| Implements | [`LoggerInterface`](https://www.php-fig.org/psr/psr-3/) |
| Uses | `LoggerTrait` |
| Source | `Logging/CategoryLogger.php` |

## Constructor

### __construct()

`public function __construct(string $category): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$category` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`alert(Stringable|string $message, array $context = []): void`](#alert) | Action must be taken immediately. |
| [`category(): string`](#category) | Returns the category name this logger is bound to. |
| [`critical(Stringable|string $message, array $context = []): void`](#critical) | Critical conditions. |
| [`debug(Stringable|string $message, array $context = []): void`](#debug) | Detailed debug information. |
| [`debugWith(callable(): string $build): void`](#debugwith) | Emit a debug message built by $build, but only when debug logging is on, and never let building it affect the caller. |
| [`emergency(Stringable|string $message, array $context = []): void`](#emergency) | System is unusable. |
| [`error(Stringable|string $message, array $context = []): void`](#error) | Runtime errors that do not require immediate action but should typically be logged and monitored. |
| [`info(Stringable|string $message, array $context = []): void`](#info) | Interesting events. |
| [`isEnabled(Level $level): bool`](#isenabled) | Whether an event at $level for this category would be emitted by at least one sink: passes the category threshold AND some sink accepts it. |
| [`log(mixed $level, Stringable|string $message, array<string, mixed> $context = []): void`](#log) | Logs with an arbitrary level. |
| [`notice(Stringable|string $message, array $context = []): void`](#notice) | Normal but significant events. |
| [`warning(Stringable|string $message, array $context = []): void`](#warning) | Exceptional occurrences that are not errors. |

### alert()

`public function alert(Stringable|string $message, array $context = []): void`

Composed in from `LoggerTrait`.

Action must be taken immediately.

Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up.

| Parameter | Type | Description |
|---|---|---|
| `$message` | [`Stringable`](https://www.php.net/manual/en/class.stringable.php)`|``string` |  |
| `$context` | `array` |  |

### category()

`public function category(): string`

Returns the category name this logger is bound to.

Returns `string`

### critical()

`public function critical(Stringable|string $message, array $context = []): void`

Composed in from `LoggerTrait`.

Critical conditions.

Example: Application component unavailable, unexpected exception.

| Parameter | Type | Description |
|---|---|---|
| `$message` | [`Stringable`](https://www.php.net/manual/en/class.stringable.php)`|``string` |  |
| `$context` | `array` |  |

### debug()

`public function debug(Stringable|string $message, array $context = []): void`

Composed in from `LoggerTrait`.

Detailed debug information.

| Parameter | Type | Description |
|---|---|---|
| `$message` | [`Stringable`](https://www.php.net/manual/en/class.stringable.php)`|``string` |  |
| `$context` | `array` |  |

### debugWith()

`public function debugWith(callable(): string $build): void`

Emit a debug message built by $build, but only when debug logging is on, and never let building it affect the caller.

Returns the message; the empty string emits nothing.

| Parameter | Type | Description |
|---|---|---|
| `$build` | `callable(): string` | Returns the message; the empty string emits nothing. |

### emergency()

`public function emergency(Stringable|string $message, array $context = []): void`

Composed in from `LoggerTrait`.

System is unusable.

| Parameter | Type | Description |
|---|---|---|
| `$message` | [`Stringable`](https://www.php.net/manual/en/class.stringable.php)`|``string` |  |
| `$context` | `array` |  |

### error()

`public function error(Stringable|string $message, array $context = []): void`

Composed in from `LoggerTrait`.

Runtime errors that do not require immediate action but should typically be logged and monitored.

| Parameter | Type | Description |
|---|---|---|
| `$message` | [`Stringable`](https://www.php.net/manual/en/class.stringable.php)`|``string` |  |
| `$context` | `array` |  |

### info()

`public function info(Stringable|string $message, array $context = []): void`

Composed in from `LoggerTrait`.

Interesting events.

Example: User logs in, SQL logs.

| Parameter | Type | Description |
|---|---|---|
| `$message` | [`Stringable`](https://www.php.net/manual/en/class.stringable.php)`|``string` |  |
| `$context` | `array` |  |

### isEnabled()

`public function isEnabled(Level $level): bool`

Whether an event at $level for this category would be emitted by at least one sink: passes the category threshold AND some sink accepts it.

Allocates nothing; safe to call per request on the hot path.

| Parameter | Type | Description |
|---|---|---|
| `$level` | [`Level`](/api/logging/level/) |  |

Returns `bool`

### log()

`public function log(mixed $level, Stringable|string $message, array<string, mixed> $context = []): void`

Composed in from `LoggerTrait`.

Logs with an arbitrary level.

| Parameter | Type | Description |
|---|---|---|
| `$level` | `mixed` | A PSR-3 level string or a [`Level`](/api/logging/level/). |
| `$message` | [`Stringable`](https://www.php.net/manual/en/class.stringable.php)`|``string` |  |
| `$context` | `array``<``string``, ``mixed``>` |  |

| Throws | When |
|---|---|
| `InvalidArgumentException` |  |

### notice()

`public function notice(Stringable|string $message, array $context = []): void`

Composed in from `LoggerTrait`.

Normal but significant events.

| Parameter | Type | Description |
|---|---|---|
| `$message` | [`Stringable`](https://www.php.net/manual/en/class.stringable.php)`|``string` |  |
| `$context` | `array` |  |

### warning()

`public function warning(Stringable|string $message, array $context = []): void`

Composed in from `LoggerTrait`.

Exceptional occurrences that are not errors.

Example: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.

| Parameter | Type | Description |
|---|---|---|
| `$message` | [`Stringable`](https://www.php.net/manual/en/class.stringable.php)`|``string` |  |
| `$context` | `array` |  |
