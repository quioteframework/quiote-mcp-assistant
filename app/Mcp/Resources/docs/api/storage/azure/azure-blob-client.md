# AzureBlobClient

> Minimal Azure Blob Storage REST client, deliberately not built on the official `microsoft/azure-storage-blob` SDK (Microsoft stopped actively developing it; a hand-rolled client against the documented REST API has proven more maintainable in production).

Minimal Azure Blob Storage REST client, deliberately not built on the official `microsoft/azure-storage-blob` SDK (Microsoft stopped actively developing it; a hand-rolled client against the documented REST API has proven more maintainable in production).

Only the operations the session and filesystem backends need: ensure-container, get, put, delete, get-properties and list. No chunked upload or snapshots.

Those absent operations are still reachable: [`AzureBlobClient::request()`](/api/storage/azure/azure-blob-client/#request) authorizes the request the same way every other method does and hands back the raw PSR-7 response, so a caller can implement the operation it needs without reimplementing the authorization.

Authorization itself, Shared Key or an Azure AD bearer token from workload identity or the Azure CLI, is delegated to an [`AzureCredential`](/api/storage/azure/azure-credential/), not built in here.

## Synopsis

`final class AzureBlobClient`

|  |  |
|---|---|
| Source | `AzureBlobClient.php` |

## Constructor

### __construct()

`public function __construct(ClientInterface $httpClient, string $accountName, AzureCredential $credential, ?string $endpoint = null, Psr17Factory $psr17 = new Psr17Factory(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$httpClient` | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |  |
| `$accountName` | `string` |  |
| `$credential` | [`AzureCredential`](/api/storage/azure/azure-credential/) |  |
| `$endpoint` | `?``string` |  |
| `$psr17` | `Psr17Factory` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(string $container, string $blob): void`](#delete) | Deletes a blob, treating a missing one as success. |
| [`ensureContainerExists(string $container): void`](#ensurecontainerexists) | Creates the container, treating "already exists" as success. |
| [`get(string $container, string $blob): ?string`](#get) | Returns the blob's contents, or null if Azure answers 404. |
| [`head(string $container, string $blob): ?ObjectMetadata`](#head) | Blob properties without transferring the body (Get Blob Properties), or null if the blob does not exist. |
| [`listObjects(string $container, string $prefix = '', string $delimiter = '', ?string $continuationToken = null, int $maxKeys = 1000): ObjectListing`](#listobjects) | Lists blobs in $container whose name starts with $prefix, one page at a time (List Blobs). |
| [`put(string $container, string $blob, string $data): void`](#put) | Creates or replaces a block blob in one request. |
| [`request(string $method, string $path, array<string, string> $query = [], array<string, string> $headers = [], ?string $body = null): ResponseInterface`](#request) | Send an arbitrary signed request and return the raw response, for operations this class does not model itself. |

### delete()

`public function delete(string $container, string $blob): void`

Deletes a blob, treating a missing one as success.

A 404 returns normally so a delete is idempotent.

| Parameter | Type | Description |
|---|---|---|
| `$container` | `string` |  |
| `$blob` | `string` |  |

| Throws | When |
|---|---|
| `AzureStorageException` | On any other 4xx/5xx status, or a transport failure that survived the retries. |

### ensureContainerExists()

`public function ensureContainerExists(string $container): void`

Creates the container, treating "already exists" as success.

A 409 from Azure means another caller got there first, which is the desired end state, so 201, 202 and 409 all return normally.

| Parameter | Type | Description |
|---|---|---|
| `$container` | `string` |  |

| Throws | When |
|---|---|
| `AzureStorageException` | On any other status, or if the request could not be sent after the configured retries. |

### get()

`public function get(string $container, string $blob): ?string`

Returns the blob's contents, or null if Azure answers 404.

A container that does not exist also answers 404, so it is indistinguishable from a missing blob here.

| Parameter | Type | Description |
|---|---|---|
| `$container` | `string` |  |
| `$blob` | `string` |  |

Returns `?``string`

| Throws | When |
|---|---|
| `AzureStorageException` | On any other 4xx/5xx status, or a transport failure that survived the retries. |

### head()

`public function head(string $container, string $blob): ?ObjectMetadata`

Blob properties without transferring the body (Get Blob Properties), or null if the blob does not exist.

| Parameter | Type | Description |
|---|---|---|
| `$container` | `string` |  |
| `$blob` | `string` |  |

Returns `?`[`ObjectMetadata`](/api/storage/object-metadata/)

### listObjects()

`public function listObjects(string $container, string $prefix = '', string $delimiter = '', ?string $continuationToken = null, int $maxKeys = 1000): ObjectListing`

Lists blobs in $container whose name starts with $prefix, one page at a time (List Blobs).

$continuationToken must be null on the first call and, for a truncated result, the previous call's [`ObjectListing::$nextContinuationToken`](/api/storage/object-listing/#nextcontinuationtoken) verbatim on the next; it carries Azure's own `NextMarker` and is opaque to a caller.

| Parameter | Type | Description |
|---|---|---|
| `$container` | `string` |  |
| `$prefix` | `string` |  |
| `$delimiter` | `string` |  |
| `$continuationToken` | `?``string` |  |
| `$maxKeys` | `int` |  |

Returns [`ObjectListing`](/api/storage/object-listing/)

| Throws | When |
|---|---|
| `AzureStorageException` | On any 4xx/5xx status, a transport failure that survived the retries, or a response body that was not the XML this expects. |

### put()

`public function put(string $container, string $blob, string $data): void`

Creates or replaces a block blob in one request.

The whole payload is sent in a single PUT with an `application/octet-stream` content type; there is no chunked upload, so the data must fit Azure's single-request block blob limit. The container must already exist.

| Parameter | Type | Description |
|---|---|---|
| `$container` | `string` |  |
| `$blob` | `string` |  |
| `$data` | `string` |  |

| Throws | When |
|---|---|
| `AzureStorageException` | If Azure answers 4xx/5xx, or the request could not be sent after the retries. |

### request()

`public function request(string $method, string $path, array<string, string> $query = [], array<string, string> $headers = [], ?string $body = null): ResponseInterface`

Send an arbitrary signed request and return the raw response, for operations this class does not model itself.

| Parameter | Type | Description |
|---|---|---|
| `$method` | `string` |  |
| `$path` | `string` |  |
| `$query` | `array``<``string``, ``string``>` | signed as part of the canonicalized resource |
| `$headers` | `array``<``string``, ``string``>` |  |
| `$body` | `?``string` |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
