# SessionMiddleware

> Bootstrap-phase session wiring for the framework pipeline.

Bootstrap-phase session wiring for the framework pipeline.

Loads or creates this request's session, installs it as the context's [`SessionBagInterface`](/api/session/session-bag-interface/) so every consumer -- the User hierarchy, CSRF token storage, OIDC state, application code -- reaches the same session, persists the user before the session is written, and bakes the Set-Cookie onto the response.

With no `session` factory slot configured there is no session to manage: Context::getSessionBag() keeps answering a NullSessionBag, and this middleware does nothing beyond ensuring an ExecutionState exists. That is the shape a console command, a queue worker or a stateless API runs in.

Distinct from [`SessionMiddleware`](/api/session/session-middleware/), which is the standalone PSR-15 wiring for an application driving SessionManager outside this pipeline. This one additionally owns the ExecutionState guarantee and the request-state flush, both of which are pipeline concerns.

## Synopsis

`class SessionMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/SessionMiddleware.php` |

## Constructor

### __construct()

`public function __construct(Controller $controller): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$controller` | [`Controller`](/api/controller/controller/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Starts the request's session, exposes it to the context, and bakes the cookie onto the response. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Starts the request's session, exposes it to the context, and bakes the cookie onto the response.

Guarantees an ExecutionState attribute on the request first. A request flagged sessionless — by `auth.sessionless`, or by the equivalent `jwt.skip_session`, both honoured — and a context with no SessionManager bound skip session handling entirely: the request passes through and the request-state flush is claimed with `persistUser: false`, so a token-derived identity is never written into whatever unrelated session the client may still carry.

Otherwise the session is started from the request and published as the container's request-scoped SessionBagInterface, so the user hierarchy, CSRF storage and application code all reach the same session. After the downstream handler returns — including when it throws — the request state is flushed so the user is written before the session is persisted; a failing flush is logged at debug and does not stop the response. The returned response is the one produced by persisting the session and baking its Set-Cookie.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
