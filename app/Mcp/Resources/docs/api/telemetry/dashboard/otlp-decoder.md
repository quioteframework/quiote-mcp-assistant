# OtlpDecoder

> Decodes OTLP `ExportTraceServiceRequest`/`ExportMetricsServiceRequest` protobuf (or JSON) payloads -- exactly what the OTel PHP OTLP/HTTP exporter sends, per `telemetry.otlp.protocol` -- into plain ReceivedSpan/ ReceivedMetric value objects.

Decodes OTLP `ExportTraceServiceRequest`/`ExportMetricsServiceRequest` protobuf (or JSON) payloads -- exactly what the OTel PHP OTLP/HTTP exporter sends, per `telemetry.otlp.protocol` -- into plain [`ReceivedSpan`](/api/telemetry/dashboard/received-span/)/ [`ReceivedMetric`](/api/telemetry/dashboard/received-metric/) value objects.

Only the metric shapes [`TelemetryMiddleware`](/api/middleware/telemetry-middleware/) actually emits (gauge, sum, histogram) are decoded; exponential histogram and summary metrics are silently skipped rather than guessed at.

A malformed/hostile payload (bad protobuf bytes, absurdly deep nested attribute values) must never crash the dashboard: every public method here wraps decode failures in [`MalformedRequestException`](/api/telemetry/dashboard/malformed-request-exception/) for the receiver to catch, and attribute flattening is depth-guarded.

## Synopsis

`final class OtlpDecoder`

|  |  |
|---|---|
| Source | `OtlpDecoder.php` |

## Methods

| Method | Description |
|---|---|
| [`decodeMetrics(string $body, string $contentType): array<ReceivedMetric>`](#decodemetrics) |  |
| [`decodeTraces(string $body, string $contentType): array<ReceivedSpan>`](#decodetraces) |  |

### decodeMetrics()

`public function decodeMetrics(string $body, string $contentType): array<ReceivedMetric>`

| Parameter | Type | Description |
|---|---|---|
| `$body` | `string` |  |
| `$contentType` | `string` |  |

Returns `array``<`[`ReceivedMetric`](/api/telemetry/dashboard/received-metric/)`>`

### decodeTraces()

`public function decodeTraces(string $body, string $contentType): array<ReceivedSpan>`

| Parameter | Type | Description |
|---|---|---|
| `$body` | `string` |  |
| `$contentType` | `string` |  |

Returns `array``<`[`ReceivedSpan`](/api/telemetry/dashboard/received-span/)`>`
