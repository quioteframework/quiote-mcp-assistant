# Doctrine

> The Quiote\\Replay\\Adapter\\Doctrine namespace — 12 documented types.

Everything under `Quiote\Replay\Adapter\Doctrine`.

## Classes

| Class | Description |
|---|---|
| [`DoctrineEffectSource`](/api/replay/adapter/doctrine/doctrine-effect-source/) | The `EffectSource` implementation `Quiote\Replay\Recording\RecorderMiddleware` activates/deactivates around one request. |
| [`DoctrineRecordingConnection`](/api/replay/adapter/doctrine/doctrine-recording-connection/) | Records `query()`/`exec()` called directly on the connection (bypassing a prepared `Statement`), and hands back a [`DoctrineRecordingStatement`](/api/replay/adapter/doctrine/doctrine-recording-statement/) from `prepare()` so a prepared statement's own `execute()` is recorded too. |
| [`DoctrineRecordingDriver`](/api/replay/adapter/doctrine/doctrine-recording-driver/) | Wraps the real driver so every connection it builds records -- or, during an isolated replay, never opens at all. |
| [`DoctrineRecordingMiddleware`](/api/replay/adapter/doctrine/doctrine-recording-middleware/) | A `Doctrine\DBAL\Driver\Middleware` (DBAL 4's own extension seam, installed via `Doctrine\DBAL\Configuration::setMiddlewares([$middleware])` passed to `Doctrine\DBAL\DriverManager::getConnection($params, $config)`) that appends one [`EffectKind::Db`](/api/replay/cassette/effect-kind/#db) entry per query to whichever [`EffectLedger`](/api/replay/replay/effect-ledger/) [`ActiveEffectLedger`](/api/replay/recording/active-effect-ledger/) currently holds. |
| [`DoctrineRecordingStatement`](/api/replay/adapter/doctrine/doctrine-recording-statement/) | Records one [`EffectKind::Db`](/api/replay/cassette/effect-kind/#db) entry per `execute()`, following the same shape as [`RecordingPdoStatement`](/api/replay/db/recording-pdo-statement/): bound parameters are captured via `bindValue()` (mirroring `Doctrine\DBAL\Logging\Statement`, DBAL's own reference middleware for observing a statement), and the real `Result` is snapshotted once into a [`DoctrineSnapshotResult`](/api/replay/adapter/doctrine/doctrine-snapshot-result/) so the caller's own fetch calls keep working after the row set has been read once for the ledger. |
| [`DoctrineSnapshotResult`](/api/replay/adapter/doctrine/doctrine-snapshot-result/) | An in-memory `Result` snapshot: what `DoctrineRecordingStatement`/ `DoctrineRecordingConnection` hand back to the caller in place of the real, now-consumed `Result` once a query's rows have been captured for the ledger, so the caller's own fetch loop still works normally. |
| [`LedgerBackedConnection`](/api/replay/adapter/doctrine/ledger-backed-connection/) | A DBAL driver connection that answers entirely from a replaying [`EffectLedger`](/api/replay/replay/effect-ledger/) and never opens anything. |
| [`LedgerBackedStatement`](/api/replay/adapter/doctrine/ledger-backed-statement/) | The statement [`LedgerBackedConnection`](/api/replay/adapter/doctrine/ledger-backed-connection/) prepares: collects bound values, then answers from the ledger by the same fingerprint the recorder wrote. |
| [`LedgerServedResult`](/api/replay/adapter/doctrine/ledger-served-result/) | Builds the [`DoctrineSnapshotResult`](/api/replay/adapter/doctrine/doctrine-snapshot-result/) a replaying statement answers with, from the matching recorded effect. |
| [`ReplayDoctrineDatabase`](/api/replay/adapter/doctrine/replay-doctrine-database/) | [`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/), with [`DoctrineRecordingMiddleware`](/api/replay/adapter/doctrine/doctrine-recording-middleware/) installed on every DBAL connection it builds. |
| [`ReplayDoctrineDbalDatabase`](/api/replay/adapter/doctrine/replay-doctrine-dbal-database/) | [`DoctrineDbalDatabase`](/api/database/adapter/doctrine/doctrine-dbal-database/), with [`DoctrineRecordingMiddleware`](/api/replay/adapter/doctrine/doctrine-recording-middleware/) installed on the connection it builds. |
| [`ReplayDoctrinePlugin`](/api/replay/adapter/doctrine/replay-doctrine-plugin/) | Wires Doctrine's own DBAL driver-middleware seam into `quioteframework/replay`'s generic effect-recording seam, through the same plugin mechanism every other Quiote package uses. |
