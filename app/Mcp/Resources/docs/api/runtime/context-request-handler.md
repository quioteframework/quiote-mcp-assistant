# ContextRequestHandler

> Turns a PSR-7 request into a response for one context.

Turns a PSR-7 request into a response for one context.

This is the per-request work that used to sit on [`Context`](/api/context/): owning the middleware pipeline, resolving the request's correlation id, opening the ambient logging scope, arming the request-state flush, and emitting the last event that sees request and response together. None of it is about being a context -- it is about serving a request against one -- and a context that also handles requests is a context that cannot be asked "which profile am I" without also carrying a middleware pipeline.

Implements `RequestHandlerInterface` rather than merely resembling it, which [`Context::handle()`](/api/context/#handle) always did without declaring it.

The pipeline is per handler, and therefore per context: a named context profile has its own middleware stack. It survives across requests within that context's lifetime, which is safe because the pipeline itself holds no request state.

## Synopsis

`final class ContextRequestHandler implements RequestHandlerInterface`

|  |  |
|---|---|
| Implements | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |
| Since | `4.0.0` |
| Source | `Runtime/ContextRequestHandler.php` |

## Constructor

### __construct()

`public function __construct(Context $context): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`correlationId(): ?string`](#correlationid) | This request's correlation id, or null outside a handled request. |
| [`forgetPipeline(): void`](#forgetpipeline) | Discard the built pipeline so the next request builds a fresh one. |
| [`handle(ServerRequestInterface $request): ResponseInterface`](#handle) | Serves one request against this handler's context. |
| [`hasPipeline(): bool`](#haspipeline) | Whether the pipeline has been built yet. |
| [`pipeline(): MiddlewarePipeline`](#pipeline) | The middleware pipeline for this context, built on first use. |

### correlationId()

`public function correlationId(): ?string`

This request's correlation id, or null outside a handled request.

Returns `?``string`

### forgetPipeline()

`public function forgetPipeline(): void`

Discard the built pipeline so the next request builds a fresh one.

The pipeline is composed from [`MiddlewareCatalog`](/api/middleware/middleware-catalog/) the first time it is needed and then reused for the context's lifetime, which is the right trade for a worker but means a later change to the catalog would otherwise never be seen. Anything that reconfigures the catalog after a request has been served -- a test replacing the core stack, a host reconfiguring middleware between runs -- has to call this.

### handle()

`public function handle(ServerRequestInterface $request): ResponseInterface`

Serves one request against this handler's context.

Opens the request scope (correlation id, ambient logging scope, request-state flush), builds the [`WebRequest`](/api/request/web-request/) eagerly, exposes the correlation id on the request as the `quiote.rid` attribute and on the response as the configured header, and runs the middleware pipeline. [`ResponseSendingEvent`](/api/event/lifecycle/response-sending-event/) is emitted last, with both request and response in hand.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### hasPipeline()

`public function hasPipeline(): bool`

Whether the pipeline has been built yet.

Answers without building one, unlike [`ContextRequestHandler::pipeline()`](/api/runtime/context-request-handler/#pipeline).

Returns `bool`

### pipeline()

`public function pipeline(): MiddlewarePipeline`

The middleware pipeline for this context, built on first use.

Returns [`MiddlewarePipeline`](/api/middleware/middleware-pipeline/)
