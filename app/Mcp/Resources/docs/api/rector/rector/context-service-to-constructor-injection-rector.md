# ContextServiceToConstructorInjectionRector

> `$this->getContext()->getService(Foo::class)` to an injected `Foo`.

`$this->getContext()->getService(Foo::class)` to an injected `Foo`.

The easiest of the rule set, and deliberately first: the service's class name is already an argument to the call, so nothing has to map an identifier onto a class. That makes it the rule that proves the shared machinery -- receiver type resolution, constructor injection, property naming -- against the least additional risk.

Only rewrites when the argument is a `::class` fetch. `getService($id)` with a variable, or with a plain string, is left alone: the target would have to be guessed, and a guess here silently injects the wrong collaborator.

```php // before final class TagAction extends Action { public function executeRead(WebRequest $rd) { return $this->getContext()->getService(TagService::class)->tag($rd); } }

// after final class TagAction extends Action { public function __construct(private readonly TagService $tagService) {}

public function executeRead(WebRequest $rd) { return $this->tagService->tag($rd); } } ```

No getRuleDefinition(): Rector 2.3's RectorInterface does not declare it, and the symplify/rule-doc-generator value objects it returns are not shipped with the packaged build. The example above serves the same purpose.

## Synopsis

`final class ContextServiceToConstructorInjectionRector extends AbstractContextInjectionRector`

|  |  |
|---|---|
| Extends | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) |
| Since | `4.0.0` |
| Source | `Rector/ContextServiceToConstructorInjectionRector.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `autowire()` | `AbstractRector` |  |
| `enterNode()` | `AbstractRector` |  |
| `getNodeTypes()` | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) |  |
| `leaveNode()` | `AbstractRector` |  |
| `refactor()` | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) | Rewrites a class's Context accessor calls into fetches of injected properties. |
