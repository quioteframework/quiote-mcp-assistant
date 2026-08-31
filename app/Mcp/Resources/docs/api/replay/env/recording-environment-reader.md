# RecordingEnvironmentReader

> A decorating environment reader: wraps a real inner EnvironmentReaderInterface and appends one EffectKind::Env entry per `get()` call to an injected EffectLedger, returning the real value completely untouched to the caller.

A decorating environment reader: wraps a real inner [`EnvironmentReaderInterface`](/api/support/environment/environment-reader-interface/) and appends one [`EffectKind::Env`](/api/replay/cassette/effect-kind/#env) entry per `get()` call to an injected [`EffectLedger`](/api/replay/replay/effect-ledger/), returning the real value completely untouched to the caller.

Fingerprint is the bare variable name -- unlike [`RecordingCache`](/api/replay/cache/recording-cache/)'s operation-scoped fingerprint, there is only one operation here (`get()`; environment variables are never written through this interface), so there is no cross-operation collision to guard against.

`getenv()`'s own contract already distinguishes "unset" (`false`) from any string value, including an empty one, so no extra hit/miss sentinel is needed the way [`RecordingCache::get()`](/api/replay/cache/recording-cache/#get) needed one for PSR-16's `null`-vs-miss ambiguity: the recorded `result` is simply the exact `string|false` the inner reader returned.

A real-reader exception is never swallowed: no effect is recorded for a failed call, and the exception propagates exactly as it would through the undecorated reader, matching every other recorder in this package.

## Synopsis

`final class RecordingEnvironmentReader implements EnvironmentReaderInterface`

|  |  |
|---|---|
| Implements | [`EnvironmentReaderInterface`](/api/support/environment/environment-reader-interface/) |
| Source | `Env/RecordingEnvironmentReader.php` |

## Constructor

### __construct()

`public function __construct(EnvironmentReaderInterface $reader, EffectLedger $ledger, ClockInterface $clock = new SystemClock(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$reader` | [`EnvironmentReaderInterface`](/api/support/environment/environment-reader-interface/) |  |
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`get(string $name): string|false`](#get) | The value of environment variable $name, or false when it is unset. |

### get()

`public function get(string $name): string|false`

The value of environment variable $name, or false when it is unset.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `string``|``false`
