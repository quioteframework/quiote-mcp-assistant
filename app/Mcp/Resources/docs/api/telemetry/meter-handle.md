# MeterHandle

> Records metric instruments (histograms, counters, gauges).

Records metric instruments (histograms, counters, gauges).

Unlike spans, metric recordings are never sampled — every call here is meant to always count toward the aggregate.

## Synopsis

`interface MeterHandle`

|  |  |
|---|---|
| Implemented by | [`NoopMeterHandle`](/api/telemetry/noop-meter-handle/), [`OtelMeterHandle`](/api/telemetry/otel-meter-handle/) |
| Source | `Telemetry/MeterHandle.php` |

## Methods

| Method | Description |
|---|---|
| [`addCounter(string $name, int|float $increment = 1, array<string, mixed> $attributes = []): void`](#addcounter) |  |
| [`recordGauge(string $name, float $value, array<string, mixed> $attributes = []): void`](#recordgauge) |  |
| [`recordHistogram(string $name, float $value, array<string, mixed> $attributes = []): void`](#recordhistogram) |  |

### addCounter()

`abstract public function addCounter(string $name, int|float $increment = 1, array<string, mixed> $attributes = []): void`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$increment` | `int``|``float` |  |
| `$attributes` | `array``<``string``, ``mixed``>` |  |

### recordGauge()

`abstract public function recordGauge(string $name, float $value, array<string, mixed> $attributes = []): void`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `float` |  |
| `$attributes` | `array``<``string``, ``mixed``>` |  |

### recordHistogram()

`abstract public function recordHistogram(string $name, float $value, array<string, mixed> $attributes = []): void`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `float` |  |
| `$attributes` | `array``<``string``, ``mixed``>` |  |
