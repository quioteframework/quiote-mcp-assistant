# S3FilesystemAdapter

> ListableFilesystemInterface over S3Client (SigV4 REST client, no aws-sdk-php).

[`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/) over [`S3Client`](/api/storage/s3/s3-client/) (SigV4 REST client, no aws-sdk-php).

The path-to-key mapping, the error translation and the listing (paging ListObjectsV2, folding CommonPrefixes back into relative paths) live in [`ListableObjectStoreFilesystemAdapter`](/api/filesystem/listable-object-store-filesystem-adapter/), shared with the other object-store drivers; this class supplies the client and the provider name that appears in its messages.

## Synopsis

`final readonly class S3FilesystemAdapter extends ListableObjectStoreFilesystemAdapter`

|  |  |
|---|---|
| Extends | [`ListableObjectStoreFilesystemAdapter`](/api/filesystem/listable-object-store-filesystem-adapter/) |
| Source | `S3FilesystemAdapter.php` |

## Constructor

### __construct()

`public function __construct(S3Client $client, string $keyPrefix = ''): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$client` | [`S3Client`](/api/storage/s3/s3-client/) |  |
| `$keyPrefix` | `string` |  |

Returns `mixed`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `delete()` | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) | Deletes the object under $path. |
| `exists()` | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) | Reports whether the store holds an object under $path. |
| `lastModified()` | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) | Returns the object's modification time, taken from its Last-Modified metadata. |
| `listContents()` | [`ListableObjectStoreFilesystemAdapter`](/api/filesystem/listable-object-store-filesystem-adapter/) |  |
| `read()` | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) | Returns the body of the object stored under $path. |
| `size()` | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) | Returns the object's size in bytes, taken from its Content-Length metadata. |
| `write()` | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) | Stores $contents as the object under $path, replacing any existing object. |
