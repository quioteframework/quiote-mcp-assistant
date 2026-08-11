# TransportException

> Base PSR-18 client exception for the Quiote HTTP client — anything that went wrong sending a request that isn't more specifically a network or malformed- request failure (NetworkException/RequestException).

Base PSR-18 client exception for the Quiote HTTP client — anything that went wrong sending a request that isn't more specifically a network or malformed- request failure ([`NetworkException`](/api/http/client/exception/network-exception/)/[`RequestException`](/api/http/client/exception/request-exception/)).

## Synopsis

`class TransportException extends RuntimeException implements ClientExceptionInterface`

|  |  |
|---|---|
| Extends | `RuntimeException` |
| Implements | `ClientExceptionInterface` |
| Source | `Http/Client/Exception/TransportException.php` |

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
