# EnvironmentReaderInterface

> The one seam a direct `getenv()` call site on the request path is meant to go through instead, mirroring ClockInterface's and RandomnessInterface's role for `time()` and `random_bytes()`: production gets SystemEnvironmentReader, a replay engine swaps in a stub answering from a recorded effect ledger.

The one seam a direct `getenv()` call site on the request path is meant to go through instead, mirroring [`ClockInterface`](/api/support/clock/clock-interface/)'s and [`RandomnessInterface`](/api/support/random/randomness-interface/)'s role for `time()` and `random_bytes()`: production gets [`SystemEnvironmentReader`](/api/support/environment/system-environment-reader/), a replay engine swaps in a stub answering from a recorded effect ledger.

The return type matches `getenv()`'s own contract exactly -- `false` for an unset variable -- rather than a nullable string, so a caller migrating from a bare `getenv()` call needs no change beyond the collaborator it reads through.

## Synopsis

`interface EnvironmentReaderInterface`

|  |  |
|---|---|
| Implemented by | [`RecordingEnvironmentReader`](/api/replay/env/recording-environment-reader/), [`StubbedEnvironmentReader`](/api/replay/replay/stubbed-environment-reader/), [`SystemEnvironmentReader`](/api/support/environment/system-environment-reader/) |
| Source | `Support/Environment/EnvironmentReaderInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`get(string $name): string|false`](#get) | The value of environment variable $name, or false when it is unset. |

### get()

`abstract public function get(string $name): string|false`

The value of environment variable $name, or false when it is unset.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `string``|``false`
