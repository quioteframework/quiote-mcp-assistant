# RedisSessionPersistence

> Redis-backed SessionPersistenceInterface for SessionManager.

Redis-backed [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) for [`SessionManager`](/api/session/session-manager/).

One string key per session id, written with `SETEX` so Redis itself expires stale sessions — no GC pass needed, unlike the PDO/file backends.

## Synopsis

`final class RedisSessionPersistence implements SessionPersistenceInterface`

|  |  |
|---|---|
| Implements | [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) |
| Source | `RedisSessionPersistence.php` |

## Constructor

### __construct()

`public function __construct(ClientInterface $redis, string $prefix = 'session:', int $ttl = 1440, SessionCodecInterface $codec = new SessionCodec(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$redis` | `ClientInterface` |  |
| `$prefix` | `string` |  |
| `$ttl` | `int` |  |
| `$codec` | [`SessionCodecInterface`](/api/session/session-codec-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(string $sid): void`](#delete) | Deletes the session's Redis key. |
| [`load(string $sid): ?array`](#load) | Reads the session's Redis key and decodes it through the codec. |
| [`save(string $sid, array<string, mixed> $data): void`](#save) |  |

### delete()

`public function delete(string $sid): void`

Deletes the session's Redis key.

Deleting a key that is absent or already expired is a no-op on Redis's side, so this reports nothing back either way.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

### load()

`public function load(string $sid): ?array`

Reads the session's Redis key and decodes it through the codec.

Returns null when the key is missing or expired — Redis expires it on its own, so an aged-out session is simply absent — and when the value is empty or not a string.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

Returns `?``array`

### save()

`public function save(string $sid, array<string, mixed> $data): void`

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |
| `$data` | `array``<``string``, ``mixed``>` |  |
