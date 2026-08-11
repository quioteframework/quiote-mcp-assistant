# TokenValidatorInterface

> Verifies a bearer token's signature and standard time claims (`exp`/`nbf`/`iat`) and returns its raw claim set.

Verifies a bearer token's signature and standard time claims (`exp`/`nbf`/`iat`) and returns its raw claim set.

Implementations own algorithm allow-listing and key resolution (shared secret, JWKS, ...); `iss`/`aud` pinning must also be enforced by the implementation, per RFC 8725 -- a JWS library only guarantees signature and time validity, never audience restriction.

## Synopsis

`interface TokenValidatorInterface`

|  |  |
|---|---|
| Implemented by | [`JwtTokenValidator`](/api/security/auth/jwt-token-validator/) |
| Since | `1.0.0` |
| Source | `TokenValidatorInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`validate(string $token): array<string, mixed>`](#validate) |  |

### validate()

`abstract public function validate(string $token): array<string, mixed>`

The raw, encoded token (e.g. the value after `Bearer `).

| Parameter | Type | Description |
|---|---|---|
| `$token` | `string` | The raw, encoded token (e.g. the value after `Bearer `). |

Returns `array``<``string``, ``mixed``>` — The validated, raw claim set.

| Throws | When |
|---|---|
| `AuthenticationException` | If the token is malformed, expired, or fails signature/iss/aud checks. |
