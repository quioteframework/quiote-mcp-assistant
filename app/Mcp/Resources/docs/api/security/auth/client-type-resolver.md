# ClientTypeResolver

> The default ClientTypeResolverInterface: applies the RFC 9068 rule -- `service` when the token's `sub` equals its `client_id`/`azp` (the authority mints machine/client-credentials tokens this way), otherwise `user`.

The default [`ClientTypeResolverInterface`](/api/security/auth/client-type-resolver-interface/): applies the RFC 9068 rule -- `service` when the token's `sub` equals its `client_id`/`azp` (the authority mints machine/client-credentials tokens this way), otherwise `user`.

An app wanting different logic replaces this service (registered by [`JwtAuthPlugin`](/api/security/auth/jwt-auth-plugin/)) rather than toggling a framework flag.

## Synopsis

`final class ClientTypeResolver implements ClientTypeResolverInterface`

|  |  |
|---|---|
| Implements | [`ClientTypeResolverInterface`](/api/security/auth/client-type-resolver-interface/) |
| Since | `1.0.0` |
| Source | `ClientTypeResolver.php` |

## Methods

| Method | Description |
|---|---|
| [`resolve(array<string, mixed> $claims): ClientType`](#resolve) |  |

### resolve()

`public function resolve(array<string, mixed> $claims): ClientType`

The validated, raw claim set.

| Parameter | Type | Description |
|---|---|---|
| `$claims` | `array``<``string``, ``mixed``>` | The validated, raw claim set. |

Returns [`ClientType`](/api/security/auth/client-type/) — [`ClientType::Service`](/api/security/auth/client-type/#service) when `sub === client_id`/`azp`, otherwise [`ClientType::User`](/api/security/auth/client-type/#user).
