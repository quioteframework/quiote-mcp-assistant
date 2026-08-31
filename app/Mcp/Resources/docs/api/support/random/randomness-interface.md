# RandomnessInterface

> The one seam every direct random_bytes()/random_int() call site on the request path is meant to go through instead.

The one seam every direct random_bytes()/random_int() call site on the request path is meant to go through instead.

Mirrors [`ClockInterface`](/api/support/clock/clock-interface/)'s role for `time()`: production gets [`SystemRandomness`](/api/support/random/system-randomness/), a test or a replay engine swaps in [`SeededRandomness`](/api/support/random/seeded-randomness/) so a session id, a correlation id or a CSRF token comes out the same on every run.

Deliberately just two primitives -- raw bytes and a bounded integer -- since every current call site reduces to one or the other (a byte string that gets base64/hex-encoded, or a probability roll).

## Synopsis

`interface RandomnessInterface`

|  |  |
|---|---|
| Implemented by | [`SeededRandomness`](/api/support/random/seeded-randomness/), [`SystemRandomness`](/api/support/random/system-randomness/) |
| Source | `Support/Random/RandomnessInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`bytes(positive-int $length): string`](#bytes) | $length cryptographically-random-shaped bytes. |
| [`int(int $min, int $max): int`](#int) | A random integer in the inclusive range [$min, $max]. |

### bytes()

`abstract public function bytes(positive-int $length): string`

$length cryptographically-random-shaped bytes.

| Parameter | Type | Description |
|---|---|---|
| `$length` | `positive-int` |  |

Returns `string`

### int()

`abstract public function int(int $min, int $max): int`

A random integer in the inclusive range [$min, $max].

Replaces a direct `random_int($min, $max)` call.

| Parameter | Type | Description |
|---|---|---|
| `$min` | `int` |  |
| `$max` | `int` |  |

Returns `int`
