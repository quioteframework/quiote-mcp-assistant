# TrustedHosts

> The `core.trusted_hosts` allow-list, applied to a hostname taken from the request.

The `core.trusted_hosts` allow-list, applied to a hostname taken from the request.

Every hostname the framework can learn from a request is attacker-controlled: `Host` is written by the client, and `X-Forwarded-Host` / `X-Original-Host` / `Forwarded` are *also* just request headers unless a proxy is known to overwrite them (nothing in a PHP process can tell the difference). Those values feed generated absolute URLs -- base href, the `Location` of a "/"-relative redirect, password-reset links -- so an unfiltered one is a host-header poisoning and cache-poisoning primitive.

This lived inline in [`RequestUrl`](/api/request/request-url/) and so protected only the one path that called it. [`Routing::getBaseHref()`](/api/routing/routing/#getbasehref) resolves a host of its own from `$_SERVER` when no context request is available, and that path went unfiltered -- meaning an application that had correctly configured `core.trusted_hosts` was still poisonable through `X-Forwarded-Host`. Sharing one implementation is what keeps the two from drifting apart again.

A non-matching host is replaced with the first literal entry rather than rejected outright: this runs while building a URL, where there is no response to fail into, and canonicalizing to a host the operator named is both safe and useful. An empty/unset setting applies no restriction at all, which preserves the behaviour of deployments that predate the setting.

## Synopsis

`final class TrustedHosts`

|  |  |
|---|---|
| Since | `3.0.4` |
| Source | `Request/TrustedHosts.php` |

## Methods

| Method | Description |
|---|---|
| [`filter(string $host): string`](#filter) | $host, or the first literal trusted host when $host matches none of them. |
| [`filterAgainst(string $host, array<array-key, mixed> $trustedHosts): string`](#filteragainst) | The filtering itself, against an explicit list. |

### filter()

`public static function filter(string $host): string`

$host, or the first literal trusted host when $host matches none of them.

The hostname resolved from the request.

| Parameter | Type | Description |
|---|---|---|
| `$host` | `string` | The hostname resolved from the request. |

Returns `string` — The hostname to actually use.

### filterAgainst()

`public static function filterAgainst(string $host, array<array-key, mixed> $trustedHosts): string`

The filtering itself, against an explicit list.

The configured entries.

| Parameter | Type | Description |
|---|---|---|
| `$host` | `string` | The hostname resolved from the request. |
| `$trustedHosts` | `array``<``array-key``, ``mixed``>` | The configured entries. |

Returns `string` — The hostname to actually use.
