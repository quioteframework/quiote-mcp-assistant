# FirewallMap

> An ordered list of Firewall definitions, matched by request path.

An ordered list of [`Firewall`](/api/security/auth/firewall/) definitions, matched by request path.

Shared by `Quiote\Security\Auth\Middleware\StatelessAuthenticationMiddleware` and `Quiote\Security\Auth\Middleware\SessionAuthenticationMiddleware` so both middleware placements agree on the same firewall configuration.

## Synopsis

`final class FirewallMap`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `FirewallMap.php` |

## Constructor

### __construct()

`public function __construct(array<Firewall> $firewalls): mixed`

Checked in order; the first match wins.

| Parameter | Type | Description |
|---|---|---|
| `$firewalls` | `array``<`[`Firewall`](/api/security/auth/firewall/)`>` | Checked in order; the first match wins. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`all(): array<Firewall>`](#all) |  |
| [`match(string $path): ?Firewall`](#match) |  |

### all()

`public function all(): array<Firewall>`

Returns `array``<`[`Firewall`](/api/security/auth/firewall/)`>` — Every firewall in this map, in match order.

### match()

`public function match(string $path): ?Firewall`

The request path to match (e.g. `$request->getUri()->getPath()`).

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | The request path to match (e.g. `$request->getUri()->getPath()`). |

Returns `?`[`Firewall`](/api/security/auth/firewall/) — The first firewall whose pattern matches $path, or null if none match.
