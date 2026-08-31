# LedgerServedResult

> Builds the DoctrineSnapshotResult a replaying statement answers with, from the matching recorded effect.

Builds the [`DoctrineSnapshotResult`](/api/replay/adapter/doctrine/doctrine-snapshot-result/) a replaying statement answers with, from the matching recorded effect.

Kept out of the statement and connection decorators because both need it and neither should own it, and because the failure cases are the interesting part: what a replay does when the cassette has no counterpart for a query is the difference between a trustworthy replay and one that fabricates a passing run.

A miss raises. Answering with an empty result set would be inventing input -- the code would take whichever branch "no rows" leads to and the replay would report a clean run for a query that was never recorded. `EffectLedger::match()` also books the miss, so a caller that catches this still sees it in [`EffectLedger::misses()`](/api/replay/replay/effect-ledger/#misses).

## Synopsis

`final class LedgerServedResult`

|  |  |
|---|---|
| Source | `LedgerServedResult.php` |

## Methods

| Method | Description |
|---|---|
| [`affectedRowsForSql(EffectLedger $ledger, string $sql): int`](#affectedrowsforsql) | The affected-row count for a replayed `exec()`. |
| [`forSql(EffectLedger $ledger, string $sql, array<int|string, mixed> $params): DoctrineSnapshotResult`](#forsql) |  |

### affectedRowsForSql()

`public static function affectedRowsForSql(EffectLedger $ledger, string $sql): int`

The affected-row count for a replayed `exec()`.

| Parameter | Type | Description |
|---|---|---|
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |
| `$sql` | `string` |  |

Returns `int`

| Throws | When |
|---|---|
| `RuntimeException` | if the cassette has no counterpart, or recorded rows where a count was expected. |

### forSql()

`public static function forSql(EffectLedger $ledger, string $sql, array<int|string, mixed> $params): DoctrineSnapshotResult`

| Parameter | Type | Description |
|---|---|---|
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |
| `$sql` | `string` |  |
| `$params` | `array``<``int``|``string``, ``mixed``>` |  |

Returns [`DoctrineSnapshotResult`](/api/replay/adapter/doctrine/doctrine-snapshot-result/)

| Throws | When |
|---|---|
| `RuntimeException` | if the cassette has no counterpart for this statement. |
