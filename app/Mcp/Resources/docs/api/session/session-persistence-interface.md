# SessionPersistenceInterface

> Storage backend contract for SessionManager.

Storage backend contract for SessionManager.

Implementations own how session data is serialized and where it lives (Postgres, Redis, etc.) — SessionManager only deals in plain arrays keyed by session id.

## Synopsis

`interface SessionPersistenceInterface`

|  |  |
|---|---|
| Implemented by | [`FileSessionPersistence`](/api/session/file-session-persistence/), [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/), [`PdoSessionPersistence`](/api/session/pdo-session-persistence/), [`PdoSessionPersistence`](/api/session/pdo/pdo-session-persistence/), [`RedisSessionPersistence`](/api/session/redis/redis-session-persistence/), [`AzureTableSessionPersistence`](/api/storage/azure/azure-table-session-persistence/) |
| Source | `Session/SessionPersistenceInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`delete(string $sid): void`](#delete) | Remove the session record for this id. |
| [`load(string $sid): array<string, mixed>|null`](#load) |  |
| [`save(string $sid, array<string, mixed> $data): void`](#save) |  |

### delete()

`abstract public function delete(string $sid): void`

Remove the session record for this id.

Deleting an id that is not stored is not an error. Implementations decide how loudly a backend failure is reported, but must not leave the caller believing the record is gone when it demonstrably is not.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

### load()

`abstract public function load(string $sid): array<string, mixed>|null`

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

Returns `array``<``string``, ``mixed``>``|``null` — null if the session id is unknown.

### save()

`abstract public function save(string $sid, array<string, mixed> $data): void`

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |
| `$data` | `array``<``string``, ``mixed``>` |  |
