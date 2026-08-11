# CsrfManager

> Application-facing CSRF helper.

Application-facing CSRF helper.

Wraps symfony/security-csrf's CsrfTokenManager (backed by the session via SessionTokenStorage) and exposes the framework's CSRF configuration (enabled flag, token id, form field / header names, safe HTTP methods). Token values are BREACH-mitigated/randomized per call by the underlying Symfony manager; comparison is constant-time.

## Synopsis

`final readonly class CsrfManager`

|  |  |
|---|---|
| Source | `CsrfManager.php` |

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
| [`cookieName(): string`](#cookiename) | Name of the readable (non-HttpOnly) cookie used to deliver the token to same-origin SPA/JS clients that don't get a server-rendered meta tag. |
| [`fieldName(): string`](#fieldname) | Name of the hidden form field carrying the token in a normal form post. |
| [`getTokenValue(): string`](#gettokenvalue) | Return the current token value, generating and persisting one if needed. |
| [`hasSessionCookie(ServerRequestInterface $request): bool`](#hassessioncookie) | Whether $request carries this application's session cookie -- i.e. |
| [`hasSessionMechanism(): bool`](#hassessionmechanism) | Whether this application has a session mechanism at all. |
| [`headerName(): string`](#headername) | Name of the request header carrying the token for XHR/fetch clients. |
| [`isCrossOriginBrowserRequest(ServerRequestInterface $request): bool`](#iscrossoriginbrowserrequest) | Whether $request was initiated by a browser from some *other* origin. |
| [`isEnabled(): bool`](#isenabled) | Whether CSRF protection is switched on for this application. |
| [`isValid(string $value): bool`](#isvalid) | Validate a submitted token value (constant-time). |
| [`removeToken(): void`](#removetoken) | Discard the current token (e.g. |
| [`safeMethods(): array<string>`](#safemethods) | HTTP methods that are NOT CSRF-checked (safe / idempotent by convention). |
| [`sessionCookieName(): string`](#sessioncookiename) | Name of the cookie that carries the session id for this application. |
| [`tokenId(): string`](#tokenid) | Identifier under which the token is stored and looked up. |
| [`trustedOrigins(): array<string>`](#trustedorigins) | Origins accepted as this application's own, beyond the request's own host. |

### cookieName()

`public function cookieName(): string`

Name of the readable (non-HttpOnly) cookie used to deliver the token to same-origin SPA/JS clients that don't get a server-rendered meta tag.

Returns `string`

### fieldName()

`public function fieldName(): string`

Name of the hidden form field carrying the token in a normal form post.

Read from `core.csrf.field_name`, defaulting to `_csrf_token`.

Returns `string`

### getTokenValue()

`public function getTokenValue(): string`

Return the current token value, generating and persisting one if needed.

Returns `string`

### hasSessionCookie()

`public function hasSessionCookie(ServerRequestInterface $request): bool`

Whether $request carries this application's session cookie -- i.e.

whether there is an ambient, automatically-attached credential for a cross-site attacker to ride. Both the validation and the token-delivery middleware key off this, so they must agree on the answer.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns `bool`

### hasSessionMechanism()

`public function hasSessionMechanism(): bool`

Whether this application has a session mechanism at all.

When it does not, every request looks sessionless to [`CsrfManager::hasSessionCookie()`](/api/security/csrf/csrf-manager/#hassessioncookie) and CSRF validation exempts all of them -- which is correct on its own terms (no ambient credential exists) but is a misconfiguration worth surfacing when CSRF is otherwise enabled.

Returns `bool`

### headerName()

`public function headerName(): string`

Name of the request header carrying the token for XHR/fetch clients.

Read from `core.csrf.header_name`, defaulting to `X-CSRF-Token`.

Returns `string`

### isCrossOriginBrowserRequest()

`public function isCrossOriginBrowserRequest(ServerRequestInterface $request): bool`

Whether $request was initiated by a browser from some *other* origin.

This is what distinguishes the two callers that both arrive without a session cookie: a legitimate first-time visitor posting a login form from this application's own page, and an attacker's page posting the same form cross-site. Both lack the ambient credential the token check keys off, so only the origin tells them apart.

An absent `Origin` means "not a browser" -- curl, a server-to-server caller, an SDK -- and returns false. That is not a loophole an attacker can take: the header is attached by the browser and is not settable from page script, so a cross-site request cannot suppress it. A literal `null` origin (sandboxed iframe, opaque origin) is the opposite case and counts as foreign.

The comparison is host-only, deliberately, and not scheme+host+port. This runs behind TLS-terminating proxies where the request's own scheme is `http` and its port is an internal one, while the browser's `Origin` says `https` on 443; comparing those would reject legitimate same-site requests on every such deployment. What that concedes is an attacker who already controls another port or the plaintext scheme on this very hostname -- a position from which the session cookie is reachable regardless, so the token check was never what stood in the way.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns `bool`

### isEnabled()

`public function isEnabled(): bool`

Whether CSRF protection is switched on for this application.

Read from `core.csrf.enabled`, defaulting to true, so protection is opt-out rather than opt-in.

Returns `bool`

### isValid()

`public function isValid(string $value): bool`

Validate a submitted token value (constant-time).

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string` |  |

Returns `bool`

### removeToken()

`public function removeToken(): void`

Discard the current token (e.g.

on logout / full session reset).

### safeMethods()

`public function safeMethods(): array<string>`

HTTP methods that are NOT CSRF-checked (safe / idempotent by convention).

Returns `array``<``string``>` — Upper-cased method names.

### sessionCookieName()

`public function sessionCookieName(): string`

Name of the cookie that carries the session id for this application.

Resolved from the configured [`SessionManager`](/api/session/session-manager/) (whose `cookie_name` defaults to `QSID`), NOT from ext/session's session_name(): the modern session mechanism never touches ext/session, so session_name() answers `PHPSESSID` — a cookie Quiote never sets. Falling back to session_name() is still right when no session factory slot is configured, because that is the legacy `storage`/native-`$_SESSION` path where ext/session genuinely owns the cookie.

Returns `string`

### tokenId()

`public function tokenId(): string`

Identifier under which the token is stored and looked up.

Read from `core.csrf.token_id`, defaulting to `quiote_csrf`. It is the key the whole application shares, so token generation and validation agree on the same value.

Returns `string`

### trustedOrigins()

`public function trustedOrigins(): array<string>`

Origins accepted as this application's own, beyond the request's own host.

Only needed where the host a browser used and the host this process sees genuinely differ -- a proxy that rewrites `Host`, or a deliberately split-origin deployment. Each entry is compared whole (`https://app.example.com`), not by suffix, so a value here cannot widen into sibling hosts the way a bare-domain match would.

Returns `array``<``string``>`
