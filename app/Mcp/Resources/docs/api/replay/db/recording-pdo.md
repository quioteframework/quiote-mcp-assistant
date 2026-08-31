# RecordingPdo

> A drop-in replacement for `\\PDO` (see `Quiote\\Database\\PdoDatabase::connect()`, which builds `new PDO($dsn, $username, $password, $options)`): connects for real, behaves exactly like a bare `\\PDO` to the caller, and additionally appends one EffectKind::Db entry per statement execution to an injected EffectLedger -- `query()`/`prepare()->execute()` through RecordingPdoStatement (installed via `PDO::ATTR_STATEMENT_CLASS`), `exec()` directly, since it has no result set to snapshot.

A drop-in replacement for `\PDO` (see `Quiote\Database\PdoDatabase::connect()`, which builds `new PDO($dsn, $username, $password, $options)`): connects for real, behaves exactly like a bare `\PDO` to the caller, and additionally appends one [`EffectKind::Db`](/api/replay/cassette/effect-kind/#db) entry per statement execution to an injected [`EffectLedger`](/api/replay/replay/effect-ledger/) -- `query()`/`prepare()->execute()` through [`RecordingPdoStatement`](/api/replay/db/recording-pdo-statement/) (installed via `PDO::ATTR_STATEMENT_CLASS`), `exec()` directly, since it has no result set to snapshot.

A statement that throws propagates the real exception and records nothing: a failed call has no result to replay, and no ledger entry is a more honest state than a fabricated one.

## Synopsis

`final class RecordingPdo extends PDO`

|  |  |
|---|---|
| Extends | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |
| Source | `Db/RecordingPdo.php` |

## Constructor

### __construct()

`public function __construct(string $dsn, ?string $username = null, ?string $password = null, array<int, mixed>|null $options = null, ?EffectLedger $ledger = null, ?ClockInterface $clock = null, int $maxSnapshotRows = Quiote\Replay\Db\RecordingPdoStatement::DEFAULT_MAX_SNAPSHOT_ROWS): mixed`

Rows one statement's snapshot holds before it stops capturing;
       see [`RecordingPdoStatement`](/api/replay/db/recording-pdo-statement/)'s own docblock.

| Parameter | Type | Description |
|---|---|---|
| `$dsn` | `string` |  |
| `$username` | `?``string` |  |
| `$password` | `?``string` |  |
| `$options` | `array``<``int``, ``mixed``>``|``null` |  |
| `$ledger` | `?`[`EffectLedger`](/api/replay/replay/effect-ledger/) |  |
| `$clock` | `?`[`ClockInterface`](/api/support/clock/clock-interface/) |  |
| `$maxSnapshotRows` | `int` | Rows one statement's snapshot holds before it stops capturing; see [`RecordingPdoStatement`](/api/replay/db/recording-pdo-statement/)'s own docblock. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`durationMicros(ClockInterface $clock, float $startMonotonicSeconds): non-negative-int`](#durationmicros) |  |
| [`exec(string $statement): int|false`](#exec) |  |
| [`query(string $query, ?int $fetchMode = null, mixed ...$fetchModeArgs): PDOStatement|false`](#query) | The `$fetchMode`/`$fetchModeArgs` shorthand PDO::query() normally accepts is not supported here -- pass the mode to fetch()/fetchAll() on the returned statement instead. |

### durationMicros()

`public static function durationMicros(ClockInterface $clock, float $startMonotonicSeconds): non-negative-int`

| Parameter | Type | Description |
|---|---|---|
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |
| `$startMonotonicSeconds` | `float` |  |

Returns `non-negative-int`

### exec()

`public function exec(string $statement): int|false`

| Parameter | Type | Description |
|---|---|---|
| `$statement` | `string` |  |

Returns `int``|``false`

### query()

`public function query(string $query, ?int $fetchMode = null, mixed ...$fetchModeArgs): PDOStatement|false`

The `$fetchMode`/`$fetchModeArgs` shorthand PDO::query() normally accepts is not supported here -- pass the mode to fetch()/fetchAll() on the returned statement instead.

Routed through prepare()+execute() rather than delegating to `parent::query()`: PDO::query() executes through an internal driver path that never calls the statement object's own execute() method, so [`RecordingPdoStatement`](/api/replay/db/recording-pdo-statement/)'s override -- and therefore the ledger recording -- would silently never run. Verified empirically against a real sqlite connection, not assumed.

`prepare()` is not a transparent substitute for `query()`, though, and that is the reason for the fallback below. A statement some drivers cannot prepare (certain DDL, a multi-statement string, a session `SET`) fails there, and with emulation off a literal `?` or `:name` inside a string literal is read as a placeholder, so `query("SELECT '?'")` errors on a parameter count mismatch. Falling back to the real `parent::query()` means installing this recorder can never turn a working query into a broken one; the cost is that such a query is not recorded, which is strictly better than the alternative and is stated in the effect ledger by its absence rather than by a fabricated entry.

| Parameter | Type | Description |
|---|---|---|
| `$query` | `string` |  |
| `$fetchMode` | `?``int` |  |
| `$fetchModeArgs` | `mixed` |  |

Returns `PDOStatement``|``false`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `beginTransaction()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `commit()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `connect()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `errorCode()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `errorInfo()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `getAttribute()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `getAvailableDrivers()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `inTransaction()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `lastInsertId()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `prepare()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `quote()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `rollBack()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `setAttribute()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
