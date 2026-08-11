# TelemetryBootstrap

> Owns the telemetry lifecycle for a process: build the providers once, flush at each request boundary, and shut down on exit.

Owns the telemetry lifecycle for a process: build the providers once, flush at each request boundary, and shut down on exit.

Called unconditionally from `Kernel::bootstrap()` -- this class decides whether there is anything to do, so callers never need a feature-flag check of their own.

Construction is delegated: [`TelemetryConfig`](/api/telemetry/telemetry-config/) resolves the settings, [`TelemetryExporterFactory`](/api/telemetry/telemetry-exporter-factory/) builds the exporters, and [`TelemetryProviderFactory`](/api/telemetry/telemetry-provider-factory/) assembles the providers around them. What remains here is the part that genuinely has to be process-wide -- "configured once", the registered shutdown function, and the handles the registry hands out.

Every path that can fail -- telemetry disabled, the open-telemetry/sdk package not installed, a bad exporter or endpoint configuration -- degrades to "telemetry stays off" rather than throwing. It is not a hard dependency.

## Synopsis

`final class TelemetryBootstrap`

|  |  |
|---|---|
| Source | `TelemetryBootstrap.php` |

## Methods

| Method | Description |
|---|---|
| [`configureFromConfig(): bool`](#configurefromconfig) | Build the providers from config. |
| [`flushAfterRequest(): void`](#flushafterrequest) | Force-flush the active providers. |
| [`inMemoryMetricExporter(): ?InMemoryExporter`](#inmemorymetricexporter) | The in-memory metric exporter, when `telemetry.exporter = none` was used. |
| [`inMemorySpanExporter(): ?InMemoryExporter`](#inmemoryspanexporter) | The in-memory span exporter, when `telemetry.exporter = none` was used. |
| [`reset(): void`](#reset) | Reset all bootstrap and registry state, for test isolation or to simulate a fresh worker. |
| [`shutdown(): void`](#shutdown) | Final flush and shutdown. |

### configureFromConfig()

`public static function configureFromConfig(): bool`

Build the providers from config.

Idempotent: a second call (a second `Kernel::bootstrap()` in the same process) is a no-op that reports whether a real provider is already active. Call [`TelemetryBootstrap::reset()`](/api/telemetry/telemetry-bootstrap/#reset) first to force a rebuild, for test isolation or to simulate a fresh worker.

Returns `bool` — True if a real, usable provider is now wired up.

### flushAfterRequest()

`public static function flushAfterRequest(): void`

Force-flush the active providers.

Called at every worker request boundary (the Kernel's post-request reset closure) so each request's spans and metrics are exported without tearing the provider down. A no-op when telemetry is not configured.

### inMemoryMetricExporter()

`public static function inMemoryMetricExporter(): ?InMemoryExporter`

The in-memory metric exporter, when `telemetry.exporter = none` was used.

For tests.

Returns `?``InMemoryExporter`

### inMemorySpanExporter()

`public static function inMemorySpanExporter(): ?InMemoryExporter`

The in-memory span exporter, when `telemetry.exporter = none` was used.

For tests.

Returns `?``InMemoryExporter`

### reset()

`public static function reset(): void`

Reset all bootstrap and registry state, for test isolation or to simulate a fresh worker.

Not used on the request path.

Cannot un-register a previously scheduled `register_shutdown_function` callback, and does not need to: that callback re-reads [`TraceRegistry`](/api/telemetry/trace-registry/) when the process actually exits, so it is a safe no-op once this call has cleared the provider.

### shutdown()

`public static function shutdown(): void`

Final flush and shutdown.

Registered once through `register_shutdown_function`, so single-shot mode (no persistent worker loop, no per-request reset closure) still exports its one request's telemetry before the process exits, and worker mode gets a last-chance flush when the worker terminates.
