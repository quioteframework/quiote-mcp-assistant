# CsrfInjectionMiddleware

> Delivers the CSRF token to clients so they can echo it back on unsafe requests.

Delivers the CSRF token to clients so they can echo it back on unsafe requests.

Two delivery channels, applied on the outgoing response: 1. Server-rendered HTML — for each `<form>` whose method is not GET (and that doesn't already carry the token field or opt out with `data-csrf="off"`), a hidden `<input name="<field>" ...>` is inserted after the opening tag, plus a `<meta name="csrf-token">` in `<head>`. 2. A readable (non-HttpOnly) `XSRF-TOKEN` cookie — for any request that carries a session cookie, regardless of content type. This is how a same-origin SPA served from a *different* service/pod (which never sees our rendered HTML or meta tag) obtains the token: it reads the cookie from document.cookie and sends it back in the configured header (default X-CSRF-Token) on POST/PUT/PATCH/DELETE. The cookie is Secure on HTTPS and SameSite=Lax, and deliberately NOT HttpOnly so JS can read it — which is safe because a cross-origin attacker cannot read our cookies and the SameSite policy keeps them off cross-site requests. Ordered ahead of CsrfValidationMiddleware (priority 45 against its 40, and priority sorts descending) so it sits outside it and decorates the response on the way back out -- which is what lets even a 403 from that middleware carry a fresh token cookie for the client to retry with. Operates on the serialized HTML independently of the Form Population filter (which only runs when there is data to repopulate), so fresh forms get a token too.

## Synopsis

`class CsrfInjectionMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/CsrfInjectionMiddleware.php` |

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
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Delivers the CSRF token on the outgoing response. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Delivers the CSRF token on the outgoing response.

Runs the rest of the pipeline first, then decorates what comes back, so even a 403 from the validation middleware carries a fresh token. The readable token cookie is added whenever the request carried a session cookie, regardless of content type; the hidden form field and `<head>` meta tag are added only to a response that declares itself `text/html` or `application/xhtml+xml` and actually contains a form. The response is returned untouched when CSRF is disabled or neither channel applies, so a non-HTML body is never rewritten.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
