# ClockInterface

> The one seam every direct time()/microtime()/new DateTime() call site in core is meant to go through instead.

The one seam every direct time()/microtime()/new DateTime() call site in core is meant to go through instead.

Extends `ClockInterface` — whose single `now()` method is the wall-clock reading most callers actually want — with the two reads the timing- and expiry-sensitive code in this codebase needs and PSR-Clock does not provide:

- [`ClockInterface::unixTimestamp()`](/api/support/clock/clock-interface/#unixtimestamp) and [`ClockInterface::microtime()`](/api/support/clock/clock-interface/#microtime) are wall-clock, exactly like `time()`/`microtime(true)`, for anything that stores or compares an epoch-relative expiry (a session's idle timeout, a cache TTL, a cookie's `Expires`). - [`ClockInterface::monotonic()`](/api/support/clock/clock-interface/#monotonic) is deliberately not wall-clock: it never steps backwards on an NTP correction or a VM clock resync, which is what a duration measurement (a request's execution time, a connection's idle check) actually needs. Mixing the two up is the class of bug documented on [`SessionManager`](/api/session/session-manager/)'s `resolveRedirect()`.

A test swaps in [`FrozenClock`](/api/support/clock/frozen-clock/) or [`OffsetClock`](/api/support/clock/offset-clock/); production gets [`SystemClock`](/api/support/clock/system-clock/).

## Synopsis

`interface ClockInterface extends ClockInterface`

|  |  |
|---|---|
| Implements | `ClockInterface` |
| Implemented by | [`FrozenClock`](/api/support/clock/frozen-clock/), [`OffsetClock`](/api/support/clock/offset-clock/), [`SystemClock`](/api/support/clock/system-clock/) |
| Source | `Support/Clock/ClockInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`microtime(): float`](#microtime) | Wall-clock Unix timestamp with microsecond precision. |
| [`monotonic(): float`](#monotonic) | Seconds on a monotonic clock: immune to wall-clock steps, so only ever meaningful as the difference between two readings. |
| [`now(): DateTimeImmutable`](#now) | The current wall-clock time. |
| [`unixTimestamp(): int`](#unixtimestamp) | Wall-clock Unix timestamp in whole seconds. |

### microtime()

`abstract public function microtime(): float`

Wall-clock Unix timestamp with microsecond precision.

Replaces a direct `microtime(true)` call.

Returns `float`

### monotonic()

`abstract public function monotonic(): float`

Seconds on a monotonic clock: immune to wall-clock steps, so only ever meaningful as the difference between two readings.

Replaces a direct `hrtime(true)` call (or a `microtime(true)` one used for a duration rather than a point in time).

Returns `float`

### now()

`abstract public function now(): DateTimeImmutable`

The current wall-clock time.

Returns [`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php)

### unixTimestamp()

`abstract public function unixTimestamp(): int`

Wall-clock Unix timestamp in whole seconds.

Replaces a direct `time()` call.

Returns `int`
