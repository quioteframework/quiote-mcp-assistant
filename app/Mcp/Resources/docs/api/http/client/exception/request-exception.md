# RequestException

> PSR-18 malformed-request failure: the request itself is not a well-formed HTTP request and could not even be attempted (e.g.

PSR-18 malformed-request failure: the request itself is not a well-formed HTTP request and could not even be attempted (e.g.

an unusable/empty URI). Not retried — retrying a malformed request can't help.

## Synopsis

`final class RequestException extends TransportException implements RequestExceptionInterface`

|  |  |
|---|---|
| Extends | [`TransportException`](/api/http/client/exception/transport-exception/) |
| Implements | `RequestExceptionInterface` |
| Source | `Http/Client/Exception/RequestException.php` |

## Constructor

### __construct()

`public function __construct(string $message, RequestInterface $request, ?Throwable $previous = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$message` | `string` |  |
| `$request` | [`RequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$previous` | `?`[`Throwable`](https://www.php.net/manual/en/class.throwable.php) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getRequest(): RequestInterface`](#getrequest) | Returns the malformed request that was rejected, as handed to the constructor. |

### getRequest()

`public function getRequest(): RequestInterface`

Returns the malformed request that was rejected, as handed to the constructor.

Returns [`RequestInterface`](https://www.php-fig.org/psr/psr-7/)

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
