# TelemetryExporterFactory

> Builds the span and metric exporters named by `telemetry.exporter`.

Builds the span and metric exporters named by `telemetry.exporter`.

One instance per configuration, holding the in-memory exporters it created so a test can read back what was exported. An unrecognised exporter name falls back to the in-memory one rather than failing the provider, because disabling telemetry entirely over a typo is worse than exporting nowhere and saying so.

## Synopsis

`final class TelemetryExporterFactory`

|  |  |
|---|---|
| Since | `3.2.0` |
| Source | `TelemetryExporterFactory.php` |

## Constructor

### __construct()

`public function __construct(TelemetryConfig $config): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$config` | [`TelemetryConfig`](/api/telemetry/telemetry-config/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`inMemoryMetricExporter(): ?InMemoryExporter`](#inmemorymetricexporter) | The in-memory metric exporter, when one was built. |
| [`inMemorySpanExporter(): ?InMemoryExporter`](#inmemoryspanexporter) | The in-memory span exporter, when one was built. |
| [`metricExporter(): MetricExporterInterface`](#metricexporter) | Builds the metric exporter named by `telemetry.exporter`, on the same terms as [`TelemetryExporterFactory::spanExporter()`](/api/telemetry/telemetry-exporter-factory/#spanexporter); the in-memory result is retained for [`TelemetryExporterFactory::inMemoryMetricExporter()`](/api/telemetry/telemetry-exporter-factory/#inmemorymetricexporter). |
| [`spanExporter(): SpanExporterInterface`](#spanexporter) | Builds the span exporter named by `telemetry.exporter`. |

### inMemoryMetricExporter()

`public function inMemoryMetricExporter(): ?InMemoryExporter`

The in-memory metric exporter, when one was built.

For tests.

Returns `?``InMemoryExporter`

### inMemorySpanExporter()

`public function inMemorySpanExporter(): ?InMemoryExporter`

The in-memory span exporter, when one was built.

For tests.

Returns `?``InMemoryExporter`

### metricExporter()

`public function metricExporter(): MetricExporterInterface`

Builds the metric exporter named by `telemetry.exporter`, on the same terms as [`TelemetryExporterFactory::spanExporter()`](/api/telemetry/telemetry-exporter-factory/#spanexporter); the in-memory result is retained for [`TelemetryExporterFactory::inMemoryMetricExporter()`](/api/telemetry/telemetry-exporter-factory/#inmemorymetricexporter).

Returns `MetricExporterInterface`

### spanExporter()

`public function spanExporter(): SpanExporterInterface`

Builds the span exporter named by `telemetry.exporter`.

`none` and any unrecognised name yield an in-memory exporter, which is retained for [`TelemetryExporterFactory::inMemorySpanExporter()`](/api/telemetry/telemetry-exporter-factory/#inmemoryspanexporter); an unrecognised name is also logged at warning level. `otlp` bridges the OTLP settings into the `OTEL_EXPORTER_OTLP_*` environment before delegating to the SDK factory.

Returns `SpanExporterInterface`
