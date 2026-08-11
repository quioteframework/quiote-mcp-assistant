# GcsFilesystemAdapter

> FilesystemAdapterInterface over GcsClient (HMAC interop-key REST client, no google/cloud-storage).

[`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) over [`GcsClient`](/api/storage/gcs/gcs-client/) (HMAC interop-key REST client, no google/cloud-storage).

The path-to-key mapping and the error translation live in [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/), shared with the other object-store drivers; this class supplies the client and the provider name that appears in its messages.

Not a [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/): the client has no list-bucket operation — see `Quiote\Filesystem\S3\S3FilesystemAdapter`'s docblock for the reasoning.

## Synopsis

`final readonly class GcsFilesystemAdapter extends ObjectStoreFilesystemAdapter`

|  |  |
|---|---|
| Extends | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) |
| Source | `GcsFilesystemAdapter.php` |

## Constructor

### __construct()

`public function __construct(ObjectStoreClientInterface $client, string $objectPrefix = ''): mixed`

Prepended to every path to form the object key.

| Parameter | Type | Description |
|---|---|---|
| `$client` | `ObjectStoreClientInterface` | The store, already bound to its bucket or container. |
| `$objectPrefix` | `string` |  |

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
