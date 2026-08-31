# AzureTokenProviderFactory

> Builds a bare AzureTokenProvider for whichever `auth` a config value asks for, scoped to an arbitrary AAD resource -- not only storage.

Builds a bare [`AzureTokenProvider`](/api/storage/azure/azure-token-provider/) for whichever `auth` a config value asks for, scoped to an arbitrary AAD resource -- not only storage.

[`AzureCredentialFactory`](/api/storage/azure/azure-credential-factory/) is the storage-flavoured caller (it wraps the result in a [`BearerCredential`](/api/storage/azure/bearer-credential/)); a caller authenticating against a different AAD-protected API (Log Analytics, another Azure REST surface) resolves its own [`AzureTokenProvider`](/api/storage/azure/azure-token-provider/) straight from here instead.

`shared_key` is deliberately not one of the strategies this factory knows: it is a request-signing scheme tied to a storage account key, not a bearer token, and has no meaning for an API that only accepts Azure AD tokens.

## Synopsis

`final class AzureTokenProviderFactory`

|  |  |
|---|---|
| Source | `AzureTokenProviderFactory.php` |

## Methods

| Method | Description |
|---|---|
| [`fromConfig(array<string, string> $config, ClientInterface $httpClient, string $resource = Quiote\Storage\Azure\AzureTokenProvider::STORAGE_RESOURCE, Psr17Factory $psr17 = new Psr17Factory(…), LoggerInterface $logger = new NullLogger(…)): AzureTokenProvider`](#fromconfig) |  |

### fromConfig()

`public static function fromConfig(array<string, string> $config, ClientInterface $httpClient, string $resource = Quiote\Storage\Azure\AzureTokenProvider::STORAGE_RESOURCE, Psr17Factory $psr17 = new Psr17Factory(…), LoggerInterface $logger = new NullLogger(…)): AzureTokenProvider`

PSR-3, so a Quiote application can pass its own
       `Quiote\Logging\Log::for(...)` without this package needing the framework as a
       dependency. Defaults to discarding everything.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `array``<``string``, ``string``>` | Keys: `auth` (`workload_identity` \| `cli` \| `chain`). |
| `$httpClient` | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |  |
| `$resource` | `string` | The `az account get-access-token --resource` form: an https URL ending in `/`. The client-credentials `scope` used for `workload_identity`/`chain` is derived from this by appending `.default`, per [`AzureTokenProvider`](/api/storage/azure/azure-token-provider/)'s own docblock. |
| `$psr17` | `Psr17Factory` |  |
| `$logger` | [`LoggerInterface`](https://www.php-fig.org/psr/psr-3/) | PSR-3, so a Quiote application can pass its own `Quiote\Logging\Log::for(...)` without this package needing the framework as a dependency. Defaults to discarding everything. |

Returns [`AzureTokenProvider`](/api/storage/azure/azure-token-provider/)
