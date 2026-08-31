# OffsetClock

> A clock that ticks in real time but reports a fixed offset from another clock -- \"the client's clock is ten minutes fast\", \"this node's clock has * drifted 30 seconds behind the cluster\".

A clock that ticks in real time but reports a fixed offset from another clock -- "the client's clock is ten minutes fast", "this node's clock has * drifted 30 seconds behind the cluster".

Unlike [`FrozenClock`](/api/support/clock/frozen-clock/), time still passes between two reads; only the offset is under test control.

The offset is applied to every reading, monotonic included: a constant shift cancels out of any duration measured as the difference of two readings, so offsetting it too keeps [`OffsetClock::monotonic()`](/api/support/clock/offset-clock/#monotonic) internally consistent with [`OffsetClock::microtime()`](/api/support/clock/offset-clock/#microtime) rather than needing a separate flag for "offset wall-clock only".

## Synopsis

`final class OffsetClock implements ClockInterface`

|  |  |
|---|---|
| Implements | [`ClockInterface`](/api/support/clock/clock-interface/) |
| Source | `Support/Clock/OffsetClock.php` |

## Constructor

### __construct()

`public function __construct(ClockInterface $inner, float $offsetSeconds = 0.0): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$inner` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |
| `$offsetSeconds` | `float` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`microtime(): float`](#microtime) | Wall-clock Unix timestamp with microsecond precision. |
| [`monotonic(): float`](#monotonic) | Seconds on a monotonic clock: immune to wall-clock steps, so only ever meaningful as the difference between two readings. |
| [`now(): DateTimeImmutable`](#now) | The current wall-clock time. |
| [`offset(): float`](#offset) |  |
| [`setOffset(float $offsetSeconds): void`](#setoffset) |  |
| [`unixTimestamp(): int`](#unixtimestamp) | Wall-clock Unix timestamp in whole seconds. |

### microtime()

`public function microtime(): float`

Wall-clock Unix timestamp with microsecond precision.

Replaces a direct `microtime(true)` call.

Returns `float`

### monotonic()

`public function monotonic(): float`

Seconds on a monotonic clock: immune to wall-clock steps, so only ever meaningful as the difference between two readings.

Replaces a direct `hrtime(true)` call (or a `microtime(true)` one used for a duration rather than a point in time).

Returns `float`

### now()

`public function now(): DateTimeImmutable`

The current wall-clock time.

Returns [`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php)

### offset()

`public function offset(): float`

Returns `float`

### setOffset()

`public function setOffset(float $offsetSeconds): void`

| Parameter | Type | Description |
|---|---|---|
| `$offsetSeconds` | `float` |  |

### unixTimestamp()

`public function unixTimestamp(): int`

Wall-clock Unix timestamp in whole seconds.

Replaces a direct `time()` call.

Returns `int`
