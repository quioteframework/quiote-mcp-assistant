# Azure

> The Quiote\\Storage\\Azure namespace — 8 documented types.

Everything under `Quiote\Storage\Azure`.

## Classes

| Class | Description |
|---|---|
| [`AzureBlobClient`](/api/storage/azure/azure-blob-client/) | Minimal Azure Blob Storage REST client using Shared Key authentication — deliberately not built on the official `microsoft/azure-storage-blob` SDK (Microsoft stopped actively developing it; a hand-rolled client against the documented REST + signing algorithm has proven more maintainable in production). |
| [`AzureBlobContainerClient`](/api/storage/azure/azure-blob-container-client/) | [`AzureBlobClient`](/api/storage/azure/azure-blob-client/) bound to one container, so it satisfies [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) like the S3 and GCS clients do. |
| [`AzureBlobSessionFactory`](/api/storage/azure/azure-blob-session-factory/) | `session` slot factory for [`AzureBlobSessionPersistence`](/api/storage/azure/azure-blob-session-persistence/). |
| [`AzureBlobSessionPersistence`](/api/storage/azure/azure-blob-session-persistence/) | [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) storing one JSON blob per session id (named `<sid>.json`) in a single Azure Blob container. |
| [`AzureStorageException`](/api/storage/azure/azure-storage-exception/) | A failure talking to Azure storage. |
| [`AzureTableClient`](/api/storage/azure/azure-table-client/) | Minimal Azure Table Storage REST client using the Table service's "Shared Key Lite" authentication scheme — a cheaper option than Blob Storage for small key/value-shaped session payloads (no per-account container needed; entities are addressed by table + partition/row key). |
| [`AzureTableSessionFactory`](/api/storage/azure/azure-table-session-factory/) | `session` slot factory for [`AzureTableSessionPersistence`](/api/storage/azure/azure-table-session-persistence/). |
| [`AzureTableSessionPersistence`](/api/storage/azure/azure-table-session-persistence/) | [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) storing one entity per session id in a single Azure Table Storage table — cheaper than [`AzureBlobSessionPersistence`](/api/storage/azure/azure-blob-session-persistence/) for small key/value-shaped session payloads, with no per-account container to manage. |
