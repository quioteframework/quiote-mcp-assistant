# TokenClaims

> Validated claims from a bearer/JWT/OIDC token, plus the ClientType derived from them by a ClientTypeResolverInterface.

Validated claims from a bearer/JWT/OIDC token, plus the [`ClientType`](/api/security/auth/client-type/) derived from them by a [`ClientTypeResolverInterface`](/api/security/auth/client-type-resolver-interface/).

Immutable value object; produced by a token validator, consumed by [`UserProviderInterface::loadByToken()`](/api/security/auth/user-provider-interface/#loadbytoken).

## Synopsis

`final class TokenClaims`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Security/Auth/TokenClaims.php` |

## Constructor

### __construct()

`public function __construct(string $subject, array<string, mixed> $claims, ClientType $clientType): mixed`

Human vs. machine, per RFC 9068.

| Parameter | Type | Description |
|---|---|---|
| `$subject` | `string` | The token's `sub` claim. |
| `$claims` | `array``<``string``, ``mixed``>` | The full, already-validated claim set. |
| `$clientType` | [`ClientType`](/api/security/auth/client-type/) | Human vs. machine, per RFC 9068. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getClaim(string $name, mixed $default = null): mixed`](#getclaim) |  |
| [`getClaims(): array<string, mixed>`](#getclaims) |  |
| [`getClientType(): ClientType`](#getclienttype) |  |
| [`getSubject(): string`](#getsubject) |  |
| [`isService(): bool`](#isservice) |  |

### getClaim()

`public function getClaim(string $name, mixed $default = null): mixed`

The value to return if $name is absent.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The claim name (e.g. `sub`, `scope`, `aud`). |
| `$default` | `mixed` | The value to return if $name is absent. |

Returns `mixed` — The raw value of a single claim, or $default if absent.

### getClaims()

`public function getClaims(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>` — The full, already-validated claim set.

### getClientType()

`public function getClientType(): ClientType`

Returns [`ClientType`](/api/security/auth/client-type/) — Human vs. machine, per RFC 9068.

### getSubject()

`public function getSubject(): string`

Returns `string` — The token's `sub` claim.

### isService()

`public function isService(): bool`

Returns `bool` — True if getClientType() is [`ClientType::Service`](/api/security/auth/client-type/#service), otherwise false.
