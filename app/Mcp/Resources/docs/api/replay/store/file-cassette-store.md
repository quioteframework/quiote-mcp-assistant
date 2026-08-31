# FileCassetteStore

> Development-default store: never the right choice in production (an AKS pod's filesystem disappears on restart/eviction/scale-down), but a zero-dependency default that makes the feature usable immediately.

Development-default store: never the right choice in production (an AKS pod's filesystem disappears on restart/eviction/scale-down), but a zero-dependency default that makes the feature usable immediately.

Modeled on [`FileSessionPersistence`](/api/session/file-session-persistence/)'s pattern: directory created `0700` at construction (refusing to proceed rather than degrade permissions later), each write goes to a temp file in the same directory, `chmod 0600`, then renamed into place, so a reader never observes a partially written cassette.

## Synopsis

`final class FileCassetteStore implements ListableCassetteStoreInterface`

|  |  |
|---|---|
| Implements | [`ListableCassetteStoreInterface`](/api/replay/store/listable-cassette-store-interface/) |
| Source | `Store/FileCassetteStore.php` |

## Constructor

### __construct()

`public function __construct(string $directory, CassetteCodec $codec = new CassetteCodec(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$directory` | `string` |  |
| `$codec` | [`CassetteCodec`](/api/replay/cassette/cassette-codec/) |  |

Returns `mixed`

| Throws | When |
|---|---|
| `StorageException` | if the directory is empty, is relative with no `core.app_dir` to anchor it, sits inside the app's public document root, cannot be created/written to, or already exists with permissions wider than the owner. |

## Methods

| Method | Description |
|---|---|
| [`delete(CassetteId $id): void`](#delete) | Removes the cassette at $id. |
| [`get(CassetteId $id): ?Cassette`](#get) | Null when no cassette is stored under this id. |
| [`has(CassetteId $id): bool`](#has) |  |
| [`put(CassetteId $id, Cassette $cassette): void`](#put) |  |
| [`slugs(): list<string>`](#slugs) | Every cassette id currently in the store, for `cassette:list` -- the file store's stand-in for a real object-store `listObjects()`. |

### delete()

`public function delete(CassetteId $id): void`

Removes the cassette at $id.

Best-effort: an id that does not exist is not an error.

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |

### get()

`public function get(CassetteId $id): ?Cassette`

Null when no cassette is stored under this id.

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |

Returns `?`[`Cassette`](/api/replay/cassette/cassette/)

### has()

`public function has(CassetteId $id): bool`

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |

Returns `bool`

### put()

`public function put(CassetteId $id, Cassette $cassette): void`

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |
| `$cassette` | [`Cassette`](/api/replay/cassette/cassette/) |  |

### slugs()

`public function slugs(): list<string>`

Every cassette id currently in the store, for `cassette:list` -- the file store's stand-in for a real object-store `listObjects()`.

Returns `list``<``string``>` — slugs, not raw ids -- the file store never learns a cassette's raw id without decoding it.
