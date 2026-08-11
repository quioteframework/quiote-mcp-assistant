# Execution

> The Quiote\\Execution namespace — 33 documented types.

Everything under `Quiote\Execution`.

## Classes

| Class | Description |
|---|---|
| [`ActionCacheHelper`](/api/execution/action-cache-helper/) | Static helpers for the action/view cache round trip used by DispatchMiddleware. |
| [`ActionDescriptor`](/api/execution/action-descriptor/) | Immutable value object describing which action to execute. |
| [`ActionExecutionContext`](/api/execution/action-execution-context/) | Lightweight DTO for container-less slot execution path. |
| [`ActionExecutor`](/api/execution/action-executor/) | ActionExecutor: container-less execution of an action+view producing ActionExecutionContext. |
| [`ActionResolver`](/api/execution/action-resolver/) | Resolves which execute* method to call and invokes action, returning raw view token. |
| [`AttributeBag`](/api/execution/attribute-bag/) | Simple immutable-style attribute bag for no-container execution path. |
| [`DeferredSlotRenderable`](/api/execution/deferred-slot-renderable/) | A slot whose action is not dispatched until its content is actually asked for. |
| [`ExecutionState`](/api/execution/execution-state/) | Mutable per-execution state for one action execution. |
| [`ForwardService`](/api/execution/forward-service/) | ForwardService: resolves forward targets (login / secure / custom) without creating a full execution container. |
| [`HttpMethodMapper`](/api/execution/http-method-mapper/) | Central mapping from HTTP verbs to Quiote action method tokens. |
| [`ImmutableViewInitContext`](/api/execution/immutable-view-init-context/) | The [`ViewInitContext`](/api/execution/view-init-context/) a view is initialized with: a fixed snapshot of the dispatch that produced it. |
| [`LightweightActionInitContext`](/api/execution/lightweight-action-init-context/) | The [`ActionInitContext`](/api/execution/action-init-context/) every dispatch path constructs: the executor, the dispatch, security and validation middleware, the slot dispatcher and the input-schema resolver. |
| [`ResponseHandle`](/api/execution/response-handle/) | Minimal façade exposing response operations in no-container execution paths. |
| [`SecurityService`](/api/execution/security-service/) | Lightweight security checker mapping Action security methods to a decision enum. |
| [`SlotContent`](/api/execution/slot-content/) | Immutable value object representing rendered slot content plus metadata. |
| [`SlotDispatcher`](/api/execution/slot-dispatcher/) | Dynamic optional action extension points used via method_exists(): |
| [`SlotExecutionContext`](/api/execution/slot-execution-context/) | Immutable context returned by SlotDispatcher for container-less execution. |
| [`SlotExecutionGuard`](/api/execution/slot-execution-guard/) | SlotExecutionGuard centralizes recursion limit enforcement for slot dispatches. |
| [`SlotRequestFactory`](/api/execution/slot-request-factory/) | Factory to derive a child PSR-7 request for slot (sub-action) execution. |
| [`SlotStack`](/api/execution/slot-stack/) | Stack tracking nested slot/sub-action executions, so recursion depth is explicit and boundable rather than implicit in the call stack. |
| [`ValidationDecision`](/api/execution/validation-decision/) | Immutable value object encapsulating the validation outcome for a request/action. |
| [`ValidationResult`](/api/execution/validation-result/) | Lightweight immutable validation result for container-less execution paths. |
| [`ValidationService`](/api/execution/validation-service/) | Adapter around legacy validation logic to enable container-less execution. |
| [`ValidationTrace`](/api/execution/validation-trace/) | Tiny immutable description of what we validated (for debugging/parity tests). |
| [`ViewFactory`](/api/execution/view-factory/) | ViewFactory: creates and initializes a view using ImmutableViewInitContext. |
| [`ViewNameResolver`](/api/execution/view-name-resolver/) | ViewNameResolver: pure resolution of raw view return values to (module, canonicalViewName\|NONE). |

## Interfaces

| Interface | Description |
|---|---|
| [`ActionInitContext`](/api/execution/action-init-context/) | What an action is handed by `Action::initialize()`: the identity of the dispatch it is running under, the request and response it works with, and the slot for the view it wants rendered. |
| [`OutputTypeNameProvider`](/api/execution/output-type-name-provider/) | Minimal contract for the legacy-style output type proxy returned by ImmutableViewInitContext::getOutputType(). |
| [`SlotRenderable`](/api/execution/slot-renderable/) | Marker interface for renderable slot results. |
| [`ViewInitContext`](/api/execution/view-init-context/) | ViewInitContext: minimal, presentation-focused initialization contract for views. |

## Enums

| Enum | Description |
|---|---|
| [`SecurityDecision`](/api/execution/security-decision/) | The outcome of the security check for an action: run it, or forward somewhere else. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Slot`](/api/execution/slot/) | 2 types |
