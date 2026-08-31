# SharedKeyCredential

> Shared Key authentication: signs every request with an HMAC-SHA256 over the storage account key, the way AzureBlobClient always used to before AzureCredential existed.

Shared Key authentication: signs every request with an HMAC-SHA256 over the storage account key, the way [`AzureBlobClient`](/api/storage/azure/azure-blob-client/) always used to before [`AzureCredential`](/api/storage/azure/azure-credential/) existed.

## Synopsis

`final class SharedKeyCredential implements AzureCredential`

|  |  |
|---|---|
| Implements | [`AzureCredential`](/api/storage/azure/azure-credential/) |
| Source | `SharedKeyCredential.php` |

## Constructor

### __construct()

`public function __construct(string $accountKey): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$accountKey` | `string` |  |

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
