# AzureTableSessionPersistence

> SessionPersistenceInterface storing one entity per session id in a single Azure Table Storage table — cheaper than AzureBlobSessionPersistence for small key/value-shaped session payloads, with no per-account container to manage.

[`SessionPersistenceInterface`](/api/session/session-persistence-interface/) storing one entity per session id in a single Azure Table Storage table — cheaper than [`AzureBlobSessionPersistence`](/api/storage/azure/azure-blob-session-persistence/) for small key/value-shaped session payloads, with no per-account container to manage.

All entities share one partition (`session`); the session id is the row key.

## Synopsis

`final class AzureTableSessionPersistence implements SessionPersistenceInterface`

|  |  |
|---|---|
| Implements | [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) |
| Source | `AzureTableSessionPersistence.php` |

## Constructor

### __construct()

`public function __construct(AzureTableClient $client, string $table = 'sessions', SessionCodecInterface $codec = new SessionCodec(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$client` | [`AzureTableClient`](/api/storage/azure/azure-table-client/) |  |
| `$table` | `string` |  |
| `$codec` | [`SessionCodecInterface`](/api/session/session-codec-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(string $sid): void`](#delete) | Deletes the entity unconditionally; the table is not created for a delete, and an entity that is not there is not an error. |
| [`load(string $sid): array<string, mixed>|null`](#load) | Reads the entity whose row key is the session id from the shared partition and decodes its `Data` property. |
| [`save(string $sid, array<string, mixed> $data): void`](#save) |  |

### delete()

`public function delete(string $sid): void`

Deletes the entity unconditionally; the table is not created for a delete, and an entity that is not there is not an error.

Deleting an id that is not stored is not an error. Implementations decide how loudly a backend failure is reported, but must not leave the caller believing the record is gone when it demonstrably is not.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

| Throws | When |
|---|---|
| `AzureStorageException` | If Azure answers with anything other than success or 404. |

### load()

`public function load(string $sid): array<string, mixed>|null`

Reads the entity whose row key is the session id from the shared partition and decodes its `Data` property.

An absent entity, an entity without a `Data` property, or one whose `Data` is not a string all read as an unknown session.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

Returns `array``<``string``, ``mixed``>``|``null`

### save()

`public function save(string $sid, array<string, mixed> $data): void`

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |
| `$data` | `array``<``string``, ``mixed``>` |  |
