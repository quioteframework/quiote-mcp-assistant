# ContextComponentInterface

> A core component the Context constructs from the factory metadata captured at Context::initialize() and drives through a two-step lifecycle.

A core component the [`Context`](/api/context/) constructs from the factory metadata captured at [`Context::initialize()`](/api/context/#initialize) and drives through a two-step lifecycle.

The request, user, routing and database manager are all built this way, and all four are rebuilt on demand after the worker request boundary nulls them. This interface is what lets [`Context`](/api/context/) express that rebuild once instead of per component.

Return types are deliberately left undeclared: implementations are free to declare `void` (or anything else), which keeps application subclasses of the shipped components compatible whether or not they declare one.

## Synopsis

`interface ContextComponentInterface`

|  |  |
|---|---|
| Implemented by | [`DatabaseManager`](/api/database/database-manager/), [`WebRequest`](/api/request/web-request/), [`Routing`](/api/routing/routing/), [`User`](/api/user/user/) |
| Since | `3.2.0` |
| Source | `ContextComponentInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`initialize(Context $context, array<string, mixed> $parameters = []): mixed`](#initialize) | Configure this component against the context that owns it. |
| [`startup(): mixed`](#startup) | Begin this component's active life, after [`ContextComponentInterface::initialize()`](/api/context-component-interface/#initialize) has configured it. |

### initialize()

`abstract public function initialize(Context $context, array<string, mixed> $parameters = []): mixed`

Configure this component against the context that owns it.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |

Returns `mixed` — Ignored; declared untyped so implementations may narrow it.

### startup()

`abstract public function startup(): mixed`

Begin this component's active life, after [`ContextComponentInterface::initialize()`](/api/context-component-interface/#initialize) has configured it.

Returns `mixed` — Ignored; declared untyped so implementations may narrow it.
