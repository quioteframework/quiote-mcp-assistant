# ContextUserToConstructorInjectionRector

> `Context::getUser()` to an injected user, or to an injected CurrentUser where holding one would be wrong.

`Context::getUser()` to an injected user, or to an injected [`CurrentUser`](/api/user/current-user/) where holding one would be wrong.

```php // before, in an action, view or validator $this->getContext()->getUser()->getCompany(); // after $this->user->getCompany();

// before, in a service $this->getContext()->getUser()->getCompany(); // after $this->currentUser->get()->getCompany(); ```

## Why two targets and not one

The user is stable within a request -- it is replaced only at the worker request boundary and by the pre-request deferral, never mid-request -- so an object that lives for exactly one execution can hold it. Actions, views and validators are built per execution, so for them the direct injection is both correct and the better read at the call site.

A service cannot, and the reason is not its own scope but its *holder's*. A singleton that holds the user serves request 1's identity to every later request in a persistent worker. The container refuses that wiring outright -- `User` is bound at request scope, so the captive-dependency guard sees it -- which means a rule that injected `User` into a singleton service would produce code that throws at wiring time rather than code that leaks. But a *transient* service is no safer in practice: nothing stops a singleton from holding one, and the guard cannot see through that indirection to the user captured inside it.

So every `Service` subclass gets [`CurrentUser`](/api/user/current-user/), whatever scope it declares. That is what `CurrentUser` exists for, it resolves through to the context on every call and memoizes nothing, and it is correct at every scope -- which is why this rule does not read `#[Service(scope: ...)]` at all. The plan expected that analysis to be a prerequisite and expected service subclasses to land in the residue report; choosing a per-call resolver for them removes both.

## Why `User` and not `SecurityUser` or `ISecurityUser`

`Context::getUser()` answers `User|ISecurityUser`, and a union cannot be a constructor type hint. `User` is the one type every user is, and [`Context::SEAM_CONTRACTS`](/api/context/#seamcontracts) binds it to the request's real instance -- so the type hint resolves to the application's own subclass rather than to a fresh empty stranger. An application reaching its own subclass's methods narrows the hint by hand afterwards; a wider-than-needed hint is a static-analysis note, while a narrower one would be a wrong binding.

## Synopsis

`final class ContextUserToConstructorInjectionRector extends AbstractContextInjectionRector`

|  |  |
|---|---|
| Extends | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) |
| Since | `4.0.0` |
| Source | `Rector/ContextUserToConstructorInjectionRector.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `autowire()` | `AbstractRector` |  |
| `enterNode()` | `AbstractRector` |  |
| `getNodeTypes()` | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) |  |
| `leaveNode()` | `AbstractRector` |  |
| `refactor()` | [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) | Rewrites a class's Context accessor calls into fetches of injected properties. |
