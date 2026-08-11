# TraceRegistry

> Process-global store of telemetry configuration AND (once TelemetryBootstrap has run) the worker-lifetime tracer/meter provider singletons.

Process-global store of telemetry configuration AND (once [`TelemetryBootstrap`](/api/telemetry/telemetry-bootstrap/) has run) the worker-lifetime tracer/meter provider singletons.

Deliberately free of any dependency on Config/the context/bootstrap (mirrors [`LogRegistry`](/api/logging/log-registry/), which plays the same role for sinks) so it can be configured in index.php before Kernel::run() and is safe to call during bootstrap itself.

The `TracerProviderInterface`/`MeterProviderInterface` type hints below reference optional open-telemetry/* classes — those packages are `suggest`-only, never a hard dependency. PHP resolves parameter/return types lazily at call time, not at class-load time, so this file loads safely even when the SDK isn't installed; [`TraceRegistry::setProviders()`](/api/telemetry/trace-registry/#setproviders) and the accessors below are simply never called in that case (guarded by [`TelemetryBootstrap`](/api/telemetry/telemetry-bootstrap/)'s own `class_exists()` check).

## Synopsis

`final class TraceRegistry`

|  |  |
|---|---|
| Source | `Telemetry/TraceRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`hasRealProvider(): bool`](#hasrealprovider) | Whether [`TraceRegistry::setProviders()`](/api/telemetry/trace-registry/#setproviders) has installed a real tracer provider. |
| [`isCategoryEnabled(string $category): bool`](#iscategoryenabled) | Whether spans in $category should be recorded. |
| [`isEnabled(): bool`](#isenabled) | Whether the process-wide master switch is on. |
| [`meter(): ?MeterInterface`](#meter) | The single shared Meter instance for the worker's lifetime, or null if unconfigured. |
| [`meterHandle(): ?OtelMeterHandle`](#meterhandle) | The single shared [`OtelMeterHandle`](/api/telemetry/otel-meter-handle/) for the worker's lifetime — cached here (rather than rebuilt per [`Trace::metrics()`](/api/telemetry/trace/#metrics) call) so its internal per-instrument-name cache (histograms/counters/gauges) survives across calls instead of recreating SDK instrument objects every time. |
| [`meterProvider(): ?MeterProviderInterface`](#meterprovider) | The installed meter provider, or null when none has been configured for this worker. |
| [`reset(): void`](#reset) | Reset all configuration and drop the provider singletons. |
| [`setCategories(array<string, bool> $map): void`](#setcategories) |  |
| [`setCategoryEnabled(string $categoryPrefix, bool $enabled): void`](#setcategoryenabled) | Enables or disables a dot-namespaced category prefix, and discards the memoized per-category resolutions so the change takes effect immediately. |
| [`setDefaultCategoryEnabled(bool $enabled): void`](#setdefaultcategoryenabled) | Sets the answer [`TraceRegistry::isCategoryEnabled()`](/api/telemetry/trace-registry/#iscategoryenabled) gives a category with no matching entry anywhere on its prefix chain, and discards the memoized resolutions so the change takes effect immediately. |
| [`setEnabled(bool $enabled): void`](#setenabled) | Sets the process-wide master switch for telemetry. |
| [`setProviders(TracerProviderInterface $tracerProvider, MeterProviderInterface $meterProvider): void`](#setproviders) | Install the worker-lifetime provider singletons. |
| [`tracer(): ?TracerInterface`](#tracer) | The single shared Tracer instance for the worker's lifetime, or null if unconfigured. |
| [`tracerProvider(): ?TracerProviderInterface`](#tracerprovider) | The installed tracer provider, or null when none has been configured for this worker. |

### hasRealProvider()

`public static function hasRealProvider(): bool`

Whether [`TraceRegistry::setProviders()`](/api/telemetry/trace-registry/#setproviders) has installed a real tracer provider.

False whenever telemetry was never configured, was disabled, the OpenTelemetry SDK is not installed, or provider construction failed — which is why callers such as [`Trace::current()`](/api/telemetry/trace/#current) check it before touching any OTel class.

Returns `bool`

### isCategoryEnabled()

`public static function isCategoryEnabled(string $category): bool`

Whether spans in $category should be recorded.

Deliberately NOT the same algorithm as [`LogRegistry::resolveLevel()`](/api/logging/log-registry/#resolvelevel): logging lets a more specific child override its parent (longest-prefix-wins); this is a cascade instead — a disabled ancestor (or the category itself) wins unconditionally, so a descendant's own explicit `true` cannot re-enable it. That's what makes disabling a category a real "turn off this whole * subtree" kill switch rather than an exercise in enumerating every leaf. Only once nothing on the chain is disabled does longest-prefix matching against explicit `true` entries apply, falling back to `$defaultCategoryEnabled`. Memoized per exact category string.

| Parameter | Type | Description |
|---|---|---|
| `$category` | `string` |  |

Returns `bool`

### isEnabled()

`public static function isEnabled(): bool`

Whether the process-wide master switch is on.

Off until something sets it.

Returns `bool`

### meter()

`public static function meter(): ?MeterInterface`

The single shared Meter instance for the worker's lifetime, or null if unconfigured.

Returns `?``MeterInterface`

### meterHandle()

`public static function meterHandle(): ?OtelMeterHandle`

The single shared [`OtelMeterHandle`](/api/telemetry/otel-meter-handle/) for the worker's lifetime — cached here (rather than rebuilt per [`Trace::metrics()`](/api/telemetry/trace/#metrics) call) so its internal per-instrument-name cache (histograms/counters/gauges) survives across calls instead of recreating SDK instrument objects every time.

Returns `?`[`OtelMeterHandle`](/api/telemetry/otel-meter-handle/)

### meterProvider()

`public static function meterProvider(): ?MeterProviderInterface`

The installed meter provider, or null when none has been configured for this worker.

Callers wanting a meter should use [`TraceRegistry::meter()`](/api/telemetry/trace-registry/#meter), which caches the single shared instance.

Returns `?``MeterProviderInterface`

### reset()

`public static function reset(): void`

Reset all configuration and drop the provider singletons.

For test isolation/reconfiguration (simulating a fresh worker); not used on the request path.

### setCategories()

`public static function setCategories(array<string, bool> $map): void`

category-prefix => enabled

| Parameter | Type | Description |
|---|---|---|
| `$map` | `array``<``string``, ``bool``>` | category-prefix => enabled |

### setCategoryEnabled()

`public static function setCategoryEnabled(string $categoryPrefix, bool $enabled): void`

Enables or disables a dot-namespaced category prefix, and discards the memoized per-category resolutions so the change takes effect immediately.

A `false` entry cascades unconditionally over the whole subtree beneath the prefix; see [`TraceRegistry::isCategoryEnabled()`](/api/telemetry/trace-registry/#iscategoryenabled) for the full resolution rules.

| Parameter | Type | Description |
|---|---|---|
| `$categoryPrefix` | `string` |  |
| `$enabled` | `bool` |  |

### setDefaultCategoryEnabled()

`public static function setDefaultCategoryEnabled(bool $enabled): void`

Sets the answer [`TraceRegistry::isCategoryEnabled()`](/api/telemetry/trace-registry/#iscategoryenabled) gives a category with no matching entry anywhere on its prefix chain, and discards the memoized resolutions so the change takes effect immediately.

True until set otherwise, so categories record unless something opts them out.

| Parameter | Type | Description |
|---|---|---|
| `$enabled` | `bool` |  |

### setEnabled()

`public static function setEnabled(bool $enabled): void`

Sets the process-wide master switch for telemetry.

Only stores the flag; providers, categories and their memoized resolutions are untouched, so turning telemetry back on resumes with the same configuration. [`Trace`](/api/telemetry/trace/) consults this before every operation.

| Parameter | Type | Description |
|---|---|---|
| `$enabled` | `bool` |  |

### setProviders()

`public static function setProviders(TracerProviderInterface $tracerProvider, MeterProviderInterface $meterProvider): void`

Install the worker-lifetime provider singletons.

Called exactly once per worker by [`TelemetryBootstrap::configureFromConfig()`](/api/telemetry/telemetry-bootstrap/#configurefromconfig).

| Parameter | Type | Description |
|---|---|---|
| `$tracerProvider` | `TracerProviderInterface` |  |
| `$meterProvider` | `MeterProviderInterface` |  |

### tracer()

`public static function tracer(): ?TracerInterface`

The single shared Tracer instance for the worker's lifetime, or null if unconfigured.

Returns `?``TracerInterface`

### tracerProvider()

`public static function tracerProvider(): ?TracerProviderInterface`

The installed tracer provider, or null when none has been configured for this worker.

Callers wanting a tracer should use [`TraceRegistry::tracer()`](/api/telemetry/trace-registry/#tracer), which caches the single shared instance.

Returns `?``TracerProviderInterface`
