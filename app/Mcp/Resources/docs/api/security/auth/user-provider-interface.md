# UserProviderInterface

> Loads a UserIdentity either by a stable identifier (form login, HTTP Basic) or from validated token claims (bearer/JWT/OIDC).

Loads a [`UserIdentity`](/api/security/auth/user-identity/) either by a stable identifier (form login, HTTP Basic) or from validated token claims (bearer/JWT/OIDC).

Backends: an in-memory config-driven provider, a PDO-backed provider reusing `DatabaseManager`, or a callable-based provider for app-custom lookups.

## Synopsis

`interface UserProviderInterface`

|  |  |
|---|---|
| Implemented by | [`CallableUserProvider`](/api/security/auth/provider/callable-user-provider/), [`InMemoryUserProvider`](/api/security/auth/provider/in-memory-user-provider/), [`PdoUserProvider`](/api/security/auth/provider/pdo-user-provider/) |
| Since | `1.0.0` |
| Source | `Security/Auth/UserProviderInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`loadByIdentifier(string $identifier): ?UserIdentity`](#loadbyidentifier) |  |
| [`loadByToken(TokenClaims $claims): ?UserIdentity`](#loadbytoken) | Maps validated token claims (e.g. |

### loadByIdentifier()

`abstract public function loadByIdentifier(string $identifier): ?UserIdentity`

E.g. an email or username.

| Parameter | Type | Description |
|---|---|---|
| `$identifier` | `string` | E.g. an email or username. |

Returns `?`[`UserIdentity`](/api/security/auth/user-identity/) — Null if no matching identity exists.

### loadByToken()

`abstract public function loadByToken(TokenClaims $claims): ?UserIdentity`

Maps validated token claims (e.g.

The validated token claims (see [`TokenValidatorInterface`](/api/security/auth/token-validator-interface/)).

| Parameter | Type | Description |
|---|---|---|
| `$claims` | [`TokenClaims`](/api/security/auth/token-claims/) | The validated token claims (see [`TokenValidatorInterface`](/api/security/auth/token-validator-interface/)). |

Returns `?`[`UserIdentity`](/api/security/auth/user-identity/) — Null if the claims don't resolve to a known identity.
