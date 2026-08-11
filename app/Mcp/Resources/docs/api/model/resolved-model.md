# ResolvedModel

> What ModelClassResolver learned about a model name: which class it names, and the two facts about that class the instantiation path needs.

What [`ModelClassResolver`](/api/model/model-class-resolver/) learned about a model name: which class it names, and the two facts about that class the instantiation path needs.

Both flags come from reflection, which is why they are resolved once and cached with the class name rather than probed per call.

## Synopsis

`final readonly class ResolvedModel`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `Model/ResolvedModel.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$class` | `string` | _readonly._ |
| `$hasConstructor` | `bool` | _readonly._ |
| `$isSingleton` | `bool` | _readonly._ |

## Constructor

### __construct()

`public function __construct(class-string $class, bool $isSingleton, bool $hasConstructor): mixed`

Whether the class declares a constructor. Without one,
            parameters go to initialize() only -- passing them to `new` would fail.

| Parameter | Type | Description |
|---|---|---|
| `$class` | `class-string` | The class the model name resolved to. |
| `$isSingleton` | `bool` | Whether the class implements [`ISingletonModel`](/api/model/i-singleton-model/), and so must be answered from the locator's per-context instance cache. |
| `$hasConstructor` | `bool` | Whether the class declares a constructor. Without one, parameters go to initialize() only -- passing them to `new` would fail. |

Returns `mixed`
