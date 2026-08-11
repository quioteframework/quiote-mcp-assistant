# NetworkException

> PSR-18 network failure: the request could not be sent / no response was received (DNS failure, connection refused/reset, timeout).

PSR-18 network failure: the request could not be sent / no response was received (DNS failure, connection refused/reset, timeout).

These are the failures the retry policy treats as transient.

## Synopsis

`final class NetworkException extends TransportException implements NetworkExceptionInterface`

|  |  |
|---|---|
| Extends | [`TransportException`](/api/http/client/exception/transport-exception/) |
| Implements | `NetworkExceptionInterface` |
| Source | `Http/Client/Exception/NetworkException.php` |

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
| [`getRequest(): RequestInterface`](#getrequest) | Returns the request that could not be completed, as handed to the constructor. |

### getRequest()

`public function getRequest(): RequestInterface`

Returns the request that could not be completed, as handed to the constructor.

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
