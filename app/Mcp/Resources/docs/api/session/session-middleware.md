# SessionMiddleware

> Opt-in PSR-15 middleware wiring SessionManager into the request lifecycle: loads/creates the session before the handler runs and attaches it to the request as an attribute keyed by self::class, then persists + bakes the Set-Cookie header onto the response afterwards.

Opt-in PSR-15 middleware wiring SessionManager into the request lifecycle: loads/creates the session before the handler runs and attaches it to the request as an attribute keyed by self::class, then persists + bakes the Set-Cookie header onto the response afterwards.

This is a self-contained alternative to hand-rolling session handling: register it via MiddlewareCatalog::register(SessionMiddleware::class, fn() => new SessionMiddleware($sessionManager)) instead of reimplementing cookie/regenerate logic per-app.

Downstream code reads/mutates the session via: $session = $request->getAttribute(SessionMiddleware::class); $session->set('user_id', $id);

Session is a mutable object (not a plain array) specifically so this works: PSR-7 requests fork on every withAttribute() call further down the pipeline, but the Session instance itself is shared, so mutations made deep in a handler are still visible here once control returns.

## Synopsis

`class SessionMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Session/SessionMiddleware.php` |

## Constructor

### __construct()

`public function __construct(SessionManager $sessionManager, ?Context $context = null): mixed`

When given, this request's session is
       also installed as the context's [`SessionBagInterface`](/api/session/session-bag-interface/), so the
       framework's own consumers -- the User hierarchy, CSRF token
       storage, OIDC state -- run against this session instead of the
       legacy `storage` slot. Without it the two remain independent, and
       an application gets two sessions and two cookies.

| Parameter | Type | Description |
|---|---|---|
| `$sessionManager` | [`SessionManager`](/api/session/session-manager/) |  |
| `$context` | `?`[`Context`](/api/context/) | When given, this request's session is also installed as the context's [`SessionBagInterface`](/api/session/session-bag-interface/), so the framework's own consumers -- the User hierarchy, CSRF token storage, OIDC state -- run against this session instead of the legacy `storage` slot. Without it the two remain independent, and an application gets two sessions and two cookies. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Loads or creates the session, runs the handler, then persists it and adds the Set-Cookie header to the response. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Loads or creates the session, runs the handler, then persists it and adds the Set-Cookie header to the response.

The session is attached to the request as an attribute keyed by this class's name, and — when a context was given — also bound into the container as the request-scoped [`SessionBagInterface`](/api/session/session-bag-interface/), so the framework's own session consumers share this session. Request state is flushed in a `finally`, so a user's roles and credentials are written before the session is serialized even when the handler throws; the exception itself is not caught and propagates without a cookie being baked.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
