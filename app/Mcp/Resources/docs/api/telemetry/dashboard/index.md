# Dashboard

> The Quiote\\Telemetry\\Dashboard namespace — 17 documented types.

Everything under `Quiote\Telemetry\Dashboard`.

## Classes

| Class | Description |
|---|---|
| [`Bars`](/api/telemetry/dashboard/bars/) | Renders a value/ceiling ratio as a fixed-width filled/empty block bar -- the dashboard's stand-in for a Gauge widget (`symfony/tui` has none; see [`Spark`](/api/telemetry/dashboard/spark/)'s docblock for the same widget-gap note). |
| [`ChartWidget`](/api/telemetry/dashboard/chart-widget/) | A leaf widget that renders a numeric series as a multi-row bar chart, filling whatever height and width it is assigned at render time. |
| [`DashboardSnapshot`](/api/telemetry/dashboard/dashboard-snapshot/) | An immutable read of [`DashboardState`](/api/telemetry/dashboard/dashboard-state/) at one point in time -- everything [`DashboardView`](/api/telemetry/dashboard/dashboard-view/) needs to draw one frame, with no further computation or I/O required. |
| [`DashboardState`](/api/telemetry/dashboard/dashboard-state/) | The rolling in-memory store fed by [`OtlpReceiver`](/api/telemetry/dashboard/otlp-receiver/)'s decoded batches and read by the render loop via [`DashboardState::snapshot()`](/api/telemetry/dashboard/dashboard-state/#snapshot). |
| [`DashboardView`](/api/telemetry/dashboard/dashboard-view/) | Pure state -> widget-tree builder for the dashboard's live view: no I/O, no `symfony/tui` runtime calls (`Tui::add()`/`requestRender()` etc.) -- only this class and `TelemetryDashboardCommand` touch `Symfony\Component\Tui\*` directly, containing the experimental package's surface to two files. |
| [`HttpMessageParser`](/api/telemetry/dashboard/http-message-parser/) | Minimal, bounded HTTP/1.1 request parser for the dashboard's OTLP receiver (see [`OtlpReceiver`](/api/telemetry/dashboard/otlp-receiver/)). |
| [`MalformedRequestException`](/api/telemetry/dashboard/malformed-request-exception/) | Thrown by [`HttpMessageParser`](/api/telemetry/dashboard/http-message-parser/) for anything outside the narrow OTLP/HTTP shape the OTel PHP exporter sends (see that class's docblock). |
| [`OtlpDecoder`](/api/telemetry/dashboard/otlp-decoder/) | Decodes OTLP `ExportTraceServiceRequest`/`ExportMetricsServiceRequest` protobuf (or JSON) payloads -- exactly what the OTel PHP OTLP/HTTP exporter sends, per `telemetry.otlp.protocol` -- into plain [`ReceivedSpan`](/api/telemetry/dashboard/received-span/)/ [`ReceivedMetric`](/api/telemetry/dashboard/received-metric/) value objects. |
| [`OtlpReceiver`](/api/telemetry/dashboard/otlp-receiver/) | A minimal OTLP/HTTP receiver: binds a TCP socket and services it on the global Revolt event loop, exactly the pattern `symfony/tui`'s own `Terminal::start()` uses for STDIN (`EventLoop::onReadable()`) -- so this runs cooperatively alongside a `Tui::run()` loop in the same process, no threads or second process needed. |
| [`ParsedHttpRequest`](/api/telemetry/dashboard/parsed-http-request/) | The result of [`HttpMessageParser::tryParse()`](/api/telemetry/dashboard/http-message-parser/#tryparse) -- method, path, headers (lower-cased names), and the fully-buffered request body. |
| [`ReceivedDataPoint`](/api/telemetry/dashboard/received-data-point/) | A single data point within a [`ReceivedMetric`](/api/telemetry/dashboard/received-metric/). |
| [`ReceivedMetric`](/api/telemetry/dashboard/received-metric/) | A metric decoded from an OTLP `ExportMetricsServiceRequest` by [`OtlpDecoder`](/api/telemetry/dashboard/otlp-decoder/). |
| [`ReceivedSpan`](/api/telemetry/dashboard/received-span/) | A span decoded from an OTLP `ExportTraceServiceRequest` by [`OtlpDecoder`](/api/telemetry/dashboard/otlp-decoder/), flattened into plain PHP values so nothing downstream (DashboardState, DashboardView, tests) needs to touch protobuf types. |
| [`RingBuffer`](/api/telemetry/dashboard/ring-buffer/) | A fixed-window, per-second time series. |
| [`RouteStats`](/api/telemetry/dashboard/route-stats/) | Per-route aggregates (count, avg latency, error %, cache-hit %, last seen) for the dashboard's route table. |
| [`Spark`](/api/telemetry/dashboard/spark/) | Renders a numeric series as a Unicode block-glyph bar chart, using eighth blocks (`▁▂▃▄▅▆▇█`) per character row to get sub-row vertical resolution across an arbitrary number of text rows. |
| [`TextSanitizer`](/api/telemetry/dashboard/text-sanitizer/) | Strips terminal-escape introducer bytes from telemetry-derived strings (span names, status messages, route labels, attribute values) before they reach a `TextWidget`. |
