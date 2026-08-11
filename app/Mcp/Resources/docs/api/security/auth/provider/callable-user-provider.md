# CallableUserProvider

> Delegates identity/claim resolution to app-supplied callables, for lookups that don't fit `InMemoryUserProvider`'s static list or `PdoUserProvider`'s single-table convention (e.g.

Delegates identity/claim resolution to app-supplied callables, for lookups that don't fit `InMemoryUserProvider`'s static list or `PdoUserProvider`'s single-table convention (e.g.

joining across services, calling a legacy API).

## Synopsis

`final class CallableUserProvider implements UserProviderInterface`

|  |  |
|---|---|
| Implements | [`UserProviderInterface`](/api/security/auth/user-provider-interface/) |
| Since | `1.0.0` |
| Source | `Provider/CallableUserProvider.php` |

## Constructor

### __construct()

`public function __construct(callable(string): ?UserIdentity $byIdentifier, callable(TokenClaims): ?UserIdentity|null $byToken = null): mixed`

Resolves validated token claims to an identity, if token-based auth is used.

| Parameter | Type | Description |
|---|---|---|
| `$byIdentifier` | `callable(string): ?UserIdentity` | Resolves an identifier (e.g. email/username) to an identity. |
| `$byToken` | `callable(TokenClaims): ?UserIdentity``|``null` | Resolves validated token claims to an identity, if token-based auth is used. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`loadByIdentifier(string $identifier): ?UserIdentity`](#loadbyidentifier) |  |
| [`loadByToken(TokenClaims $claims): ?UserIdentity`](#loadbytoken) |  |

### loadByIdentifier()

`public function loadByIdentifier(string $identifier): ?UserIdentity`

E.g. an email or username.

| Parameter | Type | Description |
|---|---|---|
| `$identifier` | `string` | E.g. an email or username. |

Returns `?`[`UserIdentity`](/api/security/auth/user-identity/) — Whatever the $byIdentifier callable returns.

### loadByToken()

`public function loadByToken(TokenClaims $claims): ?UserIdentity`

The validated token claims.

| Parameter | Type | Description |
|---|---|---|
| `$claims` | [`TokenClaims`](/api/security/auth/token-claims/) | The validated token claims. |

Returns `?`[`UserIdentity`](/api/security/auth/user-identity/) — Whatever the $byToken callable returns, or null if none was supplied.
