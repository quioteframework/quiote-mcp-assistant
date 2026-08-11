# ModelLocator

> Hands out model instances.

Hands out model instances.

Where [`ModelClassResolver`](/api/model/model-class-resolver/) answers "which class is this", the locator owns everything that follows: bootstrapping the owning module, deciding whether an instance is shared, constructing it, and running the initialize() hand-off. Those are lifetime concerns, and they change for different reasons than the naming conventions do -- which is why they are not the same class.

Singleton models are cached per context, and that cache is request-scoped state: it is dropped by [`ModelLocator::reset()`](/api/model/model-locator/#reset) at the worker request boundary, because a model holding request data would otherwise serve it to the next request.

## Synopsis

`final class ModelLocator implements ResetInterface`

|  |  |
|---|---|
| Implements | `ResetInterface` |
| Since | `4.0.0` |
| Source | `Model/ModelLocator.php` |

## Constructor

### __construct()

`public function __construct(Context $context, ModelClassResolver $resolver): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$resolver` | [`ModelClassResolver`](/api/model/model-class-resolver/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`get(string $modelName, ?string $moduleName = null, ?array<int, mixed> $parameters = null): Model`](#get) | Retrieve a model instance. |
| [`reset(): void`](#reset) | Drop the shared singleton instances at the worker request boundary. |

### get()

`public function get(string $modelName, ?string $moduleName = null, ?array<int, mixed> $parameters = null): Model`

Retrieve a model instance.

Passed to the constructor (when the class
            declares one) and to initialize().

| Parameter | Type | Description |
|---|---|---|
| `$modelName` | `string` | A model name or fully qualified class name. |
| `$moduleName` | `?``string` | A module name for a module model, null for a global one. |
| `$parameters` | `?``array``<``int``, ``mixed``>` | Passed to the constructor (when the class declares one) and to initialize(). |

Returns [`Model`](/api/model/model/)

| Throws | When |
|---|---|
| `QuioteException` | When no class exists for the name, or the class that does is not a [`Model`](/api/model/model/). |

### reset()

`public function reset(): void`

Drop the shared singleton instances at the worker request boundary.

The resolution cache is deliberately kept -- it holds class names, not request state.
