# AzureCliTokenProvider

> Reuses whatever identity a developer already authenticated with `az login`, by shelling out to `az account get-access-token`.

Reuses whatever identity a developer already authenticated with `az login`, by shelling out to `az account get-access-token`.

Meant for local development against a real storage account without ever handing out an account key.

The CLI already caches and refreshes its own token, so rather than parse its locale-formatted `expiresOn` this re-invokes it on a short, fixed TTL: the extra call is cheap and always correct, where parsing a datetime the CLI does not promise a stable format for would not be.

## Synopsis

`final class AzureCliTokenProvider implements AzureTokenProvider`

|  |  |
|---|---|
| Implements | [`AzureTokenProvider`](/api/storage/azure/azure-token-provider/) |
| Source | `AzureCliTokenProvider.php` |

## Constructor

### __construct()

`public function __construct(AzureCliProcessRunner $processRunner = new ProcOpenAzureCliProcessRunner(…), string $resource = self::STORAGE_RESOURCE): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$processRunner` | [`AzureCliProcessRunner`](/api/storage/azure/azure-cli-process-runner/) |  |
| `$resource` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getToken(): string`](#gettoken) |  |

### getToken()

`public function getToken(): string`

Returns `string`
