# Lifecycle

> The Quiote\\Event\\Lifecycle namespace — 7 documented types.

Everything under `Quiote\Event\Lifecycle`.

## Classes

| Class | Description |
|---|---|
| [`ActionAfterEvent`](/api/event/lifecycle/action-after-event/) | Emitted by [`ActionExecutor::execute()`](/api/execution/action-executor/#execute) after an action (and its view) have run, carrying the resulting execution context. |
| [`ActionBeforeEvent`](/api/event/lifecycle/action-before-event/) | Emitted by [`ActionExecutor::execute()`](/api/execution/action-executor/#execute) just before an action runs. |
| [`ExceptionCaughtEvent`](/api/event/lifecycle/exception-caught-event/) | Emitted by [`ErrorHandlingMiddleware`](/api/middleware/error-handling-middleware/) whenever it catches an unhandled throwable, before rendering the error response. |
| [`KernelBootEvent`](/api/event/lifecycle/kernel-boot-event/) | Emitted at the end of [`Quiote::bootstrap()`](/api/quiote/#bootstrap), once settings are loaded, plugins registered, and any requested contexts created. |
| [`RequestMatchedEvent`](/api/event/lifecycle/request-matched-event/) | Emitted by [`RoutingMiddleware`](/api/middleware/routing-middleware/) immediately after a request is matched to a module/action, before the matched request is handed to the rest of the pipeline. |
| [`ResponseSendingEvent`](/api/event/lifecycle/response-sending-event/) | Emitted by [`Context::handle()`](/api/context/#handle) once the pipeline has produced a response, just before it is returned to the runtime for emission. |
| [`WorkerRequestCompletedEvent`](/api/event/lifecycle/worker-request-completed-event/) | Emitted once per request from [`Kernel`](/api/runtime/kernel/)'s worker-mode reset step — after [`WorkerManager::resetForNextRequest()`](/api/util/worker-manager/#resetfornextrequest) (if worker mode is active), regardless of whether the request succeeded or the pipeline threw. |
