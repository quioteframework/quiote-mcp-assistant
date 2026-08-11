# RingBuffer

> A fixed-window, per-second time series.

A fixed-window, per-second time series.

Samples are recorded into the bucket for the second they arrived in; buckets older than the window are pruned on every [`RingBuffer::record()`](/api/telemetry/dashboard/ring-buffer/#record) call, so memory is bounded by `$windowSeconds` regardless of how long the dashboard runs or how much traffic it observes -- the same "no unbounded retention across a long run" discipline the telemetry span/metric providers hold to.

Deliberately takes the current second as a parameter rather than reading the clock itself, so it is fully deterministic and unit-testable without real wall-clock time.

## Synopsis

`final class RingBuffer`

|  |  |
|---|---|
| Source | `RingBuffer.php` |

## Constructor

### __construct()

`public function __construct(int $windowSeconds): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$windowSeconds` | `int` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`record(int $second, float $value): void`](#record) | Appends $value to the bucket for $second. |
| [`series(int $nowSecond, 'sum'|'avg'|'max'|'last'|'count' $aggregate = 'sum', float $default = 0.0): array<int, float>`](#series) |  |

### record()

`public function record(int $second, float $value): void`

Appends $value to the bucket for $second.

Also prunes every bucket older than the configured window, so the caller's notion of "now" drives retention and memory stays bounded.

| Parameter | Type | Description |
|---|---|---|
| `$second` | `int` |  |
| `$value` | `float` |  |

### series()

`public function series(int $nowSecond, 'sum'|'avg'|'max'|'last'|'count' $aggregate = 'sum', float $default = 0.0): array<int, float>`

| Parameter | Type | Description |
|---|---|---|
| `$nowSecond` | `int` |  |
| `$aggregate` | `'sum'``|``'avg'``|``'max'``|``'last'``|``'count'` |  |
| `$default` | `float` |  |

Returns `array``<``int``, ``float``>` — second => aggregated value, in chronological order, with every second in the window present (missing seconds get $default)
