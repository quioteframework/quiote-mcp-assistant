# CookieSerializer

> Bridges cookies queued on a Quiote response onto a PSR-7 response's `Set-Cookie` headers.

Bridges cookies queued on a Quiote response onto a PSR-7 response's `Set-Cookie` headers.

The response is duck-typed rather than declared, so a middleware can hand over whatever the controller gave it without first proving it is a [`WebResponse`](/api/response/web-response/). The serialization itself belongs to [`CookieSerializer`](/api/response/cookie-serializer/), which is the one implementation of the `Set-Cookie` format in the framework; this class only locates the cookies and merges the resulting lines.

## Synopsis

`final class CookieSerializer`

|  |  |
|---|---|
| Source | `Http/CookieSerializer.php` |

## Methods

| Method | Description |
|---|---|
| [`bridge(object $globalResp, ResponseInterface $response, string $basePath = '/'): ResponseInterface`](#bridge) | Append Set-Cookie headers from $globalResp to $response. |

### bridge()

`public static function bridge(object $globalResp, ResponseInterface $response, string $basePath = '/'): ResponseInterface`

Append Set-Cookie headers from $globalResp to $response.

Default path for cookies without explicit path.

| Parameter | Type | Description |
|---|---|---|
| `$globalResp` | `object` | Quiote web response object (duck-typed). |
| `$response` | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) | PSR-7 response to append headers to. |
| `$basePath` | `string` | Default path for cookies without explicit path. |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) — The (immutably) updated response.
