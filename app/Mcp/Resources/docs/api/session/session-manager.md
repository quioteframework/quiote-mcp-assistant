# SessionManager

> Opinionated, PSR-7-based session handling: a cookie carrying a session id, and a pluggable SessionPersistenceInterface backend for the data.

Opinionated, PSR-7-based session handling: a cookie carrying a session id, and a pluggable SessionPersistenceInterface backend for the data.

Deliberately does NOT use PHP's native $_SESSION/session_start()/session_regenerate_id() — those assume a single global session per process, which doesn't compose well with PSR-7 request/response objects or long-running worker runtimes (FrankenPHP, RoadRunner, etc).

Session id regeneration (regenerate()) is safe against the classic race where a request already in flight with the pre-regeneration cookie arrives after the old id has been migrated away from: instead of deleting/blanking the old id immediately, it's redirected to the new one for a short grace window (see migrateOld()). Without this, that in-flight request finds a missing/blanked session and silently starts a new anonymous one, which — if its response reaches the browser after the regenerating response's Set-Cookie — makes the user appear logged out right after logging in.

Server-side expiry is available via `session_idle_timeout` and `session_absolute_timeout` (both seconds, both 0/off by default; see [`SessionManager::hasExpired()`](/api/session/session-manager/#hasexpired)). The cookie's own Max-Age cannot stand in for these -- it is a hint to the browser, and an attacker replaying a captured id ignores it -- so without one of them set a stolen session id stays valid for as long as the record survives in storage.

Usage: construct one instance per app (it's stateless aside from config), call startFromRequest() at the top of a request to get a Session, mutate it via set()/remove(), call regenerate() on privilege transitions (e.g. login) to defeat session fixation, and persistAndBakeCookies() at the end of the request to save (if dirty) and emit the Set-Cookie header. See SessionMiddleware for a ready-made PSR-15 wiring of this lifecycle.

## Synopsis

`class SessionManager`

|  |  |
|---|---|
| Source | `Session/SessionManager.php` |

## Constructor

### __construct()

`public function __construct(SessionPersistenceInterface $persistence, array<string, mixed> $parameters = []): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$persistence` | [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(string $sid): void`](#delete) | Removes a session record from storage by id. |
| [`destroy(Session $session): void`](#destroy) | Deletes the session from storage and rebinds the handle to a fresh, empty id. |
| [`getCookieName(): string`](#getcookiename) | The name of the cookie this manager reads the session id from and bakes it back onto the response as (`cookie_name`, default `QSID`). |
| [`migrateOld(string $old, string $new, ?ServerRequestInterface $request = null): void`](#migrateold) | Replace an old session id's data with a redirect marker to the new one, valid for session_migration_grace_seconds. |
| [`persist(Session $session): void`](#persist) | Persist session data immediately without touching cookie headers. |
| [`persistAndBakeCookies(Session $session, ResponseInterface $response): ResponseInterface`](#persistandbakecookies) | Writes a dirty session to storage and returns the response with the session cookie added. |
| [`regenerate(Session $session, bool $deleteOld = false, ?ServerRequestInterface $request = null, bool $privilegeTransition = false): void`](#regenerate) | Regenerate the session id, preserving the session's data. |
| [`startFromRequest(ServerRequestInterface $request): Session`](#startfromrequest) | Resolves the request's session cookie into a [`Session`](/api/session/session/), or creates a fresh one. |

### delete()

`public function delete(string $sid): void`

Removes a session record from storage by id.

Takes a bare id rather than a [`Session`](/api/session/session/), for callers that only hold one — an administrative "sign this user out everywhere". An empty id is ignored, so no backend call is made for a session that was never persisted.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

### destroy()

`public function destroy(Session $session): void`

Deletes the session from storage and rebinds the handle to a fresh, empty id.

Used at logout: the pre-logout id is removed outright with no grace window, so it is neither replayable nor inheritable. The passed [`Session`](/api/session/session/) stays usable — it keeps the new id, empty data and a dirty flag, so anything written afterwards is persisted under the new id.

| Parameter | Type | Description |
|---|---|---|
| `$session` | [`Session`](/api/session/session/) |  |

### getCookieName()

`public function getCookieName(): string`

The name of the cookie this manager reads the session id from and bakes it back onto the response as (`cookie_name`, default `QSID`).

Exposed because consumers have to be able to ask "does this request carry * a session?" against the name actually in use. Reaching for ext/session's session_name() instead is wrong here: this class deliberately does not use ext/session at all (see the class docblock), so session_name() answers with an unrelated default -- which is exactly how CSRF validation came to exempt every request.

Returns `string`

### migrateOld()

`public function migrateOld(string $old, string $new, ?ServerRequestInterface $request = null): void`

Replace an old session id's data with a redirect marker to the new one, valid for session_migration_grace_seconds.

A request that arrives with the old cookie within that window transparently resolves to the new session instead of finding a blanked/deleted row and silently starting a new anonymous one. After the window elapses the old id stops resolving to anything — which is what actually defeats a fixation attempt.

| Parameter | Type | Description |
|---|---|---|
| `$old` | `string` |  |
| `$new` | `string` |  |
| `$request` | `?`[`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

### persist()

`public function persist(Session $session): void`

Persist session data immediately without touching cookie headers.

Useful for critical mutations (e.g. right before a privilege transition) to minimize the data-loss window on an abrupt shutdown.

| Parameter | Type | Description |
|---|---|---|
| `$session` | [`Session`](/api/session/session/) |  |

### persistAndBakeCookies()

`public function persistAndBakeCookies(Session $session, ResponseInterface $response): ResponseInterface`

Writes a dirty session to storage and returns the response with the session cookie added.

The write only happens when the session is dirty, and the timeout timestamps are stamped on just before it. The Set-Cookie is added when the session is dirty or was loaded from storage — an untouched brand-new session gets neither a row nor a cookie, while an existing one has its cookie refreshed on every response for sliding expiration.

The session's dirty flag is left as it was; call [`SessionManager::persist()`](/api/session/session-manager/#persist) instead when the write must also clear it.

| Parameter | Type | Description |
|---|---|---|
| `$session` | [`Session`](/api/session/session/) |  |
| `$response` | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### regenerate()

`public function regenerate(Session $session, bool $deleteOld = false, ?ServerRequestInterface $request = null, bool $privilegeTransition = false): void`

Regenerate the session id, preserving the session's data.

True when this rotation is a privilege transition; forces an outright delete.

| Parameter | Type | Description |
|---|---|---|
| `$session` | [`Session`](/api/session/session/) | The session to rotate. |
| `$deleteOld` | `bool` | Whether to dispose of the old id at all (false leaves it alone). |
| `$request` | `?`[`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | Used to bind a migration tombstone; irrelevant on a privilege transition. |
| `$privilegeTransition` | `bool` | True when this rotation is a privilege transition; forces an outright delete. |

### startFromRequest()

`public function startFromRequest(ServerRequestInterface $request): Session`

Resolves the request's session cookie into a [`Session`](/api/session/session/), or creates a fresh one.

The cookie value must match the generated-id format before storage is even consulted, so a malformed or attacker-supplied id costs no backend lookup. A loaded record is then handled one of three ways: a redirect marker left by a previous rotation resolves to the new id and is deleted on the spot (one-shot, so the old id stops working immediately afterwards); a record past its idle or absolute timeout is deleted; anything else is returned as a not-new session with its activity timestamps touched.

When the cookie is missing, malformed, unknown to storage, expired, or its redirect could not be resolved, a new session is returned with a freshly generated id, marked new and clean — which is what keeps an anonymous request from costing a persisted row or a Set-Cookie.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns [`Session`](/api/session/session/)
