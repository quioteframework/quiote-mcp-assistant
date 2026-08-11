# Psr7HeaderGetter

> Reads W3C `traceparent`/`tracestate` (or any other propagated header) off a PSR-7 message for TraceContextPropagator::extract().

Reads W3C `traceparent`/`tracestate` (or any other propagated header) off a PSR-7 message for `TraceContextPropagator::extract()`.

The SDK's default `ArrayAccessGetterSetter` expects array-like access, which a PSR-7 message isn't — this bridges the two.

## Synopsis

`final class Psr7HeaderGetter implements PropagationGetterInterface`

|  |  |
|---|---|
| Implements | `PropagationGetterInterface` |
| Source | `Psr7HeaderGetter.php` |

## Methods

| Method | Description |
|---|---|
| [`get(mixed $carrier, string $key): ?string`](#get) | The comma-joined value of header $key, matched case-insensitively. |
| [`keys(mixed $carrier): array`](#keys) | The header names present on the carrier, in the message's own casing. |

### get()

`public function get(mixed $carrier, string $key): ?string`

The comma-joined value of header $key, matched case-insensitively.

Null when $carrier is not a PSR-7 message or the header is absent or empty, which the propagator treats as "nothing to extract".

| Parameter | Type | Description |
|---|---|---|
| `$carrier` | `mixed` |  |
| `$key` | `string` |  |

Returns `?``string`

### keys()

`public function keys(mixed $carrier): array`

The header names present on the carrier, in the message's own casing.

An empty array when $carrier is not a PSR-7 message, since the propagator hands over whatever it was given untyped.

| Parameter | Type | Description |
|---|---|---|
| `$carrier` | `mixed` |  |

Returns `array`
