# AzureBlobContainerClient

> AzureBlobClient bound to one container, so it satisfies ObjectStoreClientInterface like the S3 and GCS clients do.

[`AzureBlobClient`](/api/storage/azure/azure-blob-client/) bound to one container, so it satisfies [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) like the S3 and GCS clients do.

Azure takes the container per call, where S3 and GCS bind the bucket to the client itself. That is the only shape difference between the three, and binding it here is what lets a consumer be written once against the interface instead of once per provider.

The container is created on first write, as [`AzureBlobClient::ensureContainerExists()`](/api/storage/azure/azure-blob-client/#ensurecontainerexists) allows -- a read against a container that does not exist answers null, which is the same thing a read of an absent blob answers.

## Synopsis

`final class AzureBlobContainerClient implements ObjectStoreClientInterface`

|  |  |
|---|---|
| Implements | [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) |
| Since | `3.2.0` |
| Source | `AzureBlobContainerClient.php` |

## Constructor

### __construct()

`public function __construct(AzureBlobClient $client, string $container): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$client` | [`AzureBlobClient`](/api/storage/azure/azure-blob-client/) |  |
| `$container` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`blobClient(): AzureBlobClient`](#blobclient) | The underlying client, for the Azure-specific operations this contract does not cover. |
| [`container(): string`](#container) | Returns the name of the container every key on this client resolves against. |
| [`delete(string $key): void`](#delete) | Deletes from the bound container; the container itself is never created for a delete. |
| [`get(string $key): ?string`](#get) | Reads from the bound container. |
| [`head(string $key): ?ObjectMetadata`](#head) | Issues an Azure Get Blob Properties request against the bound container, so no body is transferred. |
| [`put(string $key, string $body): void`](#put) | The bound container is created on the first write of this instance's lifetime and the result remembered, so later writes cost one request rather than two. |

### blobClient()

`public function blobClient(): AzureBlobClient`

The underlying client, for the Azure-specific operations this contract does not cover.

Returns [`AzureBlobClient`](/api/storage/azure/azure-blob-client/)

### container()

`public function container(): string`

Returns the name of the container every key on this client resolves against.

Returns `string`

### delete()

`public function delete(string $key): void`

Deletes from the bound container; the container itself is never created for a delete.

Best-effort: a key that does not exist is not an error.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

| Throws | When |
|---|---|
| `ObjectStoreException` | On a transport or provider failure. |

### get()

`public function get(string $key): ?string`

Reads from the bound container.

A container that has not been created yet reads as null, the same answer a missing blob gives.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `?``string`

| Throws | When |
|---|---|
| `ObjectStoreException` | On a transport or provider failure, as distinct from a missing object. |

### head()

`public function head(string $key): ?ObjectMetadata`

Issues an Azure Get Blob Properties request against the bound container, so no body is transferred.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `?`[`ObjectMetadata`](/api/storage/object-metadata/)

| Throws | When |
|---|---|
| `ObjectStoreException` | On a transport or provider failure. |

### put()

`public function put(string $key, string $body): void`

The bound container is created on the first write of this instance's lifetime and the result remembered, so later writes cost one request rather than two.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$body` | `string` |  |

| Throws | When |
|---|---|
| `ObjectStoreException` | If the write does not succeed. |
