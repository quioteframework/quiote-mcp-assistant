# InMemoryUserProvider

> A config-driven `UserProviderInterface`, for apps with a small, static user list (the `security.xml` `<provider type=\"in_memory\">` shape).

A config-driven `UserProviderInterface`, for apps with a small, static user list (the `security.xml` `<provider type="in_memory">` shape).

## Synopsis

`final class InMemoryUserProvider implements UserProviderInterface`

|  |  |
|---|---|
| Implements | [`UserProviderInterface`](/api/security/auth/user-provider-interface/) |
| Since | `1.0.0` |
| Source | `Provider/InMemoryUserProvider.php` |

## Constructor

### __construct()

`public function __construct(array<string, array{password_hash: string, roles?: array<int, string>}> $users): mixed`

Keyed by identifier (e.g. email/username).

| Parameter | Type | Description |
|---|---|---|
| `$users` | `array``<``string``, ``array{password_hash: string, roles?: array<int, string>}``>` | Keyed by identifier (e.g. email/username). |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`loadByIdentifier(string $identifier): ?UserIdentity`](#loadbyidentifier) |  |
| [`loadByToken(TokenClaims $claims): null`](#loadbytoken) |  |

### loadByIdentifier()

`public function loadByIdentifier(string $identifier): ?UserIdentity`

E.g. an email or username.

| Parameter | Type | Description |
|---|---|---|
| `$identifier` | `string` | E.g. an email or username. |

Returns `?`[`UserIdentity`](/api/security/auth/user-identity/) — Null if no matching identity exists.

### loadByToken()

`public function loadByToken(TokenClaims $claims): null`

The validated token claims.

| Parameter | Type | Description |
|---|---|---|
| `$claims` | [`TokenClaims`](/api/security/auth/token-claims/) | The validated token claims. |

Returns `null` — Always null: a static, config-driven user list has no token/claim mapping; token-derived identity resolution belongs to a Pdo/CallableUserProvider.
