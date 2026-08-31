# FrozenClock

> A clock that does not move except when told to: every read answers the wall-clock/monotonic values last set, however much real time elapses between two calls.

A clock that does not move except when told to: every read answers the wall-clock/monotonic values last set, however much real time elapses between two calls.

This is what a deterministic test of anything expiry-based (a session timeout, a cache TTL, a cookie's `Expires`) wants -- a test asserting "expired after N seconds" should not depend on how fast the test runner happens to execute.

Wall-clock time is kept as a float Unix timestamp rather than a `DateTimeImmutable`, and [`FrozenClock::now()`](/api/support/clock/frozen-clock/#now) is derived from it via the `@seconds` constructor form (which -- since PHP 7.1 -- accepts a fractional part), the same conversion [`DateTimeValidator`](/api/validator/date-time-validator/) already relies on elsewhere in this codebase. The result is always UTC, matching what a bare `new DateTimeImmutable('@...')` produces.

## Synopsis

`final class FrozenClock implements ClockInterface`

|  |  |
|---|---|
| Implements | [`ClockInterface`](/api/support/clock/clock-interface/) |
| Source | `Support/Clock/FrozenClock.php` |

## Constructor

### __construct()

`public function __construct(float $wallClockSeconds = 0.0, float $monotonicSeconds = 0.0): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$wallClockSeconds` | `float` |  |
| `$monotonicSeconds` | `float` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`advance(float $seconds): void`](#advance) | Move both the wall clock and the monotonic clock forward by the same amount, as real elapsed time would -- the common case for "then N * seconds pass" in a test, as opposed to [`FrozenClock::set()`](/api/support/clock/frozen-clock/#set) simulating a clock step where only the wall clock moves. |
| [`fromDateTime(DateTimeInterface $now, float $monotonicSeconds = 0.0): FrozenClock`](#fromdatetime) | Build a FrozenClock frozen at $now, converted through its own timezone so a caller working in local time gets the wall-clock second it expects. |
| [`microtime(): float`](#microtime) | Wall-clock Unix timestamp with microsecond precision. |
| [`monotonic(): float`](#monotonic) | Seconds on a monotonic clock: immune to wall-clock steps, so only ever meaningful as the difference between two readings. |
| [`now(): DateTimeImmutable`](#now) | The current wall-clock time. |
| [`set(float $wallClockSeconds): void`](#set) | Jump the wall clock to $wallClockSeconds, leaving the monotonic reading untouched -- a wall-clock step (an NTP correction, a VM resync) is exactly the scenario [`ClockInterface::monotonic()`](/api/support/clock/clock-interface/#monotonic) exists to be immune to. |
| [`setMonotonic(float $monotonicSeconds): void`](#setmonotonic) |  |
| [`unixTimestamp(): int`](#unixtimestamp) | Wall-clock Unix timestamp in whole seconds. |

### advance()

`public function advance(float $seconds): void`

Move both the wall clock and the monotonic clock forward by the same amount, as real elapsed time would -- the common case for "then N * seconds pass" in a test, as opposed to [`FrozenClock::set()`](/api/support/clock/frozen-clock/#set) simulating a clock step where only the wall clock moves.

| Parameter | Type | Description |
|---|---|---|
| `$seconds` | `float` |  |

### fromDateTime()

`public static function fromDateTime(DateTimeInterface $now, float $monotonicSeconds = 0.0): FrozenClock`

Build a FrozenClock frozen at $now, converted through its own timezone so a caller working in local time gets the wall-clock second it expects.

| Parameter | Type | Description |
|---|---|---|
| `$now` | [`DateTimeInterface`](https://www.php.net/manual/en/class.datetimeinterface.php) |  |
| `$monotonicSeconds` | `float` |  |

Returns [`FrozenClock`](/api/support/clock/frozen-clock/)

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

### set()

`public function set(float $wallClockSeconds): void`

Jump the wall clock to $wallClockSeconds, leaving the monotonic reading untouched -- a wall-clock step (an NTP correction, a VM resync) is exactly the scenario [`ClockInterface::monotonic()`](/api/support/clock/clock-interface/#monotonic) exists to be immune to.

| Parameter | Type | Description |
|---|---|---|
| `$wallClockSeconds` | `float` |  |

### setMonotonic()

`public function setMonotonic(float $monotonicSeconds): void`

| Parameter | Type | Description |
|---|---|---|
| `$monotonicSeconds` | `float` |  |

### unixTimestamp()

`public function unixTimestamp(): int`

Wall-clock Unix timestamp in whole seconds.

Replaces a direct `time()` call.

Returns `int`
