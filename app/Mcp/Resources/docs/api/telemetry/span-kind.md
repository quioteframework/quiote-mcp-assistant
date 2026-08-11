# SpanKind

> Mirrors OpenTelemetry's `SpanKind` constants (`OpenTelemetry\\API\\Trace\\SpanKind::KIND_*`) numerically 1:1, but as our own framework-owned enum so Trace::span()'s signature never needs the optional open-telemetry/api package to exist — PHP resolves a default parameter value eagerly (unlike type hints, which resolve lazily at call time), so a default referencing an optional class's constant would crash every `Trace::span()` call with no explicit $kind when the SDK isn't installed.

Mirrors OpenTelemetry's `SpanKind` constants (`OpenTelemetry\API\Trace\SpanKind::KIND_*`) numerically 1:1, but as our own framework-owned enum so [`Trace::span()`](/api/telemetry/trace/#span)'s signature never needs the optional open-telemetry/api package to exist — PHP resolves a default parameter value eagerly (unlike type hints, which resolve lazily at call time), so a default referencing an optional class's constant would crash every `Trace::span()` call with no explicit $kind when the SDK isn't installed.

An owned enum with matching int values sidesteps that entirely.

## Synopsis

`enum SpanKind: int`

|  |  |
|---|---|
| Source | `Telemetry/SpanKind.php` |

## Cases

| Case | Value | Description |
|---|---|---|
| `Internal` | `0` |  |
| `Client` | `1` |  |
| `Server` | `2` |  |
| `Producer` | `3` |  |
| `Consumer` | `4` |  |

## Properties

| Property | Type | Description |
|---|---|---|
| `$name` | `string` | _readonly._ |
| `$value` | `int` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`cases(): array`](#cases) |  |
| [`from(string|int $value): static`](#from) |  |
| [`tryFrom(string|int $value): ?static`](#tryfrom) |  |

### cases()

`public static function cases(): array`

Returns `array`

### from()

`public static function from(string|int $value): static`

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string``|``int` |  |

Returns `static`

### tryFrom()

`public static function tryFrom(string|int $value): ?static`

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string``|``int` |  |

Returns `?``static`
