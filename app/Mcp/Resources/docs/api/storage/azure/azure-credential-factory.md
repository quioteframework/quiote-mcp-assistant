# AzureCredentialFactory

> Builds the AzureCredential a config `auth` value asks for, so `quioteframework/session-azure` and `quioteframework/filesystem-azure` share one place that knows how to turn `shared_key` / `workload_identity` / `cli` / `chain` into an instance rather than each re-implementing the same branch.

Builds the [`AzureCredential`](/api/storage/azure/azure-credential/) a config `auth` value asks for, so `quioteframework/session-azure` and `quioteframework/filesystem-azure` share one place that knows how to turn `shared_key` / `workload_identity` / `cli` / `chain` into an instance rather than each re-implementing the same branch.

`workload_identity` and `cli` read their own configuration from the environment (the AKS webhook's variables, respectively an existing `az login` session): nothing beyond `auth` itself is required from `$config` for them. Only `shared_key` needs `account_key`.

## Synopsis

`final class AzureCredentialFactory`

|  |  |
|---|---|
| Source | `AzureCredentialFactory.php` |

## Methods

| Method | Description |
|---|---|
| [`fromConfig(array<string, string> $config, ClientInterface $httpClient, Psr17Factory $psr17 = new Psr17Factory(…), LoggerInterface $logger = new NullLogger(…)): AzureCredential`](#fromconfig) |  |

### fromConfig()

`public static function fromConfig(array<string, string> $config, ClientInterface $httpClient, Psr17Factory $psr17 = new Psr17Factory(…), LoggerInterface $logger = new NullLogger(…)): AzureCredential`

PSR-3, so a Quiote application can pass its own
       `Quiote\Logging\Log::for(...)` (it already implements the interface) without this
       package needing the framework as a dependency. Defaults to discarding everything.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `array``<``string``, ``string``>` | Keys: `auth` (default `shared_key`), `account_key`. |
| `$httpClient` | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |  |
| `$psr17` | `Psr17Factory` |  |
| `$logger` | [`LoggerInterface`](https://www.php-fig.org/psr/psr-3/) | PSR-3, so a Quiote application can pass its own `Quiote\Logging\Log::for(...)` (it already implements the interface) without this package needing the framework as a dependency. Defaults to discarding everything. |

Returns [`AzureCredential`](/api/storage/azure/azure-credential/)
