# PasswordHasherInterface

> Thin contract over PHP's `password_hash()` family, so `FormLoginAuthenticator`/`HttpBasicAuthenticator` (both in the future `packages/auth`) depend on an interface rather than the global functions directly.

Thin contract over PHP's `password_hash()` family, so `FormLoginAuthenticator`/`HttpBasicAuthenticator` (both in the future `packages/auth`) depend on an interface rather than the global functions directly.

Default implementation: argon2id, bcrypt fallback.

## Synopsis

`interface PasswordHasherInterface`

|  |  |
|---|---|
| Implemented by | [`DefaultPasswordHasher`](/api/security/auth/hasher/default-password-hasher/) |
| Since | `1.0.0` |
| Source | `Security/Auth/PasswordHasherInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`hash(string $plaintext): string`](#hash) |  |
| [`needsRehash(string $hash): bool`](#needsrehash) | True if $hash was produced with weaker-than-current-default parameters (algorithm/cost) and should be re-hashed on next successful verify. |
| [`verify(string $plaintext, string $hash): bool`](#verify) |  |

### hash()

`abstract public function hash(string $plaintext): string`

The plaintext password to hash.

| Parameter | Type | Description |
|---|---|---|
| `$plaintext` | `string` | The plaintext password to hash. |

Returns `string` — The resulting hash, suitable for storage.

### needsRehash()

`abstract public function needsRehash(string $hash): bool`

True if $hash was produced with weaker-than-current-default parameters (algorithm/cost) and should be re-hashed on next successful verify.

A previously-stored hash (see hash()).

| Parameter | Type | Description |
|---|---|---|
| `$hash` | `string` | A previously-stored hash (see hash()). |

Returns `bool` — True if $hash should be re-hashed, otherwise false.

### verify()

`abstract public function verify(string $plaintext, string $hash): bool`

A previously-stored hash (see hash()).

| Parameter | Type | Description |
|---|---|---|
| `$plaintext` | `string` | The plaintext password to check. |
| `$hash` | `string` | A previously-stored hash (see hash()). |

Returns `bool` — True if $plaintext matches $hash, otherwise false.
