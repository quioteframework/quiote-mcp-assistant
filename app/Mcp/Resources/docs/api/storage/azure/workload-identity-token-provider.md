# WorkloadIdentityTokenProvider

> Exchanges the projected service account token AKS's workload identity webhook mounts into the pod for a Storage-scoped Azure AD access token, via the OAuth2 JWT-bearer client-assertion flow.

Exchanges the projected service account token AKS's workload identity webhook mounts into the pod for a Storage-scoped Azure AD access token, via the OAuth2 JWT-bearer client-assertion flow.

Needs no secret: the assertion is the federated token file, not a client secret.

[`WorkloadIdentityTokenProvider::fromEnvironment()`](/api/storage/azure/workload-identity-token-provider/#fromenvironment) reads the four variables the webhook injects (`AZURE_TENANT_ID`, `AZURE_CLIENT_ID`, `AZURE_FEDERATED_TOKEN_FILE`, `AZURE_AUTHORITY_HOST`), the same ones the official Azure SDKs' `WorkloadIdentityCredential` reads, so a pod annotated for workload identity needs no Quiote-specific configuration at all.

## Synopsis

`final class WorkloadIdentityTokenProvider implements AzureTokenProvider`

|  |  |
|---|---|
| Implements | [`AzureTokenProvider`](/api/storage/azure/azure-token-provider/) |
| Source | `WorkloadIdentityTokenProvider.php` |

## Constructor

### __construct()

`public function __construct(ClientInterface $httpClient, string $tenantId, string $clientId, string $federatedTokenFile, string $authorityHost = 'https://login.microsoftonline.com/', Psr17Factory $psr17 = new Psr17Factory(…), string $scope = 'https://storage.azure.com/.default'): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$httpClient` | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |  |
| `$tenantId` | `string` |  |
| `$clientId` | `string` |  |
| `$federatedTokenFile` | `string` |  |
| `$authorityHost` | `string` |  |
| `$psr17` | `Psr17Factory` |  |
| `$scope` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromEnvironment(ClientInterface $httpClient, Psr17Factory $psr17 = new Psr17Factory(…), string $scope = 'https://storage.azure.com/.default'): WorkloadIdentityTokenProvider`](#fromenvironment) |  |
| [`getToken(): string`](#gettoken) |  |

### fromEnvironment()

`public static function fromEnvironment(ClientInterface $httpClient, Psr17Factory $psr17 = new Psr17Factory(…), string $scope = 'https://storage.azure.com/.default'): WorkloadIdentityTokenProvider`

| Parameter | Type | Description |
|---|---|---|
| `$httpClient` | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |  |
| `$psr17` | `Psr17Factory` |  |
| `$scope` | `string` |  |

Returns [`WorkloadIdentityTokenProvider`](/api/storage/azure/workload-identity-token-provider/)

| Throws | When |
|---|---|
| `AzureStorageException` | If any of the four AKS workload identity variables is missing from the environment. |

### getToken()

`public function getToken(): string`

Returns `string`
