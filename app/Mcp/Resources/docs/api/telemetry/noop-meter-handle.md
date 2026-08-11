# NoopMeterHandle

> The disabled-state MeterHandle: every recording is a safe no-op.

The disabled-state [`MeterHandle`](/api/telemetry/meter-handle/): every recording is a safe no-op.

A single shared instance is reused ([`NoopMeterHandle::instance()`](/api/telemetry/noop-meter-handle/#instance)), same rationale as [`NoopSpanHandle`](/api/telemetry/noop-span-handle/).

## Synopsis

`final class NoopMeterHandle implements MeterHandle`

|  |  |
|---|---|
| Implements | [`MeterHandle`](/api/telemetry/meter-handle/) |
| Source | `Telemetry/NoopMeterHandle.php` |

## Methods

| Method | Description |
|---|---|
| [`addCounter(string $name, int|float $increment = 1, array $attributes = []): void`](#addcounter) | Discards the counter increment. |
| [`instance(): NoopMeterHandle`](#instance) | The shared no-op meter handle, created on first call and reused for the rest of the process. |
| [`recordGauge(string $name, float $value, array $attributes = []): void`](#recordgauge) | Discards the gauge measurement. |
| [`recordHistogram(string $name, float $value, array $attributes = []): void`](#recordhistogram) | Discards the histogram measurement. |

### addCounter()

`public function addCounter(string $name, int|float $increment = 1, array $attributes = []): void`

Discards the counter increment.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$increment` | `int``|``float` |  |
| `$attributes` | `array` |  |

### instance()

`public static function instance(): NoopMeterHandle`

The shared no-op meter handle, created on first call and reused for the rest of the process.

Safe to hand out freely: it is stateless and every recording on it is discarded.

Returns [`NoopMeterHandle`](/api/telemetry/noop-meter-handle/)

### recordGauge()

`public function recordGauge(string $name, float $value, array $attributes = []): void`

Discards the gauge measurement.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `float` |  |
| `$attributes` | `array` |  |

### recordHistogram()

`public function recordHistogram(string $name, float $value, array $attributes = []): void`

Discards the histogram measurement.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `float` |  |
| `$attributes` | `array` |  |
