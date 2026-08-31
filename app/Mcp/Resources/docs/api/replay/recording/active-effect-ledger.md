# ActiveEffectLedger

> The single currently-active EffectLedger, for a driver whose recorder is a decorator wrapped once around a specific connection (the Doctrine/Eloquent/Cycle shape) rather than a process-scoped observer (Propulsion's shape, which needs EffectLedgerRegistry's correlation-id map instead -- see that class's own docblock).

The single currently-active [`EffectLedger`](/api/replay/replay/effect-ledger/), for a driver whose recorder is a decorator wrapped once around a specific connection (the Doctrine/Eloquent/Cycle shape) rather than a process-scoped observer (Propulsion's shape, which needs [`EffectLedgerRegistry`](/api/replay/recording/effect-ledger-registry/)'s correlation-id map instead -- see that class's own docblock).

A per-connection decorator is installed exactly once, when `DatabaseManager::recycleConnections()` first builds the connection -- and, per that method's own docblock, the connection is then recycled (ping()'d), not rebuilt, for the rest of the worker's lifetime. A ledger fixed into the decorator's constructor at that first connect() would therefore silently keep recording every later request's queries into the first request's already-finished ledger. Reading the ledger dynamically here instead -- [`EffectSource::activate()`](/api/replay/recording/effect-source/#activate)/`deactivate()} call [`ActiveEffectLedger::set()`](/api/replay/recording/active-effect-ledger/#set) once per request -- makes the decorator correct for the connection's entire lifetime, not just its first use.

No correlation id is needed, unlike [`EffectLedgerRegistry`](/api/replay/recording/effect-ledger-registry/): PHP statics are thread-local under ZTS, so concurrent worker threads never share this value.

A stack rather than a single slot, though, because dispatch does re-enter. `activate()` runs before `$handler->handle()` and `deactivate()` right after it returns, which makes one request per thread true only as long as nothing dispatches a request from inside one -- and this package itself does: `ReplayEngine` and `ReplayTestCase` both go through `Context::getRequestHandler()->handle()`, potentially from inside a request that is recording, as would any internal forward or sub-request. With a single slot the inner `deactivate()` was an unconditional clear, so the outer request's remaining queries went unrecorded with nothing to say so. Restoring the previous value turns the invariant from an assertion in this docblock into a property of the code.

## Synopsis

`final class ActiveEffectLedger`

|  |  |
|---|---|
| Source | `Recording/ActiveEffectLedger.php` |

## Methods

| Method | Description |
|---|---|
| [`depth(): int`](#depth) | How many requests are recording on this thread, outermost included. |
| [`get(): ?EffectLedger`](#get) | Null when no request is currently recording on this thread. |
| [`reset(): void`](#reset) | Test isolation. |
| [`set(?EffectLedger $ledger): void`](#set) | Pushes a ledger, or pops back to the enclosing one when given null. |

### depth()

`public static function depth(): int`

How many requests are recording on this thread, outermost included.

Nesting depth.

Returns `int`

### get()

`public static function get(): ?EffectLedger`

Null when no request is currently recording on this thread.

Returns `?`[`EffectLedger`](/api/replay/replay/effect-ledger/)

### reset()

`public static function reset(): void`

Test isolation.

### set()

`public static function set(?EffectLedger $ledger): void`

Pushes a ledger, or pops back to the enclosing one when given null.

The null form is what [`EffectSource::deactivate()`](/api/replay/recording/effect-source/#deactivate) calls, so a nested request restores its parent's ledger rather than clearing recording for the rest of that parent's work.

| Parameter | Type | Description |
|---|---|---|
| `$ledger` | `?`[`EffectLedger`](/api/replay/replay/effect-ledger/) |  |
