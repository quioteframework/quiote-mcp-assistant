# ClientType

> Distinguishes a human end-user from a machine/service caller, per the RFC 9068 rule applied by ClientTypeResolverInterface: `Service` when the token's `sub` equals its `client_id`/`azp`, otherwise `User`.

Distinguishes a human end-user from a machine/service caller, per the RFC 9068 rule applied by [`ClientTypeResolverInterface`](/api/security/auth/client-type-resolver-interface/): `Service` when the token's `sub` equals its `client_id`/`azp`, otherwise `User`.

A `Service` client type is what flips a request to sessionless (no session started at all) for a stateless firewall.

## Synopsis

`enum ClientType: string`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Security/Auth/ClientType.php` |

## Cases

| Case | Value | Description |
|---|---|---|
| `User` | `'user'` | A human end-user, authenticated on their own behalf. |
| `Service` | `'service'` | A machine/service caller (e.g. |

## Properties

| Property | Type | Description |
|---|---|---|
| `$name` | `string` | _readonly._ |
| `$value` | `string` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`cases(): array`](#cases) |  |
| [`from(string|int $value): static`](#from) |  |
| [`tryFrom(string|int $value): ?static`](#tryfrom) |  |

### cases()

`public static function cases(): array`

Returns `array`

### from()

`public static function from(string|int $value): static`

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string``|``int` |  |

Returns `static`

### tryFrom()

`public static function tryFrom(string|int $value): ?static`

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string``|``int` |  |

Returns `?``static`
