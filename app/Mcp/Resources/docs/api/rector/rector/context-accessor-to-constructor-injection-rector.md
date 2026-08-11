# ContextAccessorToConstructorInjectionRector

> Process-lifetime Context accessors to injected collaborators.

Process-lifetime Context accessors to injected collaborators.

```php // before $this->getContext()->getRouting()->gen('order.show', ['id' => $id]); // after $this->routing->gen('order.show', ['id' => $id]); ```

These are safe to hold because they live for the process: they are built once at initialize() and are not replaced at the request boundary the way the request and user are.

## The two optional components are included, and what makes that safe

`getTranslationManager()` and `getDatabaseManager()` answered null in a context that configures neither, so a call site guards with `?->`. What made injecting them unsafe was not the null: it was that both classes are instantiable with zero required constructor arguments, so a container asked for one it had no binding for would autowire a brand-new, uninitialized instance -- a translation manager with no locales -- and the guard, rewritten to a property fetch, would sail past it.

`Context` binds them either way now: to the component when the configuration declares one, and otherwise to a factory that says which configuration would have. An injected dependency therefore either is the real component or fails naming the cause, which is what makes the substitution a substitution rather than a judgement.

A `?->` at the call site survives the rewrite as `$this->translationManager?->…`, so nothing changes meaning; the branch it guards has simply become unreachable, and collapsing it to `->` is a tidy-up a reader can make later.

`getDatabaseConnection()` is deliberately still absent: its replacement is a call on the injected manager rather than the manager itself, which is a different rewrite and not a mapping entry.

## Synopsis

`final class ContextAccessorToConstructorInjectionRector extends AbstractContextInjectionRector`

|  |  |
|---|---|
| Extends | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) |
| Since | `4.0.0` |
| Source | `Rector/ContextAccessorToConstructorInjectionRector.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `autowire()` | `AbstractRector` |  |
| `enterNode()` | `AbstractRector` |  |
| `getNodeTypes()` | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) |  |
| `leaveNode()` | `AbstractRector` |  |
| `refactor()` | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) | Rewrites a class's Context accessor calls into fetches of injected properties. |
