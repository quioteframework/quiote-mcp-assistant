# EloquentQueryRecorder

> Records one EffectKind::Db entry per query on an Eloquent (illuminate/database) connection, via `Connection::listen()` -- the `Illuminate\\Database\\Events\\QueryExecuted` event Eloquent already fires after every query, rather than a PDO/DBAL-style decorator.

Records one [`EffectKind::Db`](/api/replay/cassette/effect-kind/#db) entry per query on an Eloquent (illuminate/database) connection, via `Connection::listen()` -- the `Illuminate\Database\Events\QueryExecuted` event Eloquent already fires after every query, rather than a PDO/DBAL-style decorator.

This event fires *after* the query has already run and its rows already returned to the caller through Eloquent's own internal fetch path, which this recorder never sees -- unlike `RecordingPdo`/ `DoctrineRecordingMiddleware`, there is nothing here to snapshot and hand back, so `Effect::$result` is always `null`. `call` carries the SQL, bindings and read/write type `QueryExecuted` exposes -- no row data is available at this layer, which is a real, documented limitation of recording through Eloquent's event rather than decorating its PDO connection, not an oversight.

`Illuminate\Database\Connection::listen()` is a no-op when the connection has no event dispatcher (`Quiote\Database\Adapter\Eloquent\EloquentDatabase::connect()` never sets one), so [`EloquentQueryRecorder::attach()`](/api/replay/adapter/eloquent/eloquent-query-recorder/#attach) installs a [`EloquentMinimalEventDispatcher`](/api/replay/adapter/eloquent/eloquent-minimal-event-dispatcher/) first when the connection doesn't already have one -- an application-wired dispatcher, if present, is left alone and this recorder's listener is simply added alongside whatever else is already listening.

Records into [`ActiveEffectLedger`](/api/replay/recording/active-effect-ledger/)'s current ledger rather than a fixed one taken at construction: [`EloquentQueryRecorder::attach()`](/api/replay/adapter/eloquent/eloquent-query-recorder/#attach) runs once, at `EloquentDatabase::connect()`, and that connection is then recycled (not rebuilt) across every later request in a worker process -- see [`ActiveEffectLedger`](/api/replay/recording/active-effect-ledger/)'s own docblock for why a fixed ledger would be wrong past the connection's first use. A query that runs with nothing currently active (e.g. before any request is being recorded) is simply not recorded.

A failing query never fires `QueryExecuted` (Eloquent only dispatches it after a successful run), so nothing here needs to guard against recording a failed call -- that exclusion falls out of the event's own contract.

## Synopsis

`final class EloquentQueryRecorder`

|  |  |
|---|---|
| Source | `EloquentQueryRecorder.php` |

## Methods

| Method | Description |
|---|---|
| [`attach(Connection $connection): void`](#attach) | Attaches the listener, once per connection. |
| [`fingerprintOf(string $sql): string`](#fingerprintof) | Trim + collapse internal whitespace runs; deliberately not full SQL normalization. |
| [`reset(): void`](#reset) | Test isolation: forgets which connections have been attached to. |

### attach()

`public function attach(Connection $connection): void`

Attaches the listener, once per connection.

The guard matters because `connect()` can run more than once for one logical connection -- a reconnect after a dropped socket is the case a long-running worker exists to handle -- and `Connection::listen()` appends unconditionally. Without it, every reconnect left one more listener and each query was recorded that many times into the ledger.

| Parameter | Type | Description |
|---|---|---|
| `$connection` | `Connection` |  |

### fingerprintOf()

`public static function fingerprintOf(string $sql): string`

Trim + collapse internal whitespace runs; deliberately not full SQL normalization.

| Parameter | Type | Description |
|---|---|---|
| `$sql` | `string` |  |

Returns `string`

### reset()

`public static function reset(): void`

Test isolation: forgets which connections have been attached to.
