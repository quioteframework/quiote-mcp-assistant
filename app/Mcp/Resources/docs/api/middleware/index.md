# Middleware

> The Quiote\\Middleware namespace — 29 documented types.

Everything under `Quiote\Middleware`.

## Classes

| Class | Description |
|---|---|
| [`AssetAggregationMiddleware`](/api/middleware/asset-aggregation-middleware/) | Collects legacy appended attributes like 'css' and 'js' from the Request (when using adapter) and exposes them as PSR request attributes `assets.css` and `assets.js`. |
| [`ContentNegotiationMiddleware`](/api/middleware/content-negotiation-middleware/) | Minimal wrapper over middlewares/content-type. |
| [`CoreMiddlewareRegistry`](/api/middleware/core-middleware-registry/) | The single declaration of the middleware the framework ships. |
| [`DispatchMiddleware`](/api/middleware/dispatch-middleware/) | DispatchMiddleware runs the requested action. |
| [`ErrorHandlingMiddleware`](/api/middleware/error-handling-middleware/) | Catches unhandled throwables from downstream middleware/action dispatch and produces a generic 500 (or mapped) response. |
| [`ExecutionTimeMiddleware`](/api/middleware/execution-time-middleware/) | Basic execution timing middleware replacing ExecutionTimeFilter. |
| [`FinalizeMiddleware`](/api/middleware/finalize-middleware/) | FinalizeMiddleware (scaffold): end-of-request persistence for session/user. |
| [`FormPopulationMiddleware`](/api/middleware/form-population-middleware/) | Applies the modernized form population engine to PSR-7 responses so container-less requests still receive automatic form value and error message population. |
| [`MiddlewareCatalog`](/api/middleware/middleware-catalog/) | MiddlewareCatalog stores enable/disable flags for middleware FQCNs, settable programmatically via [`MiddlewareCatalog::initialize()`](/api/middleware/middleware-catalog/#initialize) (tests, app bootstrap code), so the runtime pipeline builder can cheaply skip optional middlewares. |
| [`MiddlewarePipeline`](/api/middleware/middleware-pipeline/) | MiddlewarePipeline builds and caches the PSR-15 middleware chain; safe for worker reuse. |
| [`OutputTypeSyncMiddleware`](/api/middleware/output-type-sync-middleware/) | Synchronizes the Controller's current output type with the PSR request attribute 'output_type' after routing has resolved (and potentially overridden) it. |
| [`PayloadParsingMiddleware`](/api/middleware/payload-parsing-middleware/) | Unified body parsing leveraging middlewares/payload. |
| [`RoutingMiddleware`](/api/middleware/routing-middleware/) | Executes Quiote routing and attaches module/action/outputType to PSR request attributes. |
| [`SecurityMiddleware`](/api/middleware/security-middleware/) | Security middleware: evaluates action security requirements and forwards unauthenticated/unauthorized requests to login/secure system actions. |
| [`SessionMiddleware`](/api/middleware/session-middleware/) | Bootstrap-phase session wiring for the framework pipeline. |
| [`SlotMiddleware`](/api/middleware/slot-middleware/) | SlotMiddleware: establishes a SlotStack in request attributes for nested slot/sub-action rendering. |
| [`StealthMiddleware`](/api/middleware/stealth-middleware/) | Strips framework-identifying response headers when `core.stealth_mode` is enabled: any `X-Quiote-*` header, plus the names listed in `core.stealth_additional_headers` (covers `X-Powered-By`, which doesn't follow that prefix). |
| [`TelemetryMiddleware`](/api/middleware/telemetry-middleware/) | Opens the root OpenTelemetry span for the request and records the headline resource measurements — wall time, CPU, memory — as both span attributes and OTel metrics. |
| [`TimingMiddleware`](/api/middleware/timing-middleware/) | Records timing spans for downstream middleware execution. |
| [`TraceMiddleware`](/api/middleware/trace-middleware/) | Captures names of executed middleware for debugging. |
| [`ValidationMiddleware`](/api/middleware/validation-middleware/) | Runs validation before the action executes, and enforces that only validated parameters are reachable afterwards. |

## Traits

| Trait | Description |
|---|---|
| [`RequestDiagnostics`](/api/middleware/request-diagnostics/) | Session and authentication state for a middleware's debug lines. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Attribute`](/api/middleware/attribute/) | 1 type |
| [`Compiler`](/api/middleware/compiler/) | 5 types |
| [`Config`](/api/middleware/config/) | 1 type |
