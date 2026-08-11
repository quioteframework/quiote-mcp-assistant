# MalformedRequestException

> Thrown by HttpMessageParser for anything outside the narrow OTLP/HTTP shape the OTel PHP exporter sends (see that class's docblock).

Thrown by [`HttpMessageParser`](/api/telemetry/dashboard/http-message-parser/) for anything outside the narrow OTLP/HTTP shape the OTel PHP exporter sends (see that class's docblock).

The receiver treats this as "reject this connection with 400, log, move on" -- it must never be allowed to crash the dashboard process.

## Synopsis

`final class MalformedRequestException extends QuioteException`

|  |  |
|---|---|
| Extends | [`QuioteException`](/api/exception/quiote-exception/) |
| Source | `MalformedRequestException.php` |

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
