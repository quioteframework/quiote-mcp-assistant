# PdoCassetteStore

> A PDO-backed ListableCassetteStoreInterface: a pod's filesystem does not survive a restart/eviction, so a team without an object-store backend keeps cassettes in the database it already has instead.

A PDO-backed [`ListableCassetteStoreInterface`](/api/replay/store/listable-cassette-store-interface/): a pod's filesystem does not survive a restart/eviction, so a team without an object-store backend keeps cassettes in the database it already has instead.

Portable across PostgreSQL and SQLite only (`INSERT ... ON CONFLICT`, matching [`PdoRateLimiterStorage`](/api/security/rate-limit/pdo-rate-limiter-storage/)'s and `queue-db`'s own documented scope for this class of hand-rolled SQL) -- MySQL/MariaDB support would need `ON DUPLICATE KEY UPDATE` instead and is not implemented. The gzip-encoded cassette payload [`CassetteCodec`](/api/replay/cassette/cassette-codec/) produces is not valid UTF-8, so it is base64-encoded into a plain `TEXT` column rather than a driver-specific `BYTEA`/`BLOB` type -- the same portability trick `PdoRateLimiterStorage::save()` already uses for its own binary-ish payload, needed because a single `CREATE TABLE` string cannot name a binary column type both engines accept.

`recorded_at`/`route`/`status`/`trigger_reason` are extracted from the cassette at write time into their own indexed-by-nothing-yet columns -- not because a query here uses them (`slugs()` still returns every id, and `cassette:list`/`cassette:prune` decode-and-filter in PHP exactly as they do against [`FileCassetteStore`](/api/replay/store/file-cassette-store/), so both stores share one filtering implementation) but so the raw table is legible and directly queryable by hand (`SELECT * FROM quiote_cassettes WHERE status >= 500`) without decoding a payload column first.

Schema (see [`PdoCassetteStore::schema()`](/api/replay/store/pdo/pdo-cassette-store/#schema)): CREATE TABLE quiote_cassettes ( slug           VARCHAR(64)  PRIMARY KEY, raw_id         VARCHAR(255) NOT NULL, recorded_at    VARCHAR(32)  NULL, route          VARCHAR(255) NULL, status         INTEGER      NULL, trigger_reason VARCHAR(32)  NULL, payload        TEXT         NOT NULL );

## Synopsis

`final readonly class PdoCassetteStore implements ListableCassetteStoreInterface`

|  |  |
|---|---|
| Implements | [`ListableCassetteStoreInterface`](/api/replay/store/listable-cassette-store-interface/) |
| Source | `PdoCassetteStore.php` |

## Constructor

### __construct()

`public function __construct(PDO $pdo, string $table = 'quiote_cassettes', CassetteCodec $codec = new CassetteCodec(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$pdo` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `$table` | `string` |  |
| `$codec` | [`CassetteCodec`](/api/replay/cassette/cassette-codec/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(CassetteId $id): void`](#delete) | Removes the cassette at $id. |
| [`get(CassetteId $id): ?Cassette`](#get) | Null when no cassette is stored under this id. |
| [`has(CassetteId $id): bool`](#has) |  |
| [`put(CassetteId $id, Cassette $cassette): void`](#put) |  |
| [`schema(string $table = 'quiote_cassettes'): string`](#schema) | DDL to create the backing table (PostgreSQL / SQLite compatible). |
| [`slugs(): list<string>`](#slugs) | Every cassette slug in the table. |

### delete()

`public function delete(CassetteId $id): void`

Removes the cassette at $id.

Best-effort: an id that does not exist is not an error.

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |

| Throws | When |
|---|---|
| `StorageException` | if the delete does not succeed. |

### get()

`public function get(CassetteId $id): ?Cassette`

Null when no cassette is stored under this id.

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |

Returns `?`[`Cassette`](/api/replay/cassette/cassette/)

| Throws | When |
|---|---|
| `StorageException` | if the read does not succeed. |

### has()

`public function has(CassetteId $id): bool`

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |

Returns `bool`

| Throws | When |
|---|---|
| `StorageException` | if the read does not succeed. |

### put()

`public function put(CassetteId $id, Cassette $cassette): void`

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |
| `$cassette` | [`Cassette`](/api/replay/cassette/cassette/) |  |

| Throws | When |
|---|---|
| `StorageException` | if the write does not succeed. |

### schema()

`public static function schema(string $table = 'quiote_cassettes'): string`

DDL to create the backing table (PostgreSQL / SQLite compatible).

| Parameter | Type | Description |
|---|---|---|
| `$table` | `string` |  |

Returns `string`

### slugs()

`public function slugs(): list<string>`

Every cassette slug in the table.

A failed query raises rather than returning an empty list. Reporting an error as "the store * is empty" is the worst available answer for the two callers this has: `cassette:list` would print "No cassettes found" for a table it could not read, and `cassette:prune` would decide there was nothing to prune.

Returns `list``<``string``>`

| Throws | When |
|---|---|
| `StorageException` | if the listing does not succeed. |
