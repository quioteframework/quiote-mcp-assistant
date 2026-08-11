# UserIdentity

> The identity a UserProviderInterface resolves a credential to, before it is mapped onto a `Quiote\\User\\SecurityUser`/`RbacSecurityUser` by `Quiote\\Security\\Auth\\AuthenticationManager` (`packages/auth`).

The identity a [`UserProviderInterface`](/api/security/auth/user-provider-interface/) resolves a credential to, before it is mapped onto a `Quiote\User\SecurityUser`/`RbacSecurityUser` by `Quiote\Security\Auth\AuthenticationManager` (`packages/auth`).

Deliberately minimal: password hash/roles/credentials are provider-specific concerns exposed through whatever shape the provider's own backend needs; this contract only guarantees a stable identifier to key session/credential storage on.

## Synopsis

`interface UserIdentity`

|  |  |
|---|---|
| Implemented by | [`PasswordProtectedUserIdentity`](/api/security/auth/password-protected-user-identity/) |
| Since | `1.0.0` |
| Source | `Security/Auth/UserIdentity.php` |

## Methods

| Method | Description |
|---|---|
| [`getIdentifier(): string`](#getidentifier) | The value [`UserProviderInterface::loadByIdentifier()`](/api/security/auth/user-provider-interface/#loadbyidentifier) was called with (e.g. |
| [`getRoles(): array<int, string>`](#getroles) |  |

### getIdentifier()

`abstract public function getIdentifier(): string`

The value [`UserProviderInterface::loadByIdentifier()`](/api/security/auth/user-provider-interface/#loadbyidentifier) was called with (e.g.

an email or username) — stable across requests.

Returns `string` — This identity's stable identifier.

### getRoles()

`abstract public function getRoles(): array<int, string>`

Returns `array``<``int``, ``string``>` — Role/permission credentials to grant on the SecurityUser.
