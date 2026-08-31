# AzureCredential

> Produces the `Authorization` header value for one AzureBlobClient request.

Produces the `Authorization` header value for one [`AzureBlobClient`](/api/storage/azure/azure-blob-client/) request.

Shared Key needs the full request shape to compute a signature; a bearer-token strategy needs none of it and answers the same header for every call. Both fit through this one seam so [`AzureBlobClient::send()`](/api/storage/azure/azure-blob-client/#send) never branches on which kind of credential it was given.

## Synopsis

`interface AzureCredential`

|  |  |
|---|---|
| Implemented by | [`BearerCredential`](/api/storage/azure/bearer-credential/), [`SharedKeyCredential`](/api/storage/azure/shared-key-credential/) |
| Source | `AzureCredential.php` |

## Methods

| Method | Description |
|---|---|
| [`authorizationHeader(string $accountName, string $method, string $path, array<string, string> $query, array<string, string> $headers): string`](#authorizationheader) |  |

### authorizationHeader()

`abstract public function authorizationHeader(string $accountName, string $method, string $path, array<string, string> $query, array<string, string> $headers): string`

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
