# DoctrineSnapshotResult

> An in-memory Result snapshot: what `DoctrineRecordingStatement`/ `DoctrineRecordingConnection` hand back to the caller in place of the real, now-consumed `Result` once a query's rows have been captured for the ledger, so the caller's own fetch loop still works normally.

An in-memory `Result` snapshot: what `DoctrineRecordingStatement`/ `DoctrineRecordingConnection` hand back to the caller in place of the real, now-consumed `Result` once a query's rows have been captured for the ledger, so the caller's own fetch loop still works normally.

Deliberately not `Doctrine\DBAL\Cache\ArrayResult`: that class is marked `@internal` to DBAL's own caching layer and is not covered by DBAL's backward-compatibility promise, so depending on it here would be a fragile coupling to an implementation detail rather than a public contract.

`getColumnName()` is not part of `Result`'s enforced interface (it is declared only via the interface's `@method` docblock, and DBAL's own `AbstractResultMiddleware` checks `method_exists()` before calling it) -- this class implements it anyway, derived from the snapshotted rows' own keys, for parity with a real driver result.

## Synopsis

`final class DoctrineSnapshotResult implements Result`

|  |  |
|---|---|
| Implements | `Result` |
| Source | `DoctrineSnapshotResult.php` |

## Constructor

### __construct()

`public function __construct(list<array<string, mixed>> $rows, int|numeric-string $affectedRows, int|null $columnCount = null): mixed`

The real result's own columnCount(), captured before snapshotting.
       Required to answer correctly for an empty result set, where the rows carry no column
       names to count: a `SELECT` that matched nothing still has columns, and reporting 0
       is how a caller distinguishes a result set from a write --
       `Quiote\Replay\Db\RecordingPdoStatement` branches on exactly that. Null falls back
       to counting the first row's keys, for a caller constructing a snapshot directly with
       no real result to ask.

| Parameter | Type | Description |
|---|---|---|
| `$rows` | `list``<``array``<``string``, ``mixed``>``>` | Snapshotted rows, associative by column name. |
| `$affectedRows` | `int``|``numeric-string` | The real statement's own rowCount(), captured before snapshotting. |
| `$columnCount` | `int``|``null` | The real result's own columnCount(), captured before snapshotting. Required to answer correctly for an empty result set, where the rows carry no column names to count: a `SELECT` that matched nothing still has columns, and reporting 0 is how a caller distinguishes a result set from a write -- `Quiote\Replay\Db\RecordingPdoStatement` branches on exactly that. Null falls back to counting the first row's keys, for a caller constructing a snapshot directly with no real result to ask. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`columnCount(): int`](#columncount) | Returns the number of columns in the result |
| [`fetchAllAssociative(): list<array<string, mixed>>`](#fetchallassociative) | Returns an array containing all of the result rows represented as associative arrays. |
| [`fetchAllNumeric(): list<list<mixed>>`](#fetchallnumeric) | Returns an array containing all of the result rows represented as numeric arrays. |
| [`fetchAssociative(): array<string, mixed>|false`](#fetchassociative) | Returns the next row of the result as an associative array or FALSE if there are no more rows. |
| [`fetchFirstColumn(): list<mixed>`](#fetchfirstcolumn) | Returns an array containing the values of the first column of the result. |
| [`fetchNumeric(): list<mixed>|false`](#fetchnumeric) | Returns the next row of the result as a numeric array or FALSE if there are no more rows. |
| [`fetchOne(): mixed`](#fetchone) | The row's presence is what answers "was there a row" -- so a row whose first column is SQL `NULL` returns `null`, matching a real driver result, rather than the `false` DBAL uses for "no rows". |
| [`free(): void`](#free) | Discards the non-fetched portion of the result, enabling the originating statement to be executed again. |
| [`getColumnName(int $index): string`](#getcolumnname) |  |
| [`rowCount(): int|numeric-string`](#rowcount) | Returns the number of rows affected by the DELETE, INSERT, or UPDATE statement that produced the result. |

### columnCount()

`public function columnCount(): int`

Returns the number of columns in the result

Returns `int` — The number of columns in the result. If the columns cannot be counted, this method must return 0.

| Throws | When |
|---|---|
| `Exception` |  |

### fetchAllAssociative()

`public function fetchAllAssociative(): list<array<string, mixed>>`

Returns an array containing all of the result rows represented as associative arrays.

Returns `list``<``array``<``string``, ``mixed``>``>`

| Throws | When |
|---|---|
| `Exception` |  |

### fetchAllNumeric()

`public function fetchAllNumeric(): list<list<mixed>>`

Returns an array containing all of the result rows represented as numeric arrays.

Returns `list``<``list``<``mixed``>``>`

| Throws | When |
|---|---|
| `Exception` |  |

### fetchAssociative()

`public function fetchAssociative(): array<string, mixed>|false`

Returns the next row of the result as an associative array or FALSE if there are no more rows.

Returns `array``<``string``, ``mixed``>``|``false`

| Throws | When |
|---|---|
| `Exception` |  |

### fetchFirstColumn()

`public function fetchFirstColumn(): list<mixed>`

Returns an array containing the values of the first column of the result.

Returns `list``<``mixed``>`

| Throws | When |
|---|---|
| `Exception` |  |

### fetchNumeric()

`public function fetchNumeric(): list<mixed>|false`

Returns the next row of the result as a numeric array or FALSE if there are no more rows.

Returns `list``<``mixed``>``|``false`

| Throws | When |
|---|---|
| `Exception` |  |

### fetchOne()

`public function fetchOne(): mixed`

The row's presence is what answers "was there a row" -- so a row whose first column is SQL `NULL` returns `null`, matching a real driver result, rather than the `false` DBAL uses for "no rows".

Collapsing the two would make `SELECT MAX(id)` over an empty table, a nullable column and a `LEFT JOIN` miss all indistinguishable from an exhausted cursor, and any caller written as `if ($result->fetchOne() === false)` would change behaviour the moment this snapshot was installed.

Returns `mixed`

### free()

`public function free(): void`

Discards the non-fetched portion of the result, enabling the originating statement to be executed again.

### getColumnName()

`public function getColumnName(int $index): string`

| Parameter | Type | Description |
|---|---|---|
| `$index` | `int` |  |

Returns `string`

### rowCount()

`public function rowCount(): int|numeric-string`

Returns the number of rows affected by the DELETE, INSERT, or UPDATE statement that produced the result.

If the statement executed a SELECT query or a similar platform-specific SQL (e.g. DESCRIBE, SHOW, etc.), some database drivers may return the number of rows returned by that query. However, this behaviour is not guaranteed for all drivers and should not be relied on in portable applications.

If the number of rows exceeds `PHP_INT_MAX`, it might be returned as string if the driver supports it.

Returns `int``|``numeric-string`

| Throws | When |
|---|---|
| `Exception` |  |
