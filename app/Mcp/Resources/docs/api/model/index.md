# Model

> The Quiote\\Model namespace — 6 documented types.

Everything under `Quiote\Model`.

## Classes

| Class | Description |
|---|---|
| [`Model`](/api/model/model/) | Model provides a convention for separating business logic from application logic. |
| [`ModelClassResolver`](/api/model/model-class-resolver/) | Turns a model name into the class that implements it. |
| [`ModelLocator`](/api/model/model-locator/) | Hands out model instances. |
| [`ResolvedModel`](/api/model/resolved-model/) | What [`ModelClassResolver`](/api/model/model-class-resolver/) learned about a model name: which class it names, and the two facts about that class the instantiation path needs. |

## Interfaces

| Interface | Description |
|---|---|
| [`IModel`](/api/model/i-model/) | Model provides a convention for separating business logic from application logic. |
| [`ISingletonModel`](/api/model/i-singleton-model/) | An extension to Model, but for implementation as a Singleton |
