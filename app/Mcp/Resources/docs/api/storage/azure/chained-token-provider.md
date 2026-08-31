# ChainedTokenProvider

> Tries each provider in order and answers the first token obtained, the way the official Azure SDKs' `DefaultAzureCredential` chains workload identity, then the CLI, then further sources.

Tries each provider in order and answers the first token obtained, the way the official Azure SDKs' `DefaultAzureCredential` chains workload identity, then the CLI, then further sources.

Falling through to the next provider is the designed behaviour here, not a degradation, so a provider's failure is logged at debug rather than warning.

## Synopsis

`final class ChainedTokenProvider implements AzureTokenProvider`

|  |  |
|---|---|
| Implements | [`AzureTokenProvider`](/api/storage/azure/azure-token-provider/) |
| Source | `ChainedTokenProvider.php` |

## Constructor

### __construct()

`public function __construct(non-empty-list<AzureTokenProvider> $providers, LoggerInterface $logger = new NullLogger(…)): mixed`

PSR-3, so a Quiote application can pass its own
       `Quiote\Logging\Log::for(...)` (it already implements the interface) without this
       package needing the framework as a dependency. Defaults to discarding everything.

| Parameter | Type | Description |
|---|---|---|
| `$providers` | `non-empty-list``<`[`AzureTokenProvider`](/api/storage/azure/azure-token-provider/)`>` |  |
| `$logger` | [`LoggerInterface`](https://www.php-fig.org/psr/psr-3/) | PSR-3, so a Quiote application can pass its own `Quiote\Logging\Log::for(...)` (it already implements the interface) without this package needing the framework as a dependency. Defaults to discarding everything. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getToken(): string`](#gettoken) |  |

### getToken()

`public function getToken(): string`

Returns `string`
