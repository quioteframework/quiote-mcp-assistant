# RecordingPdoStatement

> The statement class RecordingPdo installs via `PDO::ATTR_STATEMENT_CLASS`, so every statement it prepares records one EffectKind::Db effect per RecordingPdoStatement::execute() call.

The statement class [`RecordingPdo`](/api/replay/db/recording-pdo/) installs via `PDO::ATTR_STATEMENT_CLASS`, so every statement it prepares records one [`EffectKind::Db`](/api/replay/cassette/effect-kind/#db) effect per [`RecordingPdoStatement::execute()`](/api/replay/db/recording-pdo-statement/#execute) call.

A PDO cursor is forward-only on most drivers, so recording the result set (`parent::fetchAll()`, once, right after a real `execute()`) would consume it out from under the real caller's own fetch loop. This class avoids that by snapshotting the rows itself and serving every subsequent [`RecordingPdoStatement::fetch()`](/api/replay/db/recording-pdo-statement/#fetch)/[`RecordingPdoStatement::fetchAll()`](/api/replay/db/recording-pdo-statement/#fetchall)/[`RecordingPdoStatement::rowCount()`](/api/replay/db/recording-pdo-statement/#rowcount) call from that snapshot rather than the parent -- functionally transparent for the common ASSOC/NUM/OBJ/BOTH/default fetch modes.

The snapshot is taken in `PDO::FETCH_NUM` alongside the column names from `getColumnMeta()`, not in `PDO::FETCH_ASSOC`. An associative snapshot collapses duplicate column names -- `SELECT a.id, b.id FROM a JOIN b` keeps one `id` -- and every positional mode is then rebuilt from that collapsed row, so `FETCH_NUM` and `FETCH_BOTH` returned the wrong column count and the wrong values. Positional plus names loses nothing and derives the associative view from it.

It is also bounded: `$maxSnapshotRows` caps how many rows are held, so a query returning a million rows does not become a million rows in memory twice over (once as the snapshot, once in the ledger). Past the cap the effect says `rows_truncated`, and the caller still receives every row that was captured -- see [`RecordingPdoStatement::execute()`](/api/replay/db/recording-pdo-statement/#execute).

Deliberately unsupported in this iteration: `bindColumn()`, `getColumnMeta()`, LOB streaming, and any fetch mode beyond ASSOC/NUM/OBJ/BOTH/default. Each throws a clear `\RuntimeException` rather than falling through to a parent that no longer has a live cursor to answer from.

## Synopsis

`class RecordingPdoStatement extends PDOStatement`

|  |  |
|---|---|
| Extends | `PDOStatement` |
| Uses | [`PdoRowFormatting`](/api/replay/db/pdo-row-formatting/) |
| Source | `Db/RecordingPdoStatement.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `DEFAULT_MAX_SNAPSHOT_ROWS` | `1000` | How many rows one statement's snapshot holds before it stops capturing. |

## Constructor

### __construct()

`protected function __construct(EffectLedger $ledger, ClockInterface $clock = new SystemClock(…), int $maxSnapshotRows = self::DEFAULT_MAX_SNAPSHOT_ROWS): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |
| `$maxSnapshotRows` | `int` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`bindColumn(string|int $column, mixed &$var, int $type = PDO::PARAM_STR, int $maxLength = 0, mixed $driverOptions = null): bool`](#bindcolumn) |  |
| [`bindParam(string|int $param, mixed &$var, int $type = PDO::PARAM_STR, int $maxLength = 0, mixed $driverOptions = null): bool`](#bindparam) | Records the bound variable's value at bind time and delegates by reference. |
| [`bindValue(string|int $param, mixed $value, int $type = PDO::PARAM_STR): bool`](#bindvalue) | Records the bound value before delegating, so the effect's `call` carries what the statement was actually executed with. |
| [`execute(array<int|string, mixed>|null $params = null): bool`](#execute) |  |
| [`fetch(int $mode = PDO::FETCH_DEFAULT, int $cursorOrientation = PDO::FETCH_ORI_NEXT, int $cursorOffset = 0): mixed`](#fetch) |  |
| [`fetchAll(int $mode = PDO::FETCH_DEFAULT, mixed ...$args): list<mixed>`](#fetchall) |  |
| [`fetchColumn(int $column = 0): mixed`](#fetchcolumn) | Answered from the snapshot rather than refused. |
| [`fingerprintFor(string $sql, array<int|string, mixed> $params = []): string`](#fingerprintfor) | Normalized SQL plus a digest of the bound parameters. |
| [`fingerprintOf(string $sql): string`](#fingerprintof) | Trim + collapse internal whitespace runs; deliberately not full SQL normalization. |
| [`getColumnMeta(int $column): array|false`](#getcolumnmeta) |  |
| [`rowCount(): int`](#rowcount) |  |

### bindColumn()

`public function bindColumn(string|int $column, mixed &$var, int $type = PDO::PARAM_STR, int $maxLength = 0, mixed $driverOptions = null): bool`

| Parameter | Type | Description |
|---|---|---|
| `$column` | `string``|``int` |  |
| `$var` | `mixed` |  |
| `$type` | `int` |  |
| `$maxLength` | `int` |  |
| `$driverOptions` | `mixed` |  |

Returns `bool`

### bindParam()

`public function bindParam(string|int $param, mixed &$var, int $type = PDO::PARAM_STR, int $maxLength = 0, mixed $driverOptions = null): bool`

Records the bound variable's value at bind time and delegates by reference.

A `bindParam()` binding is read by the driver at `execute()` time rather than now, so a caller that changes the variable in between makes this snapshot stale. `execute()` therefore re-reads nothing and the recorded value is the one bound here, which is the best a decorator at this layer can honestly claim -- stated rather than left to look exact.

| Parameter | Type | Description |
|---|---|---|
| `$param` | `string``|``int` |  |
| `$var` | `mixed` |  |
| `$type` | `int` |  |
| `$maxLength` | `int` |  |
| `$driverOptions` | `mixed` |  |

Returns `bool`

### bindValue()

`public function bindValue(string|int $param, mixed $value, int $type = PDO::PARAM_STR): bool`

Records the bound value before delegating, so the effect's `call` carries what the statement was actually executed with.

Without this, only the array passed to `execute()` was captured -- and the common prepared statement path binds through here instead, so the recorded `params` was empty for most real queries and [`RecordingPdoStatement::fingerprintFor()`](/api/replay/db/recording-pdo-statement/#fingerprintfor) had nothing to distinguish two executions of the same SQL with different values.

| Parameter | Type | Description |
|---|---|---|
| `$param` | `string``|``int` |  |
| `$value` | `mixed` |  |
| `$type` | `int` |  |

Returns `bool`

### execute()

`public function execute(array<int|string, mixed>|null $params = null): bool`

| Parameter | Type | Description |
|---|---|---|
| `$params` | `array``<``int``|``string``, ``mixed``>``|``null` |  |

Returns `bool`

### fetch()

`public function fetch(int $mode = PDO::FETCH_DEFAULT, int $cursorOrientation = PDO::FETCH_ORI_NEXT, int $cursorOffset = 0): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$mode` | `int` |  |
| `$cursorOrientation` | `int` |  |
| `$cursorOffset` | `int` |  |

Returns `mixed`

### fetchAll()

`public function fetchAll(int $mode = PDO::FETCH_DEFAULT, mixed ...$args): list<mixed>`

| Parameter | Type | Description |
|---|---|---|
| `$mode` | `int` |  |
| `$args` | `mixed` |  |

Returns `list``<``mixed``>`

### fetchColumn()

`public function fetchColumn(int $column = 0): mixed`

Answered from the snapshot rather than refused.

Previously this threw, which made the decorator unusable for the single most common way to read a scalar aggregate (`SELECT COUNT(*)` then `fetchColumn()`) -- installing the recorder broke working code. The snapshot has the positional values, so the column index it takes is exactly what it can answer with.

| Parameter | Type | Description |
|---|---|---|
| `$column` | `int` |  |

Returns `mixed`

### fingerprintFor()

`public static function fingerprintFor(string $sql, array<int|string, mixed> $params = []): string`

Normalized SQL plus a digest of the bound parameters.

| Parameter | Type | Description |
|---|---|---|
| `$sql` | `string` |  |
| `$params` | `array``<``int``|``string``, ``mixed``>` |  |

Returns `string`

### fingerprintOf()

`public static function fingerprintOf(string $sql): string`

Trim + collapse internal whitespace runs; deliberately not full SQL normalization.

| Parameter | Type | Description |
|---|---|---|
| `$sql` | `string` |  |

Returns `string`

### getColumnMeta()

`public function getColumnMeta(int $column): array|false`

| Parameter | Type | Description |
|---|---|---|
| `$column` | `int` |  |

Returns `array``|``false`

### rowCount()

`public function rowCount(): int`

Returns `int`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `closeCursor()` | `PDOStatement` |  |
| `columnCount()` | `PDOStatement` |  |
| `debugDumpParams()` | `PDOStatement` |  |
| `errorCode()` | `PDOStatement` |  |
| `errorInfo()` | `PDOStatement` |  |
| `fetchObject()` | `PDOStatement` |  |
| `getAttribute()` | `PDOStatement` |  |
| `getIterator()` | `PDOStatement` |  |
| `nextRowset()` | `PDOStatement` |  |
| `setAttribute()` | `PDOStatement` |  |
| `setFetchMode()` | `PDOStatement` |  |
