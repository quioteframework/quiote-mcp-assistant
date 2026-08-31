# AzureMonitorQueryClient

> Minimal Azure Monitor Query REST client: one KQL query against one Log Analytics workspace, nothing else.

Minimal Azure Monitor Query REST client: one KQL query against one Log Analytics workspace, nothing else.

Authenticates with a bearer [`AzureTokenProvider`](/api/storage/azure/azure-token-provider/) scoped to `https://api.loganalytics.io/` -- build one via [`AzureTokenProviderFactory`](/api/storage/azure/azure-token-provider-factory/), not [`AzureCredentialFactory`](/api/storage/azure/azure-credential-factory/), since this API takes no storage-account-key credential at all.

## Synopsis

`final class AzureMonitorQueryClient implements AzureMonitorQueryClientInterface`

|  |  |
|---|---|
| Implements | [`AzureMonitorQueryClientInterface`](/api/storage/azure/azure-monitor-query-client-interface/) |
| Source | `AzureMonitorQueryClient.php` |

## Constructor

### __construct()

`public function __construct(ClientInterface $httpClient, AzureTokenProvider $tokenProvider, string $workspaceId, string $endpoint = 'https://api.loganalytics.io', Psr17Factory $psr17 = new Psr17Factory(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$httpClient` | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |  |
| `$tokenProvider` | [`AzureTokenProvider`](/api/storage/azure/azure-token-provider/) |  |
| `$workspaceId` | `string` |  |
| `$endpoint` | `string` |  |
| `$psr17` | `Psr17Factory` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`query(string $kql): list<array<string, mixed>>`](#query) | Runs $kql and returns its primary result table as one row per array, keyed by column name. |

### query()

`public function query(string $kql): list<array<string, mixed>>`

Runs $kql and returns its primary result table as one row per array, keyed by column name.

An empty result set (including a query with no `tables` at all) is an empty list, not an error.

| Parameter | Type | Description |
|---|---|---|
| `$kql` | `string` |  |

Returns `list``<``array``<``string``, ``mixed``>``>`

| Throws | When |
|---|---|
| `AzureStorageException` | On a non-2xx response, a transport failure that survived the retries, or a response body that was not the JSON shape this expects. |
