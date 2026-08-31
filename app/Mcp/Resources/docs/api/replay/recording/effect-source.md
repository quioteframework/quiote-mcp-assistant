# EffectSource

> A driver-specific package's hook into RecorderMiddleware's recording lifecycle, for an ORM/driver whose own instrumentation seam is process-scoped rather than per-connection -- Propulsion's `addQueryObserver()` being the motivating case (see `quioteframework/replay-propulsion`'s own `PropulsionEffectSource`): a single observer is registered once at boot, and needs telling, for the duration of one request, which correlation id's queries belong to which EffectLedger.

A driver-specific package's hook into [`RecorderMiddleware`](/api/replay/recording/recorder-middleware/)'s recording lifecycle, for an ORM/driver whose own instrumentation seam is process-scoped rather than per-connection -- Propulsion's `addQueryObserver()` being the motivating case (see `quioteframework/replay-propulsion`'s own `PropulsionEffectSource`): a single observer is registered once at boot, and needs telling, for the duration of one request, which correlation id's queries belong to which [`EffectLedger`](/api/replay/replay/effect-ledger/).

A driver whose recorder is instead a per-request decorator constructed around a specific connection (the PDO/Doctrine/Eloquent/Cycle shape) has no need of this seam at all -- it just takes an `EffectLedger` directly in its constructor, wherever that connection gets built.

`packages/replay` itself ships no implementation of this interface and has no compile-time dependency on any ORM; a driver package registers one via [`EffectSourceRegistry::register()`](/api/replay/recording/effect-source-registry/#register) from its own plugin.

## Synopsis

`interface EffectSource`

|  |  |
|---|---|
| Implemented by | [`CycleEffectSource`](/api/replay/adapter/cycle/cycle-effect-source/), [`EloquentEffectSource`](/api/replay/adapter/eloquent/eloquent-effect-source/), [`IsolatesFromLedger`](/api/replay/replay/isolates-from-ledger/) |
| Source | `Recording/EffectSource.php` |

## Methods

| Method | Description |
|---|---|
| [`activate(string $correlationId, EffectLedger $ledger): void`](#activate) | Called once, before `$handler->handle()`, for every request [`RecorderMiddleware`](/api/replay/recording/recorder-middleware/) buffers. |
| [`deactivate(string $correlationId): void`](#deactivate) | Called once, as soon as `$handler->handle()` returns or throws. |

### activate()

`abstract public function activate(string $correlationId, EffectLedger $ledger): void`

Called once, before `$handler->handle()`, for every request [`RecorderMiddleware`](/api/replay/recording/recorder-middleware/) buffers.

| Parameter | Type | Description |
|---|---|---|
| `$correlationId` | `string` |  |
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |

### deactivate()

`abstract public function deactivate(string $correlationId): void`

Called once, as soon as `$handler->handle()` returns or throws.

| Parameter | Type | Description |
|---|---|---|
| `$correlationId` | `string` |  |
