# EloquentMinimalEventDispatcher

> A minimal `Illuminate\\Contracts\\Events\\Dispatcher` implementation, used only as the fallback `EloquentQueryRecorder::attach()` installs on a `Illuminate\\Database\\Connection` that has no event dispatcher of its own -- which is the case for `Quiote\\Database\\Adapter\\Eloquent\\EloquentDatabase`'s `connect()`, which never calls `Capsule::setEventDispatcher()`.

A minimal `Illuminate\Contracts\Events\Dispatcher` implementation, used only as the fallback `EloquentQueryRecorder::attach()` installs on a `Illuminate\Database\Connection` that has no event dispatcher of its own -- which is the case for `Quiote\Database\Adapter\Eloquent\EloquentDatabase`'s `connect()`, which never calls `Capsule::setEventDispatcher()`.

`illuminate/events` is not a dependency of this codebase (or of `illuminate/database` itself), so this exists rather than pulling in the full package for one interface.

Supports exactly what `Illuminate\Database\Connection` actually calls on a connection-level event dispatcher: `listen()`/`dispatch()`/`hasListeners()` for query, transaction and connection-lifecycle events, and `until()` as a thin wrapper over `dispatch()`. The queued-event API (`push()`/`flush()`/ `forgetPushed()`) and `subscribe()` are not part of that surface and are intentionally unimplemented (no-ops / throwing) -- if an application attaches this to anything beyond a single DB connection, that is a sign it needs a real event dispatcher, not this one.

## Synopsis

`final class EloquentMinimalEventDispatcher implements Dispatcher`

|  |  |
|---|---|
| Implements | `Dispatcher` |
| Source | `EloquentMinimalEventDispatcher.php` |

## Methods

| Method | Description |
|---|---|
| [`dispatch(string|object $event, array<int, mixed> $payload = [], bool $halt = false): mixed`](#dispatch) | Dispatch an event and call the listeners. |
| [`flush(string $event): void`](#flush) | Flush a set of pushed events. |
| [`forget(string $event): void`](#forget) | Remove a set of listeners from the dispatcher. |
| [`forgetPushed(): void`](#forgetpushed) | Forget all of the queued listeners. |
| [`hasListeners(string $eventName): bool`](#haslisteners) | Determine if a given event has listeners. |
| [`listen(Closure|string|array<int, string> $events, Closure|string|array<int, string>|null $listener = null): void`](#listen) | Register an event listener with the dispatcher. |
| [`push(string $event, array<int, mixed> $payload = []): void`](#push) | Register an event and payload to be fired later. |
| [`subscribe(object|string $subscriber): void`](#subscribe) | Register an event subscriber with the dispatcher. |
| [`until(string|object $event, array<int, mixed> $payload = []): mixed`](#until) | Dispatch an event until the first non-null response is returned. |

### dispatch()

`public function dispatch(string|object $event, array<int, mixed> $payload = [], bool $halt = false): mixed`

Dispatch an event and call the listeners.

| Parameter | Type | Description |
|---|---|---|
| `$event` | `string``|``object` |  |
| `$payload` | `array``<``int``, ``mixed``>` |  |
| `$halt` | `bool` |  |

Returns `mixed`

### flush()

`public function flush(string $event): void`

Flush a set of pushed events.

| Parameter | Type | Description |
|---|---|---|
| `$event` | `string` |  |

### forget()

`public function forget(string $event): void`

Remove a set of listeners from the dispatcher.

| Parameter | Type | Description |
|---|---|---|
| `$event` | `string` |  |

### forgetPushed()

`public function forgetPushed(): void`

Forget all of the queued listeners.

### hasListeners()

`public function hasListeners(string $eventName): bool`

Determine if a given event has listeners.

| Parameter | Type | Description |
|---|---|---|
| `$eventName` | `string` |  |

Returns `bool`

### listen()

`public function listen(Closure|string|array<int, string> $events, Closure|string|array<int, string>|null $listener = null): void`

Register an event listener with the dispatcher.

| Parameter | Type | Description |
|---|---|---|
| `$events` | [`Closure`](https://www.php.net/manual/en/class.closure.php)`|``string``|``array``<``int``, ``string``>` |  |
| `$listener` | [`Closure`](https://www.php.net/manual/en/class.closure.php)`|``string``|``array``<``int``, ``string``>``|``null` |  |

### push()

`public function push(string $event, array<int, mixed> $payload = []): void`

Register an event and payload to be fired later.

| Parameter | Type | Description |
|---|---|---|
| `$event` | `string` |  |
| `$payload` | `array``<``int``, ``mixed``>` |  |

### subscribe()

`public function subscribe(object|string $subscriber): void`

Register an event subscriber with the dispatcher.

| Parameter | Type | Description |
|---|---|---|
| `$subscriber` | `object``|``string` |  |

### until()

`public function until(string|object $event, array<int, mixed> $payload = []): mixed`

Dispatch an event until the first non-null response is returned.

| Parameter | Type | Description |
|---|---|---|
| `$event` | `string``|``object` |  |
| `$payload` | `array``<``int``, ``mixed``>` |  |

Returns `mixed`
