# SystemClock

> The real clock: ClockInterface::now()/ClockInterface::unixTimestamp()/ ClockInterface::microtime() answer from the system wall clock exactly like `new DateTimeImmutable()`/`time()`/`microtime(true)` always did, and ClockInterface::monotonic() from `hrtime(true)`.

The real clock: [`ClockInterface::now()`](/api/support/clock/clock-interface/#now)/[`ClockInterface::unixTimestamp()`](/api/support/clock/clock-interface/#unixtimestamp)/ [`ClockInterface::microtime()`](/api/support/clock/clock-interface/#microtime) answer from the system wall clock exactly like `new DateTimeImmutable()`/`time()`/`microtime(true)` always did, and [`ClockInterface::monotonic()`](/api/support/clock/clock-interface/#monotonic) from `hrtime(true)`.

This is what the container binds [`ClockInterface`](/api/support/clock/clock-interface/) to by default; nothing here is mockable, which is the point -- tests reach for [`FrozenClock`](/api/support/clock/frozen-clock/) or [`OffsetClock`](/api/support/clock/offset-clock/) instead of stubbing this class.

## Synopsis

`final class SystemClock implements ClockInterface`

|  |  |
|---|---|
| Implements | [`ClockInterface`](/api/support/clock/clock-interface/) |
| Source | `Support/Clock/SystemClock.php` |

## Methods

| Method | Description |
|---|---|
| [`microtime(): float`](#microtime) | Wall-clock Unix timestamp with microsecond precision. |
| [`monotonic(): float`](#monotonic) | Seconds on a monotonic clock: immune to wall-clock steps, so only ever meaningful as the difference between two readings. |
| [`now(): DateTimeImmutable`](#now) | The current wall-clock time. |
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

### unixTimestamp()

`public function unixTimestamp(): int`

Wall-clock Unix timestamp in whole seconds.

Replaces a direct `time()` call.

Returns `int`
