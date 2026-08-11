# JwtTokenValidator

> Verifies a JWS via `firebase/php-jwt` (JWKS + rotation via CachedKeySet for RS256/ES256, or a single Key for a shared HS256 secret) and enforces `iss`/`aud` -- the library itself only checks `exp`/`nbf`/`iat`.

Verifies a JWS via `firebase/php-jwt` (JWKS + rotation via `CachedKeySet` for RS256/ES256, or a single `Key` for a shared HS256 secret) and enforces `iss`/`aud` -- the library itself only checks `exp`/`nbf`/`iat`.

Callers are responsible for binding $key to `RS256`/`ES256` only (never mixing in a symmetric key), which is a property of how $key is constructed, not this class.

## Synopsis

`final class JwtTokenValidator implements TokenValidatorInterface`

|  |  |
|---|---|
| Implements | [`TokenValidatorInterface`](/api/security/auth/token-validator-interface/) |
| Since | `1.0.0` |
| Source | `JwtTokenValidator.php` |

## Constructor

### __construct()

`public function __construct(Key|array<string, Key>|CachedKeySet $key, string $issuer, string $audience, int $leeway = 60): mixed`

Clock-skew allowance in seconds applied to `exp`/`nbf`/`iat` (~60 is a reasonable default).

| Parameter | Type | Description |
|---|---|---|
| `$key` | `Key``|``array``<``string``, ``Key``>``|``CachedKeySet` | A single key (shared HS256 secret), a kid-keyed array of keys, or a JWKS-backed `CachedKeySet`. |
| `$issuer` | `string` | The expected `iss` claim (the token authority). |
| `$audience` | `string` | The expected `aud` claim (this resource's identifier). |
| `$leeway` | `int` | Clock-skew allowance in seconds applied to `exp`/`nbf`/`iat` (~60 is a reasonable default). |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`validate(string $token): array<string, mixed>`](#validate) |  |

### validate()

`public function validate(string $token): array<string, mixed>`

The raw, encoded token (e.g. the value after `Bearer `).

| Parameter | Type | Description |
|---|---|---|
| `$token` | `string` | The raw, encoded token (e.g. the value after `Bearer `). |

Returns `array``<``string``, ``mixed``>` — The validated, raw claim set.

| Throws | When |
|---|---|
| `AuthenticationException` | If the token is malformed, expired, or fails signature/iss/aud checks. |
