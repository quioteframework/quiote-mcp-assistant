# DbFailedJobStore

> Persistent FailedJobStoreInterface — an inspectable dead-letter table, alternative to the default LogFailedJobStore.

Persistent [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/) — an inspectable dead-letter table, alternative to the default [`LogFailedJobStore`](/api/queue/log-failed-job-store/).

Implements [`InspectableFailedJobStoreInterface`](/api/queue/inspectable-failed-job-store-interface/) so `queue:failed:list`/ `queue:failed:retry`/`queue:failed:forget` can query it.

Schema (see [`DbFailedJobStore::schema()`](/api/queue/db/db-failed-job-store/#schema)): CREATE TABLE quiote_queue_failed_jobs ( id                 VARCHAR(32)  PRIMARY KEY, job_class          VARCHAR(255) NOT NULL, params             TEXT         NOT NULL, exception_class    VARCHAR(255) NOT NULL, exception_message  TEXT         NOT NULL, exception_trace    TEXT         NOT NULL, attempts           INTEGER      NOT NULL, failed_at          INTEGER      NOT NULL );

## Synopsis

`final readonly class DbFailedJobStore implements InspectableFailedJobStoreInterface`

|  |  |
|---|---|
| Implements | [`InspectableFailedJobStoreInterface`](/api/queue/inspectable-failed-job-store-interface/) |
| Source | `DbFailedJobStore.php` |

## Constructor

### __construct()

`public function __construct(PDO $pdo, string $table = 'quiote_queue_failed_jobs'): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$pdo` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `$table` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`count(): int`](#count) | Returns the total number of rows in the dead-letter table. |
| [`delete(string $id): void`](#delete) | Deletes the dead-letter row with this id. |
| [`find(string $id): ?FailedJobRecord`](#find) | Loads a single dead-letter record by id, or null when no row matches. |
| [`list(int $limit = 50, int $offset = 0): list<FailedJobRecord>`](#list) |  |
| [`record(FailedJob $failedJob): void`](#record) | Inserts the failure as a new row with a fresh random id. |
| [`schema(string $table = 'quiote_queue_failed_jobs'): string`](#schema) | DDL to create the backing table (PostgreSQL / SQLite compatible). |

### count()

`public function count(): int`

Returns the total number of rows in the dead-letter table.

Returns `int`

| Throws | When |
|---|---|
| `RuntimeException` | if the driver refuses the count query, which in practice means the table is missing. |

### delete()

`public function delete(string $id): void`

Deletes the dead-letter row with this id.

An id with no matching row deletes nothing and reports no error.

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |

### find()

`public function find(string $id): ?FailedJobRecord`

Loads a single dead-letter record by id, or null when no row matches.

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |

Returns `?`[`FailedJobRecord`](/api/queue/failed-job-record/)

| Throws | When |
|---|---|
| `RuntimeException` | if the matching row has columns of the wrong type for a [`FailedJobRecord`](/api/queue/failed-job-record/). |

### list()

`public function list(int $limit = 50, int $offset = 0): list<FailedJobRecord>`

| Parameter | Type | Description |
|---|---|---|
| `$limit` | `int` |  |
| `$offset` | `int` |  |

Returns `list``<`[`FailedJobRecord`](/api/queue/failed-job-record/)`>`

### record()

`public function record(FailedJob $failedJob): void`

Inserts the failure as a new row with a fresh random id.

Params are stored as JSON and the failure time is stamped from the current clock, so a record is never overwritten — repeated failures of the same job class accumulate as separate rows.

| Parameter | Type | Description |
|---|---|---|
| `$failedJob` | [`FailedJob`](/api/queue/failed-job/) |  |

| Throws | When |
|---|---|
| `JsonException` | if the job params cannot be encoded. |

### schema()

`public static function schema(string $table = 'quiote_queue_failed_jobs'): string`

DDL to create the backing table (PostgreSQL / SQLite compatible).

| Parameter | Type | Description |
|---|---|---|
| `$table` | `string` |  |

Returns `string`
