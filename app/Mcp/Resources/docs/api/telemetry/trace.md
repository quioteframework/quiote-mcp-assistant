# Trace

> Static facade for the telemetry subsystem (mirrors Log).

Static facade for the telemetry subsystem (mirrors [`Log`](/api/logging/log/)).

Configuration: [`TelemetryBootstrap::configureFromConfig()`](/api/telemetry/telemetry-bootstrap/#configurefromconfig) builds the real provider from `telemetry.*` settings once per worker (called from `Kernel::bootstrap()`). Until that has run — or if it declined because telemetry is disabled, the SDK isn't installed, or construction failed — every method below resolves to a shared no-op handle, so instrumenting a call site is always safe regardless of configuration state: use Quiote\Telemetry\Trace; $span = Trace::span('Quiote.Routing', 'match'); try { ... } finally { $span->end(); }

## Synopsis

`final class Trace`

|  |  |
|---|---|
| Source | `Telemetry/Trace.php` |

## Methods

| Method | Description |
|---|---|
| [`current(): SpanHandle`](#current) | The currently active span, or a no-op handle if none is open. |
| [`enabled(): bool`](#enabled) | Whether telemetry is switched on process-wide. |
| [`metrics(): MeterHandle`](#metrics) | The handle for recording histograms, counters and gauges. |
| [`reset(): void`](#reset) | Clears all telemetry state process-wide, via [`TraceRegistry::reset()`](/api/telemetry/trace-registry/#reset): the enabled flag, the category map and its memoized resolutions, and the tracer/meter provider singletons. |
| [`setCategories(array<string, bool> $map): void`](#setcategories) |  |
| [`setCategoryEnabled(string $categoryPrefix, bool $enabled): void`](#setcategoryenabled) | Enable/disable a dot-namespaced trace category prefix (e.g. |
| [`setDefaultCategoryEnabled(bool $enabled): void`](#setdefaultcategoryenabled) | Default for a category with no matching entry on its prefix chain. |
| [`setEnabled(bool $enabled): void`](#setenabled) | Turns telemetry on or off process-wide, via [`TraceRegistry`](/api/telemetry/trace-registry/). |
| [`span(string $category, string $name, array<string, mixed> $attributes = [], SpanKind $kind = Quiote\Telemetry\SpanKind::Internal): SpanHandle`](#span) | Open a span. |

### current()

`public static function current(): SpanHandle`

The currently active span, or a no-op handle if none is open.

This is a *borrowed* reference: the returned handle does not own the span's lifecycle (`ownsLifecycle: false`), so letting it go out of scope — including as a bare expression like `Trace::current()->recordException($e)->setStatusError(...);`, whose temporary is destructed at the end of that statement — never ends the real span. Only whoever actually created it via [`Trace::span()`](/api/telemetry/trace/#span) can end it (explicitly, or via that handle's own destructor). Getting this wrong previously caused a real, hard-to-spot bug: see the class docblock on [`OtelSpanHandle`](/api/telemetry/otel-span-handle/).

Returns [`SpanHandle`](/api/telemetry/span-handle/)

### enabled()

`public static function enabled(): bool`

Whether telemetry is switched on process-wide.

Says nothing about whether a real provider has been wired up — a true here with no provider still yields no-op handles.

Returns `bool`

### metrics()

`public static function metrics(): MeterHandle`

The handle for recording histograms, counters and gauges.

Returns the shared no-op meter when telemetry is disabled or no meter provider has been installed, so a call site can record unconditionally. Otherwise it is the worker-lifetime [`OtelMeterHandle`](/api/telemetry/otel-meter-handle/) cached in [`TraceRegistry`](/api/telemetry/trace-registry/), which keeps its per-instrument-name cache warm across calls.

Returns [`MeterHandle`](/api/telemetry/meter-handle/)

### reset()

`public static function reset(): void`

Clears all telemetry state process-wide, via [`TraceRegistry::reset()`](/api/telemetry/trace-registry/#reset): the enabled flag, the category map and its memoized resolutions, and the tracer/meter provider singletons.

For test isolation and reconfiguration (simulating a fresh worker); not used on the request path.

### setCategories()

`public static function setCategories(array<string, bool> $map): void`

category-prefix => enabled

| Parameter | Type | Description |
|---|---|---|
| `$map` | `array``<``string``, ``bool``>` | category-prefix => enabled |

### setCategoryEnabled()

`public static function setCategoryEnabled(string $categoryPrefix, bool $enabled): void`

Enable/disable a dot-namespaced trace category prefix (e.g.

"Quiote.Routing"), mirroring [`Log::setLevel()`](/api/logging/log/#setlevel) — except a disabled prefix cascades unconditionally to every descendant category, it cannot be re-enabled by a more specific child entry. Configured in index.php alongside `Log::setLevels(...)`, not via `settings.xml`.

| Parameter | Type | Description |
|---|---|---|
| `$categoryPrefix` | `string` |  |
| `$enabled` | `bool` |  |

### setDefaultCategoryEnabled()

`public static function setDefaultCategoryEnabled(bool $enabled): void`

Default for a category with no matching entry on its prefix chain.

True unless set otherwise.

| Parameter | Type | Description |
|---|---|---|
| `$enabled` | `bool` |  |

### setEnabled()

`public static function setEnabled(bool $enabled): void`

Turns telemetry on or off process-wide, via [`TraceRegistry`](/api/telemetry/trace-registry/).

The master switch every method here consults first: while off, [`Trace::span()`](/api/telemetry/trace/#span)/[`Trace::current()`](/api/telemetry/trace/#current)/[`Trace::metrics()`](/api/telemetry/trace/#metrics) return shared no-op handles without touching the provider at all. Category settings and the installed providers are left as they are, so flipping it back on resumes with the same configuration.

| Parameter | Type | Description |
|---|---|---|
| `$enabled` | `bool` |  |

### span()

`public static function span(string $category, string $name, array<string, mixed> $attributes = [], SpanKind $kind = Quiote\Telemetry\SpanKind::Internal): SpanHandle`

Open a span.

| Parameter | Type | Description |
|---|---|---|
| `$category` | `string` |  |
| `$name` | `string` |  |
| `$attributes` | `array``<``string``, ``mixed``>` |  |
| `$kind` | [`SpanKind`](/api/telemetry/span-kind/) |  |

Returns [`SpanHandle`](/api/telemetry/span-handle/)
