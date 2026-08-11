# Model

> Model provides a convention for separating business logic from application logic.

Model provides a convention for separating business logic from application logic.

When using a model you're providing a globally accessible API for other modules to access, which will boost interoperability among modules in your web application.

## Synopsis

`abstract class Model implements IModel`

|  |  |
|---|---|
| Implements | [`IModel`](/api/model/i-model/) |
| Since | `1.0.0` |
| Source | `Model/Model.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$_contextName` | `mixed` | _protected._ |
| `$context` | `mixed` | _protected._ |

## Methods

| Method | Description |
|---|---|
| [`__sleep(): mixed`](#sleep) | Pre-serialization callback. |
| [`__wakeup(): mixed`](#wakeup) | Post-unserialization callback. |
| [`getContext(): Context`](#getcontext) | Retrieve the current application context. |
| [`initialize(Context $context, array<array-key, mixed> $parameters = []): void`](#initialize) | Initialize this model. |

### __sleep()

`public function __sleep(): mixed`

Pre-serialization callback.

Will set the name of the context and exclude the instance from serializing.

Returns `mixed`

### __wakeup()

`public function __wakeup(): mixed`

Post-unserialization callback.

Will restore the context based on the names set by __sleep.

Returns `mixed`

### getContext()

`final public function getContext(): Context`

Retrieve the current application context.

Returns [`Context`](/api/context/) — The current Context instance.

### initialize()

`public function initialize(Context $context, array<array-key, mixed> $parameters = []): void`

Initialize this model.

Initialization parameters. The same array
            the locator spreads into the constructor when the class declares one, so it is
            positional as often as it is associative.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | The current application context. |
| `$parameters` | `array``<``array-key``, ``mixed``>` | Initialization parameters. The same array the locator spreads into the constructor when the class declares one, so it is positional as often as it is associative. |
