# InvalidCacheKeyException

> Thrown for a cache key PSR-16 does not permit: empty, or containing one of the characters reserved by PSR-16 §1.3 (`{}()/\\@:`).

Thrown for a cache key PSR-16 does not permit: empty, or containing one of the characters reserved by PSR-16 §1.3 (`{}()/\@:`).

## Synopsis

`class InvalidCacheKeyException extends InvalidArgumentException implements InvalidArgumentException`

|  |  |
|---|---|
| Extends | `InvalidArgumentException` |
| Implements | `InvalidArgumentException` |
| Since | `3.1.1` |
| Source | `Cache/InvalidCacheKeyException.php` |

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
