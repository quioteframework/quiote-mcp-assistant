# Random

> The Quiote\\Support\\Random namespace — 4 documented types.

Everything under `Quiote\Support\Random`.

## Classes

| Class | Description |
|---|---|
| [`Randomness`](/api/support/random/randomness/) | Static facade over the process-wide source of entropy, mirroring [`Clock`](/api/support/clock/clock/). |
| [`SeededRandomness`](/api/support/random/seeded-randomness/) | A source of entropy that is not random at all: the same seed always produces the same sequence of [`SeededRandomness::bytes()`](/api/support/random/seeded-randomness/#bytes)/[`SeededRandomness::int()`](/api/support/random/seeded-randomness/#int) results, in call order. |
| [`SystemRandomness`](/api/support/random/system-randomness/) | The real source of entropy: [`SystemRandomness::bytes()`](/api/support/random/system-randomness/#bytes)/[`SystemRandomness::int()`](/api/support/random/system-randomness/#int) answer from PHP's CSPRNG exactly like `random_bytes()`/`random_int()` always did. |

## Interfaces

| Interface | Description |
|---|---|
| [`RandomnessInterface`](/api/support/random/randomness-interface/) | The one seam every direct random_bytes()/random_int() call site on the request path is meant to go through instead. |
