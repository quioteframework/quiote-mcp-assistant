# ReceivedMetric

> A metric decoded from an OTLP `ExportMetricsServiceRequest` by OtlpDecoder.

A metric decoded from an OTLP `ExportMetricsServiceRequest` by [`OtlpDecoder`](/api/telemetry/dashboard/otlp-decoder/).

`$type` is one of `'gauge'`, `'sum'`, `'histogram'` -- the only three shapes [`TelemetryMiddleware`](/api/middleware/telemetry-middleware/) emits. Other OTLP metric types (exponential histogram, summary) are skipped by the decoder rather than represented here.

## Synopsis

`final class ReceivedMetric`

|  |  |
|---|---|
| Source | `ReceivedMetric.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$dataPoints` | `array` | _readonly._ |
| `$name` | `string` | _readonly._ |
| `$resourceAttributes` | `array` | _readonly._ |
| `$type` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $name, 'gauge'|'sum'|'histogram' $type, array<ReceivedDataPoint> $dataPoints, array<string, mixed> $resourceAttributes): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$type` | `'gauge'``|``'sum'``|``'histogram'` |  |
| `$dataPoints` | `array``<`[`ReceivedDataPoint`](/api/telemetry/dashboard/received-data-point/)`>` |  |
| `$resourceAttributes` | `array``<``string``, ``mixed``>` |  |

Returns `mixed`
