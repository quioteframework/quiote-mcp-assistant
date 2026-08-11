# QuioteException

> QuioteException is the base class for all Quiote related exceptions.

QuioteException is the base class for all Quiote related exceptions.

Rendering an exception to a client belongs to [`ExceptionRenderer`](/api/exception/rendering/exception-renderer/) and its registry, not here: the default [`SafeRenderer`](/api/exception/rendering/safe-renderer/) reveals nothing about the exception, and the developer-facing page comes from the opt-in `quioteframework/whoops` package, which brings its own stack-frame and source rendering.

## Synopsis

`class QuioteException extends Exception`

|  |  |
|---|---|
| Extends | `Exception` |
| Since | `1.0.0` |
| Source | `Exception/QuioteException.php` |

## Constructor

### __construct()

`public function __construct(string $message = '', string|int $mixedCode = 0, ?Throwable $previous = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$message` | `string` |  |
| `$mixedCode` | `string``|``int` |  |
| `$previous` | `?`[`Throwable`](https://www.php.net/manual/en/class.throwable.php) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getOriginalCode(): string|int`](#getoriginalcode) | Returns the original code, which may be a string (e.g. |

### getOriginalCode()

`public function getOriginalCode(): string|int`

Returns the original code, which may be a string (e.g.

a PDO SQLSTATE like "42P01").

Returns `string``|``int`

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
