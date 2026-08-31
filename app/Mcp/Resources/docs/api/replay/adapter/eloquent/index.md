# Eloquent

> The Quiote\\Replay\\Adapter\\Eloquent namespace — 5 documented types.

Everything under `Quiote\Replay\Adapter\Eloquent`.

## Classes

| Class | Description |
|---|---|
| [`EloquentEffectSource`](/api/replay/adapter/eloquent/eloquent-effect-source/) | The [`EffectSource`](/api/replay/recording/effect-source/) implementation `Quiote\Replay\Recording\RecorderMiddleware` activates/deactivates around one request. |
| [`EloquentMinimalEventDispatcher`](/api/replay/adapter/eloquent/eloquent-minimal-event-dispatcher/) | A minimal `Illuminate\Contracts\Events\Dispatcher` implementation, used only as the fallback `EloquentQueryRecorder::attach()` installs on a `Illuminate\Database\Connection` that has no event dispatcher of its own -- which is the case for `Quiote\Database\Adapter\Eloquent\EloquentDatabase`'s `connect()`, which never calls `Capsule::setEventDispatcher()`. |
| [`EloquentQueryRecorder`](/api/replay/adapter/eloquent/eloquent-query-recorder/) | Records one [`EffectKind::Db`](/api/replay/cassette/effect-kind/#db) entry per query on an Eloquent (illuminate/database) connection, via `Connection::listen()` -- the `Illuminate\Database\Events\QueryExecuted` event Eloquent already fires after every query, rather than a PDO/DBAL-style decorator. |
| [`ReplayEloquentDatabase`](/api/replay/adapter/eloquent/replay-eloquent-database/) | [`EloquentDatabase`](/api/database/adapter/eloquent/eloquent-database/), with [`EloquentQueryRecorder`](/api/replay/adapter/eloquent/eloquent-query-recorder/) attached to the Illuminate connection it builds. |
| [`ReplayEloquentPlugin`](/api/replay/adapter/eloquent/replay-eloquent-plugin/) | Wires Eloquent's own `QueryExecuted` event seam into `quioteframework/replay`'s generic effect-recording seam, through the same plugin mechanism every other Quiote package uses. |
