# EloquentEffectSource

> The EffectSource implementation `Quiote\\Replay\\Recording\\RecorderMiddleware` activates/deactivates around one request.

The [`EffectSource`](/api/replay/recording/effect-source/) implementation `Quiote\Replay\Recording\RecorderMiddleware` activates/deactivates around one request.

[`EloquentQueryRecorder`](/api/replay/adapter/eloquent/eloquent-query-recorder/) is attached once, to a specific connection, so this source only has to point [`ActiveEffectLedger`](/api/replay/recording/active-effect-ledger/) at the current request's ledger -- every `ReplayEloquentDatabase` connection reads it from there.

## Synopsis

`final class EloquentEffectSource implements EffectSource`

|  |  |
|---|---|
| Implements | [`EffectSource`](/api/replay/recording/effect-source/) |
| Source | `EloquentEffectSource.php` |

## Methods

| Method | Description |
|---|---|
| [`activate(string $correlationId, EffectLedger $ledger): void`](#activate) | Called once, before `$handler->handle()`, for every request `RecorderMiddleware` buffers. |
| [`deactivate(string $correlationId): void`](#deactivate) | Called once, as soon as `$handler->handle()` returns or throws. |

### activate()

`public function activate(string $correlationId, EffectLedger $ledger): void`

Called once, before `$handler->handle()`, for every request `RecorderMiddleware` buffers.

| Parameter | Type | Description |
|---|---|---|
| `$correlationId` | `string` |  |
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |

### deactivate()

`public function deactivate(string $correlationId): void`

Called once, as soon as `$handler->handle()` returns or throws.

| Parameter | Type | Description |
|---|---|---|
| `$correlationId` | `string` |  |
