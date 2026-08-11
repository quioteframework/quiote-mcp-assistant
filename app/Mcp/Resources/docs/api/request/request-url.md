# RequestUrl

> Immutable holder for the URL metadata WebRequest exposes alongside the wrapped PSR-7 request: scheme, host, port, path, query, and the derived request URI / full URL / protocol string.

Immutable holder for the URL metadata WebRequest exposes alongside the wrapped PSR-7 request: scheme, host, port, path, query, and the derived request URI / full URL / protocol string.

## Synopsis

`final class RequestUrl`

|  |  |
|---|---|
| Source | `Request/RequestUrl.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$host` | `string` | _readonly._ |
| `$path` | `string` | _readonly._ |
| `$port` | `int` | _readonly._ |
| `$protocol` | `?``string` | _readonly._ |
| `$query` | `string` | _readonly._ |
| `$requestUri` | `string` | _readonly._ |
| `$scheme` | `string` | _readonly._ |
| `$url` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(?string $protocol = null, string $scheme = '', string $host = '', int $port = 0, string $path = '', string $query = '', string $requestUri = '', string $url = ''): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$protocol` | `?``string` |  |
| `$scheme` | `string` |  |
| `$host` | `string` |  |
| `$port` | `int` |  |
| `$path` | `string` |  |
| `$query` | `string` |  |
| `$requestUri` | `string` |  |
| `$url` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`authority(bool $forcePort = false): string`](#authority) | Returns the authority as `host[:port]`. |
| [`effectivePort(): int`](#effectiveport) | Effective port: falls back to the scheme default (443/80) when unset. |
| [`fromServerParams(array<string, mixed> $server): RequestUrl`](#fromserverparams) | Derive legacy URL metadata from PHP's server parameters when no PSR-7 request is available (e.g. |
| [`fromUri(UriInterface $uri, array<string, mixed> $serverParams, string $protocolVersion): RequestUrl`](#fromuri) | Derive URL metadata from a wrapped PSR-7 request's URI. |
| [`fullUrl(): string`](#fullurl) | Returns the absolute URL, recomputed from the current scheme, authority and request URI rather than from the stored `url` property. |
| [`isHttps(): bool`](#ishttps) | Reports whether the scheme is exactly `https`. |
| [`withHost(string $host): RequestUrl`](#withhost) | Returns a copy using the given host. |
| [`withPath(string $path): RequestUrl`](#withpath) | Returns a copy using the given path. |
| [`withPort(int $port): RequestUrl`](#withport) | Returns a copy using the given port. |
| [`withProtocol(?string $protocol): RequestUrl`](#withprotocol) | Returns a copy using the given protocol string, e.g. |
| [`withQuery(string $query): RequestUrl`](#withquery) | Returns a copy using the given query string, without the leading `?`. |
| [`withRequestUri(string $requestUri): RequestUrl`](#withrequesturi) | Returns a copy whose request URI is the given string. |
| [`withScheme(string $scheme): RequestUrl`](#withscheme) | Returns a copy using the given scheme. |

### authority()

`public function authority(bool $forcePort = false): string`

Returns the authority as `host[:port]`.

The port is appended only when it is not the scheme's default, unless `$forcePort` asks for it unconditionally.

| Parameter | Type | Description |
|---|---|---|
| `$forcePort` | `bool` |  |

Returns `string`

### effectivePort()

`public function effectivePort(): int`

Effective port: falls back to the scheme default (443/80) when unset.

Returns `int`

### fromServerParams()

`public static function fromServerParams(array<string, mixed> $server): RequestUrl`

Derive legacy URL metadata from PHP's server parameters when no PSR-7 request is available (e.g.

| Parameter | Type | Description |
|---|---|---|
| `$server` | `array``<``string``, ``mixed``>` |  |

Returns [`RequestUrl`](/api/request/request-url/)

### fromUri()

`public static function fromUri(UriInterface $uri, array<string, mixed> $serverParams, string $protocolVersion): RequestUrl`

Derive URL metadata from a wrapped PSR-7 request's URI.

| Parameter | Type | Description |
|---|---|---|
| `$uri` | [`UriInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$serverParams` | `array``<``string``, ``mixed``>` |  |
| `$protocolVersion` | `string` |  |

Returns [`RequestUrl`](/api/request/request-url/)

### fullUrl()

`public function fullUrl(): string`

Returns the absolute URL, recomputed from the current scheme, authority and request URI rather than from the stored `url` property.

Returns `string`

### isHttps()

`public function isHttps(): bool`

Reports whether the scheme is exactly `https`.

Returns `bool`

### withHost()

`public function withHost(string $host): RequestUrl`

Returns a copy using the given host.

The host is stored as given, without trusted-host filtering -- that is applied by the factories that read a host off the request.

| Parameter | Type | Description |
|---|---|---|
| `$host` | `string` |  |

Returns [`RequestUrl`](/api/request/request-url/)

### withPath()

`public function withPath(string $path): RequestUrl`

Returns a copy using the given path.

The stored request URI is not rebuilt from it.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns [`RequestUrl`](/api/request/request-url/)

### withPort()

`public function withPort(int $port): RequestUrl`

Returns a copy using the given port.

Pass 0 to leave the port unset, in which case [`RequestUrl::effectivePort()`](/api/request/request-url/#effectiveport) answers with the scheme's default.

| Parameter | Type | Description |
|---|---|---|
| `$port` | `int` |  |

Returns [`RequestUrl`](/api/request/request-url/)

### withProtocol()

`public function withProtocol(?string $protocol): RequestUrl`

Returns a copy using the given protocol string, e.g.

`HTTP/1.1`.

Pass null for a request whose protocol is unknown, such as one built outside a SAPI.

| Parameter | Type | Description |
|---|---|---|
| `$protocol` | `?``string` |  |

Returns [`RequestUrl`](/api/request/request-url/)

### withQuery()

`public function withQuery(string $query): RequestUrl`

Returns a copy using the given query string, without the leading `?`.

The stored request URI is not rebuilt from it.

| Parameter | Type | Description |
|---|---|---|
| `$query` | `string` |  |

Returns [`RequestUrl`](/api/request/request-url/)

### withRequestUri()

`public function withRequestUri(string $requestUri): RequestUrl`

Returns a copy whose request URI is the given string.

The path and query components are kept as they are, so a caller replacing the request URI is responsible for keeping them in step.

| Parameter | Type | Description |
|---|---|---|
| `$requestUri` | `string` |  |

Returns [`RequestUrl`](/api/request/request-url/)

### withScheme()

`public function withScheme(string $scheme): RequestUrl`

Returns a copy using the given scheme.

The stored request URI and full URL are carried over untouched, so they keep whatever they were derived from; [`RequestUrl::fullUrl()`](/api/request/request-url/#fullurl) recomputes the absolute URL from the current scheme, host and port instead.

| Parameter | Type | Description |
|---|---|---|
| `$scheme` | `string` |  |

Returns [`RequestUrl`](/api/request/request-url/)
