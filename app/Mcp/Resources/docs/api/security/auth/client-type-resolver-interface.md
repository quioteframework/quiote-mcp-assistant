# ClientTypeResolverInterface

> Derives ClientType from a set of already-validated token claims.

Derives [`ClientType`](/api/security/auth/client-type/) from a set of already-validated token claims.

The default implementation applies the RFC 9068 rule (`service` when `sub === client_id`/`azp`, else `user`); an app that needs different logic swaps this service rather than toggling a framework flag.

## Synopsis

`interface ClientTypeResolverInterface`

|  |  |
|---|---|
| Implemented by | [`ClientTypeResolver`](/api/security/auth/client-type-resolver/) |
| Since | `1.0.0` |
| Source | `Security/Auth/ClientTypeResolverInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`resolve(array<string, mixed> $claims): ClientType`](#resolve) |  |

### resolve()

`abstract public function resolve(array<string, mixed> $claims): ClientType`

The validated, raw claim set (pre-[`TokenClaims`](/api/security/auth/token-claims/)).

| Parameter | Type | Description |
|---|---|---|
| `$claims` | `array``<``string``, ``mixed``>` | The validated, raw claim set (pre-[`TokenClaims`](/api/security/auth/token-claims/)). |

Returns [`ClientType`](/api/security/auth/client-type/) — Human vs. machine, per RFC 9068.
