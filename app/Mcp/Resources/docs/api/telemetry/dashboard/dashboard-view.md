# DashboardView

> Pure state -> widget-tree builder for the dashboard's live view: no I/O, no `symfony/tui` runtime calls (`Tui::add()`/`requestRender()` etc.) -- only this class and TelemetryDashboardCommand touch `Symfony\\Component\\Tui\\*` directly, containing the experimental package's surface to two files.

Pure state -> widget-tree builder for the dashboard's live view: no I/O, no `symfony/tui` runtime calls (`Tui::add()`/`requestRender()` etc.) -- only this class and `TelemetryDashboardCommand` touch `Symfony\Component\Tui\*` directly, containing the experimental package's surface to two files.

Being pure also makes it trivially testable: feed it a `DashboardSnapshot`, assert on the text the returned widget tree renders, no terminal required.

`symfony/tui` has no Chart/Sparkline/Gauge/Table widgets -- [`Spark`](/api/telemetry/dashboard/spark/) and [`Bars`](/api/telemetry/dashboard/bars/) stand in for the first two, and route/recent-request rows are hand-aligned text for the third. Every string that ultimately originates from telemetry data (span names, status messages, route labels) is passed through [`TextSanitizer`](/api/telemetry/dashboard/text-sanitizer/) before reaching a `TextWidget`, since that widget renders raw ANSI passthrough and an instrumented app's telemetry export is not a trusted input source.

## Synopsis

`final class DashboardView`

|  |  |
|---|---|
| Source | `DashboardView.php` |

## Methods

| Method | Description |
|---|---|
| [`build(DashboardSnapshot $snapshot, string $serviceName, string $listeningAddress): ContainerWidget`](#build) | Builds the whole dashboard widget tree for one snapshot: header, the throughput/latency charts, the resource gauges, the route table, the recent-request feed and the footer. |

### build()

`public static function build(DashboardSnapshot $snapshot, string $serviceName, string $listeningAddress): ContainerWidget`

Builds the whole dashboard widget tree for one snapshot: header, the throughput/latency charts, the resource gauges, the route table, the recent-request feed and the footer.

A snapshot with no data yet renders header, a "waiting for telemetry" panel naming $listeningAddress, and the footer instead of the panels. Pure: no terminal, no I/O, no `symfony/tui` runtime calls — the caller decides when to render the result.

| Parameter | Type | Description |
|---|---|---|
| `$snapshot` | [`DashboardSnapshot`](/api/telemetry/dashboard/dashboard-snapshot/) |  |
| `$serviceName` | `string` |  |
| `$listeningAddress` | `string` |  |

Returns `ContainerWidget`
