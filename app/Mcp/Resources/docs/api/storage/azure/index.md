# Azure

> The Quiote\\Storage\\Azure namespace — 21 documented types.

Everything under `Quiote\Storage\Azure`.

## Classes

| Class | Description |
|---|---|
| [`AzureBlobClient`](/api/storage/azure/azure-blob-client/) | Minimal Azure Blob Storage REST client, deliberately not built on the official `microsoft/azure-storage-blob` SDK (Microsoft stopped actively developing it; a hand-rolled client against the documented REST API has proven more maintainable in production). |
| [`AzureBlobContainerClient`](/api/storage/azure/azure-blob-container-client/) | [`AzureBlobClient`](/api/storage/azure/azure-blob-client/) bound to one container, so it satisfies [`ListableObjectStoreClientInterface`](/api/storage/listable-object-store-client-interface/) like the S3 and GCS clients do. |
| [`AzureBlobSessionFactory`](/api/storage/azure/azure-blob-session-factory/) | `session` slot factory for [`AzureBlobSessionPersistence`](/api/storage/azure/azure-blob-session-persistence/). |
| [`AzureBlobSessionPersistence`](/api/storage/azure/azure-blob-session-persistence/) | [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) storing one JSON blob per session id (named `<sid>.json`) in a single Azure Blob container. |
| [`AzureCliTokenProvider`](/api/storage/azure/azure-cli-token-provider/) | Reuses whatever identity a developer already authenticated with `az login`, by shelling out to `az account get-access-token`. |
| [`AzureCredentialFactory`](/api/storage/azure/azure-credential-factory/) | Builds the [`AzureCredential`](/api/storage/azure/azure-credential/) a config `auth` value asks for, so `quioteframework/session-azure` and `quioteframework/filesystem-azure` share one place that knows how to turn `shared_key` / `workload_identity` / `cli` / `chain` into an instance rather than each re-implementing the same branch. |
| [`AzureMonitorQueryClient`](/api/storage/azure/azure-monitor-query-client/) | Minimal Azure Monitor Query REST client: one KQL query against one Log Analytics workspace, nothing else. |
| [`AzureStorageException`](/api/storage/azure/azure-storage-exception/) | A failure talking to Azure storage. |
| [`AzureTableClient`](/api/storage/azure/azure-table-client/) | Minimal Azure Table Storage REST client using the Table service's "Shared Key Lite" authentication scheme — a cheaper option than Blob Storage for small key/value-shaped session payloads (no per-account container needed; entities are addressed by table + partition/row key). |
| [`AzureTableSessionFactory`](/api/storage/azure/azure-table-session-factory/) | `session` slot factory for [`AzureTableSessionPersistence`](/api/storage/azure/azure-table-session-persistence/). |
| [`AzureTableSessionPersistence`](/api/storage/azure/azure-table-session-persistence/) | [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) storing one entity per session id in a single Azure Table Storage table — cheaper than [`AzureBlobSessionPersistence`](/api/storage/azure/azure-blob-session-persistence/) for small key/value-shaped session payloads, with no per-account container to manage. |
| [`AzureTokenProviderFactory`](/api/storage/azure/azure-token-provider-factory/) | Builds a bare [`AzureTokenProvider`](/api/storage/azure/azure-token-provider/) for whichever `auth` a config value asks for, scoped to an arbitrary AAD resource -- not only storage. |
| [`BearerCredential`](/api/storage/azure/bearer-credential/) | Azure AD authentication: every request carries `Authorization: Bearer {token}`, the token itself coming from an [`AzureTokenProvider`](/api/storage/azure/azure-token-provider/) (workload identity, the Azure CLI, or a chain of both). |
| [`ChainedTokenProvider`](/api/storage/azure/chained-token-provider/) | Tries each provider in order and answers the first token obtained, the way the official Azure SDKs' `DefaultAzureCredential` chains workload identity, then the CLI, then further sources. |
| [`ProcOpenAzureCliProcessRunner`](/api/storage/azure/proc-open-azure-cli-process-runner/) | Default [`AzureCliProcessRunner`](/api/storage/azure/azure-cli-process-runner/): runs the command directly via `proc_open()`'s array form, never through a shell, so there is nothing for the fixed, argument-free `az` invocation to inject into. |
| [`SharedKeyCredential`](/api/storage/azure/shared-key-credential/) | Shared Key authentication: signs every request with an HMAC-SHA256 over the storage account key, the way [`AzureBlobClient`](/api/storage/azure/azure-blob-client/) always used to before [`AzureCredential`](/api/storage/azure/azure-credential/) existed. |
| [`WorkloadIdentityTokenProvider`](/api/storage/azure/workload-identity-token-provider/) | Exchanges the projected service account token AKS's workload identity webhook mounts into the pod for a Storage-scoped Azure AD access token, via the OAuth2 JWT-bearer client-assertion flow. |

## Interfaces

| Interface | Description |
|---|---|
| [`AzureCliProcessRunner`](/api/storage/azure/azure-cli-process-runner/) | Runs one command and returns its standard output, so [`AzureCliTokenProvider`](/api/storage/azure/azure-cli-token-provider/) can be exercised in tests without actually shelling out to `az`. |
| [`AzureCredential`](/api/storage/azure/azure-credential/) | Produces the `Authorization` header value for one [`AzureBlobClient`](/api/storage/azure/azure-blob-client/) request. |
| [`AzureMonitorQueryClientInterface`](/api/storage/azure/azure-monitor-query-client-interface/) | A single KQL query against one Log Analytics workspace. |
| [`AzureTokenProvider`](/api/storage/azure/azure-token-provider/) | Produces an Azure AD access token for whichever resource its implementation was built for, caching and refreshing it however fits the source (a token exchange, a CLI call, a chain of both). |
