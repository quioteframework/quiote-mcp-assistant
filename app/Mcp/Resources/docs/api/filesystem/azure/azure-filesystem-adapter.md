# AzureFilesystemAdapter

> ListableFilesystemInterface over AzureBlobClient, against a fixed container.

[`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/) over [`AzureBlobClient`](/api/storage/azure/azure-blob-client/), against a fixed container.

Azure takes the container per call where S3 and GCS bind the bucket to the client, so the client is wrapped in an [`AzureBlobContainerClient`](/api/storage/azure/azure-blob-container-client/) that binds it. Everything after that, the path-to-key mapping, the error translation, container creation on first write, the listing, is the shared behaviour in [`ListableObjectStoreFilesystemAdapter`](/api/filesystem/listable-object-store-filesystem-adapter/) and the container facade.

## Synopsis

`final readonly class AzureFilesystemAdapter extends ListableObjectStoreFilesystemAdapter`

|  |  |
|---|---|
| Extends | [`ListableObjectStoreFilesystemAdapter`](/api/filesystem/listable-object-store-filesystem-adapter/) |
| Source | `AzureFilesystemAdapter.php` |

## Constructor

### __construct()

`public function __construct(AzureBlobClient $client, string $container, string $keyPrefix = ''): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$client` | [`AzureBlobClient`](/api/storage/azure/azure-blob-client/) |  |
| `$container` | `string` |  |
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
