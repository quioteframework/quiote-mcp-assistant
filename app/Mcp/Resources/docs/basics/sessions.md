# Sessions

> The session factory slot, the session bag your code writes through, cookie flags, and the fixation defences that run on every privilege transition.

Sessions in Quiote are PSR-7-native. There is no `session_start()`, no `$_SESSION`, and no save handler anywhere in the path — a session id rides a cookie on the PSR-7 request, the data lives in a backend you name in config, and the `Set-Cookie` rides the PSR-7 response. That is what makes sessions behave correctly under a long-lived worker runtime, where a process-global session would leak from one request into the next.

Two things to know before anything else:

- You pick a backend by pointing the **`session` factory slot** at a factory class.
- Your code reads and writes through the **session bag**, `Quiote\Session\SessionBagInterface`, injected from the container.

## The `session` slot

Sessions are a factory role, so the backend is a class name in `factories.{yaml,xml,php}`. The zero-dependency default is file-backed and needs nothing installed:

#### YAML

```yaml
# Config/factories.yaml
session:
  class: Quiote\Session\FileSessionFactory
  params:
    dir: '%core.app_dir%/cache/sessions'
```

#### PHP

```php
// Config/factories.php — the "session" role
'session' => [
    'class'  => \Quiote\Session\FileSessionFactory::class,
    'params' => [
        'dir' => '%core.app_dir%/cache/sessions',
    ],
],
```

#### XML

```xml
<!-- Config/factories.xml -->
<session class="Quiote\Session\FileSessionFactory">
    <ae:parameter name="dir">%core.app_dir%/cache/sessions</ae:parameter>
</session>
```

This is what the scaffolded app ships with.

### The slot is optional

Leave `session` out entirely and the context answers a `Quiote\Session\NullSessionBag`: reads return their default, writes are discarded, `exists()` is false, `getId()` is `''`. Nothing errors and nothing is persisted. That is the right shape for a console command, a queue worker, or a genuinely stateless API — a context with no use for a session is not forced to have one.

:::danger[No session slot means no session cookie, which means CSRF validation never runs]
`CsrfValidationMiddleware` treats any request arriving without a session cookie as exempt from CSRF checking — with no ambient credential there is nothing for an attacker to ride (see [Authentication & authorization: CSRF protection](/advanced/authentication-authorization/#csrf-protection)). With no `session` slot configured, no session cookie is ever sent, so that exemption fires on *every* request. `CsrfInjectionMiddleware` still puts a `_csrf_token` field in every non-GET form, so it looks like protection is active, but nothing validates it.

If your app has any state-changing form or endpoint a browser could be tricked into submitting, configure a `session` slot before relying on CSRF protection. Omitting it is correct only for stateless apps and APIs, where there is no ambient session cookie for CSRF to protect in the first place.
:::

### Available backends

Every backend ships a `session` slot factory. Name one, configure its parameters, and you are done — there is no wiring to write and no backend needs a hand-rolled wrapper.

| Backend | Factory class | Ships in |
|---|---|---|
| Files | `Quiote\Session\FileSessionFactory` | the kernel |
| PDO | `Quiote\Session\PdoSessionFactory` | the kernel |
| Redis | `Quiote\Session\Redis\RedisSessionFactory` | [`quioteframework/session-redis`](/plugins/official-packages/#quioteframeworksession-redis) |
| S3 | `Quiote\Storage\S3\S3SessionFactory` | [`quioteframework/session-s3`](/plugins/official-packages/#quioteframeworksession-s3) |
| GCS | `Quiote\Storage\Gcs\GcsSessionFactory` | [`quioteframework/session-gcs`](/plugins/official-packages/#quioteframeworksession-gcs) |
| Azure Blob | `Quiote\Storage\Azure\AzureBlobSessionFactory` | [`quioteframework/session-azure`](/plugins/official-packages/#quioteframeworksession-azure) |
| Azure Table | `Quiote\Storage\Azure\AzureTableSessionFactory` | [`quioteframework/session-azure`](/plugins/official-packages/#quioteframeworksession-azure) |

:::caution[The S3, GCS and Azure factories need a PSR-18 client in the container]
Those three carry no vendor SDK — they are small signed REST clients over whatever PSR-18 implementation you already use, which they resolve from the [container](/architecture/container/) by the `Psr\Http\Client\ClientInterface` id. Bind one, exactly as the matching `filesystem-*` packages expect. Without it the factory throws at startup with a message naming the missing binding, and the context falls back to `NullSessionBag`.
:::

A custom backend implements `Quiote\Session\SessionPersistenceInterface` (`load`/`save`/`delete`) plus a `Quiote\Session\SessionFactoryInterface` to build it, and can then be named in the slot like any other.

### File-backed sessions

`FileSessionFactory` builds a `Quiote\Session\FileSessionPersistence`. Beyond `dir`, it takes the backend's own knobs:

| Parameter | Default | Effect |
|---|---|---|
| `dir` | `%core.app_dir%/cache/sessions` | Where session files live. Must be writable. |
| `idle_ttl` | `1440` | Seconds of inactivity before a session is treated as expired. `0` disables expiry — sessions live until deleted. |
| `gc_probability` | `1` | Numerator of the chance that a `save()` also runs a GC sweep. |
| `gc_divisor` | `100` | Denominator of that chance. |

How it behaves:

- **One file per session**, named by the **SHA-256 hash of the session id**. An untrusted cookie value therefore can't traverse out of the directory, and session ids aren't recoverable from a directory listing.
- **Atomic writes** — data goes to a temp file in the same directory and is renamed into place, so a crash mid-write can't corrupt a session and no locking is needed. A reader holding the old inode keeps a consistent snapshot; the last concurrent save wins, matching the PDO backend's upsert semantics.
- **mtime-based expiry** — a file older than `idle_ttl` is treated as unknown on load and removed.
- **Probabilistic GC** — by default a sweep runs on roughly 1 in 100 `save()` calls. To take collection off the request path entirely, set `gc_probability` to `0` and call `gc()` from a cron or [queue](/advanced/queues/) job — or a [scheduled task](/advanced/scheduling/).

Files are the right default for a single host, or for any deployment with a shared filesystem. For several hosts without one, see [Deployment](/architecture/deployment/#sessions-across-multiple-hosts).

### Database-backed sessions

`Quiote\Session\PdoSessionFactory` ships in the kernel and takes its connection from the application's own [database manager](/basics/databases/), so sessions live alongside everything else rather than needing separate credentials:

#### YAML

```yaml
session:
  class: Quiote\Session\PdoSessionFactory
  params:
    database: sessions   # connection name from databases.xml; omit for the default
    table: session       # defaults to "session"
```

#### PHP

```php
'session' => [
    'class'  => \Quiote\Session\PdoSessionFactory::class,
    'params' => [
        'database' => 'sessions',
        'table'    => 'session',
    ],
],
```

#### XML

```xml
<session class="Quiote\Session\PdoSessionFactory">
    <ae:parameter name="database">sessions</ae:parameter>
    <ae:parameter name="table">session</ae:parameter>
</session>
```

The table needs the three columns most PHP session-table conventions already use, and the backend upserts into it with one portable statement per driver:

```sql
CREATE TABLE session (
    sess_id   VARCHAR(64) PRIMARY KEY,
    sess_data BLOB NOT NULL,        -- BYTEA on Postgres, TEXT works too
    sess_time TIMESTAMP NOT NULL
);
```

A dedicated connection is worth considering under SQLite, where session writes and application writes against one file contend for the same lock.

The [`quioteframework/session-pdo`](/plugins/official-packages/#quioteframeworksession-pdo) package provides an equivalent `Quiote\Session\Pdo\PdoSessionFactory`. Since the kernel ships a PDO backend of its own, that package is only needed by an application already requiring it.

### Redis-backed sessions

```yaml
session:
  class: Quiote\Session\Redis\RedisSessionFactory
  params:
    dsn: 'redis://127.0.0.1:6379'
    prefix: 'session:'
    ttl: 1440
```

`composer require quioteframework/session-redis predis/predis`. Redis expires the key itself via `SETEX`, so `ttl` doubles as the session lifetime and there is **no GC pass to schedule** — unlike the file and PDO backends.

### Cloud object-storage backends

Three packages keep sessions in managed object storage, each a lightweight signed REST client with no vendor SDK dependency:

```yaml
session:
  class: Quiote\Storage\S3\S3SessionFactory
  params:
    region: eu-west-1
    bucket: my-app-sessions
    access_key_id: '%env(AWS_ACCESS_KEY_ID)%'
    secret_access_key: '%env(AWS_SECRET_ACCESS_KEY)%'
    key_prefix: 'sessions/'
    # endpoint: 'https://minio.internal'   # any S3-compatible service
```

GCS uses the S3-compatible HMAC interoperability API, so its credentials are an HMAC key pair (`access_key`/`secret_key`) rather than a service-account JSON file. The Azure factories take `account_name`/`account_key` plus a `container` (Blob) or `table` (Table). All of them need the PSR-18 binding described above, and expect the bucket, container or table to already exist — creation and lifecycle belong to infrastructure tooling, not a session backend.

See [Official packages: Session backends](/plugins/official-packages/#session-backends).

### The stored wire format

Every backend serializes through one codec, `Quiote\Session\SessionCodec` behind `SessionCodecInterface`. There's a single discriminator on the way back in: a payload beginning with `{` or `[` is JSON, anything else is offered to igbinary. Decoding accepts both formats whichever one it writes, so a payload written by one backend stays readable by another — moving from file to Redis doesn't invalidate live sessions.

Each backend defaults to the codec appropriate for it, and configuring sessions through the `session` slot needs no thought about this: igbinary for file and database stores, JSON for object stores, where the round trip dominates and a readable stored object is worth more than a compact one.

If you construct a persistence backend **directly**, the codec is the last constructor argument and it defaults:

```php
use Quiote\Session\SessionCodec;

new PdoSessionPersistence($pdo, ['table' => 'session']);                            // default codec
new PdoSessionPersistence($pdo, ['table' => 'session'], SessionCodec::portable());  // explicit
```

Implement `SessionCodecInterface` to change the stored form — encryption at rest, a compressed envelope, a format an external consumer already reads — and hand it to the backend.

:::caution[Session keys must be non-numeric strings]
A top-level key PHP coerces to an integer (`$bag->set('0', …)`) cannot round-trip: the decoded array is then a list rather than session data. That's a property of PHP's array keys rather than of the encoding, and it has always been true of every backend.
:::

## Cookie flags

Cookie settings are parameters on the same `session` slot, alongside the backend's own:

| Parameter | Default | Notes |
|---|---|---|
| `cookie_name` | `QSID` | The cookie name. |
| `session_cookie_lifetime` | `0` | Seconds. `0` means a session cookie that dies with the browser. |
| `session_cookie_secure` | `true` | HTTPS-only by default. |
| `session_cookie_httponly` | `true` | Keep it on; blocks JS access. |
| `session_cookie_samesite` | `Lax` | Set to `null` to omit the attribute. |
| `session_migration_grace_seconds` | `5` | See [session fixation](#session-fixation-and-regeneration) below. |

```yaml
session:
  class: Quiote\Session\FileSessionFactory
  params:
    dir: '%core.app_dir%/cache/sessions'
    cookie_name: MyApp
    session_cookie_samesite: Strict
```

Because `Secure` defaults to true, sessions won't be set over plain HTTP unless you explicitly set `session_cookie_secure` to false — intended, so a misconfiguration fails safe rather than leaking a cookie in the clear.

## Reading and writing session data

Application code goes through `SessionBagInterface`, which the [`SessionMiddleware`](/architecture/middleware-reference/#sessionmiddleware) binds in the container, request-scoped, for the current request. An action or a view declares it and gets this request's bag:

```php
public function __construct(private readonly SessionBagInterface $session) {}

public function executeWrite(WebRequest $rd)
{
    $this->session->set('cart/items', $items);       // write
    $items = $this->session->get('cart/items', []);  // read, with a default
    $has   = $this->session->has('cart/items');      // presence check
    $this->session->remove('cart/items');            // delete

    return 'Success';
}
```

The binding is request-scoped, so a **singleton** cannot hold the bag — the container refuses that wiring rather than letting one request's session serve the next under a worker. Resolve it per call there instead. See [a singleton cannot depend on request-scoped state](/architecture/container/#a-singleton-cannot-depend-on-request-scoped-state).

The full contract:

| Method | Does |
|---|---|
| `get(string $key, mixed $default = null): mixed` | Read, answering `$default` when the key is absent. |
| `has(string $key): bool` | Whether the key is present. |
| `set(string $key, mixed $value): void` | Write. Creates the session if there isn't one. |
| `remove(string $key): void` | Delete the key. |
| `exists(): bool` | Whether a session already exists — see below. |
| `getId(): string` | The current session id, or `''` when there is no session. |
| `regenerate(bool $deleteOld = true, bool $privilegeTransition = false): void` | Move the contents to a fresh id. `$privilegeTransition` forces the old id to stop resolving immediately — see [session fixation](#session-fixation-and-regeneration). |
| `destroy(): void` | Discard the contents and continue under a fresh id. |

This is the same API the framework's own `User` classes use to persist authentication state and credentials — see [Authentication and authorization](/advanced/authentication-authorization/).

### `exists()` and the anonymous request

**An anonymous request creates no session and emits no cookie.** A request that touches nothing costs nothing: no file written, no row inserted, no `Set-Cookie` on the response, so health checks and crawlers never manufacture session state. A visitor who *does* write something — a language preference, a cart, an anonymous CSRF token — gets a session, and it sticks.

`exists()` is how you stay on the right side of that. It answers *"can a write land in a session that already exists?"*, and you consult it before persisting **default or empty** state, so a client that never asked for a session doesn't acquire one:

```php
// Persisting a default: don't create a session just to record "nothing".
if ($session->exists()) {
    $session->set('locale', $default);
}

// A deliberate write — a login, a user's own choice — simply doesn't ask.
$session->set('locale', $chosenByUser);
```

Code that needs a session id for every visitor has to make that explicit with a write of its own.

## Session lifecycle

### How it fits in a request

You never start or close a session yourself — `Quiote\Middleware\SessionMiddleware` does it. The kernel discovers it like every other middleware (the `MiddlewareAttributeScanner` reads `#[Middleware]` attributes, the `MiddlewareOrderResolver` orders them); it declares the `bootstrap` phase at priority 900, which places it early — before security — so the session bag is live before anything that depends on a user.

> Kernel boots and builds the pipeline → request enters → `SessionMiddleware` loads or creates this request's session from the incoming cookie and installs the bag on the context → `SecurityMiddleware` reads and writes the authenticated user through it → the action runs → on the way out `SessionMiddleware` **persists the user, then the session**, and bakes the `Set-Cookie` onto the response.

For the full pipeline see [Request lifecycle](/architecture/request-lifecycle/) and [Middleware pipeline](/architecture/middleware-pipeline/).

:::caution[User state is persisted inside `SessionMiddleware`, before the response is emitted]
The user is the only writer of roles, credentials and attributes, and it has to be written before the session is serialized — a write after that is a write nobody reads back. So the flush happens inside `SessionMiddleware`, on the way out, not after the pipeline has unwound.

The consequence: anything that mutates the user **below** `SessionMiddleware` in the pipeline, or in a worker-completed listener, does not persist, and does so silently. Such code belongs above `SessionMiddleware`.
:::

A request marked `auth.sessionless` or `jwt.skip_session` — a token-authenticated machine client — skips all of this and persists nothing at all, so a token-derived identity is never pushed into whatever unrelated session the client may still be carrying.

### Logging out

`SecurityUser::setAuthenticated(false)` **discards the session contents and rotates the id**, so the pre-logout id is neither replayable nor inheritable. Session data does not survive a logout: anything that has to outlive one — a shopping cart, a locale preference — belongs somewhere else, or must be re-seeded after the call.

## Session fixation and regeneration

Session fixation is the attack where an attacker plants a session id on a victim, waits for them to authenticate under it, and then uses the id they already know. The defence is to change the id at the privilege transition:

```php
$session->regenerate(privilegeTransition: true);   // new id, same data — call on login
```

You mostly get this for free: `SecurityUser::setAuthenticated(true)` regenerates for you, and passes `$privilegeTransition` on the unauthenticated-to-authenticated step (see the [auth page](/advanced/authentication-authorization/#securityuser)).

### A privilege transition deletes the old id; a routine rotation migrates it

The two rotations have different requirements, and `$privilegeTransition` is what tells them apart.

**At a privilege transition the old id stops resolving immediately.** That is the whole point: an id an attacker planted must be dead the moment the victim authenticates under it, matching what `session_regenerate_id(true)` does. There is no grace window, no tombstone, and nothing an attacker can ride.

**A routine rotation migrates instead**, because deleting the old id outright creates a race. A request already in flight carrying the pre-rotation cookie arrives just after rotation, finds nothing, and quietly starts a fresh anonymous session — and if *its* response reaches the browser after the rotating response's `Set-Cookie`, the user appears logged out immediately after logging in.

So a non-privilege rotation leaves a **tombstone** at the old id pointing at the new one. That is a fixation window by construction, so it's kept as narrow as it can usefully be:

- **One-shot.** The tombstone is consumed on first use. It rescues the one in-flight request it exists for, not every request that arrives during the window.
- **Bound to the client.** The redirect records the requesting user agent and only resolves for a matching one. This is a nuisance to an opportunist, not an authentication control — which is exactly why it is not what login relies on.
- **Skipped when there is nothing to preserve.** An empty session has the same contents either way, so it takes the direct path.
- **Short.** The default grace is **5 seconds**, configurable per slot as `session_migration_grace_seconds`.

```yaml
session:
  class: Quiote\Session\FileSessionFactory
  params:
    dir: '%core.app_dir%/cache/sessions'
    session_migration_grace_seconds: 2
```

Setting it to `0` disables the migration and takes the race back. That is a defensible choice for an app whose flows issue no concurrent requests, and a bad one for a page that fires XHRs while a rotation is still resolving. It has no effect on the login path, which never migrates.

:::note[Subclassing `SessionManager`?]
`regenerate()` and `migrateOld()` take an optional request argument — they need the request to do the client binding. A subclass overriding either must carry it through.
:::

### `destroy()` versus `regenerate()`

`regenerate()` keeps the data and changes the id — a privilege *escalation*. `destroy()` throws the data away and changes the id — a logout. Reach for the one that matches the transition; using `regenerate()` at logout leaves the old contents intact under a new id.

## Worker-mode safety

Under [worker mode](/architecture/deployment/) — FrankenPHP, RoadRunner, Swoole — a resident process serves many requests, and the classic session hazard is state surviving from one to the next.

Here that hazard is **structurally absent** rather than defended against:

- There is no process-global session id and no `$_SESSION`, so there is nothing for one request to inherit from another.
- There is no `SessionHandlerInterface`, so no callback can re-enter the function that invoked it.
- `save()` is an ordinary write with no relationship to `headers_sent()`, so a late write lands rather than vanishing.
- The cookie rides the PSR-7 response rather than PHP's output layer, so nothing has to be synthesised off-SAPI.

This is verified against real RoadRunner, Swoole and FrankenPHP servers in the integration suite.

The rule for your code is simply: **reach the session through the bag.** The framework never populates `$_SESSION`, so reaching for it directly finds nothing.

## Testing

Binding `SessionBagInterface` request-scoped into the container is the supported way to give a test a session (`Context::setSessionBag()` no longer exists as of 4.0). See [Testing](/advanced/testing/#sessions).
