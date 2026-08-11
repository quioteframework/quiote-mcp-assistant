# DashboardSnapshot

> An immutable read of DashboardState at one point in time -- everything DashboardView needs to draw one frame, with no further computation or I/O required.

An immutable read of [`DashboardState`](/api/telemetry/dashboard/dashboard-state/) at one point in time -- everything [`DashboardView`](/api/telemetry/dashboard/dashboard-view/) needs to draw one frame, with no further computation or I/O required.

Kept separate from `DashboardState` so rendering logic can be pure and unit-tested against a hand-built snapshot without touching the mutable store at all.

## Synopsis

`final class DashboardSnapshot`

|  |  |
|---|---|
| Source | `DashboardSnapshot.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$avgLatencyMs` | `float` | _readonly._ |
| `$cpuSystemMs` | `float` | _readonly._ |
| `$cpuUserMs` | `float` | _readonly._ |
| `$errorRate` | `float` | _readonly._ |
| `$hasData` | `bool` | _readonly._ |
| `$latencySeries` | `array` | _readonly._ |
| `$maxLatencyMs` | `float` | _readonly._ |
| `$memoryPeakBytes` | `float` | _readonly._ |
| `$p95LatencyMs` | `float` | _readonly._ |
| `$recentErrors` | `array` | _readonly._ |
| `$recentSpans` | `array` | _readonly._ |
| `$requestsPerSecond` | `float` | _readonly._ |
| `$routeRows` | `array` | _readonly._ |
| `$throughputSeries` | `array` | _readonly._ |
| `$totalErrors` | `int` | _readonly._ |
| `$totalRequests` | `int` | _readonly._ |
| `$uptimeSeconds` | `int` | _readonly._ |
| `$workerRssBytes` | `float` | _readonly._ |

## Constructor

### __construct()

`public function __construct(bool $hasData, int $uptimeSeconds, int $totalRequests, int $totalErrors, float $requestsPerSecond, float $errorRate, float $avgLatencyMs, float $p95LatencyMs, float $maxLatencyMs, float $cpuUserMs, float $cpuSystemMs, float $memoryPeakBytes, float $workerRssBytes, array<float> $throughputSeries, array<float> $latencySeries, list<array{route: string, count: int, avgMs: float, errorRate: float, cacheHitRate: float, lastSeenSecond: int}> $routeRows, list<array{second: int, traceId: string, name: string, statusCode: int, durationMs: float, isError: bool, statusMessage: string}> $recentSpans, list<array{second: int, traceId: string, name: string, statusCode: int, durationMs: float, isError: bool, statusMessage: string}> $recentErrors): mixed`

most recent first

| Parameter | Type | Description |
|---|---|---|
| `$hasData` | `bool` |  |
| `$uptimeSeconds` | `int` |  |
| `$totalRequests` | `int` |  |
| `$totalErrors` | `int` |  |
| `$requestsPerSecond` | `float` |  |
| `$errorRate` | `float` |  |
| `$avgLatencyMs` | `float` |  |
| `$p95LatencyMs` | `float` |  |
| `$maxLatencyMs` | `float` |  |
| `$cpuUserMs` | `float` |  |
| `$cpuSystemMs` | `float` |  |
| `$memoryPeakBytes` | `float` |  |
| `$workerRssBytes` | `float` |  |
| `$throughputSeries` | `array``<``float``>` | per-second request counts, chronological, one entry per second in the window |
| `$latencySeries` | `array``<``float``>` | per-second average latency (ms), chronological, aligned with $throughputSeries |
| `$routeRows` | `list``<``array{route: string, count: int, avgMs: float, errorRate: float, cacheHitRate: float, lastSeenSecond: int}``>` |  |
| `$recentSpans` | `list``<``array{second: int, traceId: string, name: string, statusCode: int, durationMs: float, isError: bool, statusMessage: string}``>` | most recent first |
| `$recentErrors` | `list``<``array{second: int, traceId: string, name: string, statusCode: int, durationMs: float, isError: bool, statusMessage: string}``>` | most recent first |

Returns `mixed`
