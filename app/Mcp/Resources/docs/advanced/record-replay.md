# Record, replay & regression tests

> Recording a real request as a cassette with quioteframework/replay, replaying it in isolation to see what changed, and emitting it as a committed PHPUnit regression test.

**[`quioteframework/replay`](/plugins/official-packages/#quioteframeworkreplay)** answers a question that is otherwise expensive to answer: *what exactly did that one request do, and does it still do it?*

A middleware watches requests as they run in a real deployment. When one matches the sampling policy — by default, only when it errors — everything that request consisted of is written to a single file: the method, URI, headers, cookies and body that came in; the route, action and validated parameters the request resolved to; the database queries the action ran, with their bound parameters and the rows they returned; and the response that went back out, or the exception that escaped instead. That file is a **cassette**.

Given a cassette, `quiote replay <id>` dispatches that same request through your application again — on a laptop, in CI, anywhere — and reports every way the outcome differs from the recording. `quiote replay <id> --as-test` turns it into an ordinary PHPUnit test file you commit.

```bash
php bin/quiote cassette:list --status=5xx   # what got recorded
php bin/quiote replay CRX2050               # dispatch that request here; report what changed
php bin/quiote replay CRX2050 --as-test     # freeze it as tests/Replay/ReplayCRX2050Test.php
```

A replay is **isolated** by default: nothing the request did to the outside world is done again. Database queries are answered from the rows the cassette recorded, the clock is frozen at the instant of recording so every `now()`-dependent branch takes the path it originally took, and the stubs standing in for the cache, the queue, outbound HTTP and environment reads refuse to invent a value they have no recording for rather than quietly making one up. That is what makes a recorded `POST /orders` safe to re-run on every CI build: no database, no payment provider, no order created. Which requests can actually replay this way is narrower than that paragraph suggests — [what isolation covers, and what it does not](#what-isolation-covers-and-what-it-does-not) is worth reading before depending on it.

<Aside type="note" title="Inbound requests, not outbound calls">
"Cassette" is borrowed from VCR-style libraries, but the direction is reversed. Those record the HTTP calls your application *makes*, so a test suite can be handed them back. This records a request your application *received*, so the whole request can be dispatched again. The calls the request made are recorded too — as the cassette's [effect ledger](#the-effect-ledger) — but they are what the replay answers *with*, not what it replays.
</Aside>

Two workflows, one artifact:

- **Reproduce a production bug.** A request 500s. The recorder kept a cassette because the response was an error. Copy the id out of your logs, run `quiote replay <id> --as-test`, and you have a test that fails the same way locally — no database, no upstream API, no session store involved beyond what the cassette itself carries.
- **Pin current behaviour.** Record a representative set of real requests (in staging, or in production behind the `error` sampling policy), emit tests from all of them, commit. A later change to routing, validation, rendering or serialization that alters the response for a real-world input now fails in CI, with the offending request in hand.

## Enabling it

```bash
composer require quioteframework/replay
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Replay\ReplayPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Replay\ReplayPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Replay\ReplayPlugin" />
    </ae:configuration>
</ae:configurations>
```

Installing and enabling the package alone changes nothing observable — `replay.enabled` defaults to `false` and `replay.record` to `never`, and `RecorderMiddleware` is a single enum comparison and a return when either says so. Recording needs **both**:

#### PHP

```php
// Config/settings.php
return [
    'replay.enabled' => true,
    'replay.record' => 'error',
];
```

#### YAML

```yaml
# Config/settings.yaml
replay.enabled: true
replay.record: error
```

#### XML

```xml
<!-- Config/settings.xml -->
<settings prefix="replay.">
  <setting name="enabled">true</setting>
  <setting name="record">error</setting>
</settings>
```

The middleware registers itself (`phase: bootstrap`, priority 1100) — there is no `middleware` config to edit. It sits between `StealthMiddleware` and `ErrorHandlingMiddleware`, so it sees the *rendered* error response and also catches an exception that escapes error handling entirely.

## Sampling policy

`replay.record` decides which requests actually become cassettes:

| Value | Behaviour |
|---|---|
| `never` (default) | Nothing is recorded. |
| `error` | Buffer every request, but only write a cassette when the response is 5xx or an exception escaped. Nothing is serialized or written for the requests that succeed — the recommended default for production. |
| `rate` | Keep with probability `replay.sample_rate` (`0.0`–`1.0`). The roll happens **at request entry**, not at the end: the rate does not depend on the outcome, so a lost roll skips the body copy, the upload digests and the effect ledger rather than performing them and discarding the result. |
| `header` | Keep only when the header named by `replay.trigger_header` (default `X-Quiote-Record`) is present. Development/staging only — this is not an authentication check, so don't expose it in production without an authenticated gate in front of it. |
| `always` | Keep everything. Development only. |

An unrecognised value throws rather than silently falling back to `never` — a typo must not silently disable a feature that already-happened-in-production debugging depends on.

## What's in a cassette

A cassette is one gzipped JSON document with a `.qcast` extension and a `_schema_version` field (currently `1`). `CassetteCodec` understands exactly one version and refuses a newer one outright rather than best-effort parsing it. Decoding is bounded: a cassette is untrusted input and gzip's ratio is unbounded, so inflation is incremental against a 32 MiB ceiling — a hostile or corrupt cassette raises a normal exception instead of exhausting `memory_limit` and taking `cassette:list` down with it.

`meta`, `request` and `response` are the only sections a cassette must carry; the rest are optional and absent when not captured.

| Section | Contents |
|---|---|
| `meta` | Id, `recorded_at`, PHP version, context name, the `trigger` that kept it, and the four honesty flags below. |
| `request` | Method, URI, protocol, headers, cookies, body, uploads, and an allowlisted subset of server params (`REQUEST_METHOD`, `REQUEST_URI`, `SERVER_PROTOCOL`, `HTTP_HOST`, `REMOTE_ADDR`, `SERVER_NAME`, `SERVER_PORT`, `REQUEST_TIME_FLOAT`). Captured at entry, before anything mutates it. An upload is recorded as its field name, client name, media type, size and a streaming SHA-256 — never its content. |
| `resolved` | Route name, module/action, route params, output type, the validation report if validation failed, and `validated_params`: the parameter set that survived validation. That last field is usually the single most useful one for debugging a "my parameter vanished" surprise, since it shows what the action actually received rather than what the client sent. |
| `session` | The session id and whether it existed. `SessionBagInterface` has no key-enumeration method, so `before` and `after` carry the same end-of-request snapshot rather than a genuine diff. |
| `effects` | An ordered ledger of side effects the request performed — see [The effect ledger](#the-effect-ledger). |
| `response` | Status, headers, body. |
| `exception` | Class, message, file, line and a stack trace, when one escaped. |

Four `meta` flags exist so a reader can tell an incomplete recording apart from a request that genuinely did that little — without them, a replay reports the recorder's own gaps as drift in the application:

| Flag | Means |
|---|---|
| `effects_instrumented` | Whether any effect source was registered at all. `false` says "nothing was watched", not "nothing happened". |
| `effects_truncated` | `replay.max_effects` or the ledger's byte budget dropped something. |
| `request_body_truncated` | The request body exceeded `replay.max_bytes`. A cassette with this set **cannot be replayed** — replaying a prefix and calling it the request would attribute the recorder's truncation to the application. Re-record with a larger `replay.max_bytes`. |
| `response_body_truncated` | The response body exceeded `replay.max_bytes`. Such a cassette still replays; the body diff compares the recorded prefix and reports a mismatch as a warning rather than an error. |

The stack trace is built from `getTrace()`, one line per frame, not `getTraceAsString()`. PHP's trace-as-string embeds each frame's scalar arguments, so a connection failure would record `PDO->__construct('mysql:…', 'user', 'hunter2')` in the one section nothing in `replay.redact.*` can reach — and the section most likely to be present, since the `error` trigger exists to capture exactly those requests.

A cassette's id is the request's [correlation id](/architecture/logging/#correlation-ids), or a freshly generated one when the request carried no correlation header. That id is untrusted input — sanitizing it strips control bytes but passes `/`, `.` and `..` through — so a store never keys on it directly: an id that is already `[A-Za-z0-9_-]{1,64}` is used as the key verbatim (readable in a directory listing), and anything else is reduced to its SHA-256 digest. The raw value is still kept in `meta.id`, since that is what a human matches against a log line. It is also why an emitted test is occasionally named after a 64-character hash rather than a legible id.

### Opting an action out entirely

An action that must never be recorded — payment or credential handling, where a body's sensitive field names aren't knowable in advance — carries an attribute:

```php
use Quiote\Replay\Attribute\NoRecord;

#[NoRecord]
final class Checkout extends Action
{
    // ...
}
```

A `#[NoRecord]` action's cassette keeps only a metadata skeleton: method, URI, module, action. No headers, cookies, body, uploads, server params, session, response body or exception. The attribute is read off the resolved action's *class name* by reflection, so nothing is instantiated a second time to answer the question.

## Redaction

Redaction runs at capture time, before anything is buffered — not deferred to write time, since a value sitting unredacted in process memory can still leak through a later dump. The denylists are matched case-insensitively:

| Key | Default | Matches |
|---|---|---|
| `replay.redact.headers` | `authorization`, `cookie`, `set-cookie`, `proxy-authorization`, `x-api-key` | Request **and response** header names, and outbound header names on a recorded HTTP effect. |
| `replay.redact.params` | `password`, `password_confirm`, `token`, `secret`, `card`, `cvv`, `ssn` | Parameter names (at any nesting depth), cookie names, and bound/fetched database column names where the driver can supply one. |
| `replay.redact.session` | `_csrf`, `auth.token` | Session snapshot keys. |
| `replay.redact.env` | `password`, `passwd`, `secret`, `token`, `key`, `credential`, `private`, `auth`, `dsn`, `connection_string`, `connectionstring`, `salt`, `cert` | Environment variable names, matched as **substrings** — env vars are named per deployment (`APP_DB_PASSWORD`, `STRIPE_SECRET_KEY`), so an exact-match list would have to enumerate every name in every app. |

The scrubbing happens at two points, deliberately: `RecorderMiddleware` covers the request envelope, and `EffectRedactor` sits on the effect ledger itself — the one place every recorder in every driver package already funnels through, so a newly written recorder cannot forget to redact.

`replay.redact.mode` controls how a matched value is replaced:

| Mode | Result | Note |
|---|---|---|
| `drop` (default) | `[REDACTED]` | Discloses nothing. |
| `hash` | `sha256:…` of `replay.redact.hash_salt` + the value | Useful for confirming two cassettes carried the *same* secret without seeing it. **Set the salt.** An unsalted digest is not a redaction for a low-entropy value, and the shipped denylist covers exactly those: a three-digit `cvv` falls to a thousand guesses. |
| `mask` | All but the last four characters replaced with `*` | The weakest of the three: it discloses the value's exact length and its last four characters. |

An unrecognised mode throws, for the same reason an unrecognised sampling policy does.

<Aside type="caution" title="A cassette is as sensitive as a log with bodies enabled">
Redaction covers known *names*. A value that carries no name of its own — a free-text field, an opaque cache value, a token inside a JSON response body, a serialized session blob under an innocuous key — is not caught. Treat a cassette store the way you'd treat request logging with bodies turned on: use `replay.capture_body`/`replay.capture_session` for coarse control, and `#[NoRecord]` on anything that shouldn't be captured by name at all.
</Aside>

## The effect ledger

A cassette's `effects` section is an ordered list of side effects the request performed, each with a **fingerprint** (normalized SQL plus a hash of bound parameters for a query; method + URI + body hash for HTTP; `op:key` for a cache call; the variable name for an environment read), the call's own description, the result, and how long the real call took.

The ledger is what makes a replay more than a response diff. During recording it is append-only; during replay it is read-only, and every call the code makes is matched against it — so "the code asked for something the recording has no counterpart for" and "the recording holds something the code no longer asks for" both become answerable.

### What is wired into a live request today

| Effect kind | Recorded during a live request | Substituted during isolated replay |
|---|---|---|
| `db` | Yes, with a driver package installed (below) | Yes, for Doctrine and Propulsion |
| `http`, `cache`, `queue`, `env` | **No** | Yes |
| `clock` | No (the replay clock is frozen instead — see below) | — |
| `mail`, `entropy`, `session` | No | No |

The database is the one subsystem wired end to end. The `http`/`cache`/`queue`/`env` recorders (`RecordingHttpTransport`, `RecordingCache`, `RecordingQueueDriver`, `RecordingEnvironmentReader`) exist and are unit-tested, but nothing substitutes them for an application's live client, cache, queue or environment reader, so those effects are absent from every cassette the recorder writes today. What that means in practice is spelled out under [Replaying in isolation](#what-isolation-covers-and-what-it-does-not) — it is the sharpest edge on the feature.

## Recording database effects

Installing `quioteframework/replay` alone gives you the HTTP request and response, but not what the request read or wrote in the database — and "fetch a row, do something buggy with it, crash" is the dominant real-world crash shape. A driver package for your database adapter adds it, with no code changes beyond enabling the plugin:

| Package | Records from | Records rows | Can isolate |
|---|---|---|---|
| [`replay-propulsion`](/plugins/official-packages/#quioteframeworkreplay-propulsion) | Propulsion's process-wide query observer | Yes | Yes — by substituting the connection |
| [`replay-doctrine`](/plugins/official-packages/#quioteframeworkreplay-doctrine) | A DBAL driver middleware | Yes | Yes — the decorator is called *instead of* the real statement |
| [`replay-eloquent`](/plugins/official-packages/#quioteframeworkreplay-eloquent) | The `QueryExecuted` event | No | No |
| [`replay-cycle`](/plugins/official-packages/#quioteframeworkreplay-cycle) | Cycle's PSR-3 query logger | No | No |

Each records SQL text, bound parameters and — where the seam allows — the fetched rows, redacted the same way request parameters are. A recorded DB result distinguishes three states explicitly: `rows: null` means the recorder cannot see rows at that layer, `rows: []` means the query genuinely returned none, and `affectedRows` is kept for a write even when rows are also present.

Register a driver package's plugin **after** its underlying database adapter's plugin: it overrides that adapter's driver alias to a recording subclass, and the override is last-writer-wins. See [Databases](/basics/databases/) for the adapters themselves and [Official packages](/plugins/official-packages/#record-replay--regression-tests) for each package's exact registration.

<Aside type="note" title="No new database dependency">
None of the driver packages add a required dependency to `quioteframework/replay` itself — each lives in its own package specifically so that installing `replay` (or any one driver) never pulls in an ORM you don't use. The framework's built-in raw `pdo` driver has **no** replay driver package, so an app on `class="pdo"` records no database effects.
</Aside>

### Eloquent and Cycle can only watch

Eloquent's `QueryExecuted` event and Cycle's PSR-3 logger both fire *after* the query has run and its rows have already gone back to the caller. There is no point at which either could return a recorded result instead, and neither ORM offers a connection-level substitution to fall back on. An isolated replay through them would read from — and write to — the real database while appearing isolated, so `quiote replay` **refuses to run** in isolated mode and names the package rather than degrading quietly. Their cassettes are still perfectly good for the response diff and for `cassette:show`; use `--live` (deliberately), or record through `replay-doctrine`/`replay-propulsion`, to replay in isolation.

## Cassette stores

`replay.store` names the store. The store is selected **by configuration**, not by plugin load order: each store package contributes its alias and a factory, and `ReplayPlugin`'s single `CassetteStoreInterface` binding builds whichever alias `replay.store` names. Installing a store package therefore does not commit an application to it, and load order does not matter.

| Alias | Package | For |
|---|---|---|
| `file` (default) | built in | Development. A zero-dependency default; never right in a container whose filesystem doesn't survive a restart or a scale-down. |
| `pdo` | `replay-pdo` | A team with no object store that still wants cassettes to outlive a pod. |
| `azure-blob` | `replay-azure` (on `replay-storage`) | Production on AKS + Azure Blob + Log Analytics. |
| any other object store | `replay-storage` directly, [wired up yourself](#s3-or-gcs) | S3, GCS, or anything else behind `ListableObjectStoreClientInterface`. No ready-made plugin ships for these yet — `replay-azure` is the only one, and doubles as the template. |

### The file store

| Key | Default | Meaning |
|---|---|---|
| `replay.store.path` | `var/cassettes` | Directory for the file store. A relative path anchors to `core.app_dir`, and is **refused** if there is no `core.app_dir` to anchor it to — a store whose location is decided by the process working directory is not a location anyone chose. |

The directory is created `0700` at construction; one that already exists with group or other access is narrowed to `0700`, and refused if it cannot be. Each cassette is written to a temp file created `0600` *before* anything is written into it, then renamed into place, so a reader never sees a partial cassette. A path inside `{core.app_dir}/pub` is refused outright — a cassette can carry request bodies and session data and must never be web-servable.

### The PDO-backed store

**[`quioteframework/replay-pdo`](/plugins/official-packages/#quioteframeworkreplay-pdo)** keeps cassettes in the database you already have.

```bash
composer require quioteframework/replay-pdo
```

Register `Quiote\Replay\Store\Pdo\ReplayPdoPlugin` in `Config/plugins.*` (order relative to `ReplayPlugin` doesn't matter):

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Replay\ReplayPlugin::class, 'enabled' => true],
    ['class' => \Quiote\Replay\Store\Pdo\ReplayPdoPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Replay\ReplayPlugin
  enabled: true
- class: Quiote\Replay\Store\Pdo\ReplayPdoPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Replay\ReplayPlugin" />
        <plugin class="Quiote\Replay\Store\Pdo\ReplayPdoPlugin" />
    </ae:configuration>
</ae:configurations>
```

Registering the package's plugin is what actually binds the `pdo` alias against `CassetteStoreRegistry` — installing the Composer package alone does nothing, the same way installing `quioteframework/replay` alone didn't in [Enabling it](#enabling-it). Then set the alias and connection:

| Key | Default | Meaning |
|---|---|---|
| `replay.store` | `file` | Set to `pdo`. |
| `replay.store.pdo.connection` | `main` | Which configured connection (`Config/databases.*`) to use. Its adapter must expose a raw PDO handle (`getPdo()`) — a plain `pdo` connection, or an ORM adapter layered on PDO. |
| `replay.store.pdo.table` | `quiote_cassettes` | Table name. |

The table is **not** created automatically — run the DDL `PdoCassetteStore::schema()` returns as a migration:

```sql
CREATE TABLE IF NOT EXISTS quiote_cassettes (
    slug           VARCHAR(64)  NOT NULL PRIMARY KEY,
    raw_id         VARCHAR(255) NOT NULL,
    recorded_at    VARCHAR(32)  NULL,
    route          VARCHAR(255) NULL,
    status         INTEGER      NULL,
    trigger_reason VARCHAR(32)  NULL,
    payload        TEXT         NOT NULL
);
```

PostgreSQL and SQLite only: the store's upsert is `INSERT … ON CONFLICT`, and MySQL/MariaDB would need `ON DUPLICATE KEY UPDATE` instead. The gzipped payload is not valid UTF-8, so it is base64-encoded into a plain `TEXT` column rather than a driver-specific `BYTEA`/`BLOB`, because one `CREATE TABLE` string cannot name a binary type both engines accept.

`recorded_at`/`route`/`status`/`trigger_reason` are extracted from the cassette at write time so the raw table is legible and queryable by hand (`SELECT * FROM quiote_cassettes WHERE status >= 500`). `cassette:list`/`cassette:prune` still decode every cassette and filter in PHP, exactly as they do against the file store, so both stores share one filtering implementation.

### The object-store-backed store

**`quioteframework/replay-storage`** implements a cassette store over any `Quiote\Storage\ListableObjectStoreClientInterface` — Azure Blob, S3 or GCS all satisfy it — via `ObjectStoreCassetteStore`, `CassetteKeyScheme` and two storage-agnostic cassette indexes (`ExplicitKeyIndex`, `PrefixScanIndex`). It is a library, not a plugin: something still has to construct a client for a specific backend and register it against a `replay.store` alias.

**`quioteframework/replay-azure`** is that wiring for Azure Blob, shipped as a ready-made plugin. There is no equivalent `replay-s3`/`replay-gcs` package today — [wire S3 or GCS yourself](#s3-or-gcs) with the same pieces `replay-azure` uses, below.

#### Azure Blob (`replay-azure`)

```bash
composer require quioteframework/replay-azure
```

Register `Quiote\Replay\Store\Azure\ReplayAzurePlugin` in `Config/plugins.*`, the same way as any other plugin — load order relative to `ReplayPlugin` doesn't matter, since the store binding is resolved lazily by `replay.store`, not by which plugin registered first:

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Replay\ReplayPlugin::class, 'enabled' => true],
    ['class' => \Quiote\Replay\Store\Azure\ReplayAzurePlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Replay\ReplayPlugin
  enabled: true
- class: Quiote\Replay\Store\Azure\ReplayAzurePlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Replay\ReplayPlugin" />
        <plugin class="Quiote\Replay\Store\Azure\ReplayAzurePlugin" />
    </ae:configuration>
</ae:configurations>
```

This step is easy to miss: `composer require quioteframework/replay-azure` only puts the package's classes on disk. Nothing binds the `azure-blob` alias until `ReplayAzurePlugin` has actually registered itself here — installing the Composer package is necessary but not sufficient. Without it, `replay.store: azure-blob` fails at `CassetteStoreRegistry::instantiateClassFor()`: with no alias by that name registered, `azure-blob` is treated as a literal (unqualified) class name, which of course doesn't exist, and the `RuntimeException` says as much — *"Cassette store \"azure-blob\" resolves to class \"azure-blob\", which does not exist. … is a plugin missing?"*

<Aside type="caution" title="Also needs a PSR-18 client bound in the container">
`ReplayAzurePlugin` builds `AzureBlobClient` (and, for the Log Analytics index, `AzureMonitorQueryClient`) over a plain `Psr\Http\Client\ClientInterface`, which it resolves from the container itself rather than constructing — same contract `filesystem-azure` and `session-azure` need. Registering the plugin is not enough on its own: without a client bound, `ReplayAzurePlugin::requireHttpClient()` throws at boot naming the missing interface. The fastest fix is a one-line plugin of your own:

```php
$registrar->service(
    \Psr\Http\Client\ClientInterface::class,
    static fn() => \Quiote\Http\Client\TransportFactory::default(),
    \Quiote\DI\Container::SCOPE_SINGLETON,
);
```

registered before `ReplayAzurePlugin`. See [Bring your own PSR-18 client](/basics/psr-18-client/) for the full picture, including how to route this through the named HTTP client factory instead so these calls get retries and trace propagation too.
</Aside>

Then set `replay.store` to `azure-blob` and the rest of the Azure settings:

| Key | Default | Meaning |
|---|---|---|
| `replay.store.azure.account` | `''` | Storage account name — just the name (`mystorageacct`), not a URL. `AzureBlobClient` derives `https://{account}.blob.core.windows.net` from it. |
| `replay.store.azure.container` | `quiote-cassettes` | Blob container. |
| `replay.store.azure.auth` | `shared_key` | `shared_key`, `workload_identity`, `cli` or `chain` — see [`cloud-azure`](/plugins/official-packages/#cloud-transport-packages). |
| `replay.store.azure.account_key` | `''` | Only for `shared_key`. |
| `replay.store.azure.endpoint` | `''` | Overrides the derived URL wholesale — set this for Azurite or a private endpoint/custom DNS zone. Leave it empty (the default) to use `account` against the real Azure endpoint, which is what an Entra-ID-locked storage account needs. |
| `replay.store.azure.prefix` | `quiote-cassettes` | First key segment. |
| `replay.store.azure.env` | `''` | The environment segment of a key. Empty means this process's own `core.environment` — which is right for the deployment doing the recording, and wrong for a laptop reading its cassettes, hence the override. |
| `replay.store.azure.lookback_hours` | `48` | How far back a bare-id lookup probes. |

Cassettes are written to a deterministic, time-partitioned key derived from the cassette's own `recorded_at`, forced to UTC:

```
{prefix}/{env}/{yyyy}/{mm}/{dd}/{hh}/{id}.qcast
```

Partitioning by the recorded hour rather than the write time means the same cassette resolves to the same key a day later from any timezone, and a lifecycle rule or a "what happened this hour" listing is a prefix away. `get()`/`has()`/`delete()` take a bare id, which carries no date, so they **probe backward hour by hour** from now with a cheap `head()` per hour, up to `lookback_hours`. That makes the plain store contract work with no extra machinery; the [index chain](#finding-a-cassette-by-id) is the faster path, not a prerequisite.

Two consequences worth stating plainly: `cassette:list` against this store enumerates only the same lookback window, so an older cassette exists and is still fetchable by key but will not be listed; and `delete()` removes *every* copy of a slug it finds across hour partitions, not just the newest, because one id can legitimately be re-recorded into a second hour.

Every write also emits a **pointer log line** — `cassette stored`, at `error` when the trigger was an error and `info` otherwise — carrying the id, store alias, container, key, size, status and route, and nothing else. No headers, no body, no parameters: the log line is the index, and it stays safe in a log sink with a wider audience than the cassette container itself.

#### S3 or GCS

Both **`quioteframework/cloud-s3`**'s `S3Client` and **`quioteframework/cloud-gcs`**'s `GcsClient` implement `ListableObjectStoreClientInterface` already — the same clients `filesystem-s3`/`filesystem-gcs` and `session-s3`/`session-gcs` build on — so `replay-storage`'s `ObjectStoreCassetteStore` works over either with no new code beyond a plugin that constructs one and registers it. Model it on `ReplayAzurePlugin` above:

```bash
composer require quioteframework/replay-storage quioteframework/cloud-s3
```

```php
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientInterface;
use Quiote\Config\Config;
use Quiote\DI\Container;
use Quiote\Plugin\Attribute\Plugin as PluginAttribute;
use Quiote\Plugin\PluginInterface;
use Quiote\Plugin\PluginRegistrar;
use Quiote\Replay\Index\CassetteIndexRegistry;
use Quiote\Replay\Store\CassetteStoreRegistry;
use Quiote\Replay\Store\Storage\CassetteKeyScheme;
use Quiote\Replay\Store\Storage\Index\ExplicitKeyIndex;
use Quiote\Replay\Store\Storage\Index\PrefixScanIndex;
use Quiote\Replay\Store\Storage\ObjectStoreCassetteStore;
use Quiote\Storage\S3\S3Client;

#[PluginAttribute(name: 'app/replay-s3')]
final class ReplayS3Plugin implements PluginInterface
{
    public function register(PluginRegistrar $registrar): void
    {
        $registrar->configDefault('replay.store.s3.region', 'us-east-1');
        $registrar->configDefault('replay.store.s3.bucket', '');
        $registrar->configDefault('replay.store.s3.access_key_id', '');
        $registrar->configDefault('replay.store.s3.secret_access_key', '');
        $registrar->configDefault('replay.store.s3.endpoint', '');
        $registrar->configDefault('replay.store.s3.prefix', 'quiote-cassettes');
        $registrar->configDefault('replay.store.s3.env', '');
        $registrar->configDefault('replay.store.s3.lookback_hours', 48);

        CassetteStoreRegistry::register(
            's3',
            ObjectStoreCassetteStore::class,
            static fn(Container $container) => new ObjectStoreCassetteStore(
                self::makeClient($container),
                self::makeKeyScheme(),
                storeAlias: 's3',
                containerLabel: Config::getString('replay.store.s3.bucket', ''),
                lookbackHours: Config::getInt('replay.store.s3.lookback_hours', 48),
            ),
        );

        // Storage-agnostic — the same two indexes replay-azure contributes, minus the
        // Log Analytics one, which is an Azure Monitor-specific lookup.
        CassetteIndexRegistry::register(static fn(Container $c) => new ExplicitKeyIndex(self::makeClient($c)));
        CassetteIndexRegistry::register(static fn(Container $c) => new PrefixScanIndex(self::makeClient($c), self::makeKeyScheme()));

        $registrar->stateReset('app/replay-s3', static function (): void {
            CassetteStoreRegistry::reset();
            CassetteIndexRegistry::reset();
        });
    }

    private static function makeClient(Container $container): S3Client
    {
        $httpClient = $container->get(ClientInterface::class);

        return new S3Client(
            $httpClient,
            Config::getString('replay.store.s3.region', 'us-east-1'),
            Config::getString('replay.store.s3.access_key_id', ''),
            Config::getString('replay.store.s3.secret_access_key', ''),
            Config::getString('replay.store.s3.bucket', ''),
            Config::getNullableString('replay.store.s3.endpoint', null) ?: null,
            new Psr17Factory(),
        );
    }

    private static function makeKeyScheme(): CassetteKeyScheme
    {
        $env = Config::getString('replay.store.s3.env', '');

        return new CassetteKeyScheme(
            Config::getString('replay.store.s3.prefix', 'quiote-cassettes'),
            $env !== '' ? $env : Config::getString('core.environment', 'production'),
        );
    }
}
```

Register `ReplayS3Plugin` in `Config/plugins.*` (exactly like `ReplayAzurePlugin` above — `{'class' => \App\Plugin\ReplayS3Plugin::class, 'enabled' => true}` in PHP, or the YAML/XML equivalent), then set `replay.store` to `s3`. Nothing binds the alias until that plugin's `register()` has actually run — a custom plugin needs this step exactly as much as an installed package does. `GcsClient` (`quioteframework/cloud-gcs`) takes the same shape minus a region — `__construct(ClientInterface $httpClient, string $accessKey, string $secretKey, string $bucket, string $endpoint = 'https://storage.googleapis.com', Psr17Factory $psr17 = new Psr17Factory())`, using GCS's HMAC keys rather than a service-account key file — so the same plugin works for GCS by swapping the client class and dropping the region setting. Either way, a PSR-18 `ClientInterface` must already be bound in the container, same as `replay-azure` requires — see [Bring your own PSR-18 client](/basics/psr-18-client/).

The `s3`/`gcs` alias, config prefix and `app/…` plugin name above are conventions for an in-house plugin, not something the framework enforces — pick whatever names fit the application, as long as `replay.store` names the alias actually registered.

<Aside type="tip" title="Nothing to run on an object store">
`cassette:prune` matters for the file and PDO stores. An object-store-backed one — Azure Blob, S3, GCS — prunes itself via a lifecycle rule on the bucket/container — nothing needs to run in your cluster.
</Aside>

## Finding a cassette by id

An id copied out of a log viewer is resolved in a fixed order, by both `quiote cassette:fetch` and `quiote replay`:

1. **The local cache** (`replay.local_path`, default `var/cassettes`) — no network at all.
2. **The configured store** — unless `--key` was given, which is an exact key and goes straight to step 3.
3. **The cassette index chain**, using whatever hints were supplied.

Whatever step 2 or 3 resolves is written into the local cache before returning, so a second lookup for the same id is offline. `replay.local_path` is deliberately a different setting from `replay.store.path`: a remote-store deployment still gets a fast local copy once fetched.

For an object-store-backed cassette store, the index chain comes from whatever package wired that store up: `ExplicitKeyIndex` and `PrefixScanIndex` are storage-agnostic (`replay-storage`) and apply to Azure, S3, GCS or anything else built the same way; `LogAnalyticsIndex` is Azure-specific and ships only with `replay-azure`. Each index either resolves the cassette, *declines* (nothing to try — not configured, no matching hint, or a legitimate zero-result lookup) so the next one runs, or *fails* loudly. A failure is recorded and also falls through, so one broken index never blocks the others — but if every index declines or fails, the aggregate error names each failure rather than saying a flat "not found".

| Index | Needs | Resolves |
|---|---|---|
| `ExplicitKeyIndex` | `--key`, pasted from a pointer log line | Straight to that object. A key that resolves to nothing is an error, not a decline — you pointed at a specific place. |
| `LogAnalyticsIndex` | `replay.index.log_analytics.workspace_id` | A **bare id, no hints**: queries the workspace for the recorder's own pointer line, reads `cassette_key` off it, fetches that object. A pointer found whose object has since been pruned throws — "it existed and is gone now" is a materially more useful answer than "not found". |
| `PrefixScanIndex` | `--date` (optionally `--hour`) | A delimited listing of that UTC day's hour buckets, then a scan for the slug. Needs blob read only — the right fallback for a developer with a storage RBAC grant but no workspace access. |

| Key | Default | Meaning |
|---|---|---|
| `replay.index.log_analytics.workspace_id` | `''` | Empty makes the index a permanent, cost-free decline: it builds neither a query client nor a blob client. |
| `replay.index.log_analytics.endpoint` | `https://api.loganalytics.io` | |
| `replay.index.log_analytics.lookback_hours` | `720` | The KQL query's `ago()` window — log retention outlives blob retention, hence the wider default. |

## Console commands

### `cassette:list`

```bash
php bin/quiote cassette:list [--since=<iso8601>] [--status=<code-or-class>] [--route=<name>] [--json]
```

Enumerates the configured store, newest first. `--status` accepts an exact code (`500`) or a class (`5xx`). `--since` is compared as an instant, not as a string. A cassette that fails to decode is reported as a warning rather than taking the listing down.

### `cassette:show`

```bash
php bin/quiote cassette:show <id> [--section=<name>] [--include-bodies] [--raw] [--json]
```

Prints one cassette's sections: `meta`, `request`, `resolved`, `session`, `user`, `effects`, `response`, `exception`, `log`. Bodies are excerpted to a length and a sha256 and an effect's captured rows to a count; `--include-bodies` turns both back into full content. `--raw` treats the argument as a path to an already-uncompressed (plain JSON) cassette file, bypassing the store.

`cassette:show`, `cassette:list` and `cassette:prune` read the **configured store only** — they do not walk the index chain, and `--raw` expects uncompressed JSON rather than a `.qcast`. Only `cassette:fetch` and `replay` resolve an id the store itself cannot find.

### `cassette:fetch`

```bash
php bin/quiote cassette:fetch <id> [--key=<store-key>] [--date=<yyyy-mm-dd>] [--hour=<00-23>] [--to=<dir>] [--json]
```

Resolves an id through the chain above and caches the cassette locally without replaying it — the scripting verb, and the one to reach for when a replay isn't wanted at all. `quiote replay <id> --save` is the same operation under the replay command's own name.

### `cassette:prune`

```bash
php bin/quiote cassette:prune [--older-than=<duration>] [--keep=<n>] [--dry-run] [--json]
```

`--older-than` takes a plain duration (`30d`, `24h`, `90m`, `45s`); `--keep` retains only the most recently recorded *n*. The two compose — a cassette is deleted if it matches *either* — and if neither is given, `--older-than` defaults to `replay.retention_days` (14). `--dry-run` reports without deleting.

A cassette with no `recorded_at` (a `#[NoRecord]` skeleton) is never matched by `--older-than`, since there's nothing to compare, but can still be pruned by `--keep`.

### `replay`

```bash
php bin/quiote replay <id> [--live] [--force] [--context=<name>] [--as-test] [--expect-fixed]
                          [--save] [--key=…] [--date=…] [--hour=…] [--json]
                          [--uri=<uri>] [--query=<key=value>]... [--body=<key=value>]...
                          [--as-session=<id>] [--enforce-csrf]
```

Reconstructs the cassette's request and dispatches it through the real pipeline, then reports drift. `--context` picks the context, defaulting to the cassette's own recorded one, then `core.default_context`. The command exits non-zero when any diagnostic is an error.

## Replaying in isolation

**Isolation is the default and needs no configuration.** Every ledger-backed subsystem is answered from the cassette's own recorded effects, nothing is performed, and the replay can run anywhere — which is the point of having recorded the request in the first place.

Each substitution goes through a seam that already existed for it, and every one is undone in a `finally` — including when the dispatch throws, because leaving a stub installed would make every later request in the same process silently replay-shaped:

| Subsystem | During isolated replay |
|---|---|
| Clock | Frozen at the cassette's `recorded_at`, so every `now()`-dependent branch takes the path it originally took. Nothing records individual clock reads, so there is nothing to match — freezing recovers most of the value a recorded clock would have had. |
| Randomness | **Not** substituted. Nothing recorded the values, so any substitute would be inventing input — which is what an isolated replay exists to avoid. |
| Environment | `StubbedEnvironmentReader`. A variable recorded as unset replays as unset; a variable with no recorded effect **throws**. |
| Cache | `StubbedCache`. A recorded `get()` replays its exact hit/miss state (a stored `null` is not a miss). An unrecorded read returns the caller's `$default` — PSR-16 requires that and forbids throwing — and is reported. An unrecorded write silently succeeds; it cannot affect anything. |
| Outbound HTTP | `StubbedHttpTransport`. Never opens a socket, never resolves a hostname. A recorded call is rebuilt as a real PSR-7 response; an unrecorded one throws a `ClientExceptionInterface`. |
| Queue | `AssertingQueueDriver`, bound under the configured driver's own class. Nothing is pushed anywhere; every push is captured for `pushedJobs()`/`wasJobPushed()`. |
| Database | Doctrine's driver middleware serves recorded rows through the same objects; Propulsion gets a ledger-backed connection installed on every datasource, in both read and write mode. Eloquent and Cycle cannot, and the replay refuses instead. |

A miss anywhere raises where the subsystem's own contract allows it (`\PDO` and PSR-18 do; PSR-16 does not) rather than fabricating a value, because a fabricated value is how an isolated replay ends up producing a passing test that means nothing. The ledger also refuses a *positional* match by default: answering a call from the next unconsumed effect of the right kind, carrying a different call's result, is indistinguishable from a correct answer and is recorded as a miss instead.

### What isolation covers, and what it does not

Isolation is only as complete as the seams that exist. Today that means:

- **A request whose only external effects are database queries through Doctrine or Propulsion replays cleanly.** This is the case the feature is built for.
- **A request that reads the cache replays against a cold cache**, and each unrecorded read is reported as an error diagnostic. The response is still the application's own answer, but a cache-dependent branch may take the other path.
- **A request that makes an outbound HTTP call, or reads an environment variable through `Quiote\Support\Environment`, cannot be replayed in isolation** — the stub throws, because nothing recorded those effects to answer from. Use `--live`.
- **A request that queries through Eloquent, Cycle, or the raw `pdo` driver is not isolated from its database.** Eloquent and Cycle are refused outright. The raw `pdo` driver registers no effect source at all, so there is nothing to refuse and nothing to intercept: the replayed queries reach the real database. Treat `--live` as the honest description of that case and configure it deliberately.

### Drift

Drift is reported, never smoothed over. Both halves come back as one list of diagnostics:

| Code | Severity | Meaning |
|---|---|---|
| `REPLAY_STATUS_MISMATCH` | error | The status a client would see changed. |
| `REPLAY_BODY_MISMATCH` | error | The response body changed, reported as the two sha256 digests. Downgraded to a warning when the recorded body was truncated, since a matching *prefix* is the strongest claim that can honestly be made about one. |
| `REPLAY_HEADER_MISSING` / `REPLAY_HEADER_MISMATCH` / `REPLAY_HEADER_UNEXPECTED` | warning | A header set routinely carries ambient values. `Date`, `Set-Cookie` and the correlation-id headers (`X-Correlation-Id`, `X-Request-Id`, `X-Quiote-Rid`) are skipped entirely rather than warned about on every run. |
| `REPLAY_EFFECT_MISS` | error | The code asked the ledger for something the cassette has no counterpart for — it now does something it didn't do when recorded, and whatever it did next was built on a default rather than on what happened. |
| `REPLAY_EFFECT_UNPLAYED` | warning | The cassette recorded an effect nothing asked for — the code no longer does something it used to. |
| `REPLAY_EFFECT_FUZZY` | warning | A call was answered from a recorded effect with a different fingerprint. A weaker claim than a match, so it says so. |

The three effect diagnostics are the part a live replay structurally cannot produce: its effects go to real collaborators, not through a ledger that could notice one missing.

## Replaying live

`--live` dispatches against whatever the context is really configured with and really re-performs the request's side effects. It exists for the one thing isolation cannot do — confirm a fix works against real collaborators — and carries the two guards that needs:

- It refuses unless `replay.allow_live` is `true` (default `false`, everywhere).
- It refuses anything but a **safe** method (`GET`, `HEAD`, `OPTIONS`, `TRACE`) without `--force`.

Safe, not idempotent. `PUT` and `DELETE` are idempotent — doing them twice leaves the same state as doing them once — but that says nothing about whether doing them *at all* is harmless. Gating on idempotence let a recorded `DELETE /accounts/42` replay against a live application and delete account 42, with no prompt.

## Overriding what was recorded

A recorded request often can't be replayed verbatim: a path parameter (`/orders/23940239`) may not exist in this environment, a body param names a row (`BusinessUnits[]=162345`) that's only in production, or the request was authenticated and a cassette never carries session content to replay from — `RecorderMiddleware` only ever captures a session's id and whether it existed. `quiote replay` takes overrides for exactly these cases, applied to the reconstructed request before dispatch, in both isolated and `--live` mode alike:

| Option | Overrides |
|---|---|
| `--uri=<uri>` | The whole request URI (path and/or query), replacing what was recorded. |
| `--query=<key=value>` | One query string param, merged onto the URI's existing query string. Repeatable; `key[]=value` appends to an array. |
| `--body=<key=value>` | One body param, merged onto the recorded body. Repeatable; `key[]=value` appends to an array. Works against a form-urlencoded or a JSON body — a JSON value is JSON-decoded when it parses as one, so `--body count=3` sets a number rather than the string `"3"`. |
| `--as-session=<id>` | Points the request's session cookie at a **real, live session** with this id in this context's own session store, so the app's own `SessionManager` loads it normally. |

```bash
php bin/quiote replay CRX2050 --uri=/orders/10001
php bin/quiote replay CRX2050 --body "BusinessUnits[]=1" --body "BusinessUnits[]=2"
php bin/quiote replay CRX2050 --as-session=8f3c1a9e2b4d6f7081a2b3c4d5e6f708
```

`--as-session` refuses anything not shaped like a session id `SessionManager` would itself generate (16–64 chars of `A-Za-z0-9_-`) — silently falling back to an anonymous replay would defeat the point of passing it — and refuses outright if the context declares no `session` factory slot. There is deliberately no way to *fabricate* session content from the cassette itself; pointing at a real session (your own browser session, or a service/test account's) is the only honest way to replay an authenticated request.

CSRF validation (`quioteframework/csrf`) is **off by default** for a replay, isolated or live: a CSRF token is validated against current server-side state by design, so a recorded one is only ever replayable by coincidence (the same session, not yet rotated), never reliably. `--enforce-csrf` opts back into strict validation for the rare case where the CSRF layer itself is what you're trying to reproduce.

## Emitting regression tests

`--as-test` writes two files under `replay.tests_path` (default `tests/Replay/`, relative to `core.app_dir`): a copy of the cassette at `cassettes/{slug}.qcast`, and a thin test that references it —

```php
/** Generated from cassette "CRX2050", recorded 2026-08-19T14:02:11+03:00. Edit freely -- regenerating overwrites this file. */
final class ReplayCRX2050Test extends Quiote\Replay\Testing\ReplayTestCase
{
    public function testOrdersUpdateReproducesRecordedResponse(): void
    {
        $this->replay(__DIR__ . '/cassettes/CRX2050.qcast')
            ->assertStatus(500)
            ->assertSee('Undefined array key "shipping"');
    }
}
```

`ReplayTestCase` extends the same `HttpTestCase` your other feature tests already use, and `replay()` returns the same `TestResponse` — so every assertion you already know (`assertJsonEquals`, `assertHeader`, `assertHasXPath`, …) works unchanged. Assertions are scaffolded from what was actually recorded, and deliberately no further: `assertStatus()` always, `assertJsonEquals()` for a JSON body, `assertSee()` on the exception message for an error cassette, `assertHeader('Location', …)` for a redirect. A recorded database write or enqueued job is called out as a **comment** naming the SQL or the job — not as commented-out code calling an assertion helper that doesn't exist, which would invite uncommenting a line that cannot pass.

Cassette text interpolated into the generated source is neutralised first: an id is adopted from a correlation header and an exception message routinely embeds user input, and a newline, a block-comment terminator or a `?>` inside a comment hands the rest of the value to the parser as PHP.

**An emitted test replays in isolation**, which is what makes it safe to run unattended: a recorded `POST` or `DELETE` re-runs on every CI build without re-performing the write, and needs no database and no configuration beyond having the package installed. That is why `ReplayTestCase` deliberately does not go through the CLI's `ReplayEngine`, whose `replay.allow_live` guard is right for a developer pointing a command at a shared application and wrong for a committed test.

`replay.tests_allow_live = true` opts a whole suite out, into a live dispatch with real reads *and* real writes on every run. There is no second gate — the setting is the decision — and it is only safe where the environment is disposable.

### The "reproduce, then fix" shape

`--as-test --expect-fixed` emits the inverted skeleton instead of asserting the recorded (buggy) response:

```php
public function testOrdersUpdateFixesRecordedBug(): void
{
    $response = $this->replay(__DIR__ . '/cassettes/CRX2050.qcast');

    // Recorded (buggy) response: status 500 (ErrorException: Undefined array key "shipping").
    $this->markTestIncomplete('Fix the recorded bug (status 500 (ErrorException: Undefined array key "shipping")), then replace the line below with assertions describing the fixed behaviour.');
}
```

Replace the `markTestIncomplete()` call with real assertions once you've fixed the bug, and the test starts pinning the fixed behaviour going forward.

## Settings reference

Every key, with its default. All of them live under the `replay.` prefix, which in XML needs a `<settings prefix="replay.">` wrapper.

| Key | Default | Meaning |
|---|---|---|
| `replay.enabled` | `false` | Master switch. Off means the middleware returns after one enum comparison. |
| `replay.record` | `never` | Sampling policy: `never`, `error`, `rate`, `header`, `always`. |
| `replay.sample_rate` | `0.0` | Probability for `rate`, `0.0`–`1.0`. |
| `replay.trigger_header` | `X-Quiote-Record` | Header name for `header`. |
| `replay.capture_body` | `true` | Capture the request envelope at all. Off means the cassette cannot be replayed. |
| `replay.capture_session` | `true` | Capture the session id/existence snapshot. |
| `replay.max_bytes` | `2097152` | One 2 MiB pool for the request and response bodies together, plus a second, independent pool of the same size for the effect ledger's payloads — so instrumenting effects never silently costs a request its body. Truncation cuts on a character boundary, so what is kept stays valid UTF-8. |
| `replay.max_effects` | `2000` | How *many* effects are kept (`max_bytes` bounds how large). |
| `replay.store` | `file` | Store alias: `file`, `pdo`, `azure-blob`, or one you register yourself against `replay-storage` (S3, GCS, …). |
| `replay.store.path` | `var/cassettes` | The file store's directory. |
| `replay.local_path` | `var/cassettes` | Where a fetched cassette is cached locally. |
| `replay.tests_path` | `tests/Replay` | Where `--as-test` writes. |
| `replay.retention_days` | `14` | Default `cassette:prune --older-than` window. |
| `replay.redact.headers` | see [Redaction](#redaction) | Header-name denylist. |
| `replay.redact.params` | see above | Parameter/cookie/column-name denylist. |
| `replay.redact.session` | `_csrf`, `auth.token` | Session-key denylist. |
| `replay.redact.env` | see above | Env-var-name substring denylist. |
| `replay.redact.mode` | `drop` | `drop`, `hash` or `mask`. |
| `replay.redact.hash_salt` | `''` | Salt for `hash` mode. Set it if you use that mode. |
| `replay.allow_live` | `false` | Gates `quiote replay --live`. |
| `replay.tests_allow_live` | `false` | Makes emitted tests dispatch live instead of in isolation. |
| `replay.store.pdo.connection` | `main` | `replay-pdo`. |
| `replay.store.pdo.table` | `quiote_cassettes` | `replay-pdo`. |
| `replay.store.azure.*` | see [above](#the-object-store-backed-store) | `replay-azure`. |
| `replay.index.log_analytics.*` | see [above](#finding-a-cassette-by-id) | `replay-azure`. |

## Known limits

Stated rather than implied, and each of them a gap in the recorder rather than a designed property:

- HTTP, cache, queue and environment effects are not recorded during a live request, with the replay consequences described [above](#what-isolation-covers-and-what-it-does-not).
- `meta.quiote_version`, `source_hash`, `runtime`, `trace_id` and `span_id` are always `null` — there is no runtime-readable framework version constant, and OTel span correlation is not wired. `cassette:list` therefore offers no `--stale` filter: staleness is a comparison against `source_hash`.
- `response.stray_output` is always empty: output capture belongs to `Quiote\Runtime\Kernel` and isn't reachable from a PSR-15 middleware.
- `session.before` and `session.after` carry the same end-of-request snapshot, and `user` is never populated.
