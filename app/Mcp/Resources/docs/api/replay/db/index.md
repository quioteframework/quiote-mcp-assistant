# Db

> The Quiote\\Replay\\Db namespace — 3 documented types.

Everything under `Quiote\Replay\Db`.

## Classes

| Class | Description |
|---|---|
| [`RecordingPdo`](/api/replay/db/recording-pdo/) | A drop-in replacement for `\PDO` (see `Quiote\Database\PdoDatabase::connect()`, which builds `new PDO($dsn, $username, $password, $options)`): connects for real, behaves exactly like a bare `\PDO` to the caller, and additionally appends one [`EffectKind::Db`](/api/replay/cassette/effect-kind/#db) entry per statement execution to an injected [`EffectLedger`](/api/replay/replay/effect-ledger/) -- `query()`/`prepare()->execute()` through [`RecordingPdoStatement`](/api/replay/db/recording-pdo-statement/) (installed via `PDO::ATTR_STATEMENT_CLASS`), `exec()` directly, since it has no result set to snapshot. |
| [`RecordingPdoStatement`](/api/replay/db/recording-pdo-statement/) | The statement class [`RecordingPdo`](/api/replay/db/recording-pdo/) installs via `PDO::ATTR_STATEMENT_CLASS`, so every statement it prepares records one [`EffectKind::Db`](/api/replay/cassette/effect-kind/#db) effect per [`RecordingPdoStatement::execute()`](/api/replay/db/recording-pdo-statement/#execute) call. |

## Traits

| Trait | Description |
|---|---|
| [`PdoRowFormatting`](/api/replay/db/pdo-row-formatting/) | Shared by [`RecordingPdoStatement`](/api/replay/db/recording-pdo-statement/) and [`StubbedPdoStatement`](/api/replay/replay/stubbed-pdo-statement/): both serve a snapshotted result set with no live cursor to delegate to, and both need to reformat a row into whichever `PDO::FETCH_*` mode the caller asked for, entirely in PHP. |
