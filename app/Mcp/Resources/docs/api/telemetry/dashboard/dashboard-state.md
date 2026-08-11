# DashboardState

> The rolling in-memory store fed by OtlpReceiver's decoded batches and read by the render loop via DashboardState::snapshot().

The rolling in-memory store fed by [`OtlpReceiver`](/api/telemetry/dashboard/otlp-receiver/)'s decoded batches and read by the render loop via [`DashboardState::snapshot()`](/api/telemetry/dashboard/dashboard-state/#snapshot).

Single-threaded (one Revolt event loop drives both ingestion and rendering), so plain arrays with no locking are correct here.

**Worth calling out**: throughput, latency (avg/p95/max), error rate, per-route stats, and the recent-request/error feeds are all derived from **root spans**, not from `http.server.request.count`/ `http.server.request.duration` metrics. The root span itself already carries `http.route`/`route_name`/`quiote.cache.hit`/`http.response.status_code` attributes (see `RoutingMiddleware::process()` and `TelemetryMiddleware::recordMeasurements()`) plus its own real duration and OTel `Status` -- a strictly richer, per-request-precise source than aggregated histogram buckets, and it means genuine percentiles (not bucket-boundary estimates) are possible from a bounded reservoir of raw samples. Metrics are still the only source for **CPU time and memory**, which spans don't carry, and for worker RSS, an aggregate signal with no meaningful per-span equivalent at all.

## Synopsis

`final class DashboardState`

|  |  |
|---|---|
| Source | `DashboardState.php` |

## Constructor

### __construct()

`public function __construct(): mixed`

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`ingestMetrics(array<ReceivedMetric> $metrics, int $second): void`](#ingestmetrics) |  |
| [`ingestSpans(array<ReceivedSpan> $spans, int $second): void`](#ingestspans) |  |
| [`snapshot(int $second): DashboardSnapshot`](#snapshot) | Builds the immutable view model the dashboard renders for $second. |

### ingestMetrics()

`public function ingestMetrics(array<ReceivedMetric> $metrics, int $second): void`

| Parameter | Type | Description |
|---|---|---|
| `$metrics` | `array``<`[`ReceivedMetric`](/api/telemetry/dashboard/received-metric/)`>` |  |
| `$second` | `int` |  |

### ingestSpans()

`public function ingestSpans(array<ReceivedSpan> $spans, int $second): void`

| Parameter | Type | Description |
|---|---|---|
| `$spans` | `array``<`[`ReceivedSpan`](/api/telemetry/dashboard/received-span/)`>` |  |
| `$second` | `int` |  |

### snapshot()

`public function snapshot(int $second): DashboardSnapshot`

Builds the immutable view model the dashboard renders for $second.

Aggregates the throughput and latency ring buffers into series, derives the current requests-per-second from the last five seconds only (so the figure tracks recent traffic rather than the whole window), and reverses the recent-span and recent-error feeds into newest-first order. Reads state only; nothing is mutated or pruned here.

| Parameter | Type | Description |
|---|---|---|
| `$second` | `int` |  |

Returns [`DashboardSnapshot`](/api/telemetry/dashboard/dashboard-snapshot/)
