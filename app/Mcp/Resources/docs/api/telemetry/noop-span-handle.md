# NoopSpanHandle

> The disabled-state SpanHandle: every call is a safe no-op.

The disabled-state [`SpanHandle`](/api/telemetry/span-handle/): every call is a safe no-op.

A single shared instance is reused ([`NoopSpanHandle::instance()`](/api/telemetry/noop-span-handle/#instance)) so instrumenting a call site costs no allocation whether telemetry is globally off, a trace category is filtered out, or no real tracer has been wired up yet.

## Synopsis

`final class NoopSpanHandle implements SpanHandle`

|  |  |
|---|---|
| Implements | [`SpanHandle`](/api/telemetry/span-handle/) |
| Source | `Telemetry/NoopSpanHandle.php` |

## Methods

| Method | Description |
|---|---|
| [`addEvent(string $name, array $attributes = []): static`](#addevent) | Discards the event and returns $this. |
| [`end(): void`](#end) | Does nothing; there is no span to end. |
| [`instance(): NoopSpanHandle`](#instance) | The shared no-op span handle, created on first call and reused for the rest of the process. |
| [`recordException(Throwable $e): static`](#recordexception) | Discards the exception and returns $this; nothing is exported. |
| [`setAttribute(string $key, mixed $value): static`](#setattribute) | Discards the attribute and returns $this. |
| [`setAttributes(array $attributes): static`](#setattributes) | Discards the attributes and returns $this. |
| [`setStatusError(?string $description = null): static`](#setstatuserror) | Discards the error status and returns $this. |
| [`spanId(): ?string`](#spanid) | Always null — a no-op span has no trace context. |
| [`traceId(): ?string`](#traceid) | Always null — a no-op span has no trace context. |
| [`updateName(string $name): static`](#updatename) | Discards the new name and returns $this. |

### addEvent()

`public function addEvent(string $name, array $attributes = []): static`

Discards the event and returns $this.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$attributes` | `array` |  |

Returns `static`

### end()

`public function end(): void`

Does nothing; there is no span to end.

### instance()

`public static function instance(): NoopSpanHandle`

The shared no-op span handle, created on first call and reused for the rest of the process.

Safe to hand out freely: it is stateless, owns no span lifecycle, and every call on it is discarded.

Returns [`NoopSpanHandle`](/api/telemetry/noop-span-handle/)

### recordException()

`public function recordException(Throwable $e): static`

Discards the exception and returns $this; nothing is exported.

| Parameter | Type | Description |
|---|---|---|
| `$e` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php) |  |

Returns `static`

### setAttribute()

`public function setAttribute(string $key, mixed $value): static`

Discards the attribute and returns $this.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$value` | `mixed` |  |

Returns `static`

### setAttributes()

`public function setAttributes(array $attributes): static`

Discards the attributes and returns $this.

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array` |  |

Returns `static`

### setStatusError()

`public function setStatusError(?string $description = null): static`

Discards the error status and returns $this.

| Parameter | Type | Description |
|---|---|---|
| `$description` | `?``string` |  |

Returns `static`

### spanId()

`public function spanId(): ?string`

Always null — a no-op span has no trace context.

Returns `?``string`

### traceId()

`public function traceId(): ?string`

Always null — a no-op span has no trace context.

Returns `?``string`

### updateName()

`public function updateName(string $name): static`

Discards the new name and returns $this.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `static`
