# SpanHandle

> A single unit of work in a trace.

A single unit of work in a trace.

Every mutator returns $this so call sites can chain; [`SpanHandle::end()`](/api/telemetry/span-handle/#end) is idempotent — safe to call more than once (e.g. once explicitly in a `finally` block and again implicitly via a wrapping scope guard).

## Synopsis

`interface SpanHandle`

|  |  |
|---|---|
| Implemented by | [`NoopSpanHandle`](/api/telemetry/noop-span-handle/), [`OtelSpanHandle`](/api/telemetry/otel-span-handle/) |
| Source | `Telemetry/SpanHandle.php` |

## Methods

| Method | Description |
|---|---|
| [`addEvent(string $name, array<string, mixed> $attributes = []): static`](#addevent) |  |
| [`end(): void`](#end) | Ends the span, fixing its duration and handing it to the exporter. |
| [`recordException(Throwable $e): static`](#recordexception) | Attaches $e to the span as an exception event. |
| [`setAttribute(string $key, mixed $value): static`](#setattribute) | Sets a single attribute on the span, replacing any previous value for that key. |
| [`setAttributes(array<string, mixed> $attributes): static`](#setattributes) |  |
| [`setStatusError(?string $description = null): static`](#setstatuserror) | Marks the span's status as an error, optionally with a human-readable description of what went wrong. |
| [`spanId(): ?string`](#spanid) | The span's own span ID (16 lowercase hex chars), or null — see [`SpanHandle::traceId()`](/api/telemetry/span-handle/#traceid). |
| [`traceId(): ?string`](#traceid) | The span's trace ID (32 lowercase hex chars), or null for a no-op span or one with no valid context. |
| [`updateName(string $name): static`](#updatename) | Renames the span (e.g. |

### addEvent()

`abstract public function addEvent(string $name, array<string, mixed> $attributes = []): static`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$attributes` | `array``<``string``, ``mixed``>` |  |

Returns `static`

### end()

`abstract public function end(): void`

Ends the span, fixing its duration and handing it to the exporter.

Idempotent: later calls, and any mutation attempted after the first one, have no effect.

### recordException()

`abstract public function recordException(Throwable $e): static`

Attaches $e to the span as an exception event.

Recording an exception does not by itself mark the span as failed — call [`SpanHandle::setStatusError()`](/api/telemetry/span-handle/#setstatuserror) for that.

| Parameter | Type | Description |
|---|---|---|
| `$e` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php) |  |

Returns `static`

### setAttribute()

`abstract public function setAttribute(string $key, mixed $value): static`

Sets a single attribute on the span, replacing any previous value for that key.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$value` | `mixed` |  |

Returns `static`

### setAttributes()

`abstract public function setAttributes(array<string, mixed> $attributes): static`

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array``<``string``, ``mixed``>` |  |

Returns `static`

### setStatusError()

`abstract public function setStatusError(?string $description = null): static`

Marks the span's status as an error, optionally with a human-readable description of what went wrong.

| Parameter | Type | Description |
|---|---|---|
| `$description` | `?``string` |  |

Returns `static`

### spanId()

`abstract public function spanId(): ?string`

The span's own span ID (16 lowercase hex chars), or null — see [`SpanHandle::traceId()`](/api/telemetry/span-handle/#traceid).

Returns `?``string`

### traceId()

`abstract public function traceId(): ?string`

The span's trace ID (32 lowercase hex chars), or null for a no-op span or one with no valid context.

IDs exist regardless of the sampling decision — a dropped/unsampled span still has a real trace ID, just nothing exported for it.

Returns `?``string`

### updateName()

`abstract public function updateName(string $name): static`

Renames the span (e.g.

once route matching resolves the root request span's low-cardinality identity).

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `static`
