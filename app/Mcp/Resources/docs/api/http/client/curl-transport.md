# CurlTransport

> Zero-dependency PSR-18 transport built on ext-curl and the Nyholm PSR-17 factory (already a hard framework dependency).

Zero-dependency PSR-18 transport built on ext-curl and the Nyholm PSR-17 factory (already a hard framework dependency).

This is the default transport so the HTTP client abstraction works out of the box with no extra Composer package; [`TransportFactory`](/api/http/client/transport-factory/) prefers Guzzle when it is installed.

Failure mapping follows PSR-18: a connectivity failure (DNS, refused, reset, timeout) throws [`NetworkException`](/api/http/client/exception/network-exception/); an unusable request throws [`RequestException`](/api/http/client/exception/request-exception/); a real HTTP response — including 4xx/5xx — is returned, never thrown (status handling is the caller's job).

## Synopsis

`final class CurlTransport implements ClientInterface`

|  |  |
|---|---|
| Implements | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |
| Source | `Http/Client/CurlTransport.php` |

## Constructor

### __construct()

`public function __construct(ResponseFactoryInterface $responseFactory = new Psr17Factory(…), StreamFactoryInterface $streamFactory = new Psr17Factory(…), float $timeoutSeconds = 30.0, float $connectTimeoutSeconds = 10.0): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$responseFactory` | `ResponseFactoryInterface` |  |
| `$streamFactory` | `StreamFactoryInterface` |  |
| `$timeoutSeconds` | `float` |  |
| `$connectTimeoutSeconds` | `float` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`sendRequest(RequestInterface $request): ResponseInterface`](#sendrequest) | Performs the request with curl and builds a PSR-7 response from the result. |

### sendRequest()

`public function sendRequest(RequestInterface $request): ResponseInterface`

Performs the request with curl and builds a PSR-7 response from the result.

Redirects are not followed, so a 3xx is returned as-is; response headers are collected line by line and re-added to the response, preserving repeated names. Any HTTP status, including 4xx and 5xx, is returned rather than thrown.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`RequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

| Throws | When |
|---|---|
| `NetworkException` | when curl reports a connectivity-level failure (DNS, connect, timeout, TLS handshake, or a truncated exchange) |
| `RequestException` | when the URI or the HTTP method is empty, or curl fails for any other reason |
