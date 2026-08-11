# InMemoryUserIdentity

> A plain value-object PasswordProtectedUserIdentity, returned by every foundation `UserProviderInterface` implementation (`InMemoryUserProvider`, `PdoUserProvider`, `CallableUserProvider`).

A plain value-object [`PasswordProtectedUserIdentity`](/api/security/auth/password-protected-user-identity/), returned by every foundation `UserProviderInterface` implementation (`InMemoryUserProvider`, `PdoUserProvider`, `CallableUserProvider`).

## Synopsis

`final class InMemoryUserIdentity implements PasswordProtectedUserIdentity`

|  |  |
|---|---|
| Implements | [`PasswordProtectedUserIdentity`](/api/security/auth/password-protected-user-identity/) |
| Since | `1.0.0` |
| Source | `Identity/InMemoryUserIdentity.php` |

## Constructor

### __construct()

`public function __construct(string $identifier, string $passwordHash, array<int, string> $roles = []): mixed`

Roles/permissions to grant on the SecurityUser.

| Parameter | Type | Description |
|---|---|---|
| `$identifier` | `string` | The stable identifier (e.g. email/username). |
| `$passwordHash` | `string` | The stored password hash. |
| `$roles` | `array``<``int``, ``string``>` | Roles/permissions to grant on the SecurityUser. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getIdentifier(): string`](#getidentifier) | The value `UserProviderInterface::loadByIdentifier()` was called with (e.g. |
| [`getPasswordHash(): string`](#getpasswordhash) |  |
| [`getRoles(): array<int, string>`](#getroles) |  |

### getIdentifier()

`public function getIdentifier(): string`

The value `UserProviderInterface::loadByIdentifier()` was called with (e.g.

an email or username) — stable across requests.

Returns `string` — This identity's stable identifier.

### getPasswordHash()

`public function getPasswordHash(): string`

Returns `string` — The stored password hash.

### getRoles()

`public function getRoles(): array<int, string>`

Returns `array``<``int``, ``string``>` — Roles/permissions to grant on the SecurityUser.
