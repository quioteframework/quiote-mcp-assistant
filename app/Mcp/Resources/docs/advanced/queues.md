# Background jobs & queues

> Pushing and processing background jobs — Job/RetryableJob, the sync and DB-backed drivers, retry/backoff, dead-letter handling, and the queue:work/queue:failed:* commands.

**[`quioteframework/queue`](/plugins/official-packages/#quioteframeworkqueue)** adds a background job/queue abstraction — a `Job` interface, an app-facing `QueueManager::push()`, retry with configurable backoff, dead-letter storage for jobs that exhaust their retries, and a `queue:work` console command to drive a persistent backend. **`quioteframework/queue-db`** adds the persistent half: a driver and dead-letter store backed by the app's own database, following the same core-plugin + backend-plugin split as `quioteframework/auth`/`auth-jwt`.

## Which package for which role

`queue` alone is a complete, working queue — it just runs jobs **in-process**, synchronously, inside the request that pushed them. That's genuinely useful for dev/test and for jobs that are fine to run inline, but it means `push()` blocks the caller until the job (and any retries) finish. `queue-db` adds a **persistent backlog** — jobs pushed to it are written to a database table and processed later by a separate `queue:work` process, so the request that pushed a job doesn't wait for it to run.

| Scenario | Package |
|---|---|
| Dev/test, or jobs cheap enough to run inline | `queue` alone (the `sync` driver, the default) |
| Production use — don't block the request that pushed the job | `queue` + `queue-db` (the `db` driver) or `queue-redis` (the `redis` driver) |
| Inspecting/retrying/discarding dead-lettered jobs from the CLI | `queue` + `queue-db` (`LogFailedJobStore` only logs; `DbFailedJobStore` is queryable) |
| Running jobs on a cron schedule | `queue` + [`quioteframework/scheduler`](/advanced/scheduling/) |

Between the two persistent drivers: `queue-db` needs no new infrastructure — it uses a table in the database you already have, and comes with a queryable dead-letter store. `queue-redis` needs a Redis server but handles concurrent polling better (its reservation is a genuinely atomic `RPOPLPUSH`, not the UPDATE-then-SELECT pair the DB driver uses for portability).

## Core concepts (`quioteframework/queue`)

### `Job` and `RetryableJob`

```php
namespace App\Job;

use Quiote\Queue\Job;

final class SendWelcomeEmail implements Job
{
    public function __construct(private readonly int $userId)
    {
    }

    public function handle(): void
    {
        // send the email
    }
}
```

A job is instantiated fresh per attempt via `Quiote\DI\Container::make()` — the same fresh-per-call autowiring actions/views already get — so constructor-injected services autowire normally, and only the job's own arguments need to travel through the queue as `JobPayload::$params`.

The class name is checked **before** anything is constructed. `JobPayload::$jobClass` is a plain string because it comes from stored data that hasn't been validated, so `JobExecutor` resolves the hierarchy from the string alone (`is_a($jobClass, Job::class, true)`) and rejects a non-`Job` without instantiating it. That matters for any queue row an attacker could influence — a webhook-triggered enqueue, a shared Redis instance — where constructing an arbitrary autoloadable class with attacker-chosen constructor arguments is a real object-injection surface. The post-construction `instanceof` check stays as well, since the container may legitimately answer with a decorator or a substitute.

Implement `RetryableJob` (which extends `Job`) to override the retry policy per job instead of using the config-level default:

```php
use Quiote\Queue\RetryableJob;

final class SendWelcomeEmail implements RetryableJob
{
    public function __construct(private readonly int $userId) {}

    public function handle(): void { /* ... */ }

    public function maxAttempts(): int
    {
        return 5; // total attempts, including the first
    }

    public function backoffSeconds(int $attempt): int
    {
        return $attempt * 10; // linear backoff; return whatever policy you want
    }
}
```

A job that doesn't implement `RetryableJob` gets the config-level defaults (`queue.retry.max_attempts` = 3, `queue.retry.backoff_seconds` = 5).

### Pushing a job

```php
$queueManager = $container->get(\Quiote\Queue\QueueManager::class);

$queueManager->push(SendWelcomeEmail::class, ['userId' => 5]);

// Delay availability (only meaningful for a persistent driver — see below):
$queueManager->push(SendWelcomeEmail::class, ['userId' => 5], delaySeconds: 300);
```

`$params` must be JSON-serializable if you're using a persistent driver (`queue-db`); the in-process `sync` driver has no such restriction. `QueueManager::driver(?string $alias)` resolves an explicit driver by alias instead of the configured default, if you need to push to a specific backend.

### The `sync` driver (the default)

`queue.default_driver` defaults to `sync` — `SyncQueueDriver` runs `push()`'s job **inline**, in the same process, with blocking retries (`usleep()` between attempts) via `JobExecutor::executeWithRetries()`. This is always available with no further configuration, and is fine for dev/test — production use should configure a persistent driver so a job's execution time (and retries) don't block the request that pushed it.

### Retry and dead-letter handling

Whichever driver you use, retry/backoff decisions and dead-letter recording go through `JobExecutor`, so the policy isn't duplicated per driver:

- On a thrown exception, if `attempts < maxAttempts` (from `RetryableJob`, or the config defaults), the job is retried after `backoffSeconds($attempts)`.
- Once retries are exhausted, the failure is recorded to the configured `FailedJobStoreInterface` and the job is not retried again.

The default `FailedJobStoreInterface` is `LogFailedJobStore` — it logs the failure (job class, params, attempts, exception class/message/trace) via PSR-3 and drops it; there's nothing to query afterward. Bind `quioteframework/queue-db`'s `DbFailedJobStore` instead (see below) for an inspectable dead-letter table.

### Config

`QueuePlugin` publishes these `queue.*` defaults:

| Key | Default | Meaning |
|---|---|---|
| `queue.default_driver` | `sync` | Driver alias `QueueManager`/`queue:work` use when none is given explicitly. |
| `queue.retry.max_attempts` | `3` | Total attempts (including the first) for a job that isn't a `RetryableJob`. |
| `queue.retry.backoff_seconds` | `5` | Delay before a retry, for a job that isn't a `RetryableJob`. |

### `queue:work` — processing a persistent backlog

```bash
php bin/quiote queue:work --driver=db
```

| Option | Default | Effect |
|---|---|---|
| `--driver` | `queue.default_driver` | Driver alias to work. |
| `--max-jobs` | unlimited | Stop after processing this many jobs. |
| `--sleep` | `1` | Seconds to sleep between empty polls. |
| `--stop-when-empty` | — | Exit as soon as the queue is empty instead of polling forever. |

Running `queue:work` against `sync` (the default — nothing to poll) fails fast with a clear error telling you to configure a persistent driver, rather than spinning uselessly. Internally, `QueueWorker::processNext()` claims one job off a `PollableQueueDriverInterface` (`reserve()`), runs it via `JobExecutor`, and then `ack()`s (success), `release()`s with a delay (retry), or `discard()`s it (exhausted — the dead-letter record was already written by `JobExecutor`).

### `queue:failed:*` — inspecting dead-lettered jobs

Only works against an `InspectableFailedJobStoreInterface` (i.e. `DbFailedJobStore` from `queue-db` — the default `LogFailedJobStore` errors out with a clear message telling you to bind a persistent store instead):

```bash
php bin/quiote queue:failed:list --limit=50 --offset=0
php bin/quiote queue:failed:retry <id>      # or --all
php bin/quiote queue:failed:forget <id>     # or --all
```

`queue:failed:retry` re-pushes the job (via `QueueManager::push()`, onto the currently configured driver) and removes it from the failed store; it errors if the stored `job_class` no longer exists or no longer implements `Job`. `queue:failed:forget` deletes the record without retrying it.

## `quioteframework/queue-db`

Adds the `db` driver alias (`DbQueueDriver`) and a persistent `DbFailedJobStore`, both backed by a PDO connection from the app's own `DatabaseManager` — not a separate database of its own.

```bash
composer require quioteframework/queue-db
```

`QueueDbPlugin` publishes these additional config keys:

| Key | Default | Meaning |
|---|---|---|
| `queue.db.connection` | `main` | Which configured database connection (`Config/databases.*`) to use. |
| `queue.db.table` | `quiote_queue_jobs` | Table name for the job backlog. |
| `queue.db.failed_table` | `quiote_queue_failed_jobs` | Table name for the dead-letter store. |

The connection must be PDO-backed (`Quiote\Database\PdoDatabase`) — `QueueDbPlugin` throws a clear error at resolution time otherwise, or if no `DatabaseManager` is configured on the context at all.

### Enabling it

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Queue\QueuePlugin::class, 'enabled' => true],
    ['class' => \Quiote\Queue\Db\QueueDbPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Queue\QueuePlugin
  enabled: true
- class: Quiote\Queue\Db\QueueDbPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Queue\QueuePlugin" />
        <plugin class="Quiote\Queue\Db\QueueDbPlugin" />
    </ae:configuration>
</ae:configurations>
```

Then point `queue.default_driver` at `db` (or pass `--driver=db` to `queue:work` explicitly):

```php
// Config/settings.php
'queue.default_driver' => 'db',
```

### Schema

Neither table is created automatically — run the DDL `DbQueueDriver::schema()`/`DbFailedJobStore::schema()` return (portable across PostgreSQL and SQLite; no `SERIAL`/`AUTOINCREMENT`, no `FOR UPDATE SKIP LOCKED`) as a migration:

```sql
-- DbQueueDriver::schema()
CREATE TABLE IF NOT EXISTS quiote_queue_jobs (
    id VARCHAR(32) NOT NULL PRIMARY KEY,
    job_class VARCHAR(255) NOT NULL,
    params TEXT NOT NULL,
    attempts INTEGER NOT NULL DEFAULT 0,
    available_at INTEGER NOT NULL,
    reserved_at INTEGER NULL,
    reserved_token VARCHAR(32) NULL
);

-- DbFailedJobStore::schema()
CREATE TABLE IF NOT EXISTS quiote_queue_failed_jobs (
    id VARCHAR(32) NOT NULL PRIMARY KEY,
    job_class VARCHAR(255) NOT NULL,
    params TEXT NOT NULL,
    exception_class VARCHAR(255) NOT NULL,
    exception_message TEXT NOT NULL,
    exception_trace TEXT NOT NULL,
    attempts INTEGER NOT NULL,
    failed_at INTEGER NOT NULL
);
```

`id`/`reserved_token` are random hex strings rather than an autoincrement key, for the same portability reasons as `Quiote\Security\RateLimit\PdoRateLimiterStorage`.

:::caution[Reservation is "reasonably safe", not provably race-free]
`DbQueueDriver::reserve()` claims a row via an UPDATE-then-SELECT-by-token pair rather than `SELECT ... FOR UPDATE SKIP LOCKED`, so it works identically on both PostgreSQL and SQLite. Under heavy concurrent polling on PostgreSQL this is a documented limitation, not a silently-ignored one — acceptable for typical `queue:work` deployments (a handful of worker processes), but not a guarantee under arbitrary concurrency.
:::

### `DbFailedJobStore` without the `db` driver

`DbFailedJobStore` is registered as `DbFailedJobStore::class` only — it is **not** bound as the default `FailedJobStoreInterface` automatically just because `queue-db` is installed. Bind it yourself if you want persistent dead-letter storage independent of which `QueueDriverInterface` you actually queue jobs through:

```php
$registrar->service(\Quiote\Queue\FailedJobStoreInterface::class, static fn($container) =>
    $container->get(\Quiote\Queue\Db\DbFailedJobStore::class)
);
```

This is deliberate: an app opts into persistent dead-letter storage explicitly, rather than `queue-db` silently overriding `QueuePlugin`'s `LogFailedJobStore` default depending on plugin registration order.

## `quioteframework/queue-redis`

Adds the `redis` driver alias (`RedisQueueDriver`). Unlike `queue-db`, the connection is self-contained — built straight from a DSN, with no dependence on the app's `DatabaseManager`.

```bash
composer require quioteframework/queue-redis predis/predis
```

Register `Quiote\Queue\Redis\QueueRedisPlugin` alongside `QueuePlugin` (same shape as the `queue-db` snippets above), then point `queue.default_driver` at `redis` or pass `--driver=redis` to `queue:work`.

| Key | Default | Meaning |
|---|---|---|
| `queue.redis.dsn` | `redis://127.0.0.1:6379` | Connection DSN. |
| `queue.redis.prefix` | `quiote_queue` | Key prefix for the driver's own keys. |

Any of `ext-redis`, `ext-relay` or `predis/predis` will do — see [Redis backends](/plugins/official-packages/#redis-backends).

### The reliable-queue design

There's no dead-letter table to create and no schema to run, but the key layout is worth knowing since it's what you'd inspect when debugging:

| Key | Type | Holds |
|---|---|---|
| `{prefix}:ready` | LIST | Jobs available to run now. |
| `{prefix}:processing` | LIST | Jobs currently reserved by a worker. |
| `{prefix}:delayed` | ZSET | Delayed and released jobs, scored by their due unix timestamp. |

`reserve()` first promotes any due members of the delayed ZSET back onto the ready list, then **atomically** moves one entry from `ready` to `processing` with `RPOPLPUSH` — the classic reliable-queue pattern. A worker that crashes mid-job therefore leaves that job sitting in `processing`, recoverable, rather than lost. `ack()`, `release()` and `discard()` `LREM` the entry from `processing`. Each entry embeds a random `uid`, so two otherwise-identical jobs stay distinct strings and `LREM` can't remove the wrong one.

Note that dead-lettering is unaffected by the driver choice — it goes through `JobExecutor` and the configured `FailedJobStoreInterface`, so `queue-redis` still uses `LogFailedJobStore` unless you bind something else (e.g. `queue-db`'s `DbFailedJobStore`, which works independently of which driver you queue through).
