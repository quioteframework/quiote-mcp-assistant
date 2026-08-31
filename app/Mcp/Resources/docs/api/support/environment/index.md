# Environment

> The Quiote\\Support\\Environment namespace — 3 documented types.

Everything under `Quiote\Support\Environment`.

## Classes

| Class | Description |
|---|---|
| [`Environment`](/api/support/environment/environment/) | Static facade over the process-wide environment reader, mirroring [`Clock`](/api/support/clock/clock/) and [`Randomness`](/api/support/random/randomness/). |
| [`SystemEnvironmentReader`](/api/support/environment/system-environment-reader/) | The real environment: `getenv()` first, then `$_ENV`. |

## Interfaces

| Interface | Description |
|---|---|
| [`EnvironmentReaderInterface`](/api/support/environment/environment-reader-interface/) | The one seam a direct `getenv()` call site on the request path is meant to go through instead, mirroring [`ClockInterface`](/api/support/clock/clock-interface/)'s and [`RandomnessInterface`](/api/support/random/randomness-interface/)'s role for `time()` and `random_bytes()`: production gets [`SystemEnvironmentReader`](/api/support/environment/system-environment-reader/), a replay engine swaps in a stub answering from a recorded effect ledger. |
