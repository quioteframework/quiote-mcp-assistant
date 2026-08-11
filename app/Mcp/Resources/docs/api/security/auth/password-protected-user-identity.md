# PasswordProtectedUserIdentity

> A UserIdentity that can be checked against a password, resolved by `InMemoryUserProvider`/`PdoUserProvider`/`CallableUserProvider` and consumed by `FormLoginAuthenticator`/`HttpBasicAuthenticator` via PasswordHasherInterface.

A [`UserIdentity`](/api/security/auth/user-identity/) that can be checked against a password, resolved by `InMemoryUserProvider`/`PdoUserProvider`/`CallableUserProvider` and consumed by `FormLoginAuthenticator`/`HttpBasicAuthenticator` via [`PasswordHasherInterface`](/api/security/auth/password-hasher-interface/).

## Synopsis

`interface PasswordProtectedUserIdentity extends UserIdentity`

|  |  |
|---|---|
| Implements | [`UserIdentity`](/api/security/auth/user-identity/) |
| Implemented by | [`InMemoryUserIdentity`](/api/security/auth/identity/in-memory-user-identity/) |
| Since | `1.0.0` |
| Source | `PasswordProtectedUserIdentity.php` |

## Methods

| Method | Description |
|---|---|
| [`getPasswordHash(): string`](#getpasswordhash) |  |

### getPasswordHash()

`abstract public function getPasswordHash(): string`

Returns `string` — The stored password hash, suitable for [`PasswordHasherInterface::verify()`](/api/security/auth/password-hasher-interface/#verify).

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `getIdentifier()` | [`UserIdentity`](/api/security/auth/user-identity/) | The value [`UserProviderInterface::loadByIdentifier()`](/api/security/auth/user-provider-interface/#loadbyidentifier) was called with (e.g. |
| `getRoles()` | [`UserIdentity`](/api/security/auth/user-identity/) |  |
