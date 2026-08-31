# CassetteStoreInterface

> Where a cassette is written and read back from.

Where a cassette is written and read back from.

Listing is deliberately not part of this base contract -- see [`ListableCassetteStoreInterface`](/api/replay/store/listable-cassette-store-interface/), which [`FileCassetteStore`](/api/replay/store/file-cassette-store/), a PDO-backed store, and an object-store-backed one all implement, each over its own underlying listing mechanism (a directory scan, a `SELECT`, or `Quiote\Storage\ListableObjectStoreClientInterface`'s own prefix-scan listing).

## Synopsis

`interface CassetteStoreInterface`

|  |  |
|---|---|
| Implemented by | [`ListableCassetteStoreInterface`](/api/replay/store/listable-cassette-store-interface/) |
| Source | `Store/CassetteStoreInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`delete(CassetteId $id): void`](#delete) | Removes the cassette at $id. |
| [`get(CassetteId $id): ?Cassette`](#get) | Null when no cassette is stored under this id. |
| [`has(CassetteId $id): bool`](#has) |  |
| [`put(CassetteId $id, Cassette $cassette): void`](#put) |  |

### delete()

`abstract public function delete(CassetteId $id): void`

Removes the cassette at $id.

Best-effort: an id that does not exist is not an error.

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |

### get()

`abstract public function get(CassetteId $id): ?Cassette`

Null when no cassette is stored under this id.

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |

Returns `?`[`Cassette`](/api/replay/cassette/cassette/)

### has()

`abstract public function has(CassetteId $id): bool`

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |

Returns `bool`

### put()

`abstract public function put(CassetteId $id, Cassette $cassette): void`

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |
| `$cassette` | [`Cassette`](/api/replay/cassette/cassette/) |  |

| Throws | When |
|---|---|
| `StorageException` | if the cassette could not be written. |
