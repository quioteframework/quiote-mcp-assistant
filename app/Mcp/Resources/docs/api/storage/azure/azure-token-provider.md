# AzureTokenProvider

> Produces an Azure AD access token for whichever resource its implementation was built for, caching and refreshing it however fits the source (a token exchange, a CLI call, a chain of both).

Produces an Azure AD access token for whichever resource its implementation was built for, caching and refreshing it however fits the source (a token exchange, a CLI call, a chain of both).

`STORAGE_RESOURCE` is every implementation's own default, since Blob/Table storage is what [`AzureCredentialFactory`](/api/storage/azure/azure-credential-factory/) builds one for; a caller that needs a token for a different AAD-protected API (e.g. Log Analytics) passes its own resource/scope instead, via [`AzureTokenProviderFactory`](/api/storage/azure/azure-token-provider-factory/) or a provider's constructor directly.

## Synopsis

`interface AzureTokenProvider`

|  |  |
|---|---|
| Implemented by | [`AzureCliTokenProvider`](/api/storage/azure/azure-cli-token-provider/), [`ChainedTokenProvider`](/api/storage/azure/chained-token-provider/), [`WorkloadIdentityTokenProvider`](/api/storage/azure/workload-identity-token-provider/) |
| Source | `AzureTokenProvider.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `STORAGE_RESOURCE` | `'https://storage.azure.com/'` | The `az account get-access-token --resource` form: an https URL ending in `/`. |

## Methods

| Method | Description |
|---|---|
| [`getToken(): string`](#gettoken) |  |

### getToken()

`abstract public function getToken(): string`

Returns `string`

| Throws | When |
|---|---|
| `AzureStorageException` | If no token could be obtained. |
