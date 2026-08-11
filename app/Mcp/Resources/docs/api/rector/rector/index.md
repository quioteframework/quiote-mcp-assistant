# Rector

> The Quiote\\Rector\\Rector namespace — 8 documented types.

Everything under `Quiote\Rector\Rector`.

## Classes

| Class | Description |
|---|---|
| [`AbstractContextInjectionRector`](/api/rector/rector/abstract-context-injection-rector/) | Shared machinery for the rules that replace a Context accessor with an injected collaborator. |
| [`ContextAccessorToConstructorInjectionRector`](/api/rector/rector/context-accessor-to-constructor-injection-rector/) | Process-lifetime Context accessors to injected collaborators. |
| [`ContextGetInstanceToRegistryRector`](/api/rector/rector/context-get-instance-to-registry-rector/) | `Context::getInstance('web')` to an injected `ContextRegistry`. |
| [`ContextGetModelToLocatorRector`](/api/rector/rector/context-get-model-to-locator-rector/) | `$this->getContext()->getModel(…)` to an injected `ModelLocator`. |
| [`ContextRequestToRequestStateRector`](/api/rector/rector/context-request-to-request-state-rector/) | The request half of the plan's rule 3, targeting `RequestState` instead of the `$rd` parameter. |
| [`ContextResidueReporter`](/api/rector/rector/context-residue-reporter/) | Reports the Context call sites the rewriting rules cannot touch, with a reason for each. |
| [`ContextServiceToConstructorInjectionRector`](/api/rector/rector/context-service-to-constructor-injection-rector/) | `$this->getContext()->getService(Foo::class)` to an injected `Foo`. |
| [`ContextUserToConstructorInjectionRector`](/api/rector/rector/context-user-to-constructor-injection-rector/) | `Context::getUser()` to an injected user, or to an injected [`CurrentUser`](/api/user/current-user/) where holding one would be wrong. |
