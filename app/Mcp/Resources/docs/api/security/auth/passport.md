# Passport

> The resolved outcome of a successful AuthenticatorInterface::authenticate() call: the identity plus the credentials/roles to grant, and whether the identity is stateless (re-derived from the credential every request rather than read back from the session).

The resolved outcome of a successful [`AuthenticatorInterface::authenticate()`](/api/security/auth/authenticator-interface/#authenticate) call: the identity plus the credentials/roles to grant, and whether the identity is stateless (re-derived from the credential every request rather than read back from the session).

Consumed by `Quiote\Security\Auth\AuthenticationManager` (`packages/auth`) to populate a `SecurityUser`/`RbacSecurityUser`.

## Synopsis

`final class Passport`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Security/Auth/Passport.php` |

## Constructor

### __construct()

`public function __construct(UserIdentity $identity, array<int, string> $credentials = [], bool $stateless = false, ?TokenClaims $claims = null): mixed`

The token this passport was derived from, if any (see getClaims()).

| Parameter | Type | Description |
|---|---|---|
| `$identity` | [`UserIdentity`](/api/security/auth/user-identity/) | The resolved identity. |
| `$credentials` | `array``<``int``, ``string``>` | Roles/permissions to grant on the SecurityUser. |
| `$stateless` | `bool` | True if the identity is re-derived from the credential every request. |
| `$claims` | `?`[`TokenClaims`](/api/security/auth/token-claims/) | The token this passport was derived from, if any (see getClaims()). |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getClaims(): ?TokenClaims`](#getclaims) | The token claims this passport was derived from, if the authenticator that produced it was token-based (bearer/JWT/OIDC). |
| [`getCredentials(): array<int, string>`](#getcredentials) |  |
| [`getIdentity(): UserIdentity`](#getidentity) |  |
| [`isStateless(): bool`](#isstateless) |  |

### getClaims()

`public function getClaims(): ?TokenClaims`

The token claims this passport was derived from, if the authenticator that produced it was token-based (bearer/JWT/OIDC).

Returns `?`[`TokenClaims`](/api/security/auth/token-claims/) — The token claims, or null for a non-token authenticator (form login, HTTP Basic).

### getCredentials()

`public function getCredentials(): array<int, string>`

Returns `array``<``int``, ``string``>` — Roles/permissions to grant on the SecurityUser.

### getIdentity()

`public function getIdentity(): UserIdentity`

Returns [`UserIdentity`](/api/security/auth/user-identity/) — The identity resolved by the authenticator.

### isStateless()

`public function isStateless(): bool`

Returns `bool` — True if the identity is re-derived from the credential every request, otherwise false.
