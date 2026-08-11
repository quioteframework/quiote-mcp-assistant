# FileSessionPersistence

> File-backed SessionPersistenceInterface implementation — the zero-dependency default backend.

File-backed SessionPersistenceInterface implementation — the zero-dependency default backend.

Each session lives in its own file under the configured directory; the filename is the SHA-256 of the session id, so untrusted cookie values can never traverse outside the directory and session ids are not recoverable from a directory listing.

Writes go to a temp file in the same directory and are renamed into place, so readers never observe a partially written session and no file locking is needed (a reader holding the old inode keeps a consistent snapshot; the last concurrent save wins, matching the upsert semantics of the PDO backend).

Expiry is mtime-based: a file older than `idle_ttl` seconds is treated as unknown on load (and removed). Expired files are additionally swept by gc(), which save() triggers probabilistically (`gc_probability`/`gc_divisor`, defaults 1/100); set `gc_probability` to 0 and call gc() from a cron/queue job to take GC off the request path entirely. An `idle_ttl` of 0 disables expiry (sessions live until deleted).

This class deliberately does not touch ext/session (no session_start(), no $_SESSION, no save handlers) — see SessionManager.

## Synopsis

`class FileSessionPersistence implements SessionPersistenceInterface`

|  |  |
|---|---|
| Implements | [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) |
| Source | `Session/FileSessionPersistence.php` |

## Constructor

### __construct()

`public function __construct(string $directory, array<string, mixed> $parameters = [], SessionCodecInterface $codec = new SessionCodec(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$directory` | `string` |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |
| `$codec` | [`SessionCodecInterface`](/api/session/session-codec-interface/) |  |

Returns `mixed`

| Throws | When |
|---|---|
| `StorageException` | if the directory cannot be created or written to. |

## Methods

| Method | Description |
|---|---|
| [`delete(string $sid): void`](#delete) | Unlinks the session's file. |
| [`gc(): int`](#gc) | Remove all expired session files. |
| [`load(string $sid): ?array`](#load) | Reads a session from its file, decoding it through the configured codec. |
| [`save(string $sid, array $data): void`](#save) | Writes the session atomically: encode, write to a temp file in the same directory, chmod 0600, rename into place. |

### delete()

`public function delete(string $sid): void`

Unlinks the session's file.

Best-effort and silent, matching the PDO backend: an unknown id and a failed unlink are both indistinguishable no-ops to the caller.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

### gc()

`public function gc(): int`

Remove all expired session files.

Safe to call concurrently and from outside the request path (cron/queue job). No-op when idle_ttl is 0.

Returns `int` — number of files removed.

### load()

`public function load(string $sid): ?array`

Reads a session from its file, decoding it through the configured codec.

Returns null when no file exists for the id, when the file is empty or unreadable, or — with a non-zero `idle_ttl` — when its mtime is older than that many seconds, in which case the stale file is unlinked on the way out. A future-dated mtime, which a backward clock step can produce, does not count as expired.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

Returns `?``array`

### save()

`public function save(string $sid, array $data): void`

Writes the session atomically: encode, write to a temp file in the same directory, chmod 0600, rename into place.

Readers therefore never see a half-written session and no locking is needed; concurrent saves are last-write-wins. After a successful publish this may run [`FileSessionPersistence::gc()`](/api/session/file-session-persistence/#gc), with probability `gc_probability`/`gc_divisor`.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |
| `$data` | `array` |  |

| Throws | When |
|---|---|
| `StorageException` | if the temp file cannot be written or renamed into place; the temp file is cleaned up first in both cases. |
