# Telemetry

> The Quiote\\Telemetry namespace — 36 documented types.

Everything under `Quiote\Telemetry`.

## Classes

| Class | Description |
|---|---|
| [`AttributeSanitizer`](/api/telemetry/attribute-sanitizer/) | Validates arbitrary attribute maps against the shape the OTel SDK's own span/meter APIs require: non-empty-string keys, and values that are `array\|bool\|float\|int\|string\|null` (arrays homogeneous, one scalar type throughout). |
| [`ForceSampleSampler`](/api/telemetry/force-sample-sampler/) | Head-based force sampling: "trace this one request" without touching the global sampling ratio. |
| [`MiddlewareSpanDecorator`](/api/telemetry/middleware-span-decorator/) | Wraps a single pipeline middleware in a child span named by its FQCN. |
| [`NoopMeterHandle`](/api/telemetry/noop-meter-handle/) | The disabled-state [`MeterHandle`](/api/telemetry/meter-handle/): every recording is a safe no-op. |
| [`NoopSpanHandle`](/api/telemetry/noop-span-handle/) | The disabled-state [`SpanHandle`](/api/telemetry/span-handle/): every call is a safe no-op. |
| [`OtelMeterHandle`](/api/telemetry/otel-meter-handle/) | Real [`MeterHandle`](/api/telemetry/meter-handle/), wrapping an OpenTelemetry `MeterInterface`. |
| [`OtelSpanHandle`](/api/telemetry/otel-span-handle/) | Real [`SpanHandle`](/api/telemetry/span-handle/), wrapping an active OpenTelemetry `SpanInterface`. |
| [`Psr7HeaderGetter`](/api/telemetry/psr7-header-getter/) | Reads W3C `traceparent`/`tracestate` (or any other propagated header) off a PSR-7 message for `TraceContextPropagator::extract()`. |
| [`Psr7HeaderSetter`](/api/telemetry/psr7-header-setter/) | The outbound counterpart to [`Psr7HeaderGetter`](/api/telemetry/psr7-header-getter/): adapts a PSR-7 request to OpenTelemetry's propagation *setter* so `TraceContextPropagator::inject()` can write `traceparent`/`tracestate` onto an outgoing request. |
| [`TelemetryBootstrap`](/api/telemetry/telemetry-bootstrap/) | Owns the telemetry lifecycle for a process: build the providers once, flush at each request boundary, and shut down on exit. |
| [`TelemetryConfig`](/api/telemetry/telemetry-config/) | The `telemetry.*` settings, read once and resolved into concrete values. |
| [`TelemetryExporterFactory`](/api/telemetry/telemetry-exporter-factory/) | Builds the span and metric exporters named by `telemetry.exporter`. |
| [`TelemetryPlugin`](/api/telemetry/telemetry-plugin/) | Wires the OTel-SDK-dependent exporter bootstrap ([`TelemetryBootstrap`](/api/telemetry/telemetry-bootstrap/)) into the generic event seams instead of [`Kernel`](/api/runtime/kernel/) calling it by hard FQCN. |
| [`TelemetryProviderFactory`](/api/telemetry/telemetry-provider-factory/) | Assembles the TracerProvider and MeterProvider: the resource describing this service, the sampler, the span processor, and the metric reader. |
| [`Trace`](/api/telemetry/trace/) | Static facade for the telemetry subsystem (mirrors [`Log`](/api/logging/log/)). |
| [`TraceRegistry`](/api/telemetry/trace-registry/) | Process-global store of telemetry configuration AND (once [`TelemetryBootstrap`](/api/telemetry/telemetry-bootstrap/) has run) the worker-lifetime tracer/meter provider singletons. |

## Interfaces

| Interface | Description |
|---|---|
| [`MeterHandle`](/api/telemetry/meter-handle/) | Records metric instruments (histograms, counters, gauges). |
| [`SpanHandle`](/api/telemetry/span-handle/) | A single unit of work in a trace. |

## Enums

| Enum | Description |
|---|---|
| [`SpanKind`](/api/telemetry/span-kind/) | Mirrors OpenTelemetry's `SpanKind` constants (`OpenTelemetry\API\Trace\SpanKind::KIND_*`) numerically 1:1, but as our own framework-owned enum so [`Trace::span()`](/api/telemetry/trace/#span)'s signature never needs the optional open-telemetry/api package to exist — PHP resolves a default parameter value eagerly (unlike type hints, which resolve lazily at call time), so a default referencing an optional class's constant would crash every `Trace::span()` call with no explicit $kind when the SDK isn't installed. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Dashboard`](/api/telemetry/dashboard/) | 17 types |
