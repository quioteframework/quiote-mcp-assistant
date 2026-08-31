# ListableObjectStoreFilesystemAdapter

> A ListableFilesystemInterface over any ListableObjectStoreClientInterface, everything but listing inherited unchanged from ObjectStoreFilesystemAdapter.

A [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/) over any [`ListableObjectStoreClientInterface`](/api/storage/listable-object-store-client-interface/), everything but listing inherited unchanged from [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/).

[`ListableObjectStoreFilesystemAdapter::listContents()`](/api/filesystem/listable-object-store-filesystem-adapter/#listcontents) treats $path the way a filesystem does even though the store underneath is flat: it lists with a `/` delimiter at the key one level below $path, so a deeper key never surfaces as if it were a direct child, then folds the store's own pagination away -- a caller gets one full, sorted list rather than having to drive continuation tokens itself. A prefix that groups into a "directory" comes back as a bare relative path, exactly like a subdirectory from [`LocalFilesystemAdapter::listContents()`](/api/filesystem/local-filesystem-adapter/#listcontents), not with its trailing delimiter.

A second, separately-typed reference to the same client this class was constructed with: [`ObjectStoreFilesystemAdapter::$client`](/api/filesystem/object-store-filesystem-adapter/#client) cannot be redeclared with a narrower type in PHP (property types are invariant across inheritance), so the listing-capable view of the identical object lives here instead.

## Synopsis

`readonly class ListableObjectStoreFilesystemAdapter extends ObjectStoreFilesystemAdapter implements ListableFilesystemInterface`

|  |  |
|---|---|
| Extends | [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) |
| Implements | [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/) |
| Since | `4.2.0` |
| Source | `ListableObjectStoreFilesystemAdapter.php` |

## Constructor

### __construct()

`public function __construct(ListableObjectStoreClientInterface $listableClient, string $providerName, string $keyPrefix = ''): mixed`

Prepended to every path to form the object key.

| Parameter | Type | Description |
|---|---|---|
| `$listableClient` | [`ListableObjectStoreClientInterface`](/api/storage/listable-object-store-client-interface/) |  |
| `$providerName` | `string` | Named in error messages, e.g. 'S3', 'GCS', 'Azure'. |
| `$keyPrefix` | `string` | Prepended to every path to form the object key. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`listContents(string $path = ''): list<string>`](#listcontents) | The entries directly under $path. |

### listContents()

`public function listContents(string $path = ''): list<string>`

The entries directly under $path.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `list``<``string``>` — Relative paths, non-recursive.

| Throws | When |
|---|---|
| `FilesystemStorageException` | If the store call itself failed. |

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
