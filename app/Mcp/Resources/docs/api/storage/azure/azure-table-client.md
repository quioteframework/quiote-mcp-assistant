# AzureTableClient

> Minimal Azure Table Storage REST client using the Table service's \"Shared Key Lite\" authentication scheme — a cheaper option than Blob Storage for small key/value-shaped session payloads (no per-account container needed; entities are addressed by table + partition/row key).

Minimal Azure Table Storage REST client using the Table service's "Shared Key Lite" authentication scheme — a cheaper option than Blob Storage for small key/value-shaped session payloads (no per-account container needed; entities are addressed by table + partition/row key).

Only the three entity operations [`AzureTableSessionPersistence`](/api/storage/azure/azure-table-session-persistence/) needs: ensure-table, upsert entity, get entity, delete entity.

## Synopsis

`final class AzureTableClient`

|  |  |
|---|---|
| Source | `AzureTableClient.php` |

## Constructor

### __construct()

`public function __construct(ClientInterface $httpClient, string $accountName, string $accountKey, ?string $endpoint = null, Psr17Factory $psr17 = new Psr17Factory(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$httpClient` | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |  |
| `$accountName` | `string` |  |
| `$accountKey` | `string` |  |
| `$endpoint` | `?``string` |  |
| `$psr17` | `Psr17Factory` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(string $table, string $partitionKey, string $rowKey): void`](#delete) | Deletes one entity, treating a missing one as success. |
| [`ensureTableExists(string $table): void`](#ensuretableexists) | Creates the table, treating "already exists" as success. |
| [`get(string $table, string $partitionKey, string $rowKey): array<string, mixed>|null`](#get) |  |
| [`upsert(string $table, string $partitionKey, string $rowKey, array<string, mixed> $properties): void`](#upsert) |  |

### delete()

`public function delete(string $table, string $partitionKey, string $rowKey): void`

Deletes one entity, treating a missing one as success.

Sends `If-Match: *`, so the entity is removed whatever its current ETag — this is an unconditional delete, not an optimistic-concurrency one. A 404 returns normally so the call is idempotent.

| Parameter | Type | Description |
|---|---|---|
| `$table` | `string` |  |
| `$partitionKey` | `string` |  |
| `$rowKey` | `string` |  |

| Throws | When |
|---|---|
| `AzureStorageException` | On any other 4xx/5xx status, or a transport failure that survived the retries. |

### ensureTableExists()

`public function ensureTableExists(string $table): void`

Creates the table, treating "already exists" as success.

A 409 means another caller created it first, which is the desired end state, so both 201 and 409 return normally.

| Parameter | Type | Description |
|---|---|---|
| `$table` | `string` |  |

| Throws | When |
|---|---|
| `AzureStorageException` | On any other status, or if the request could not be sent after the configured retries. |
| `JsonException` | If the table name cannot be encoded. |

### get()

`public function get(string $table, string $partitionKey, string $rowKey): array<string, mixed>|null`

| Parameter | Type | Description |
|---|---|---|
| `$table` | `string` |  |
| `$partitionKey` | `string` |  |
| `$rowKey` | `string` |  |

Returns `array``<``string``, ``mixed``>``|``null`

### upsert()

`public function upsert(string $table, string $partitionKey, string $rowKey, array<string, mixed> $properties): void`

| Parameter | Type | Description |
|---|---|---|
| `$table` | `string` |  |
| `$partitionKey` | `string` |  |
| `$rowKey` | `string` |  |
| `$properties` | `array``<``string``, ``mixed``>` |  |
