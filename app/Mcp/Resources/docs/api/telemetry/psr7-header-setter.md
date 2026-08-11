# Psr7HeaderSetter

> The outbound counterpart to Psr7HeaderGetter: adapts a PSR-7 request to OpenTelemetry's propagation *setter* so `TraceContextPropagator::inject()` can write `traceparent`/`tracestate` onto an outgoing request.

The outbound counterpart to [`Psr7HeaderGetter`](/api/telemetry/psr7-header-getter/): adapts a PSR-7 request to OpenTelemetry's propagation *setter* so `TraceContextPropagator::inject()` can write `traceparent`/`tracestate` onto an outgoing request.

This was previously unbuilt for want of an HTTP client to inject into.

The carrier is passed and reassigned by reference because PSR-7 messages are immutable — `withHeader()` returns a new instance — so `inject()`'s `&$carrier` contract is exactly what lets the mutated request propagate back to the caller.

Like [`Psr7HeaderGetter`](/api/telemetry/psr7-header-getter/), this implements an open-telemetry/context interface directly, so it is only ever referenced behind a `Trace::enabled()` gate (in [`HttpClient`](/api/http/client/http-client/)), at which point the SDK is installed and the interface exists.

## Synopsis

`final class Psr7HeaderSetter implements PropagationSetterInterface`

|  |  |
|---|---|
| Implements | `PropagationSetterInterface` |
| Source | `Psr7HeaderSetter.php` |

## Methods

| Method | Description |
|---|---|
| [`set(MessageInterface &$carrier, string $key, string $value): void`](#set) | Set the value for a given key on the associated carrier. |

### set()

`public function set(MessageInterface &$carrier, string $key, string $value): void`

Set the value for a given key on the associated carrier.

| Parameter | Type | Description |
|---|---|---|
| `$carrier` | `MessageInterface` |  |
| `$key` | `string` |  |
| `$value` | `string` |  |
