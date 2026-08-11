# Hasher

> The Quiote\\Security\\Auth\\Hasher namespace — 2 documented types.

Everything under `Quiote\Security\Auth\Hasher`.

## Classes

| Class | Description |
|---|---|
| [`DefaultPasswordHasher`](/api/security/auth/hasher/default-password-hasher/) | Thin wrapper over PHP's `password_hash()` family: argon2id by default, falling back to bcrypt only when the running PHP build lacks argon2 support (no libargon2 at compile time). |
| [`DummyPasswordHash`](/api/security/auth/hasher/dummy-password-hash/) | A valid hash of a value no submitted password can match, used to spend the same key-derivation time on an unknown identifier as on a known one. |
