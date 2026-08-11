# OtelSpanHandle

> Real SpanHandle, wrapping an active OpenTelemetry SpanInterface.

Real [`SpanHandle`](/api/telemetry/span-handle/), wrapping an active OpenTelemetry `SpanInterface`.

If the span was activated (pushed onto the current context via `SpanInterface::activate()` when [`Trace::span()`](/api/telemetry/trace/#span) created it), the owning `ScopeInterface` is detached exactly once, when [`OtelSpanHandle::end()`](/api/telemetry/otel-span-handle/#end) runs.

A handle obtained from [`Trace::current()`](/api/telemetry/trace/#current) is a *borrowed* reference — it didn't create the span and doesn't own its lifecycle, so `$ownsLifecycle = false` there. This matters: `Trace::current()` is often used inline as a bare expression, e.g. `Trace::current()->recordException($e)->setStatusError(...);` — the temporary `OtelSpanHandle` this creates has no other reference and is destructed at the end of that statement. If `__destruct()` unconditionally called `end()`, that would end the REAL underlying span the caller merely borrowed a reference to, before whoever actually owns it (e.g. `TelemetryMiddleware`, still further up the call stack) gets a chance to — silently discarding every mutation made after that point, since a real OTel span ignores `setStatus()`/`recordException()`/etc. once ended. This is exactly the bug an earlier version of this file had, caught during the OTel Collector end-to-end verification (docs/OPENTELEMETRY_E2E_VERIFICATION.md): `RoutingMiddleware` captures `Trace::current()` into a local `$root` variable to rename it on a successful match; that local going out of scope (including mid-exception-unwind) was silently ending the root span long before `TelemetryMiddleware`'s own `finally` block ran, so an action exception's Error status never made it onto the exported root span. An explicit `->end()` call is still always honored, on any handle — this only changes whether *destruction* implies ending.

Every mutator is wrapped so a call site can never crash the request: attribute keys/values are validated by [`AttributeSanitizer`](/api/telemetry/attribute-sanitizer/) against what the SDK's own API accepts (`bool|int|float|string|array|null`, non-empty-string keys), so passing an object/resource/etc — a caller bug, or hostile/unexpected instrumentation input — throws there instead of reaching the SDK. That is swallowed and logged at debug level rather than propagating, matching the no-op layer's "instrumenting a call site is * always safe" guarantee.

## Synopsis

`final class OtelSpanHandle implements SpanHandle`

|  |  |
|---|---|
| Implements | [`SpanHandle`](/api/telemetry/span-handle/) |
| Source | `OtelSpanHandle.php` |

## Constructor

### __construct()

`public function __construct(SpanInterface $span, ?ScopeInterface $scope = null, bool $ownsLifecycle = true): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$span` | `SpanInterface` |  |
| `$scope` | `?``ScopeInterface` |  |
| `$ownsLifecycle` | `bool` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`__destruct(): mixed`](#destruct) |  |
| [`addEvent(string $name, array $attributes = []): static`](#addevent) | Adds a timestamped event to the span. |
| [`end(): void`](#end) | Ends the underlying span and detaches the scope it was activated in. |
| [`recordException(Throwable $e): static`](#recordexception) | Records $e on the span as an exception event. |
| [`setAttribute(string $key, mixed $value): static`](#setattribute) | Sets a single attribute, passing key and value through [`AttributeSanitizer::sanitizeEntry()`](/api/telemetry/attribute-sanitizer/#sanitizeentry) first. |
| [`setAttributes(array $attributes): static`](#setattributes) | Sets several attributes at once, sanitized as in [`OtelSpanHandle::setAttribute()`](/api/telemetry/otel-span-handle/#setattribute). |
| [`setStatusError(?string $description = null): static`](#setstatuserror) | Sets the span's status to `ERROR` with an optional description. |
| [`spanId(): ?string`](#spanid) | The 16-hex-character span ID of the underlying span, or null under the same conditions as [`OtelSpanHandle::traceId()`](/api/telemetry/otel-span-handle/#traceid). |
| [`traceId(): ?string`](#traceid) | The 32-hex-character trace ID of the underlying span. |
| [`updateName(string $name): static`](#updatename) | Renames the underlying span, substituting `(unnamed)` for an empty string so an exported span always carries a name. |

### __destruct()

`public function __destruct(): mixed`

Returns `mixed`

### addEvent()

`public function addEvent(string $name, array $attributes = []): static`

Adds a timestamped event to the span.

Failures are swallowed and logged at debug level.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$attributes` | `array` |  |

Returns `static`

### end()

`public function end(): void`

Ends the underlying span and detaches the scope it was activated in.

Guarded by an `$ended` flag, so repeated calls — including the one from `__destruct()` on a handle that owns its span's lifecycle — do nothing after the first. Both the end and the detach are swallowed on failure and logged at debug level.

### recordException()

`public function recordException(Throwable $e): static`

Records $e on the span as an exception event.

Does not change the span's status — call [`OtelSpanHandle::setStatusError()`](/api/telemetry/otel-span-handle/#setstatuserror) for that. Failures are swallowed and logged at debug level.

| Parameter | Type | Description |
|---|---|---|
| `$e` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php) |  |

Returns `static`

### setAttribute()

`public function setAttribute(string $key, mixed $value): static`

Sets a single attribute, passing key and value through [`AttributeSanitizer::sanitizeEntry()`](/api/telemetry/attribute-sanitizer/#sanitizeentry) first.

A key or value the SDK cannot accept makes the sanitizer throw; that is caught and logged at debug level, so the attribute is dropped rather than failing the caller.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$value` | `mixed` |  |

Returns `static`

### setAttributes()

`public function setAttributes(array $attributes): static`

Sets several attributes at once, sanitized as in [`OtelSpanHandle::setAttribute()`](/api/telemetry/otel-span-handle/#setattribute).

The batch is applied as a unit: if sanitizing any entry throws, none of them reach the span and the failure is logged at debug level.

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array` |  |

Returns `static`

### setStatusError()

`public function setStatusError(?string $description = null): static`

Sets the span's status to `ERROR` with an optional description.

The SDK ignores status changes on an already-ended span, so this has no effect after [`OtelSpanHandle::end()`](/api/telemetry/otel-span-handle/#end). Failures are swallowed and logged at debug level.

| Parameter | Type | Description |
|---|---|---|
| `$description` | `?``string` |  |

Returns `static`

### spanId()

`public function spanId(): ?string`

The 16-hex-character span ID of the underlying span, or null under the same conditions as [`OtelSpanHandle::traceId()`](/api/telemetry/otel-span-handle/#traceid).

Returns `?``string`

### traceId()

`public function traceId(): ?string`

The 32-hex-character trace ID of the underlying span.

Null when the span context is invalid (a non-recording or propagation placeholder span) or when reading it throws. Independent of the sampling decision — an unsampled span still reports its ID.

Returns `?``string`

### updateName()

`public function updateName(string $name): static`

Renames the underlying span, substituting `(unnamed)` for an empty string so an exported span always carries a name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `static`
