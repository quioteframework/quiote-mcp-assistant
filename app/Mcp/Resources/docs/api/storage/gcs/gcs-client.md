# GcsClient

> Minimal Google Cloud Storage REST client authenticating with an HMAC key pair (GCS's \"interoperability\" auth mode, meant for exactly this kind of S3-like tool) rather than a service-account OAuth2/JWT flow — no `google/cloud-storage` dependency, no token exchange round-trip, just the operations a session or filesystem backend needs against the XML API: get, put, delete and head a single object.

Minimal Google Cloud Storage REST client authenticating with an HMAC key pair (GCS's "interoperability" auth mode, meant for exactly this kind of S3-like tool) rather than a service-account OAuth2/JWT flow — no `google/cloud-storage` dependency, no token exchange round-trip, just the operations a session or filesystem backend needs against the XML API: get, put, delete and head a single object.

Anything beyond those — listing a bucket, resumable upload, ACLs — is deliberately absent, but reachable: [`GcsClient::request()`](/api/storage/gcs/gcs-client/#request) performs the HMAC signing and hands back the raw PSR-7 response, so a caller can implement the operation it needs without reimplementing the signature.

## Synopsis

`final class GcsClient implements ObjectStoreClientInterface`

|  |  |
|---|---|
| Implements | [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) |
| Source | `GcsClient.php` |

## Constructor

### __construct()

`public function __construct(ClientInterface $httpClient, string $accessKey, string $secretKey, string $bucket, string $endpoint = 'https://storage.googleapis.com', Psr17Factory $psr17 = new Psr17Factory(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$httpClient` | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |  |
| `$accessKey` | `string` |  |
| `$secretKey` | `string` |  |
| `$bucket` | `string` |  |
| `$endpoint` | `string` |  |
| `$psr17` | `Psr17Factory` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(string $object): void`](#delete) | A 404 returns normally, so deleting an object that is not there is not an error; any other 4xx/5xx raises [`GcsStorageException`](/api/storage/gcs/gcs-storage-exception/). |
| [`get(string $object): ?string`](#get) | A 404 from the XML API is reported as null; every other 4xx/5xx raises [`GcsStorageException`](/api/storage/gcs/gcs-storage-exception/), as does a transport failure. |
| [`head(string $object): ?ObjectMetadata`](#head) | Object metadata without transferring the body, or null if the object does not exist. |
| [`put(string $object, string $body): void`](#put) | The whole body is sent in one PUT as `application/octet-stream`; there is no resumable upload here. |
| [`request(string $method, string $object = '', array<string, string> $query = [], ?string $body = null, string $contentType = ''): ResponseInterface`](#request) | Send an arbitrary signed request to this client's bucket and return the raw response, for operations this class does not model itself. |

### delete()

`public function delete(string $object): void`

A 404 returns normally, so deleting an object that is not there is not an error; any other 4xx/5xx raises [`GcsStorageException`](/api/storage/gcs/gcs-storage-exception/).

Best-effort: a key that does not exist is not an error.

| Parameter | Type | Description |
|---|---|---|
| `$object` | `string` |  |

| Throws | When |
|---|---|
| `ObjectStoreException` | On a transport or provider failure. |

### get()

`public function get(string $object): ?string`

A 404 from the XML API is reported as null; every other 4xx/5xx raises [`GcsStorageException`](/api/storage/gcs/gcs-storage-exception/), as does a transport failure.

No retry is attempted.

| Parameter | Type | Description |
|---|---|---|
| `$object` | `string` |  |

Returns `?``string`

| Throws | When |
|---|---|
| `ObjectStoreException` | On a transport or provider failure, as distinct from a missing object. |

### head()

`public function head(string $object): ?ObjectMetadata`

Object metadata without transferring the body, or null if the object does not exist.

| Parameter | Type | Description |
|---|---|---|
| `$object` | `string` |  |

Returns `?`[`ObjectMetadata`](/api/storage/object-metadata/)

### put()

`public function put(string $object, string $body): void`

The whole body is sent in one PUT as `application/octet-stream`; there is no resumable upload here.

The bucket must already exist.

| Parameter | Type | Description |
|---|---|---|
| `$object` | `string` |  |
| `$body` | `string` |  |

| Throws | When |
|---|---|
| `ObjectStoreException` | If the write does not succeed. |

### request()

`public function request(string $method, string $object = '', array<string, string> $query = [], ?string $body = null, string $contentType = ''): ResponseInterface`

Send an arbitrary signed request to this client's bucket and return the raw response, for operations this class does not model itself.

| Parameter | Type | Description |
|---|---|---|
| `$method` | `string` |  |
| `$object` | `string` |  |
| `$query` | `array``<``string``, ``string``>` |  |
| `$body` | `?``string` |  |
| `$contentType` | `string` |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
