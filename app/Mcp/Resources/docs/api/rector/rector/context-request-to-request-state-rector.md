# ContextRequestToRequestStateRector

> The request half of the plan's rule 3, targeting `RequestState` instead of the `$rd` parameter.

The request half of the plan's rule 3, targeting `RequestState` instead of the `$rd` parameter.

```php // before $id = $this->getContext()->getRequest()->getParameter('id'); $this->getContext()->setRequest($replacement); // after $id = $this->requestState->current()->getParameter('id'); $this->requestState->publish($replacement); ```

## Why not the `$rd` parameter the method already has

That was the plan's approach, and it is a validation bypass. A parameter holds the request as it was at method *entry*; `WebRequest` is immutable, so anything that mutates it publishes a replacement, and from that point the parameter is stale while the context is authoritative. `Quiote\Execution\ValidationService` re-reads from the context precisely because `pruneParametersToValidated()` has republished, and its `validate*()` must see the post-prune request. Substituting the parameter there feeds it un-pruned parameters.

`RequestState::current()` resolves per call, so it preserves `Context::getRequest()`'s semantics exactly. It is also the only form that is safe in every hierarchy: it holds nothing, so a singleton-scoped `Service` may inject it where injecting a `WebRequest` would be refused.

## The carve-out

A chain whose result is discarded is never rewritten:

```php $this->getContext()->getRequest()->setAttribute('populate', [...]);   // left alone ```

Every `WebRequest` mutator returns a new instance, so that statement already does nothing. Rewriting it to `$this->requestState->current()->setAttribute(...)` would be identically broken but look deliberate, in freshly reviewed code. Those sites need `FormPopulationConfig` and a `publish()` -- a change of meaning, so they belong to a human and to the residue reporter.

## Synopsis

`final class ContextRequestToRequestStateRector extends AbstractContextInjectionRector`

|  |  |
|---|---|
| Extends | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) |
| Since | `4.0.0` |
| Source | `Rector/ContextRequestToRequestStateRector.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `autowire()` | `AbstractRector` |  |
| `enterNode()` | `AbstractRector` |  |
| `getNodeTypes()` | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) |  |
| `leaveNode()` | `AbstractRector` |  |
| `refactor()` | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) | Rewrites a class's Context accessor calls into fetches of injected properties. |
