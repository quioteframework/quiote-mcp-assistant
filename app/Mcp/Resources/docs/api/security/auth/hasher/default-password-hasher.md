# DefaultPasswordHasher

> Thin wrapper over PHP's `password_hash()` family: argon2id by default, falling back to bcrypt only when the running PHP build lacks argon2 support (no libargon2 at compile time).

Thin wrapper over PHP's `password_hash()` family: argon2id by default, falling back to bcrypt only when the running PHP build lacks argon2 support (no libargon2 at compile time).

## Synopsis

`final class DefaultPasswordHasher implements PasswordHasherInterface`

|  |  |
|---|---|
| Implements | [`PasswordHasherInterface`](/api/security/auth/password-hasher-interface/) |
| Since | `1.0.0` |
| Source | `Hasher/DefaultPasswordHasher.php` |

## Constructor

### __construct()

`public function __construct(?string $algorithm = null, array<string, mixed> $options = []): mixed`

Passed through to `password_hash()`/`password_needs_rehash()`.

| Parameter | Type | Description |
|---|---|---|
| `$algorithm` | `?``string` | One of the `PASSWORD_*` constants; defaults to argon2id (or bcrypt if unavailable). |
| `$options` | `array``<``string``, ``mixed``>` | Passed through to `password_hash()`/`password_needs_rehash()`. |

Returns `mixed`

| Throws | When |
|---|---|
| `InvalidArgumentException` | If $algorithm is neither `PASSWORD_BCRYPT` nor (when available) `PASSWORD_ARGON2ID`. |

## Methods

| Method | Description |
|---|---|
| [`hash(string $plaintext): string`](#hash) |  |
| [`needsRehash(string $hash): bool`](#needsrehash) |  |
| [`verify(string $plaintext, string $hash): bool`](#verify) |  |

### hash()

`public function hash(string $plaintext): string`

The plaintext password to hash.

| Parameter | Type | Description |
|---|---|---|
| `$plaintext` | `string` | The plaintext password to hash. |

Returns `string` — The resulting hash, suitable for storage.

### needsRehash()

`public function needsRehash(string $hash): bool`

A previously-stored hash (see hash()).

| Parameter | Type | Description |
|---|---|---|
| `$hash` | `string` | A previously-stored hash (see hash()). |

Returns `bool` — True if $hash was produced with weaker-than-current-default parameters, otherwise false.

### verify()

`public function verify(string $plaintext, string $hash): bool`

A previously-stored hash (see hash()).

| Parameter | Type | Description |
|---|---|---|
| `$plaintext` | `string` | The plaintext password to check. |
| `$hash` | `string` | A previously-stored hash (see hash()). |

Returns `bool` — True if $plaintext matches $hash, otherwise false.
