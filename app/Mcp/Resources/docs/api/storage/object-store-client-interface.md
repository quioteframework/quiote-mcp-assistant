# ObjectStoreClientInterface

> Read, write, remove and stat a single object in a flat keyed store.

Read, write, remove and stat a single object in a flat keyed store.

The operations S3, GCS and Azure Blob genuinely share. Deliberately narrow: no listing (see [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/) for why), no copy or move, no ACLs, no multipart. A provider client exposes its full API on its own concrete class -- this is the part consumers can be written against once.

Keys are flat strings. A provider whose API takes a container or bucket per call binds it at construction, so a consumer never has to know which shape it is talking to.

## Synopsis

`interface ObjectStoreClientInterface`

|  |  |
|---|---|
| Implemented by | [`AzureBlobContainerClient`](/api/storage/azure/azure-blob-container-client/), [`GcsClient`](/api/storage/gcs/gcs-client/), [`S3Client`](/api/storage/s3/s3-client/) |
| Since | `3.2.0` |
| Source | `Storage/ObjectStoreClientInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`delete(string $key): void`](#delete) | Remove the object at $key. |
| [`get(string $key): ?string`](#get) | The object's contents, or null when no object exists at $key. |
| [`head(string $key): ?ObjectMetadata`](#head) | The object's metadata, or null when no object exists at $key. |
| [`put(string $key, string $body): void`](#put) | Create or replace the object at $key. |

### delete()

`abstract public function delete(string $key): void`

Remove the object at $key.

Best-effort: a key that does not exist is not an error.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

| Throws | When |
|---|---|
| `ObjectStoreException` | On a transport or provider failure. |

### get()

`abstract public function get(string $key): ?string`

The object's contents, or null when no object exists at $key.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `?``string`

| Throws | When |
|---|---|
| `ObjectStoreException` | On a transport or provider failure, as distinct from a missing object. |

### head()

`abstract public function head(string $key): ?ObjectMetadata`

The object's metadata, or null when no object exists at $key.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `?`[`ObjectMetadata`](/api/storage/object-metadata/)

| Throws | When |
|---|---|
| `ObjectStoreException` | On a transport or provider failure. |

### put()

`abstract public function put(string $key, string $body): void`

Create or replace the object at $key.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$body` | `string` |  |

| Throws | When |
|---|---|
| `ObjectStoreException` | If the write does not succeed. |
