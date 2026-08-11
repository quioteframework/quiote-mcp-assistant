# TelemetryProviderFactory

> Assembles the TracerProvider and MeterProvider: the resource describing this service, the sampler, the span processor, and the metric reader.

Assembles the TracerProvider and MeterProvider: the resource describing this service, the sampler, the span processor, and the metric reader.

Takes its exporters from a [`TelemetryExporterFactory`](/api/telemetry/telemetry-exporter-factory/) rather than building them, so which exporter is in use and how the providers are wired around it stay separable -- a caller can assemble providers over an in-memory exporter without any OTLP configuration existing.

## Synopsis

`final readonly class TelemetryProviderFactory`

|  |  |
|---|---|
| Since | `3.2.0` |
| Source | `TelemetryProviderFactory.php` |

## Constructor

### __construct()

`public function __construct(TelemetryConfig $config, TelemetryExporterFactory $exporters): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$config` | [`TelemetryConfig`](/api/telemetry/telemetry-config/) |  |
| `$exporters` | [`TelemetryExporterFactory`](/api/telemetry/telemetry-exporter-factory/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`meterProvider(ResourceInfo $resource): MeterProviderInterface`](#meterprovider) | Builds a MeterProvider over $resource, reading through an ExportingReader wrapped around the configured metric exporter. |
| [`resource(): ResourceInfo`](#resource) | The resource every span and metric is attributed to: service name, optional namespace, and whatever `telemetry.resource` adds, merged over the SDK's own detected defaults. |
| [`sampler(): SamplerInterface`](#sampler) | Head-based sampling, wrapped so a span can force itself to be recorded. |
| [`tracerProvider(ResourceInfo $resource): TracerProviderInterface`](#tracerprovider) | Builds a TracerProvider over $resource and the configured sampler. |

### meterProvider()

`public function meterProvider(ResourceInfo $resource): MeterProviderInterface`

Builds a MeterProvider over $resource, reading through an ExportingReader wrapped around the configured metric exporter.

Sampling does not apply to metrics.

| Parameter | Type | Description |
|---|---|---|
| `$resource` | `ResourceInfo` |  |

Returns `MeterProviderInterface`

### resource()

`public function resource(): ResourceInfo`

The resource every span and metric is attributed to: service name, optional namespace, and whatever `telemetry.resource` adds, merged over the SDK's own detected defaults.

Returns `ResourceInfo`

### sampler()

`public function sampler(): SamplerInterface`

Head-based sampling, wrapped so a span can force itself to be recorded.

Metrics are never sampled -- this only affects the TracerProvider.

Returns `SamplerInterface`

### tracerProvider()

`public function tracerProvider(ResourceInfo $resource): TracerProviderInterface`

Builds a TracerProvider over $resource and the configured sampler.

Spans go through a SimpleSpanProcessor when `telemetry.export_mode` is `simple` (each span exported as it ends, which tests rely on) and a BatchSpanProcessor otherwise.

| Parameter | Type | Description |
|---|---|---|
| `$resource` | `ResourceInfo` |  |

Returns `TracerProviderInterface`
