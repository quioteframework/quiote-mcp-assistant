# RouteStats

> Per-route aggregates (count, avg latency, error %, cache-hit %, last seen) for the dashboard's route table.

Per-route aggregates (count, avg latency, error %, cache-hit %, last seen) for the dashboard's route table.

Route names come from telemetry data an instrumented app controls (`http.route`/`route_name` span attributes, see [`DashboardState`](/api/telemetry/dashboard/dashboard-state/)), so the number of distinct routes is bounded defensively at record()-time -- not just at display time -- to keep memory bounded even if a hostile/buggy app emits an unbounded number of distinct route labels: once the tracked-route cap is hit, anything new folds into a single `(other)` bucket rather than growing the map forever.

## Synopsis

`final class RouteStats`

|  |  |
|---|---|
| Source | `RouteStats.php` |

## Methods

| Method | Description |
|---|---|
| [`record(string $route, float $durationMs, bool $isError, bool $cacheHit, int $second): void`](#record) | Folds one request into the aggregates for $route. |
| [`rows(int $limit = 25): list<array{route: string, count: int, avgMs: float, errorRate: float, cacheHitRate: float, lastSeenSecond: int}>`](#rows) |  |

### record()

`public function record(string $route, float $durationMs, bool $isError, bool $cacheHit, int $second): void`

Folds one request into the aggregates for $route.

Once the tracked-route cap is reached, a previously unseen route name is rewritten to the `(other)` bucket instead of adding a new entry, so an app emitting unbounded distinct route labels cannot grow the map without limit.

| Parameter | Type | Description |
|---|---|---|
| `$route` | `string` |  |
| `$durationMs` | `float` |  |
| `$isError` | `bool` |  |
| `$cacheHit` | `bool` |  |
| `$second` | `int` |  |

### rows()

`public function rows(int $limit = 25): list<array{route: string, count: int, avgMs: float, errorRate: float, cacheHitRate: float, lastSeenSecond: int}>`

| Parameter | Type | Description |
|---|---|---|
| `$limit` | `int` |  |

Returns `list``<``array{route: string, count: int, avgMs: float, errorRate: float, cacheHitRate: float, lastSeenSecond: int}``>` — sorted by request count, descending
