# ClientAddress

> The connecting peer's address, for use as a throttle key.

The connecting peer's address, for use as a throttle key.

Deliberately `REMOTE_ADDR` and never a client-supplied forwarding header (`X-Forwarded-For`, `Forwarded`, ...): a spoofable key lets an attacker present a fresh one on every request, which is indistinguishable from no throttling at all. A deployment that genuinely sits behind a trusted proxy has to make `REMOTE_ADDR` correct at the proxy boundary rather than have every authenticator second-guess the header.

Null when the peer is unknown (CLI, a synthesized request, some worker runtimes). Callers must treat that as "no client key available" and fall back to their identifier-scoped key alone, never as a shared literal -- bucketing every unknown-peer attempt under one key would let one caller exhaust the allowance for all of them.

## Synopsis

`final class ClientAddress`

|  |  |
|---|---|
| Since | `3.0.4` |
| Source | `ClientAddress.php` |

## Methods

| Method | Description |
|---|---|
| [`fromRequest(ServerRequestInterface $request): ?string`](#fromrequest) |  |

### fromRequest()

`public static function fromRequest(ServerRequestInterface $request): ?string`

The incoming request.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The incoming request. |

Returns `?``string` — The peer address, or null when it is unknown.
