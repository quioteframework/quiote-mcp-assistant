# ContextGetInstanceToRegistryRector

> `Context::getInstance('web')` to an injected `ContextRegistry`.

`Context::getInstance('web')` to an injected `ContextRegistry`.

```php // before Context::getInstance('web')->getRouting()->gen(…); // after $this->contexts->get('web')->getRouting()->gen(…); ```

The one rule that rewrites a *static* reach rather than an instance call, which is also what makes it the only one where the receiver cannot be type-resolved -- there is no receiver expression, only a class name. So this matches on the name resolving to `Context` or a subclass, which is exact rather than heuristic: a static call names its class outright.

## The target got simpler than the plan sketched

The plan expected to emit `$this->contexts->get('web')->getContainer()->get(Routing::class)->gen(…)` and noted that the awkwardness was informative. It is no longer necessary: `ContextRegistry` exists, is bound in the container as `ContextRegistry`/`contexts`, and `get()` answers a real `Context`, so the accessor chain after it stays exactly as it was. Whatever the call site then reaches for is rule 1's, 2's, 3's or 4's business on a later pass.

The plan's other observation stands and is worth keeping: most of these sites probably want the *current* context rather than a named lookup, and this rewrite makes that visible instead of hiding it behind a static call. Expect the most human review per site of any rule here.

A no-argument `Context::getInstance()` is rewritten to `get()` with no argument too, which the registry reads as `core.default_context` -- the same meaning the static call had.

## Synopsis

`final class ContextGetInstanceToRegistryRector extends AbstractContextInjectionRector`

|  |  |
|---|---|
| Extends | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) |
| Since | `4.0.0` |
| Source | `Rector/ContextGetInstanceToRegistryRector.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `autowire()` | `AbstractRector` |  |
| `enterNode()` | `AbstractRector` |  |
| `getNodeTypes()` | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) |  |
| `leaveNode()` | `AbstractRector` |  |
| `refactor()` | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) | Rewrites a class's Context accessor calls into fetches of injected properties. |
