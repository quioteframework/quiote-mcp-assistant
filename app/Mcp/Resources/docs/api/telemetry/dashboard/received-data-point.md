# ReceivedDataPoint

> A single data point within a ReceivedMetric.

A single data point within a [`ReceivedMetric`](/api/telemetry/dashboard/received-metric/).

`$value` is the gauge reading / sum total for gauge and sum metrics, or the histogram's `sum` for histogram metrics -- `$count` is only meaningful (non-null) for histograms, where `$value / $count` is the mean.

## Synopsis

`final class ReceivedDataPoint`

|  |  |
|---|---|
| Source | `ReceivedDataPoint.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$attributes` | `array` | _readonly._ |
| `$count` | `?``int` | _readonly._ |
| `$timeUnixNano` | `int` | _readonly._ |
| `$value` | `float` | _readonly._ |

## Constructor

### __construct()

`public function __construct(array<string, mixed> $attributes, float $value, ?int $count, int $timeUnixNano): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array``<``string``, ``mixed``>` |  |
| `$value` | `float` |  |
| `$count` | `?``int` |  |
| `$timeUnixNano` | `int` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`mean(): ?float`](#mean) | The histogram's mean, i.e. |

### mean()

`public function mean(): ?float`

The histogram's mean, i.e.

`$value / $count`.

Null when `$count` is null (a gauge or sum data point, which has no mean) or zero (a histogram bucket that recorded nothing).

Returns `?``float`
