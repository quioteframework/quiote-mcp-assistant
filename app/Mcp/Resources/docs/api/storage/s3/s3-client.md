# S3Client

> Minimal S3 REST client using AWS Signature Version 4 — deliberately not built on `aws/aws-sdk-php` (a heavy dependency pulling in a client for every AWS service) for the operations a session or filesystem backend needs: get, put, delete and head a single object.

Minimal S3 REST client using AWS Signature Version 4 — deliberately not built on `aws/aws-sdk-php` (a heavy dependency pulling in a client for every AWS service) for the operations a session or filesystem backend needs: get, put, delete and head a single object.

Path-style requests, so `endpoint` also works against any S3-compatible service (MinIO, etc). The bucket is assumed to already exist — bucket lifecycle is normally managed outside the app (IaC), unlike Azure's implicit per-account containers.

Anything beyond those four operations — ListObjectsV2, multipart upload, tagging — is deliberately absent, but reachable: [`S3Client::request()`](/api/storage/s3/s3-client/#request) performs the SigV4 signing and hands back the raw PSR-7 response, so a caller can implement the operation it needs without reimplementing the signature.

## Synopsis

`final class S3Client implements ObjectStoreClientInterface`

|  |  |
|---|---|
| Implements | [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) |
| Source | `S3Client.php` |

## Constructor

### __construct()

`public function __construct(ClientInterface $httpClient, string $region, string $accessKeyId, string $secretAccessKey, string $bucket, ?string $endpoint = null, Psr17Factory $psr17 = new Psr17Factory(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$httpClient` | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |  |
| `$region` | `string` |  |
| `$accessKeyId` | `string` |  |
| `$secretAccessKey` | `string` |  |
| `$bucket` | `string` |  |
| `$endpoint` | `?``string` |  |
| `$psr17` | `Psr17Factory` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(string $key): void`](#delete) | A 404 returns normally, so deleting a key that is not there is not an error; any other 4xx/5xx raises [`S3StorageException`](/api/storage/s3/s3-storage-exception/). |
| [`get(string $key): ?string`](#get) | A 404 is reported as null; every other 4xx/5xx raises [`S3StorageException`](/api/storage/s3/s3-storage-exception/), as does a transport failure. |
| [`head(string $key): ?ObjectMetadata`](#head) | Object metadata without transferring the body, or null if the object does not exist. |
| [`put(string $key, string $body): void`](#put) | The whole body is sent in a single signed PUT; there is no multipart upload, so the payload must fit one request. |
| [`request(string $method, string $key = '', array<string, string> $query = [], ?string $body = null): ResponseInterface`](#request) | Send an arbitrary signed request to this client's bucket and return the raw response, for operations this class does not model itself. |

### delete()

`public function delete(string $key): void`

A 404 returns normally, so deleting a key that is not there is not an error; any other 4xx/5xx raises [`S3StorageException`](/api/storage/s3/s3-storage-exception/).

Best-effort: a key that does not exist is not an error.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

| Throws | When |
|---|---|
| `ObjectStoreException` | On a transport or provider failure. |

### get()

`public function get(string $key): ?string`

A 404 is reported as null; every other 4xx/5xx raises [`S3StorageException`](/api/storage/s3/s3-storage-exception/), as does a transport failure.

No retry is attempted.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `?``string`

| Throws | When |
|---|---|
| `ObjectStoreException` | On a transport or provider failure, as distinct from a missing object. |

### head()

`public function head(string $key): ?ObjectMetadata`

Object metadata without transferring the body, or null if the object does not exist.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `?`[`ObjectMetadata`](/api/storage/object-metadata/)

### put()

`public function put(string $key, string $body): void`

The whole body is sent in a single signed PUT; there is no multipart upload, so the payload must fit one request.

The bucket must already exist — this client never creates one.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$body` | `string` |  |

| Throws | When |
|---|---|
| `ObjectStoreException` | If the write does not succeed. |

### request()

`public function request(string $method, string $key = '', array<string, string> $query = [], ?string $body = null): ResponseInterface`

Send an arbitrary signed request to this client's bucket and return the raw response, for operations this class does not model itself.

query parameters, signed as part of the request

| Parameter | Type | Description |
|---|---|---|
| `$method` | `string` |  |
| `$key` | `string` |  |
| `$query` | `array``<``string``, ``string``>` | query parameters, signed as part of the request |
| `$body` | `?``string` |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
