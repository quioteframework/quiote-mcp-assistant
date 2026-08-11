# UncacheableException

> UncacheableException can be thrown by cache group callbacks to signal to the framework's execution filter that no caching should occur.

UncacheableException can be thrown by cache group callbacks to signal to the framework's execution filter that no caching should occur.

## Synopsis

`class UncacheableException extends QuioteException`

|  |  |
|---|---|
| Extends | [`QuioteException`](/api/exception/quiote-exception/) |
| Since | `1.0.0` |
| Source | `Exception/UncacheableException.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `getCode()` | `Exception` |  |
| `getFile()` | `Exception` |  |
| `getLine()` | `Exception` |  |
| `getMessage()` | `Exception` |  |
| `getOriginalCode()` | [`QuioteException`](/api/exception/quiote-exception/) | Returns the original code, which may be a string (e.g. |
| `getPrevious()` | `Exception` |  |
| `getTrace()` | `Exception` |  |
| `getTraceAsString()` | `Exception` |  |
