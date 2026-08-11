# PdoSessionPersistence

> Default PDO-backed SessionPersistenceInterface implementation.

Default PDO-backed SessionPersistenceInterface implementation.

Works on Postgres, MySQL and SQLite -- the upsert is chosen per driver, since no single statement is portable across all three (see buildSaveSql()).

Expects a table with (at least) sess_id/sess_data/sess_time columns, matching the schema most PHP session table conventions already use:

CREATE TABLE session ( sess_id   VARCHAR(64) PRIMARY KEY, sess_data BYTEA/BLOB/TEXT NOT NULL, sess_time TIMESTAMP NOT NULL );

## Synopsis

`class PdoSessionPersistence implements SessionPersistenceInterface`

|  |  |
|---|---|
| Implements | [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) |
| Source | `Session/PdoSessionPersistence.php` |

## Constructor

### __construct()

`public function __construct(PDO $pdo, array<string, mixed> $parameters = [], SessionCodecInterface $codec = new SessionCodec(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$pdo` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |
| `$codec` | [`SessionCodecInterface`](/api/session/session-codec-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(string $sid): void`](#delete) | Deletes the session row. |
| [`load(string $sid): ?array`](#load) | Selects the session row and decodes its payload through the codec. |
| [`save(string $sid, array $data): void`](#save) | Upserts the encoded session payload against the id. |

### delete()

`public function delete(string $sid): void`

Deletes the session row.

A database failure is logged at error rather than thrown — the caller is usually mid-logout or mid-rotation and has nothing useful to do with the exception — so a failed delete leaves the session loadable until it expires.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

### load()

`public function load(string $sid): ?array`

Selects the session row and decodes its payload through the codec.

Returns null when the id has no row or the stored blob is empty. A bytea column comes back from pdo_pgsql as a stream resource rather than a string, so the blob is drained before decoding. The cursor is always closed, including on failure: a fetched-but-unclosed statement leaves the cached statement open, which on SQLite holds a shared lock that a later [`PdoSessionPersistence::save()`](/api/session/pdo-session-persistence/#save) upsert cannot upgrade.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

Returns `?``array`

| Throws | When |
|---|---|
| `StorageException` | if the query fails. |

### save()

`public function save(string $sid, array $data): void`

Upserts the encoded session payload against the id.

The statement is the driver-specific upsert built once per instance, and the payload is bound as a LOB so a binary encoding survives on drivers with a bytea/blob column.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |
| `$data` | `array` |  |

| Throws | When |
|---|---|
| `StorageException` | if encoding or the write fails. |
