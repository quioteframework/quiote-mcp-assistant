# DoctrineEffectSource

> The EffectSource implementation `Quiote\\Replay\\Recording\\RecorderMiddleware` activates/deactivates around one request.

The `EffectSource` implementation `Quiote\Replay\Recording\RecorderMiddleware` activates/deactivates around one request.

Unlike `quioteframework/replay-propulsion`'s [`PropulsionEffectSource`](/api/replay/adapter/propulsion/propulsion-effect-source/) (which routes by correlation id, because Propulsion's query observer is process-scoped), [`DoctrineRecordingMiddleware`](/api/replay/adapter/doctrine/doctrine-recording-middleware/)'s decorator chain is wrapped around one specific connection -- so this source only has to point [`ActiveEffectLedger`](/api/replay/recording/active-effect-ledger/) at the current request's ledger; every `ReplayDoctrineDatabase`/`ReplayDoctrineDbalDatabase` connection reads it from there.

Implements [`IsolatesFromLedger`](/api/replay/replay/isolates-from-ledger/) because that decorator chain is a DBAL driver middleware -- called *instead of* the real statement -- so it can serve a recorded result rather than only observe one. Of the four ORM adapters this package family ships, it is the only one whose seam allows that; see the interface's own docblock for why the others cannot.

## Synopsis

`final class DoctrineEffectSource implements IsolatesFromLedger`

|  |  |
|---|---|
| Implements | [`IsolatesFromLedger`](/api/replay/replay/isolates-from-ledger/) |
| Source | `DoctrineEffectSource.php` |

## Methods

| Method | Description |
|---|---|
| [`activate(string $correlationId, EffectLedger $ledger): void`](#activate) | Called once, before `$handler->handle()`, for every request `RecorderMiddleware` buffers. |
| [`beginIsolation(EffectLedger $ledger): void`](#beginisolation) | Nothing to do: [`DoctrineRecordingMiddleware`](/api/replay/adapter/doctrine/doctrine-recording-middleware/)'s decorator chain is already installed on the connection and reads [`ActiveEffectLedger`](/api/replay/recording/active-effect-ledger/) on every statement, which [`IsolatedReplay`](/api/replay/replay/isolated-replay/) has set to the replaying ledger by the time this runs. |
| [`deactivate(string $correlationId): void`](#deactivate) | Called once, as soon as `$handler->handle()` returns or throws. |
| [`endIsolation(): void`](#endisolation) | Called once, as soon as the dispatch returns or throws, to undo [`DoctrineEffectSource::beginIsolation()`](/api/replay/adapter/doctrine/doctrine-effect-source/#beginisolation). |

### activate()

`public function activate(string $correlationId, EffectLedger $ledger): void`

Called once, before `$handler->handle()`, for every request `RecorderMiddleware` buffers.

| Parameter | Type | Description |
|---|---|---|
| `$correlationId` | `string` |  |
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |

### beginIsolation()

`public function beginIsolation(EffectLedger $ledger): void`

Nothing to do: [`DoctrineRecordingMiddleware`](/api/replay/adapter/doctrine/doctrine-recording-middleware/)'s decorator chain is already installed on the connection and reads [`ActiveEffectLedger`](/api/replay/recording/active-effect-ledger/) on every statement, which [`IsolatedReplay`](/api/replay/replay/isolated-replay/) has set to the replaying ledger by the time this runs.

`DoctrineRecordingDriver::connect()` likewise sees it and hands back a connection that opens nothing.

Empty because the work is genuinely already done, not because it is unimplemented -- see `quioteframework/replay-propulsion`'s own implementation for the case where a driver has to be actively substituted instead.

| Parameter | Type | Description |
|---|---|---|
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |

### deactivate()

`public function deactivate(string $correlationId): void`

Called once, as soon as `$handler->handle()` returns or throws.

| Parameter | Type | Description |
|---|---|---|
| `$correlationId` | `string` |  |

### endIsolation()

`public function endIsolation(): void`

Called once, as soon as the dispatch returns or throws, to undo [`DoctrineEffectSource::beginIsolation()`](/api/replay/adapter/doctrine/doctrine-effect-source/#beginisolation).

Must be safe to call without a matching `beginIsolation()`, and must not throw: it runs in a `finally`, where a throw would replace whatever the replay itself was reporting -- and would leave a later request in the same process talking to a stub.
