# SystemRandomness

> The real source of entropy: SystemRandomness::bytes()/SystemRandomness::int() answer from PHP's CSPRNG exactly like `random_bytes()`/`random_int()` always did.

The real source of entropy: [`SystemRandomness::bytes()`](/api/support/random/system-randomness/#bytes)/[`SystemRandomness::int()`](/api/support/random/system-randomness/#int) answer from PHP's CSPRNG exactly like `random_bytes()`/`random_int()` always did.

This is what the container binds [`RandomnessInterface`](/api/support/random/randomness-interface/) to by default; nothing here is mockable, which is the point -- tests reach for [`SeededRandomness`](/api/support/random/seeded-randomness/) instead of stubbing this class.

## Synopsis

`final class SystemRandomness implements RandomnessInterface`

|  |  |
|---|---|
| Implements | [`RandomnessInterface`](/api/support/random/randomness-interface/) |
| Source | `Support/Random/SystemRandomness.php` |

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
