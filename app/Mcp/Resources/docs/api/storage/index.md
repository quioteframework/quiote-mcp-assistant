# Storage

> The Quiote\\Storage namespace — 19 documented types.

Everything under `Quiote\Storage`.

## Classes

| Class | Description |
|---|---|
| [`ObjectMetadata`](/api/storage/object-metadata/) | The subset of a stored object's HEAD response worth typing: everything else a provider returns (storage class, versioning, generation, SSE and custom metadata headers) is available from the raw response via the client's own `request()` method for callers that need it. |
| [`ObjectStoreException`](/api/storage/object-store-exception/) | A failure talking to an object store. |

## Interfaces

| Interface | Description |
|---|---|
| [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) | Read, write, remove and stat a single object in a flat keyed store. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Azure`](/api/storage/azure/) | 8 types |
| [`Gcs`](/api/storage/gcs/) | 4 types |
| [`S3`](/api/storage/s3/) | 4 types |
