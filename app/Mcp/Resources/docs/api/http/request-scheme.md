# RequestScheme

> Whether a PSR-7 request reached the client over TLS.

Whether a PSR-7 request reached the client over TLS.

The URI's own scheme is not enough on its own. Behind a TLS-terminating proxy -- the ordinary production shape -- the connection this process sees is plain HTTP, so `$request->getUri()->getScheme()` answers `http` for a request the browser made over `https`. Anything deciding on "is this connection * secure" from that alone silently does the wrong thing in exactly the deployment where it matters: [`SecurityHeadersMiddleware`](/api/security/headers/security-headers-middleware/) never emitted HSTS, and a `Secure` cookie attribute would be dropped.

The forwarded header is consulted last and only when `core.proxy.trust_forwarded_headers` is on (the default, matching [`ForwardedHeaderResolver`](/api/runtime/proxy/forwarded-header-resolver/)). It is client-supplied, so an application reachable directly from the internet should turn that setting off -- otherwise any caller can claim its plaintext request was secure.

## Synopsis

`final class RequestScheme`

|  |  |
|---|---|
| Since | `3.0.4` |
| Source | `Http/RequestScheme.php` |

## Methods

| Method | Description |
|---|---|
| [`isHttps(ServerRequestInterface $request): bool`](#ishttps) | Whether the client's connection was over TLS. |

### isHttps()

`public static function isHttps(ServerRequestInterface $request): bool`

Whether the client's connection was over TLS.

Four sources are consulted in order, and the first that says "secure" wins: the URI scheme, the `HTTPS` server param (true, or any scalar other than an empty string, `off` or `0`), `REQUEST_SCHEME`, and finally the leftmost token of `X-Forwarded-Proto`. The forwarded header is only read when `core.proxy.trust_forwarded_headers` is on; with it off, a request that reached this process as plain HTTP reports false no matter what the client claims.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns `bool`
