# S3FilesystemAdapter

> FilesystemAdapterInterface over S3Client (SigV4 REST client, no aws-sdk-php).

[`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) over [`S3Client`](/api/storage/s3/s3-client/) (SigV4 REST client, no aws-sdk-php).

The path-to-key mapping and the error translation live in [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/), shared with the other object-store drivers; this class supplies the client and the provider name that appears in its messages.

Not a [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/): the client has no list-bucket operation, and a listing would mean paging ListObjectsV2 and folding CommonPrefixes back into relative paths — both more than this adapter should decide on a caller's behalf and, on a large prefix, more round-trips than a flat return value admits to. Applications that need a listing should keep it in their own database beside the record that owns the files, or drive [`S3Client::request()`](/api/storage/s3/s3-client/#request) — which signs an arbitrary request and returns the raw response — directly.

## Synopsis

`final readonly class S3FilesystemAdapter extends ObjectStoreFilesystemAdapter`

|  |  |
|---|---|
| Extends | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) |
| Source | `S3FilesystemAdapter.php` |

## Constructor

### __construct()

`public function __construct(ObjectStoreClientInterface $client, string $keyPrefix = ''): mixed`

Prepended to every path to form the object key.

| Parameter | Type | Description |
|---|---|---|
| `$client` | `ObjectStoreClientInterface` | The store, already bound to its bucket or container. |
| `$keyPrefix` | `string` | Prepended to every path to form the object key. |

Returns `mixed`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `delete()` | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) | Deletes the object under $path. |
| `exists()` | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) | Reports whether the store holds an object under $path. |
| `lastModified()` | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) | Returns the object's modification time, taken from its Last-Modified metadata. |
| `read()` | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) | Returns the body of the object stored under $path. |
| `size()` | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) | Returns the object's size in bytes, taken from its Content-Length metadata. |
| `write()` | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) | Stores $contents as the object under $path, replacing any existing object. |
