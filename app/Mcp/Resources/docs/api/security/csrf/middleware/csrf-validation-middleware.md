# CsrfValidationMiddleware

> Verifies a CSRF token on every unsafe (state-changing) request before the action is dispatched.

Verifies a CSRF token on every unsafe (state-changing) request before the action is dispatched.

Safe methods (GET/HEAD/OPTIONS/TRACE) pass through. The token is read from the configured form field (parsed body) or the configured header (for XHR/fetch clients) and validated against the session-stored token via [`CsrfManager`](/api/security/csrf/csrf-manager/). On failure the request is short-circuited with HTTP 403 and the action never runs. CSRF exists to stop an attacker site from riding a victim's ambient, automatically-attached session cookie. Two classes of request fall outside that threat model and are exempted automatically, without needing a per-route opt-out: - Requests an authenticator already resolved from a caller-supplied credential (JWT, API key, OAuth2 bearer token), signalled by the `auth.stateless`/`auth.sessionless` request attributes. Such a caller's identity does not come from an ambient cookie, so it is not forgeable cross-site. Note this is deliberately NOT "an Authorization header is *     present": that header can be attached alongside a session cookie, so presence alone proved nothing and made the exemption a bypass. - Requests with no session cookie at all AND no foreign `Origin`. With no ambient session-backed credential present there is nothing for an attacker to ride, but that is only true of the request itself -- a login POST also arrives without a session, and exempting it on that basis made login CSRF work. So the sessionless exemption additionally requires that the request is not a browser request from another origin; see [`CsrfManager::isCrossOriginBrowserRequest()`](/api/security/csrf/csrf-manager/#iscrossoriginbrowserrequest). Non-browser callers send no `Origin` and stay exempt. The cookie name comes from the configured SessionManager via [`CsrfManager::hasSessionCookie()`](/api/security/csrf/csrf-manager/#hassessioncookie), never from ext/session's session_name() -- the modern session mechanism does not use ext/session, so session_name() named a cookie Quiote never sets and this exemption matched every request. Routes that still need protecting despite one of the above (rare) can force the check by adding an `_csrf => true` default; routes that need to opt out for any other reason can add `_csrf => false`. Runs after PayloadParsingMiddleware (so the body is parsed) and RoutingMiddleware (so route opt-out is known), before DispatchMiddleware.

## Synopsis

`class CsrfValidationMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/CsrfValidationMiddleware.php` |

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
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Validates the CSRF token on an unsafe request, or rejects it with 403. |
| [`resetWarnings(): void`](#resetwarnings) | Test isolation: re-arm the once-per-process missing-session warning. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Validates the CSRF token on an unsafe request, or rejects it with 403.

The request is passed through unchecked when CSRF is disabled, when the method is one of the configured safe methods, when the matched route carries an `_csrf => false` default, or when it falls outside the threat model (statelessly authenticated, or sessionless and not a cross-origin browser request). A route default of `_csrf => true` forces the check regardless of those exemptions. The token is taken from the configured form field or header; a missing or invalid one short-circuits the pipeline with a 403 carrying `X-Quiote-Csrf: failed`, so the action never runs.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### resetWarnings()

`public static function resetWarnings(): void`

Test isolation: re-arm the once-per-process missing-session warning.
