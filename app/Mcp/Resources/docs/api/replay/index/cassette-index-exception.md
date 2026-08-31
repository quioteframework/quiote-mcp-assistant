# CassetteIndexException

> Thrown by a CassetteIndexInterface for a genuine failure -- a malformed hint, a broken query, an auth error, or a pointer that resolved to a key whose object has already expired.

Thrown by a [`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/) for a genuine failure -- a malformed hint, a broken query, an auth error, or a pointer that resolved to a key whose object has already expired.

Never thrown for "this index has nothing to say for this id/hints", which is a `null` return instead (see [`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/)'s own docblock) -- a chain of indexes must be able to tell "nothing here, try the next one" apart from "this one is broken."

## Synopsis

`final class CassetteIndexException extends RuntimeException`

|  |  |
|---|---|
| Extends | `RuntimeException` |
| Source | `Index/CassetteIndexException.php` |

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
