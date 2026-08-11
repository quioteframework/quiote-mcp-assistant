# MiddlewareOrderException

> Thrown by MiddlewareOrderResolver when a `#[Middleware]` ordering constraint cannot be honoured and there is no safe fallback: either the `before`/`after` constraints form a cycle, or a *guarded* (framework) middleware's constraint names something that isn't there.

Thrown by MiddlewareOrderResolver when a `#[Middleware]` ordering constraint cannot be honoured and there is no safe fallback: either the `before`/`after` constraints form a cycle, or a *guarded* (framework) middleware's constraint names something that isn't there.

An unresolvable reference on app or plugin middleware still degrades to a Diagnostic and is skipped -- anchoring to an optional package's middleware is a legitimate pattern, and that middleware simply falls back to its phase and priority. For framework middleware it is not survivable: those constraints are how a security check's position in the pipeline is guaranteed at all, so silently dropping one turns "CSRF runs before dispatch" into "CSRF happens to * run before dispatch, given the current priorities".

## Synopsis

`final class MiddlewareOrderException extends RuntimeException`

|  |  |
|---|---|
| Extends | `RuntimeException` |
| Since | `1.0.0` |
| Source | `Middleware/Compiler/MiddlewareOrderException.php` |

## Methods

| Method | Description |
|---|---|
| [`cycle(array<string> $involved): MiddlewareOrderException`](#cycle) |  |
| [`unresolvedGuardedReference(string $from, string $reference, string $why): MiddlewareOrderException`](#unresolvedguardedreference) |  |

### cycle()

`public static function cycle(array<string> $involved): MiddlewareOrderException`

FQCNs of the middleware still unordered when the cycle was detected.

| Parameter | Type | Description |
|---|---|---|
| `$involved` | `array``<``string``>` | FQCNs of the middleware still unordered when the cycle was detected. |

Returns [`MiddlewareOrderException`](/api/middleware/compiler/middleware-order-exception/)

### unresolvedGuardedReference()

`public static function unresolvedGuardedReference(string $from, string $reference, string $why): MiddlewareOrderException`

What was wrong with it (unknown, or ambiguous).

| Parameter | Type | Description |
|---|---|---|
| `$from` | `string` | The guarded middleware carrying the constraint. |
| `$reference` | `string` | The unresolvable before/after target as written. |
| `$why` | `string` | What was wrong with it (unknown, or ambiguous). |

Returns [`MiddlewareOrderException`](/api/middleware/compiler/middleware-order-exception/)

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `getCode()` | `Exception` |  |
| `getFile()` | `Exception` |  |
| `getLine()` | `Exception` |  |
| `getMessage()` | `Exception` |  |
| `getPrevious()` | `Exception` |  |
| `getTrace()` | `Exception` |  |
| `getTraceAsString()` | `Exception` |  |
