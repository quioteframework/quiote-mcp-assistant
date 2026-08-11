# ForwardedAuthority

> The scheme/host/port a reverse proxy says the client actually used, as resolved by ForwardedHeaderResolver.

The scheme/host/port a reverse proxy says the client actually used, as resolved by [`ForwardedHeaderResolver`](/api/runtime/proxy/forwarded-header-resolver/).

Any field may be null when the corresponding header was absent or unusable.

$portExplicit distinguishes "the proxy told us a port" from "we inferred * nothing": only an explicit port is written back into the request's SERVER_PORT / authority, so a plain `X-Forwarded-Proto: https` does not silently pin port 80 from the original connection.

## Synopsis

`final readonly class ForwardedAuthority`

|  |  |
|---|---|
| Source | `Runtime/Proxy/ForwardedAuthority.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$host` | `?``string` | _readonly._ |
| `$port` | `?``int` | _readonly._ |
| `$portExplicit` | `bool` | _readonly._ |
| `$scheme` | `?``string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(?string $scheme = null, ?string $host = null, ?int $port = null, bool $portExplicit = false): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$scheme` | `?``string` |  |
| `$host` | `?``string` |  |
| `$port` | `?``int` |  |
| `$portExplicit` | `bool` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`isEmpty(): bool`](#isempty) | True when there is nothing to apply, so callers can skip the rewrite entirely. |

### isEmpty()

`public function isEmpty(): bool`

True when there is nothing to apply, so callers can skip the rewrite entirely.

Returns `bool`
