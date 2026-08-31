# CassetteCodecException

> A cassette payload could not be decoded: corrupt/truncated gzip, invalid JSON, a missing required section, or a schema version this codec does not understand.

A cassette payload could not be decoded: corrupt/truncated gzip, invalid JSON, a missing required section, or a schema version this codec does not understand.

No silent best-effort parsing -- a partially understood cassette produces a wrong test, which is worse than no test.

## Synopsis

`final class CassetteCodecException extends RuntimeException`

|  |  |
|---|---|
| Extends | `RuntimeException` |
| Source | `Cassette/CassetteCodecException.php` |

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
