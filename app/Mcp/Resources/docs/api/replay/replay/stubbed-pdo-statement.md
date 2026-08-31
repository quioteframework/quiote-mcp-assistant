# StubbedPdoStatement

> The isolated-replay counterpart to RecordingPdoStatement: never touches a real connection (never calls `parent::__construct()`), and answers `execute()`/`fetch()`/`fetchAll()`/`rowCount()` entirely from an injected EffectLedger, matching on the same normalized-SQL fingerprint the recorder used.

The isolated-replay counterpart to [`RecordingPdoStatement`](/api/replay/db/recording-pdo-statement/): never touches a real connection (never calls `parent::__construct()`), and answers `execute()`/`fetch()`/`fetchAll()`/`rowCount()` entirely from an injected [`EffectLedger`](/api/replay/replay/effect-ledger/), matching on the same normalized-SQL fingerprint the recorder used.

A ledger miss -- the SQL has no recorded counterpart, or every recorded effect for it has already been consumed -- raises rather than returning an empty/invented result: inventing a result would fabricate a passing test, which is exactly what isolated replay must not do.

Deliberately unsupported, same as the recording side: `fetchColumn()`, `bindColumn()`, `getColumnMeta()`, LOB streaming, and any fetch mode beyond ASSOC/NUM/OBJ/BOTH/default.

## Synopsis

`final class StubbedPdoStatement extends PDOStatement`

|  |  |
|---|---|
| Extends | `PDOStatement` |
| Uses | [`PdoRowFormatting`](/api/replay/db/pdo-row-formatting/) |
| Source | `Replay/StubbedPdoStatement.php` |

## Constructor

### __construct()

`public function __construct(EffectLedger $ledger, string $sql): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |
| `$sql` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`bindColumn(string|int $column, mixed &$var, int $type = PDO::PARAM_STR, int $maxLength = 0, mixed $driverOptions = null): bool`](#bindcolumn) |  |
| [`bindParam(string|int $param, mixed &$var, int $type = PDO::PARAM_STR, int $maxLength = 0, mixed $driverOptions = null): bool`](#bindparam) |  |
| [`bindValue(string|int $param, mixed $value, int $type = PDO::PARAM_STR): bool`](#bindvalue) | Records a bound value, so [`StubbedPdoStatement::execute()`](/api/replay/replay/stubbed-pdo-statement/#execute) fingerprints what the recorder fingerprinted. |
| [`execute(array<int|string, mixed>|null $params = null): bool`](#execute) | Matched on the same normalized-SQL-plus-parameter-digest fingerprint the recorder writes, so two executions of one prepared statement with different bound values are told apart rather than matched by position. |
| [`fetch(int $mode = PDO::FETCH_DEFAULT, int $cursorOrientation = PDO::FETCH_ORI_NEXT, int $cursorOffset = 0): mixed`](#fetch) |  |
| [`fetchAll(int $mode = PDO::FETCH_DEFAULT, mixed ...$args): list<mixed>`](#fetchall) |  |
| [`fetchColumn(int $column = 0): mixed`](#fetchcolumn) | Answered from the snapshot, matching [`RecordingPdoStatement::fetchColumn()`](/api/replay/db/recording-pdo-statement/#fetchcolumn). |
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

Records a bound value, so [`StubbedPdoStatement::execute()`](/api/replay/replay/stubbed-pdo-statement/#execute) fingerprints what the recorder fingerprinted.

| Parameter | Type | Description |
|---|---|---|
| `$param` | `string``|``int` |  |
| `$value` | `mixed` |  |
| `$type` | `int` |  |

Returns `bool`

### execute()

`public function execute(array<int|string, mixed>|null $params = null): bool`

Matched on the same normalized-SQL-plus-parameter-digest fingerprint the recorder writes, so two executions of one prepared statement with different bound values are told apart rather than matched by position.

Superseded by anything bound through
       [`StubbedPdoStatement::bindValue()`](/api/replay/replay/stubbed-pdo-statement/#bindvalue)/[`StubbedPdoStatement::bindParam()`](/api/replay/replay/stubbed-pdo-statement/#bindparam) only when null, matching the recording side.

| Parameter | Type | Description |
|---|---|---|
| `$params` | `array``<``int``|``string``, ``mixed``>``|``null` | Superseded by anything bound through [`StubbedPdoStatement::bindValue()`](/api/replay/replay/stubbed-pdo-statement/#bindvalue)/[`StubbedPdoStatement::bindParam()`](/api/replay/replay/stubbed-pdo-statement/#bindparam) only when null, matching the recording side. |

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

Answered from the snapshot, matching [`RecordingPdoStatement::fetchColumn()`](/api/replay/db/recording-pdo-statement/#fetchcolumn).

| Parameter | Type | Description |
|---|---|---|
| `$column` | `int` |  |

Returns `mixed`

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
