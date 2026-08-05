# Upgrading from 2.x to 3.0

> What changed in the 3.0 session overhaul, what you have to edit, and the one thing most likely to break you silently.

3.0 replaces the session subsystem. The ext/session-backed `storage` component is gone; sessions are PSR-7-native, which is what makes them behave correctly under a long-lived worker runtime.

Most applications need three changes: swap one factory slot, replace `getStorage()` calls, and accept that everyone is logged out once.

If you are starting a new application, you do not need this page — read [Sessions](/basics/sessions/) instead.

## Why

Under FrankenPHP, RoadRunner and Swoole the old stack had defects that were not implementation slips but consequences of forcing ext/session — a single global session per process, a cookie emitted through `header()` — into a PSR-7 request pipeline in a process that serves many requests.

The visible symptoms were a login that returned 302, logged success, and then 403'd on every following request; a session row written for every request that reached the framework, health checks and bots included; and `SQLITE_BUSY` under load.

All three are fixed, and most of the root causes are now structurally impossible rather than merely repaired. There is no process-global session id, so nothing can leak from one worker request into the next. There is no `SessionHandlerInterface`, so no callback can re-enter the function that invoked it. `save()` is an ordinary write with no relationship to `headers_sent()`, so a late write lands instead of silently vanishing. And the cookie rides the PSR-7 response rather than PHP's output layer, so nothing has to be synthesised off-SAPI.

Verified against real RoadRunner, Swoole and FrankenPHP servers.

## 1. Replace the `storage` slot with a `session` slot

**Before**

```yaml
storage:
  class: Quiote\Storage\PdoSessionStorage
  params:
    database: sessions
    db_table: session
```

**After**

```yaml
session:
  class: Quiote\Session\PdoSessionFactory
  params:
    database: sessions
    table: session
```

The zero-dependency default needs no database:

```yaml
session:
  class: Quiote\Session\FileSessionFactory
  params:
    dir: '%core.app_dir%/cache/sessions'
```

Cookie settings move onto the same slot: `cookie_name`, `session_cookie_lifetime`, `session_cookie_secure`, `session_cookie_httponly`, `session_cookie_samesite`, `session_migration_grace_seconds`. Note that the default cookie name is now `QSID`.

### If you had `NullStorage`

Delete the slot. A context with no `session` entry gets a `NullSessionBag`: reads return their default, writes are discarded, `exists()` is false. That is the right shape for a console command, a queue worker or a stateless API, and it is what `NullStorage` expressed before.

The `session` slot is **optional**. Nothing forces a session backend on a context that has no use for one.

:::caution
As before, a context with no session emits no session cookie, and `CsrfValidationMiddleware` exempts cookieless requests. If your app has real forms, configure a slot — see [Sessions: the slot is optional](/basics/sessions/#the-slot-is-optional).
:::

### Backend mapping

| Backend | Old class | New factory to name in `session:` | Package |
|---|---|---|---|
| Files | *(via ext/session)* | `Quiote\Session\FileSessionFactory` | core |
| PDO | `Quiote\Storage\Pdo\PdoSessionStorage` | `Quiote\Session\PdoSessionFactory` | core |
| Redis | `RedisSessionPersistence` *(hand-wired)* | `Quiote\Session\Redis\RedisSessionFactory` | `session-redis` |
| S3 | `S3SessionPersistence` *(hand-wired)* | `Quiote\Storage\S3\S3SessionFactory` | `session-s3` |
| GCS | `GcsSessionPersistence` *(hand-wired)* | `Quiote\Storage\Gcs\GcsSessionFactory` | `session-gcs` |
| Azure Blob | `AzureBlobSessionPersistence` *(hand-wired)* | `Quiote\Storage\Azure\AzureBlobSessionFactory` | `session-azure` |
| Azure Table | `AzureTableSessionPersistence` *(hand-wired)* | `Quiote\Storage\Azure\AzureTableSessionFactory` | `session-azure` |

Every backend now ships a slot factory, so no backend needs a hand-written wrapper. The S3, GCS and Azure factories expect a PSR-18 client bound in the container, the same contract the matching `filesystem-*` packages use.

A custom backend implements `Quiote\Session\SessionPersistenceInterface` (`load`/`save`/`delete`) plus a `Quiote\Session\SessionFactoryInterface` to build it, and can then be named in the slot like any other.

## 2. Replace `Context::getStorage()` with `Context::getSessionBag()`

`SessionBagInterface` is narrower and more explicit than `Storage` was.

| Before | After |
|---|---|
| `$context->getStorage()->retrieve($k)` | `$context->getSessionBag()->get($k)` |
| `$context->getStorage()->retrieve($k) ?? $d` | `$context->getSessionBag()->get($k, $d)` |
| `$context->getStorage()->store($k, $v)` | `$context->getSessionBag()->set($k, $v)` |
| `$context->getStorage()->remove($k)` | `$context->getSessionBag()->remove($k)` |
| `$storage->regenerate(true)` | `$bag->regenerate(true)` |
| — | `$bag->has($k)`, `$bag->exists()`, `$bag->getId()`, `$bag->destroy()` |

Two differences worth knowing:

- **`get()` normalizes "missing".** `SessionStorage::retrieve()` answered `null` and `NullStorage::retrieve()` answered `false`; code only survived that through loose comparison. `get()` returns your `$default` for both.
- **`exists()` is new and load-bearing.** It answers "can a write land in a session that already exists?" Consult it before persisting default or empty state, so an anonymous or stateless request does not acquire a session it never asked for. A deliberate write — a login, a user preference — should not consult it. See [`exists()` and the anonymous request](/basics/sessions/#exists-and-the-anonymous-request).

### Removed classes

`Quiote\Storage\Storage`, `NullStorage`, `SessionStorage`, `PdoSessionStorage`, `Quiote\Storage\Pdo\PdoSessionStorage`, `Quiote\Runtime\Session\NativeSessionCookieBridge`. `WorkerLoop`'s constructor no longer takes a `sessionCookies` argument.

`Quiote\Middleware\SessionMiddleware` still exists under the same FQCN, so middleware ordering config and `before:`/`after:` anchors keep resolving. It now drives the configured backend, installs the session bag on the context, and owns the request-state flush.

The `core.use_modern_session` setting is gone — configuring the slot *is* the switch.

## 3. Everyone is logged out once

Old `$_SESSION` payloads are not migrated to the new backend. There is no converter and there will not be one: it is a large amount of serialization archaeology for a one-time event. Plan the deploy accordingly.

## Behaviour changes that need no code edit, but will be noticed

**Anonymous requests no longer create a session or emit a cookie.** A request that touches nothing costs nothing. A visitor who *does* write something — a language preference, a cart, an anonymous CSRF token — still gets a session, and it still sticks. Only code that assumed *every* visitor already has a session id is affected; give it an explicit write.

**Logging out invalidates the session.** `setAuthenticated(false)` now discards the session contents and rotates the id. Previously it recorded `authenticated=false` and left the id valid and replayable. Anything relying on data surviving a logout must move that data elsewhere.

**User state is persisted earlier.** It is written before the response is emitted, not after. Anything mutating the user *after* the pipeline unwind — late middleware below `SessionMiddleware`, a worker-completed listener — no longer persists and must move above `SessionMiddleware`.

**Sessionless requests persist nothing.** A request marked `auth.sessionless` or `jwt.skip_session` no longer writes user state at all.

## If you subclass `User`, `SecurityUser` or `RbacSecurityUser`

**This is the change most likely to break you silently.**

The user hierarchy now tracks whether a request actually changed anything and writes nothing when it did not. A subclass that mutates `$attributes`, `$credentials` or `$roles` *directly*, or overrides a mutator without calling `parent::`, is invisible to that tracking and will stop persisting — with no error.

```php
// Invisible to dirty tracking:
$this->attributes[$ns]['userId'] = $id;

// Either go through the mutator:
$this->setAttribute('userId', $id, $ns);

// or say so explicitly:
$this->attributes[$ns]['userId'] = $id;
$this->markDirty();
```

`markDirty()` is public and exists for exactly this. `isDirty()` and `markClean()` round out the API.

Audit for direct writes to those three properties before upgrading. See [Subclassing: go through the mutators](/advanced/authentication-authorization/#subclassing-go-through-the-mutators-or-call-markdirty).

## Session fixation

`SessionManager::regenerate()` migrates the old id rather than deleting it outright, so a request already in flight with the pre-rotation cookie is not silently logged out. That window is much tighter than a plain grace period: the tombstone is consumed on first use, it is bound to the requesting client, it is skipped entirely when the pre-login session was empty, and the default grace is 5 seconds (`session_migration_grace_seconds`).

`SessionManager::regenerate()` and `migrateOld()` take an additional optional request argument. **This breaks subclasses overriding them.**

Full detail: [Sessions: session fixation and regeneration](/basics/sessions/#session-fixation-and-regeneration).

## Also in 3.0

**The cloud clients moved into their own packages.** `cloud-s3`, `cloud-gcs` and `cloud-azure` now hold the signed REST clients that the matching `session-*` and `filesystem-*` packages share. Previously `filesystem-s3` depended on `session-s3` to get the S3 client, which read backwards; both now depend on `cloud-s3`. They are transitive dependencies, so nobody installs them directly — but a `composer.json` pinning `session-s3` purely to get a client should drop that pin.

**A FrankenPHP Dockerfile fix worth copying.** `dunglas/frankenphp` reads `/etc/frankenphp/Caddyfile`, not `/etc/caddy/Caddyfile`. An image copying its Caddyfile to the latter has it silently ignored and starts in classic mode rather than worker mode. Check your own Dockerfile — see [Deployment: Docker](/architecture/deployment/#docker).

## Checklist

- [ ] Replace the `storage` slot with a `session` slot in every `factories.{yaml,xml,php}`, or delete it for contexts with no session
- [ ] Replace `getStorage()` with `getSessionBag()` and map the method names
- [ ] Grep for direct writes to `$attributes`, `$credentials`, `$roles` in `User` subclasses; add `markDirty()` where needed
- [ ] Move any post-unwind user mutation above `SessionMiddleware`
- [ ] Check for code assuming every visitor has a session id
- [ ] Check for anything relying on session data surviving logout
- [ ] Drop `sessionCookies:` if you construct `WorkerLoop` yourself
- [ ] Update the session cookie name if you relied on it being `Quiote` (it is now `QSID`)
- [ ] Plan for a one-time logout on deploy
