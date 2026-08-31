# ObjectStoreCassetteStore

> A ListableCassetteStoreInterface over any ListableObjectStoreClientInterface -- Azure Blob, S3 or GCS.

A [`ListableCassetteStoreInterface`](/api/replay/store/listable-cassette-store-interface/) over any [`ListableObjectStoreClientInterface`](/api/storage/listable-object-store-client-interface/) -- Azure Blob, S3 or GCS.

A pod's filesystem does not survive a restart/eviction/scale-down, which is disproportionately likely to be exactly when the interesting request happened.

`put()` writes to the deterministic, date-partitioned key [`CassetteKeyScheme`](/api/replay/store/storage/cassette-key-scheme/) derives from the cassette's own `recorded_at`. `get()`/`has()`/`delete()`/`slugs()` take only a bare [`CassetteId`](/api/replay/cassette/cassette-id/) or nothing at all -- neither carries a date -- so they cannot go straight to a key the way [`FileCassetteStore`](/api/replay/store/file-cassette-store/)'s directory listing or [`PdoCassetteStore`](/api/replay/store/pdo/pdo-cassette-store/)'s `WHERE slug = ?` can. Instead they **probe backward hour by hour**, from now, up to `$lookbackHours` (default a Docker-deployment-realistic 48h), checking each hour's deterministic key with a cheap `head()` rather than listing. This makes the base `CassetteStoreInterface` contract honestly work with no further machinery -- slower than an index-assisted lookup for an old cassette, but correct -- and [`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/) (an explicit key/date hint, or a Log Analytics query) is the *faster* path for exactly the case this probe is slow at, not a requirement for the store to function at all.

A stated, deliberate limitation, not a silent one: `slugs()` only enumerates the same `$lookbackHours` window `get()`/`has()`/`delete()` probe, not the object store's entire history. A cassette older than that window exists and is still fetchable by key, but will not appear in `cassette:list`'s output.

## Synopsis

`final class ObjectStoreCassetteStore implements ListableCassetteStoreInterface`

|  |  |
|---|---|
| Implements | [`ListableCassetteStoreInterface`](/api/replay/store/listable-cassette-store-interface/) |
| Source | `ObjectStoreCassetteStore.php` |

## Constructor

### __construct()

`public function __construct(ListableObjectStoreClientInterface $client, CassetteKeyScheme $keyScheme, string $storeAlias, string $containerLabel, int $lookbackHours = 48, CassetteCodec $codec = new CassetteCodec(…), ClockInterface $clock = new SystemClock(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$client` | [`ListableObjectStoreClientInterface`](/api/storage/listable-object-store-client-interface/) |  |
| `$keyScheme` | [`CassetteKeyScheme`](/api/replay/store/storage/cassette-key-scheme/) |  |
| `$storeAlias` | `string` |  |
| `$containerLabel` | `string` |  |
| `$lookbackHours` | `int` |  |
| `$codec` | [`CassetteCodec`](/api/replay/cassette/cassette-codec/) |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(CassetteId $id): void`](#delete) | Deletes every copy, not just the newest. |
| [`get(CassetteId $id): ?Cassette`](#get) | Null when no cassette is stored under this id. |
| [`has(CassetteId $id): bool`](#has) |  |
| [`put(CassetteId $id, Cassette $cassette): void`](#put) |  |
| [`slugs(): list<string>`](#slugs) | Every slug the last `$lookbackHours` of hour-partitions hold -- see this class's own docblock for why that window, not the object store's entire history. |

### delete()

`public function delete(CassetteId $id): void`

Deletes every copy, not just the newest.

`put()` keys by the cassette's own recorded hour, so one slug can legitimately exist in several hour partitions -- a re-recorded correlation id, or a cassette fetched from elsewhere and stored again. Stopping at the first hit meant `cassette:prune` reported a deletion while older copies survived indefinitely, which is the one thing a prune must not do.

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

Every slug the last `$lookbackHours` of hour-partitions hold -- see this class's own docblock for why that window, not the object store's entire history.

Returns `list``<``string``>`
