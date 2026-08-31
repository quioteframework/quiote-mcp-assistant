# ListableObjectStoreClientInterface

> An ObjectStoreClientInterface whose store can also enumerate what it holds.

An [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) whose store can also enumerate what it holds.

Separate from the base contract for the same reason [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/) is separate from [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/): a consumer that only needs get/put/delete/head should not have to know whether the store behind the interface can list, and one that does need listing should fail to wire up rather than fail at first call.

Pagination, prefix/delimiter grouping and per-entry metadata are normalized the same way across providers even though S3 (an opaque continuation token), GCS and Azure (both a marker, echoed back as [`ObjectListing::$nextContinuationToken`](/api/storage/object-listing/#nextcontinuationtoken)) each name and shape it differently on the wire.

## Synopsis

`interface ListableObjectStoreClientInterface extends ObjectStoreClientInterface`

|  |  |
|---|---|
| Implements | [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) |
| Implemented by | [`AzureBlobContainerClient`](/api/storage/azure/azure-blob-container-client/), [`GcsClient`](/api/storage/gcs/gcs-client/), [`S3Client`](/api/storage/s3/s3-client/) |
| Since | `4.2.0` |
| Source | `ListableObjectStoreClientInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`listObjects(string $prefix = '', string $delimiter = '', ?string $continuationToken = null, int $maxKeys = 1000): ObjectListing`](#listobjects) | Lists up to $maxKeys keys starting with $prefix, oldest API quirks aside the same one page at a time on every provider. |

### listObjects()

`abstract public function listObjects(string $prefix = '', string $delimiter = '', ?string $continuationToken = null, int $maxKeys = 1000): ObjectListing`

Lists up to $maxKeys keys starting with $prefix, oldest API quirks aside the same one page at a time on every provider.

With $delimiter empty, every matching key comes back as an [`ObjectSummary`](/api/storage/object-summary/) in [`ObjectListing::$objects`](/api/storage/object-listing/#objects) -- a fully recursive listing. With $delimiter set, a key is only listed that way when $prefix (plus nothing else) reaches it before the first occurrence of $delimiter; everything past that point is collapsed into one entry per distinct prefix-up-to-and-including-the-delimiter in [`ObjectListing::$commonPrefixes`](/api/storage/object-listing/#commonprefixes) instead -- the "one directory level" view every provider's own console uses.

$continuationToken must be null on the first call and, for a truncated result, [`ObjectListing::$nextContinuationToken`](/api/storage/object-listing/#nextcontinuationtoken) verbatim on the next -- it is opaque, provider specific, and never meant to be inspected or constructed by a caller.

| Parameter | Type | Description |
|---|---|---|
| `$prefix` | `string` |  |
| `$delimiter` | `string` |  |
| `$continuationToken` | `?``string` |  |
| `$maxKeys` | `int` |  |

Returns [`ObjectListing`](/api/storage/object-listing/)

| Throws | When |
|---|---|
| `ObjectStoreException` | On a transport or provider failure. |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `delete()` | [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) | Remove the object at $key. |
| `get()` | [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) | The object's contents, or null when no object exists at $key. |
| `head()` | [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) | The object's metadata, or null when no object exists at $key. |
| `put()` | [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) | Create or replace the object at $key. |
