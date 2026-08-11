# PdoSessionPersistence

> PDO-backed SessionPersistenceInterface for SessionManager.

PDO-backed [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) for [`SessionManager`](/api/session/session-manager/).

One row per session id; the payload is JSON (igbinary, if the extension is loaded, purely as a smaller-and-faster wire format — JSON is always the fallback and the only format [`PdoSessionPersistence::load()`](/api/session/pdo/pdo-session-persistence/#load) needs to recognize besides it).

Expects a table shaped like:

CREATE TABLE session ( sess_id   VARCHAR(64) PRIMARY KEY, sess_data BYTEA/BLOB/TEXT NOT NULL, sess_time TIMESTAMP NOT NULL );

## Synopsis

`final class PdoSessionPersistence implements SessionPersistenceInterface`

|  |  |
|---|---|
| Implements | [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) |
| Source | `PdoSessionPersistence.php` |

## Constructor

### __construct()

`public function __construct(PDO $pdo, string $table = 'session', SessionCodecInterface $codec = new SessionCodec(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$pdo` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `$table` | `string` |  |
| `$codec` | [`SessionCodecInterface`](/api/session/session-codec-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(string $sid): void`](#delete) | Deletes the session row. |
| [`load(string $sid): ?array`](#load) | Selects the session row and decodes its payload through the codec. |
| [`save(string $sid, array<string, mixed> $data): void`](#save) |  |

### delete()

`public function delete(string $sid): void`

Deletes the session row.

A database failure is logged at error rather than thrown — a connection already torn down at shutdown is ordinary, and the caller is typically mid-logout — so a failed delete leaves the session loadable until it expires.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

### load()

`public function load(string $sid): ?array`

Selects the session row and decodes its payload through the codec.

Returns null when the statement cannot be prepared, when the id has no row, or when the stored payload is empty or is not a string. A LOB column arrives as a stream on some drivers and is drained while the cursor is still open. The cursor is closed in a `finally`, since a fetched-but-open statement holds a shared lock that blocks other connections from writing on SQLite.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

Returns `?``array`

| Throws | When |
|---|---|
| `StorageException` | if the query fails. |

### save()

`public function save(string $sid, array<string, mixed> $data): void`

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |
| `$data` | `array``<``string``, ``mixed``>` |  |
