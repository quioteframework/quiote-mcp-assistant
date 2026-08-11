# ContextGetModelToLocatorRector

> `$this->getContext()->getModel(…)` to an injected `ModelLocator`.

`$this->getContext()->getModel(…)` to an injected `ModelLocator`.

```php // before $order = $this->getContext()->getModel('Order', 'Sales'); // after $order = $this->modelLocator->get('Order', 'Sales'); ```

The plan called this "inject a locator", which then had to be designed. It exists now: `Quiote\Model\ModelLocator`, bound as `ModelLocator`/`modelLocator`, and `Context::getModel()` is already a thin delegation to it. So the arguments pass through untouched -- `get()` takes the same `(modelName, moduleName, parameters)` triple, in the same order, with the same defaults.

Safe to inject into any of the four container-built hierarchies, singletons included. The locator holds a shared-model cache, which *is* request-scoped state -- but the locator clears it itself at the request boundary, so holding the locator does not hold the models. That is the same reasoning that makes `RequestState` and `CurrentUser` injectable: the accessor is stable even though what it answers is not.

## Synopsis

`final class ContextGetModelToLocatorRector extends AbstractContextInjectionRector`

|  |  |
|---|---|
| Extends | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) |
| Since | `4.0.0` |
| Source | `Rector/ContextGetModelToLocatorRector.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `autowire()` | `AbstractRector` |  |
| `enterNode()` | `AbstractRector` |  |
| `getNodeTypes()` | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) |  |
| `leaveNode()` | `AbstractRector` |  |
| `refactor()` | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) | Rewrites a class's Context accessor calls into fetches of injected properties. |
