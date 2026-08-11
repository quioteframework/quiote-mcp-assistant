# AzureFilesystemAdapter

> FilesystemAdapterInterface over AzureBlobClient (Shared-Key REST client), against a fixed container.

[`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) over [`AzureBlobClient`](/api/storage/azure/azure-blob-client/) (Shared-Key REST client), against a fixed container.

Azure takes the container per call where S3 and GCS bind the bucket to the client, so the client is wrapped in an [`AzureBlobContainerClient`](/api/storage/azure/azure-blob-container-client/) that binds it. Everything after that -- the path-to-key mapping, the error translation, container creation on first write -- is the shared behaviour in [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) and the container facade.

Not a [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/): the client has no list-blobs operation — see `Quiote\Filesystem\S3\S3FilesystemAdapter`'s docblock for the reasoning.

## Synopsis

`final readonly class AzureFilesystemAdapter extends ObjectStoreFilesystemAdapter`

|  |  |
|---|---|
| Extends | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) |
| Source | `AzureFilesystemAdapter.php` |

## Constructor

### __construct()

`public function __construct(ObjectStoreClientInterface $client, string $container, string $keyPrefix = ''): mixed`

Prepended to every path to form the object key.

| Parameter | Type | Description |
|---|---|---|
| `$client` | `ObjectStoreClientInterface` | The store, already bound to its bucket or container. |
| `$container` | `string` |  |
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
