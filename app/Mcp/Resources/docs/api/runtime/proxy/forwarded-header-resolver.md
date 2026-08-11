# ForwardedHeaderResolver

> Reads the reverse-proxy headers off a PSR-7 request and reports the scheme/host/port the client actually used.

Reads the reverse-proxy headers off a PSR-7 request and reports the scheme/host/port the client actually used.

Pure: no superglobal access, no mutation. That matters because the same correction has to apply to requests a CLI-hosted worker server hands us (RoadRunner, Swoole), where there is no $_SERVER to adjust -- previously this logic lived in Kernel and worked by writing to $_SERVER directly, which only ever worked under a real SAPI.

Precedence per field: the explicit X-* header wins, then RFC 7239 `Forwarded`. X-Original-Host is checked before X-Forwarded-Host because proxies that rewrite Host (Azure Application Gateway, some ingress controllers) put the client's original value there.

Note: every proxy header is trusted unconditionally when enabled. There is no trusted-proxy allowlist; an app reachable directly from the internet should set `core.proxy.trust_forwarded_headers` to false.

## Synopsis

`final class ForwardedHeaderResolver`

|  |  |
|---|---|
| Source | `Runtime/Proxy/ForwardedHeaderResolver.php` |

## Methods

| Method | Description |
|---|---|
| [`formatAuthorityHost(string $host): string`](#formatauthorityhost) | Formats a host for use in an authority: bare IPv6 literals need bracketing, everything else passes through. |
| [`isPortNonDefault(?string $scheme, int $port): bool`](#isportnondefault) | Whether $port needs to appear in an authority at all for $scheme. |
| [`resolve(ServerRequestInterface $request): ForwardedAuthority`](#resolve) | Reports the scheme, host and port the client used, per the proxy headers. |

### formatAuthorityHost()

`public static function formatAuthorityHost(string $host): string`

Formats a host for use in an authority: bare IPv6 literals need bracketing, everything else passes through.

| Parameter | Type | Description |
|---|---|---|
| `$host` | `string` |  |

Returns `string`

### isPortNonDefault()

`public static function isPortNonDefault(?string $scheme, int $port): bool`

Whether $port needs to appear in an authority at all for $scheme.

| Parameter | Type | Description |
|---|---|---|
| `$scheme` | `?``string` |  |
| `$port` | `int` |  |

Returns `bool`

### resolve()

`public function resolve(ServerRequestInterface $request): ForwardedAuthority`

Reports the scheme, host and port the client used, per the proxy headers.

Each field is taken from its X-* header if present, otherwise from the matching parameter of an RFC 7239 `Forwarded` header, using only the first entry in a comma-separated chain. A host that carries its own port wins over `X-Forwarded-Port`. When none of the three headers is present, an empty [`ForwardedAuthority`](/api/runtime/proxy/forwarded-authority/) comes back, meaning "no correction".

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns [`ForwardedAuthority`](/api/runtime/proxy/forwarded-authority/)
