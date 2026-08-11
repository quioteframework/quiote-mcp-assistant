# LogContext

> Ambient, stack-based logging context (Serilog LogContext / .NET BeginScope).

Ambient, stack-based logging context (Serilog LogContext / .NET BeginScope).

Properties pushed here are merged into every [`LogEvent`](/api/logging/log-event/) emitted while the scope is active — e.g. the request correlation id, the authenticated user id. WORKER-MODE SAFETY: the stack is process-global. In a FrankenPHP worker the process is long-lived, so a scope left on the stack would leak one request's properties into the next request's logs (a cross-request data leak, same class as the session-id leak). [`LogContext::clear()`](/api/logging/log-context/#clear) MUST be called between requests — it is wired into Context::reset().

## Synopsis

`final class LogContext`

|  |  |
|---|---|
| Source | `Logging/LogContext.php` |

## Methods

| Method | Description |
|---|---|
| [`clear(): void`](#clear) | Drop all scopes. |
| [`current(): array<string, mixed>`](#current) | The merged property set of all active frames, later pushes winning on key collisions. |
| [`enrich(array<string, mixed> $properties): void`](#enrich) | Push properties for the remainder of the request with NO token to hold — the frame is removed only by [`LogContext::clear()`](/api/logging/log-context/#clear) (worker reset). |
| [`isEmpty(): bool`](#isempty) | Reports whether no context scope is currently active. |
| [`push(array<string, mixed> $properties): ScopeToken`](#push) | Push a set of properties. |

### clear()

`public static function clear(): void`

Drop all scopes.

Call between requests in worker mode (Context::reset()).

### current()

`public static function current(): array<string, mixed>`

The merged property set of all active frames, later pushes winning on key collisions.

Memoized until the frame set changes.

Returns `array``<``string``, ``mixed``>`

### enrich()

`public static function enrich(array<string, mixed> $properties): void`

Push properties for the remainder of the request with NO token to hold — the frame is removed only by [`LogContext::clear()`](/api/logging/log-context/#clear) (worker reset).

| Parameter | Type | Description |
|---|---|---|
| `$properties` | `array``<``string``, ``mixed``>` |  |

### isEmpty()

`public static function isEmpty(): bool`

Reports whether no context scope is currently active.

Lets a caller skip the merge [`LogContext::current()`](/api/logging/log-context/#current) would otherwise perform when there is nothing to attach to a record. True also when frames were pushed and have all since been popped or cleared.

Returns `bool`

### push()

`public static function push(array<string, mixed> $properties): ScopeToken`

Push a set of properties.

| Parameter | Type | Description |
|---|---|---|
| `$properties` | `array``<``string``, ``mixed``>` |  |

Returns [`ScopeToken`](/api/logging/scope-token/)
