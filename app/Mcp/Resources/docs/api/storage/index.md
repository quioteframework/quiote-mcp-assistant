# Storage

> The Quiote\\Storage namespace — 35 documented types.

Everything under `Quiote\Storage`.

## Classes

| Class | Description |
|---|---|
| [`ObjectListing`](/api/storage/object-listing/) | One page of [`ListableObjectStoreClientInterface::listObjects()`](/api/storage/listable-object-store-client-interface/#listobjects). |
| [`ObjectMetadata`](/api/storage/object-metadata/) | The subset of a stored object's HEAD response worth typing: everything else a provider returns (storage class, versioning, generation, SSE and custom metadata headers) is available from the raw response via the client's own `request()` method for callers that need it. |
| [`ObjectStoreException`](/api/storage/object-store-exception/) | A failure talking to an object store. |
| [`ObjectSummary`](/api/storage/object-summary/) | One entry in a [`ObjectListing`](/api/storage/object-listing/): the same three metadata fields [`ObjectMetadata`](/api/storage/object-metadata/) carries for a single object, plus the key they describe, so a listing result and a [`ObjectStoreClientInterface::head()`](/api/storage/object-store-client-interface/#head) result read the same way. |

## Interfaces

| Interface | Description |
|---|---|
| [`ListableObjectStoreClientInterface`](/api/storage/listable-object-store-client-interface/) | An [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) whose store can also enumerate what it holds. |
| [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) | Read, write, remove and stat a single object in a flat keyed store. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Azure`](/api/storage/azure/) | 21 types |
| [`Gcs`](/api/storage/gcs/) | 4 types |
| [`S3`](/api/storage/s3/) | 4 types |
