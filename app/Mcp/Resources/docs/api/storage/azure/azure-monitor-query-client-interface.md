# AzureMonitorQueryClientInterface

> A single KQL query against one Log Analytics workspace.

A single KQL query against one Log Analytics workspace.

Split from [`AzureMonitorQueryClient`](/api/storage/azure/azure-monitor-query-client/) so a consumer like `quioteframework/replay-azure`'s `LogAnalyticsIndex` depends on the one operation it actually calls, not the concrete REST client -- the same shape [`AzureTokenProvider`](/api/storage/azure/azure-token-provider/) already gives token providers.

## Synopsis

`interface AzureMonitorQueryClientInterface`

|  |  |
|---|---|
| Implemented by | [`AzureMonitorQueryClient`](/api/storage/azure/azure-monitor-query-client/) |
| Source | `AzureMonitorQueryClientInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`query(string $kql): list<array<string, mixed>>`](#query) | Runs $kql and returns its primary result table as one row per array, keyed by column name. |

### query()

`abstract public function query(string $kql): list<array<string, mixed>>`

Runs $kql and returns its primary result table as one row per array, keyed by column name.

An empty result set (including a query with no `tables` at all) is an empty list, not an error.

| Parameter | Type | Description |
|---|---|---|
| `$kql` | `string` |  |

Returns `list``<``array``<``string``, ``mixed``>``>`

| Throws | When |
|---|---|
| `AzureStorageException` | On a non-2xx response, a transport failure that survived the retries, or a response body that was not the JSON shape this expects. |
