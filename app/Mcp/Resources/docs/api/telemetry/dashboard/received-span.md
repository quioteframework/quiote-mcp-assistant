# ReceivedSpan

> A span decoded from an OTLP `ExportTraceServiceRequest` by OtlpDecoder, flattened into plain PHP values so nothing downstream (DashboardState, DashboardView, tests) needs to touch protobuf types.

A span decoded from an OTLP `ExportTraceServiceRequest` by [`OtlpDecoder`](/api/telemetry/dashboard/otlp-decoder/), flattened into plain PHP values so nothing downstream (DashboardState, DashboardView, tests) needs to touch protobuf types.

## Synopsis

`final class ReceivedSpan`

|  |  |
|---|---|
| Source | `ReceivedSpan.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$attributes` | `array` | _readonly._ |
| `$endTimeUnixNano` | `int` | _readonly._ |
| `$kind` | `int` | _readonly._ |
| `$name` | `string` | _readonly._ |
| `$parentSpanId` | `?``string` | _readonly._ |
| `$resourceAttributes` | `array` | _readonly._ |
| `$spanId` | `string` | _readonly._ |
| `$startTimeUnixNano` | `int` | _readonly._ |
| `$statusCode` | `int` | _readonly._ |
| `$statusMessage` | `string` | _readonly._ |
| `$traceId` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $traceId, string $spanId, ?string $parentSpanId, string $name, int $kind, int $startTimeUnixNano, int $endTimeUnixNano, int $statusCode, string $statusMessage, array<string, mixed> $attributes, array<string, mixed> $resourceAttributes): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$traceId` | `string` |  |
| `$spanId` | `string` |  |
| `$parentSpanId` | `?``string` |  |
| `$name` | `string` |  |
| `$kind` | `int` |  |
| `$startTimeUnixNano` | `int` |  |
| `$endTimeUnixNano` | `int` |  |
| `$statusCode` | `int` |  |
| `$statusMessage` | `string` |  |
| `$attributes` | `array``<``string``, ``mixed``>` |  |
| `$resourceAttributes` | `array``<``string``, ``mixed``>` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`durationMillis(): float`](#durationmillis) | The span's duration in milliseconds, derived from [`ReceivedSpan::durationNanos()`](/api/telemetry/dashboard/received-span/#durationnanos). |
| [`durationNanos(): int`](#durationnanos) | The span's wall-clock duration in nanoseconds, clamped at zero so an end timestamp that precedes the start one never yields a negative duration. |
| [`isError(): bool`](#iserror) | OTel `Status.StatusCode`: 0 = Unset, 1 = Ok, 2 = Error. |
| [`isRoot(): bool`](#isroot) | Whether this is the trace's root span, i.e. |
| [`serviceName(): ?string`](#servicename) | The `service.name` resource attribute, or null when the exporter sent no such attribute or sent a non-string value for it. |

### durationMillis()

`public function durationMillis(): float`

The span's duration in milliseconds, derived from [`ReceivedSpan::durationNanos()`](/api/telemetry/dashboard/received-span/#durationnanos).

Returns `float`

### durationNanos()

`public function durationNanos(): int`

The span's wall-clock duration in nanoseconds, clamped at zero so an end timestamp that precedes the start one never yields a negative duration.

Returns `int`

### isError()

`public function isError(): bool`

OTel `Status.StatusCode`: 0 = Unset, 1 = Ok, 2 = Error.

Returns `bool`

### isRoot()

`public function isRoot(): bool`

Whether this is the trace's root span, i.e.

it carries no parent span ID.

Returns `bool`

### serviceName()

`public function serviceName(): ?string`

The `service.name` resource attribute, or null when the exporter sent no such attribute or sent a non-string value for it.

Returns `?``string`
