# DbQueueDriver

> PDO-backed PollableQueueDriverInterface.

PDO-backed [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/).

Portable across PostgreSQL and SQLite (no `SERIAL`/`AUTOINCREMENT`, no `FOR UPDATE SKIP LOCKED`) — `id`/`reserved_token` are random hex strings rather than an autoincrement key, following [`PdoRateLimiterStorage`](/api/security/rate-limit/pdo-rate-limiter-storage/)'s portability approach.

`reserve()` claims a row via an UPDATE-then-SELECT-by-token pair rather than `SELECT ... FOR UPDATE SKIP LOCKED`, so it works on both backends; under heavy concurrent polling on PostgreSQL this is "reasonably safe", not provably race-free — acceptable for v1, a documented limitation rather than a silent one.

Schema (see [`DbQueueDriver::schema()`](/api/queue/db/db-queue-driver/#schema)): CREATE TABLE quiote_queue_jobs ( id             VARCHAR(32)  PRIMARY KEY, job_class      VARCHAR(255) NOT NULL, params         TEXT         NOT NULL, attempts       INTEGER      NOT NULL DEFAULT 0, available_at   INTEGER      NOT NULL, reserved_at    INTEGER      NULL, reserved_token VARCHAR(32)  NULL );

## Synopsis

`final readonly class DbQueueDriver implements PollableQueueDriverInterface`

|  |  |
|---|---|
| Implements | [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/) |
| Source | `DbQueueDriver.php` |

## Constructor

### __construct()

`public function __construct(PDO $pdo, string $table = 'quiote_queue_jobs', ClockInterface $clock = new SystemClock(…), RandomnessInterface $randomness = new SystemRandomness(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$pdo` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `$table` | `string` |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |
| `$randomness` | [`RandomnessInterface`](/api/support/random/randomness-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`ack(ReservedJob $job): void`](#ack) | Deletes the job's row, so a successfully processed job is never served again. |
| [`discard(ReservedJob $job): void`](#discard) | Deletes the job's row after its retries are exhausted. |
| [`push(JobPayload $payload): void`](#push) | Inserts the job as an unreserved row with a fresh random id. |
| [`release(ReservedJob $job, int $delaySeconds): void`](#release) | Clears the reservation and makes the job due again after the delay. |
| [`reserve(): ?ReservedJob`](#reserve) | Claims the oldest due, unreserved row and returns it as a reserved job. |
| [`schema(string $table = 'quiote_queue_jobs'): string`](#schema) | DDL to create the backing table (PostgreSQL / SQLite compatible). |

### ack()

`public function ack(ReservedJob $job): void`

Deletes the job's row, so a successfully processed job is never served again.

| Parameter | Type | Description |
|---|---|---|
| `$job` | [`ReservedJob`](/api/queue/reserved-job/) |  |

### discard()

`public function discard(ReservedJob $job): void`

Deletes the job's row after its retries are exhausted.

Identical in effect to [`DbQueueDriver::ack()`](/api/queue/db/db-queue-driver/#ack); the dead-letter record has already been written by [`JobExecutor`](/api/queue/job-executor/).

| Parameter | Type | Description |
|---|---|---|
| `$job` | [`ReservedJob`](/api/queue/reserved-job/) |  |

### push()

`public function push(JobPayload $payload): void`

Inserts the job as an unreserved row with a fresh random id.

Params are stored as JSON, so they must be JSON-serializable. The row's `available_at` is [`JobPayload::$availableAt`](/api/queue/job-payload/#availableat) when set and the current time otherwise, which is what keeps a delayed job invisible to [`DbQueueDriver::reserve()`](/api/queue/db/db-queue-driver/#reserve) until it is due.

| Parameter | Type | Description |
|---|---|---|
| `$payload` | [`JobPayload`](/api/queue/job-payload/) |  |

| Throws | When |
|---|---|
| `JsonException` | if the payload params cannot be encoded. |

### release()

`public function release(ReservedJob $job, int $delaySeconds): void`

Clears the reservation and makes the job due again after the delay.

The stored attempt count is incremented, so a released job carries its retry history forward. A negative `$delaySeconds` is clamped to zero, making the job immediately due.

| Parameter | Type | Description |
|---|---|---|
| `$job` | [`ReservedJob`](/api/queue/reserved-job/) |  |
| `$delaySeconds` | `int` |  |

### reserve()

`public function reserve(): ?ReservedJob`

Claims the oldest due, unreserved row and returns it as a reserved job.

The claim stamps a random token and `reserved_at` onto exactly one row via UPDATE, then reads that row back by token. Returns null when the UPDATE matched nothing — the backlog holds no row that is both due (`available_at <= now`) and unreserved — or when the read-back finds no row for the token because another connection has since removed it.

Returns `?`[`ReservedJob`](/api/queue/reserved-job/)

| Throws | When |
|---|---|
| `RuntimeException` | if the stored `job_class` does not implement [`Job`](/api/queue/job/), or a column has an unusable type. |
| `JsonException` | if the stored params are not valid JSON. |

### schema()

`public static function schema(string $table = 'quiote_queue_jobs'): string`

DDL to create the backing table (PostgreSQL / SQLite compatible).

| Parameter | Type | Description |
|---|---|---|
| `$table` | `string` |  |

Returns `string`
