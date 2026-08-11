# OtelMeterHandle

> Real MeterHandle, wrapping an OpenTelemetry MeterInterface.

Real [`MeterHandle`](/api/telemetry/meter-handle/), wrapping an OpenTelemetry `MeterInterface`.

Instruments are created once per name and cached for the worker's lifetime (recreating the Counter/Histogram/Gauge object on every recording call would be wasteful and risks metadata — unit/description — diverging between calls for the same instrument name).

Every recording is wrapped so a call site can never crash the request; see [`OtelSpanHandle`](/api/telemetry/otel-span-handle/) for the same rationale.

## Synopsis

`final class OtelMeterHandle implements MeterHandle`

|  |  |
|---|---|
| Implements | [`MeterHandle`](/api/telemetry/meter-handle/) |
| Source | `OtelMeterHandle.php` |

## Constructor

### __construct()

`public function __construct(MeterInterface $meter): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$meter` | `MeterInterface` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`addCounter(string $name, int|float $increment = 1, array $attributes = []): void`](#addcounter) | Adds $increment to the counter called $name, creating and caching the instrument on first use. |
| [`recordGauge(string $name, float $value, array $attributes = []): void`](#recordgauge) | Records the current value of the gauge called $name, creating and caching the instrument on first use. |
| [`recordHistogram(string $name, float $value, array $attributes = []): void`](#recordhistogram) | Records $value into the histogram called $name. |

### addCounter()

`public function addCounter(string $name, int|float $increment = 1, array $attributes = []): void`

Adds $increment to the counter called $name, creating and caching the instrument on first use.

Failures are swallowed as in [`OtelMeterHandle::recordHistogram()`](/api/telemetry/otel-meter-handle/#recordhistogram).

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$increment` | `int``|``float` |  |
| `$attributes` | `array` |  |

### recordGauge()

`public function recordGauge(string $name, float $value, array $attributes = []): void`

Records the current value of the gauge called $name, creating and caching the instrument on first use.

Failures are swallowed as in [`OtelMeterHandle::recordHistogram()`](/api/telemetry/otel-meter-handle/#recordhistogram).

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `float` |  |
| `$attributes` | `array` |  |

### recordHistogram()

`public function recordHistogram(string $name, float $value, array $attributes = []): void`

Records $value into the histogram called $name.

The histogram instrument is created on first use and cached under $name for the life of this handle. Attributes are sanitized, and any failure — creating the instrument or recording — is swallowed and logged at debug level rather than propagating to the call site.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `float` |  |
| `$attributes` | `array` |  |
