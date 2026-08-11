# SecurityHeadersMiddleware

> Adds standard hardening response headers (CSP, X-Content-Type-Options, X-Frame-Options, Referrer-Policy, Permissions-Policy, HSTS).

Adds standard hardening response headers (CSP, X-Content-Type-Options, X-Frame-Options, Referrer-Policy, Permissions-Policy, HSTS).

Only sets a header when the response doesn't already carry one, so an action can still override any of these on a per-route basis. HSTS is only added for https requests — sending it over plain http is meaningless and, if the request is deployed for local http development, actively unhelpful.

Placement matters and is not negotiable: DispatchMiddleware is the terminal middleware — it never calls `$handler->handle()` and builds its response from the rendered view instead — so any middleware ordered after it decorates a response nobody returns. This sits at the very outside of the pipeline, one step further out than ErrorHandlingMiddleware, so the headers also land on error and 404 responses that ErrorHandlingMiddleware renders in place of the action's.

## Synopsis

`class SecurityHeadersMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `SecurityHeadersMiddleware.php` |

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Adds the hardening headers to the response on the way back out. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Adds the hardening headers to the response on the way back out.

Runs the rest of the pipeline first, then sets each configured header only if the response does not already carry it, so an action's own choice always wins. Returns the response untouched when `security_headers.enabled` is off. `Permissions-Policy` is only sent when configured to a non-empty value, and HSTS only when enabled and the request arrived over HTTPS.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
