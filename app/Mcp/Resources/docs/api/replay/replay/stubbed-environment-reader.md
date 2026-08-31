# StubbedEnvironmentReader

> The isolated-replay counterpart to RecordingEnvironmentReader: never reads a real environment variable, answering every call from an injected EffectLedger matched on the bare variable name.

The isolated-replay counterpart to [`RecordingEnvironmentReader`](/api/replay/env/recording-environment-reader/): never reads a real environment variable, answering every call from an injected [`EffectLedger`](/api/replay/replay/effect-ledger/) matched on the bare variable name.

A variable with no matching recorded effect throws rather than fabricating a value or falling through to the real `getenv()` -- inventing a value would fabricate a passing test, the same rule [`StubbedCache`](/api/replay/replay/stubbed-cache/)/[`StubbedPdo`](/api/replay/replay/stubbed-pdo/)/[`StubbedHttpTransport`](/api/replay/replay/stubbed-http-transport/) follow. A variable that WAS recorded as unset (`false`) replays as `false`, not an exception -- that is itself the recorded, correct answer.

## Synopsis

`final class StubbedEnvironmentReader implements EnvironmentReaderInterface`

|  |  |
|---|---|
| Implements | [`EnvironmentReaderInterface`](/api/support/environment/environment-reader-interface/) |
| Source | `Replay/StubbedEnvironmentReader.php` |

## Constructor

### __construct()

`public function __construct(EffectLedger $ledger): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |

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
