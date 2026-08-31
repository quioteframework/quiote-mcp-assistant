# BearerCredential

> Azure AD authentication: every request carries `Authorization: Bearer {token}`, the token itself coming from an AzureTokenProvider (workload identity, the Azure CLI, or a chain of both).

Azure AD authentication: every request carries `Authorization: Bearer {token}`, the token itself coming from an [`AzureTokenProvider`](/api/storage/azure/azure-token-provider/) (workload identity, the Azure CLI, or a chain of both).

No storage account key is ever read or needed.

## Synopsis

`final class BearerCredential implements AzureCredential`

|  |  |
|---|---|
| Implements | [`AzureCredential`](/api/storage/azure/azure-credential/) |
| Source | `BearerCredential.php` |

## Constructor

### __construct()

`public function __construct(AzureTokenProvider $tokenProvider): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$tokenProvider` | [`AzureTokenProvider`](/api/storage/azure/azure-token-provider/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`authorizationHeader(string $accountName, string $method, string $path, array<string, string> $query, array<string, string> $headers): string`](#authorizationheader) |  |

### authorizationHeader()

`public function authorizationHeader(string $accountName, string $method, string $path, array<string, string> $query, array<string, string> $headers): string`

The request's headers, including `x-ms-date` and
                                       `x-ms-version`, before `Authorization` is added.

| Parameter | Type | Description |
|---|---|---|
| `$accountName` | `string` |  |
| `$method` | `string` |  |
| `$path` | `string` |  |
| `$query` | `array``<``string``, ``string``>` | Signed as part of the canonicalized resource. |
| `$headers` | `array``<``string``, ``string``>` | The request's headers, including `x-ms-date` and `x-ms-version`, before `Authorization` is added. |

Returns `string`
