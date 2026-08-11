# InspectableFailedJobStoreInterface

> A FailedJobStoreInterface whose dead-letter records can be listed, looked up, and removed — the query side needed by `queue:failed:list`/`queue:failed:retry`/`queue:failed:forget` (see QueueFailedListCommand and friends).

A [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/) whose dead-letter records can be listed, looked up, and removed — the query side needed by `queue:failed:list`/`queue:failed:retry`/`queue:failed:forget` (see [`QueueFailedListCommand`](/api/queue/console/queue-failed-list-command/) and friends).

Deliberately not part of the base interface: the default [`LogFailedJobStore`](/api/queue/log-failed-job-store/) only logs and drops, so it has nothing to query. `quioteframework/queue-db`'s `DbFailedJobStore` implements this.

## Synopsis

`interface InspectableFailedJobStoreInterface extends FailedJobStoreInterface`

|  |  |
|---|---|
| Implements | [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/) |
| Implemented by | [`DbFailedJobStore`](/api/queue/db/db-failed-job-store/) |
| Source | `InspectableFailedJobStoreInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`count(): int`](#count) | Returns the total number of dead-letter records held, ignoring any paging. |
| [`delete(string $id): void`](#delete) | Removes the record with this id. |
| [`find(string $id): ?FailedJobRecord`](#find) | Returns the record with this id, or null if no such record is stored. |
| [`list(int $limit = 50, int $offset = 0): list<FailedJobRecord>`](#list) |  |

### count()

`abstract public function count(): int`

Returns the total number of dead-letter records held, ignoring any paging.

Returns `int`

### delete()

`abstract public function delete(string $id): void`

Removes the record with this id.

Deleting an id that is not stored is not an error — implementors treat it as a no-op, so `queue:failed:forget` and the retry command's delete-after-requeue step stay idempotent.

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |

### find()

`abstract public function find(string $id): ?FailedJobRecord`

Returns the record with this id, or null if no such record is stored.

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |

Returns `?`[`FailedJobRecord`](/api/queue/failed-job-record/)

### list()

`abstract public function list(int $limit = 50, int $offset = 0): list<FailedJobRecord>`

| Parameter | Type | Description |
|---|---|---|
| `$limit` | `int` |  |
| `$offset` | `int` |  |

Returns `list``<`[`FailedJobRecord`](/api/queue/failed-job-record/)`>`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `record()` | [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/) | Takes delivery of a job that has permanently failed. |
