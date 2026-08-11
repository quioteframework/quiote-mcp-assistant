# RequestParameterStore

> Immutable holder for WebRequest's runtime (internal) parameters and the strict-validation whitelist.

Immutable holder for WebRequest's runtime (internal) parameters and the strict-validation whitelist.

This is the security enforcement core: only parameters whitelisted in $validatedKeys may ever be read back out via WebRequest::getParameter()/hasParameter().

Every mutation returns a new instance. Callers (WebRequest) are expected to replace their own reference with the returned store rather than relying on in-place mutation.

## Synopsis

`final class RequestParameterStore`

|  |  |
|---|---|
| Source | `Request/RequestParameterStore.php` |

## Constructor

### __construct()

`public function __construct(array<array-key, mixed> $runtimeParameters = [], array<array-key, bool> $validatedKeys = []): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$runtimeParameters` | `array``<``array-key``, ``mixed``>` |  |
| `$validatedKeys` | `array``<``array-key``, ``bool``>` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`all(): array<array-key, mixed>`](#all) |  |
| [`get(string $name): mixed`](#get) | Returns the runtime parameter of that exact name, or null when it is not set. |
| [`has(string $name): bool`](#has) | Reports whether a runtime parameter of that exact name is present. |
| [`isWhitelisted(string $name): bool`](#iswhitelisted) | Reports whether the name may be read back out under strict validation. |
| [`keys(): array<int, string>`](#keys) |  |
| [`pruneTo(array<int, string> $keep, array<int, string> $failed, array<array-key, bool> $preserve): self`](#pruneto) | Compute the keep/remove decision set for pruning: a name survives if whitelisted directly, previously declared valid, or explicitly preserved — but an explicit failure always wins. |
| [`withAppendedParameter(string $name, mixed $value): RequestParameterStore`](#withappendedparameter) | Legacy append API mirrors ParameterHolder::appendParameter semantics. |
| [`withCleared(): RequestParameterStore`](#withcleared) | Returns a copy with every runtime parameter dropped. |
| [`withDeclaredParameter(string $name): RequestParameterStore`](#withdeclaredparameter) | Returns a copy with the given name whitelisted for strict-validation access. |
| [`withDeclaredParameters(array<string> $names): RequestParameterStore`](#withdeclaredparameters) | Mark the given request parameter names as declared (whitelisted for strict-validation access). |
| [`withEnforcedValidatedParameters(array<int, string> $keys): RequestParameterStore`](#withenforcedvalidatedparameters) | Define additional validated parameter names (expanding bracket-path variants), merging into the existing whitelist. |
| [`withParameter(string $name, mixed $value): RequestParameterStore`](#withparameter) | Legacy write API: set a runtime parameter (not an attribute, not HTTP input). |
| [`withParameters(array<array-key, mixed> $params): RequestParameterStore`](#withparameters) | Bulk counterpart to withParameter(): apply many runtime parameters in one shot. |
| [`withRemovedParameter(string $name): RequestParameterStore`](#withremovedparameter) | Remove a runtime parameter, including nested-path removal (best-effort). |
| [`withRevokedParameter(string $name): RequestParameterStore`](#withrevokedparameter) | Returns a copy with the parameter removed and its strict-validation whitelist entry revoked. |
| [`withUnvalidatedParameter(string $name, mixed $value): RequestParameterStore`](#withunvalidatedparameter) | Sets a runtime parameter's value WITHOUT whitelisting it, unlike withParameter(). |
| [`withUnvalidatedParameters(array<array-key, mixed> $params): RequestParameterStore`](#withunvalidatedparameters) | Bulk counterpart to withUnvalidatedParameter(): apply many unvalidated runtime parameters in one shot, copying the runtime array once instead of once per key -- used to promote a whole batch of route params into the pipeline (see ValidationMiddleware) without an O(n) clone loop. |

### all()

`public function all(): array<array-key, mixed>`

Returns `array``<``array-key``, ``mixed``>`

### get()

`public function get(string $name): mixed`

Returns the runtime parameter of that exact name, or null when it is not set.

A top-level key lookup only, with no nested bracket-path resolution and no whitelist check; a stored null is indistinguishable from a missing parameter, so pair it with [`RequestParameterStore::has()`](/api/request/request-parameter-store/#has) when that matters.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `mixed`

### has()

`public function has(string $name): bool`

Reports whether a runtime parameter of that exact name is present.

A top-level key check only: nested bracket paths are not resolved, and the whitelist is not consulted, so a caller enforcing strict validation must still ask [`RequestParameterStore::isWhitelisted()`](/api/request/request-parameter-store/#iswhitelisted).

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `bool`

### isWhitelisted()

`public function isWhitelisted(string $name): bool`

Reports whether the name may be read back out under strict validation.

True when the name was declared verbatim, or when its numeric bracket indices normalise onto a declared wildcard form -- so a validator declaring `items[]` also covers `items[0]`, `items[1]` and so on.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `bool`

### keys()

`public function keys(): array<int, string>`

Returns `array``<``int``, ``string``>`

### pruneTo()

`public function pruneTo(array<int, string> $keep, array<int, string> $failed, array<array-key, bool> $preserve): self`

Compute the keep/remove decision set for pruning: a name survives if whitelisted directly, previously declared valid, or explicitly preserved — but an explicit failure always wins.

| Parameter | Type | Description |
|---|---|---|
| `$keep` | `array``<``int``, ``string``>` |  |
| `$failed` | `array``<``int``, ``string``>` |  |
| `$preserve` | `array``<``array-key``, ``bool``>` |  |

Returns `self` — New store with only surviving runtime parameters retained.

### withAppendedParameter()

`public function withAppendedParameter(string $name, mixed $value): RequestParameterStore`

Legacy append API mirrors ParameterHolder::appendParameter semantics.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

Returns [`RequestParameterStore`](/api/request/request-parameter-store/)

### withCleared()

`public function withCleared(): RequestParameterStore`

Returns a copy with every runtime parameter dropped.

The strict-validation whitelist is kept, so names already declared stay readable once they are set again.

Returns [`RequestParameterStore`](/api/request/request-parameter-store/)

### withDeclaredParameter()

`public function withDeclaredParameter(string $name): RequestParameterStore`

Returns a copy with the given name whitelisted for strict-validation access.

An empty name is ignored and this instance is returned unchanged. No runtime value is created; the name merely becomes readable once one is.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns [`RequestParameterStore`](/api/request/request-parameter-store/)

### withDeclaredParameters()

`public function withDeclaredParameters(array<string> $names): RequestParameterStore`

Mark the given request parameter names as declared (whitelisted for strict-validation access).

| Parameter | Type | Description |
|---|---|---|
| `$names` | `array``<``string``>` |  |

Returns [`RequestParameterStore`](/api/request/request-parameter-store/)

### withEnforcedValidatedParameters()

`public function withEnforcedValidatedParameters(array<int, string> $keys): RequestParameterStore`

Define additional validated parameter names (expanding bracket-path variants), merging into the existing whitelist.

| Parameter | Type | Description |
|---|---|---|
| `$keys` | `array``<``int``, ``string``>` |  |

Returns [`RequestParameterStore`](/api/request/request-parameter-store/)

### withParameter()

`public function withParameter(string $name, mixed $value): RequestParameterStore`

Legacy write API: set a runtime parameter (not an attribute, not HTTP input).

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

Returns [`RequestParameterStore`](/api/request/request-parameter-store/)

### withParameters()

`public function withParameters(array<array-key, mixed> $params): RequestParameterStore`

Bulk counterpart to withParameter(): apply many runtime parameters in one shot.

| Parameter | Type | Description |
|---|---|---|
| `$params` | `array``<``array-key``, ``mixed``>` |  |

Returns [`RequestParameterStore`](/api/request/request-parameter-store/)

### withRemovedParameter()

`public function withRemovedParameter(string $name): RequestParameterStore`

Remove a runtime parameter, including nested-path removal (best-effort).

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns [`RequestParameterStore`](/api/request/request-parameter-store/)

### withRevokedParameter()

`public function withRevokedParameter(string $name): RequestParameterStore`

Returns a copy with the parameter removed and its strict-validation whitelist entry revoked.

The counterpart of [`RequestParameterStore::withParameter()`](/api/request/request-parameter-store/#withparameter), which whitelists a name as a side effect of setting it. [`RequestParameterStore::withRemovedParameter()`](/api/request/request-parameter-store/#withremovedparameter) undoes only the value, leaving the name declared and therefore still readable; this undoes both halves, so the name reads as never-declared again.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns [`RequestParameterStore`](/api/request/request-parameter-store/)

### withUnvalidatedParameter()

`public function withUnvalidatedParameter(string $name, mixed $value): RequestParameterStore`

Sets a runtime parameter's value WITHOUT whitelisting it, unlike withParameter().

Used for values that must be visible to validators (e.g. a route param promoted into the pipeline so it can be validated like any other input) but must not become readable via WebRequest::getParameter() unless a real validator actually targets that name -- the value sits in runtimeParameters (so getParameters('parameters')'s pre-filter merge and a validator's getKeysInCurrentBase() can see it), but isWhitelisted() stays false until ValidationManager's own enforceValidatedParameters()/pruneTo() decide it survived real validation.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

Returns [`RequestParameterStore`](/api/request/request-parameter-store/)

### withUnvalidatedParameters()

`public function withUnvalidatedParameters(array<array-key, mixed> $params): RequestParameterStore`

Bulk counterpart to withUnvalidatedParameter(): apply many unvalidated runtime parameters in one shot, copying the runtime array once instead of once per key -- used to promote a whole batch of route params into the pipeline (see ValidationMiddleware) without an O(n) clone loop.

| Parameter | Type | Description |
|---|---|---|
| `$params` | `array``<``array-key``, ``mixed``>` |  |

Returns [`RequestParameterStore`](/api/request/request-parameter-store/)
