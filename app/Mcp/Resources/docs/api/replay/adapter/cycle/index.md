# Cycle

> The Quiote\\Replay\\Adapter\\Cycle namespace — 4 documented types.

Everything under `Quiote\Replay\Adapter\Cycle`.

## Classes

| Class | Description |
|---|---|
| [`CycleEffectSource`](/api/replay/adapter/cycle/cycle-effect-source/) | The [`EffectSource`](/api/replay/recording/effect-source/) implementation `Quiote\Replay\Recording\RecorderMiddleware` activates/deactivates around one request. |
| [`CycleRecordingLogger`](/api/replay/adapter/cycle/cycle-recording-logger/) | Records one [`EffectKind::Db`](/api/replay/cassette/effect-kind/#db) entry per successful query on a Cycle (`cycle/database`) connection, and forwards every message to whatever logger the application already had, via Cycle's own PSR-3 logger seam -- `Cycle\Database\Driver\Driver::statement()` logs every query through whatever `Psr\Log\LoggerInterface` was installed on it, at `info` on success and `error`+`alert` on failure (read directly from `vendor/cycle/database/src/Driver/Driver.php`, not assumed). |
| [`ReplayCycleDatabase`](/api/replay/adapter/cycle/replay-cycle-database/) | [`CycleDatabase`](/api/database/adapter/cycle/cycle-database/), with [`CycleRecordingLogger`](/api/replay/adapter/cycle/cycle-recording-logger/) installed on the `Cycle\Database\DatabaseManager` it builds. |
| [`ReplayCyclePlugin`](/api/replay/adapter/cycle/replay-cycle-plugin/) | Wires Cycle's own PSR-3 logger seam into `quioteframework/replay`'s generic effect-recording seam, through the same plugin mechanism every other Quiote package uses. |
