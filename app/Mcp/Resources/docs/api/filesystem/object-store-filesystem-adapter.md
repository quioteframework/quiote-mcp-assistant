# ObjectStoreFilesystemAdapter

> A FilesystemAdapterInterface over any ObjectStoreClientInterface.

A [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) over any [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/).

Every keyed object store maps onto a filesystem the same way -- prefix the path to form a key, translate a missing object into a not-found error, and read size and modification time out of the object's metadata. That mapping is provider-independent, so it lives here once and the provider packages supply only their client.

Not a [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/) itself: that needs a store that can enumerate its keys, which not every [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) can. [`ListableObjectStoreFilesystemAdapter`](/api/filesystem/listable-object-store-filesystem-adapter/) adds it for the ones that can, without every consumer of this class paying for the distinction.

The provider name is carried for error messages only, so a failure says "S3 returned no * Content-Length" rather than something a reader has to trace back to a driver alias.

## Synopsis

`readonly class ObjectStoreFilesystemAdapter implements FilesystemAdapterInterface`

|  |  |
|---|---|
| Implements | [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) |
| Since | `3.2.0` |
| Source | `ObjectStoreFilesystemAdapter.php` |

## Constructor

### __construct()

`public function __construct(ObjectStoreClientInterface $client, string $providerName, string $keyPrefix = ''): mixed`

Prepended to every path to form the object key.

| Parameter | Type | Description |
|---|---|---|
| `$client` | [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) | The store, already bound to its bucket or container. |
| `$providerName` | `string` | Named in error messages, e.g. 'S3', 'GCS', 'Azure'. |
| `$keyPrefix` | `string` | Prepended to every path to form the object key. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(string $path): void`](#delete) | Deletes the object under $path. |
| [`exists(string $path): bool`](#exists) | Reports whether the store holds an object under $path. |
| [`lastModified(string $path): DateTimeImmutable`](#lastmodified) | Returns the object's modification time, taken from its Last-Modified metadata. |
| [`read(string $path): string`](#read) | Returns the body of the object stored under $path. |
| [`size(string $path): int`](#size) | Returns the object's size in bytes, taken from its Content-Length metadata. |
| [`write(string $path, string $contents): void`](#write) | Stores $contents as the object under $path, replacing any existing object. |

### delete()

`public function delete(string $path): void`

Deletes the object under $path.

Deleting a key the store does not hold is not an error — object stores treat delete as idempotent — so only a transport or authorization failure is reported.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

| Throws | When |
|---|---|
| `FilesystemStorageException` | If the store rejected the delete. |

### exists()

`public function exists(string $path): bool`

Reports whether the store holds an object under $path.

Costs a metadata request, not a download.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `bool`

| Throws | When |
|---|---|
| `FilesystemStorageException` | If the metadata request failed for a reason other than the object being absent. |

### lastModified()

`public function lastModified(string $path): DateTimeImmutable`

Returns the object's modification time, taken from its Last-Modified metadata.

A provider that omits the header, or sends one that could not be parsed, is reported as a failure naming the provider rather than defaulting to the current time.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns [`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php)

| Throws | When |
|---|---|
| `FileNotFoundStorageException` | If the store holds no object under $path. |
| `FilesystemStorageException` | If the metadata carried no usable modification time. |

### read()

`public function read(string $path): string`

Returns the body of the object stored under $path.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `string`

| Throws | When |
|---|---|
| `FileNotFoundStorageException` | If the store reports no object for that key. |
| `FilesystemStorageException` | If the store call itself failed. |

### size()

`public function size(string $path): int`

Returns the object's size in bytes, taken from its Content-Length metadata.

A provider that answers the metadata request without a usable Content-Length is a failure, not a zero-length file, and is reported naming the provider.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `int`

| Throws | When |
|---|---|
| `FileNotFoundStorageException` | If the store holds no object under $path. |
| `FilesystemStorageException` | If the metadata carried no content length. |

### write()

`public function write(string $path, string $contents): void`

Stores $contents as the object under $path, replacing any existing object.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$contents` | `string` |  |

| Throws | When |
|---|---|
| `FilesystemStorageException` | If the store rejected the put; the provider's own exception is kept as the previous exception. |
