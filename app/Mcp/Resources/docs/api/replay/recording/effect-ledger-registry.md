# EffectLedgerRegistry

> Routes a driver observation back to the request it belongs to, by correlation id.

Routes a driver observation back to the request it belongs to, by correlation id.

The plumbing an [`EffectSource`](/api/replay/recording/effect-source/) implementation needs when its underlying instrumentation seam is process-scoped rather than per-connection (Propulsion's `addQueryObserver()` being the motivating case, in `quioteframework/replay-propulsion`) -- a single observer registered once at boot needs to find *which* request's [`EffectLedger`](/api/replay/replay/effect-ledger/) a given correlation id belongs to.

Safe under a shared-process worker model for the same reason a driver's own correlation id is (see e.g. Propulsion's `docs/WORKER_MODE.md` R10): each request uses a unique id (`Quiote\Support\CorrelationId`), so concurrent requests never collide on the same key even though the underlying array is one shared structure.

## Synopsis

`final class EffectLedgerRegistry`

|  |  |
|---|---|
| Source | `Recording/EffectLedgerRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`forget(string $correlationId): void`](#forget) |  |
| [`get(?string $correlationId): ?EffectLedger`](#get) | Null when no request is recording under this correlation id (including when it's null itself). |
| [`register(string $correlationId, EffectLedger $ledger): void`](#register) |  |
| [`reset(): void`](#reset) | Test isolation. |

### forget()

`public static function forget(string $correlationId): void`

| Parameter | Type | Description |
|---|---|---|
| `$correlationId` | `string` |  |

### get()

`public static function get(?string $correlationId): ?EffectLedger`

Null when no request is recording under this correlation id (including when it's null itself).

| Parameter | Type | Description |
|---|---|---|
| `$correlationId` | `?``string` |  |

Returns `?`[`EffectLedger`](/api/replay/replay/effect-ledger/)

### register()

`public static function register(string $correlationId, EffectLedger $ledger): void`

| Parameter | Type | Description |
|---|---|---|
| `$correlationId` | `string` |  |
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |

### reset()

`public static function reset(): void`

Test isolation.
