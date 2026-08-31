# SeededRandomness

> A source of entropy that is not random at all: the same seed always produces the same sequence of SeededRandomness::bytes()/SeededRandomness::int() results, in call order.

A source of entropy that is not random at all: the same seed always produces the same sequence of [`SeededRandomness::bytes()`](/api/support/random/seeded-randomness/#bytes)/[`SeededRandomness::int()`](/api/support/random/seeded-randomness/#int) results, in call order.

This is what a deterministic test of anything id- or token-shaped wants -- a test asserting a specific generated session id, or a replay engine reproducing a recorded CSRF token, should not depend on the real CSPRNG happening to agree with what was recorded.

Backed by `Randomizer` over a seeded `Mt19937` engine -- not cryptographically secure, which is irrelevant here: the whole point is that the sequence is reproducible, not that it is unguessable.

## Synopsis

`final class SeededRandomness implements RandomnessInterface`

|  |  |
|---|---|
| Implements | [`RandomnessInterface`](/api/support/random/randomness-interface/) |
| Source | `Support/Random/SeededRandomness.php` |

## Constructor

### __construct()

`public function __construct(int $seed): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$seed` | `int` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`bytes(positive-int $length): string`](#bytes) | $length cryptographically-random-shaped bytes. |
| [`int(int $min, int $max): int`](#int) | A random integer in the inclusive range [$min, $max]. |

### bytes()

`public function bytes(positive-int $length): string`

$length cryptographically-random-shaped bytes.

| Parameter | Type | Description |
|---|---|---|
| `$length` | `positive-int` |  |

Returns `string`

### int()

`public function int(int $min, int $max): int`

A random integer in the inclusive range [$min, $max].

Replaces a direct `random_int($min, $max)` call.

| Parameter | Type | Description |
|---|---|---|
| `$min` | `int` |  |
| `$max` | `int` |  |

Returns `int`
