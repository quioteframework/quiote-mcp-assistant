# HttpClientConfig

> Mutable, fluent configuration for a named HTTP client, populated inside a HttpClientFactory::configure() callback (the dotnet `AddHttpClient(\"name\", c => ...)` analogue).

Mutable, fluent configuration for a named HTTP client, populated inside a [`HttpClientFactory::configure()`](/api/http/client/http-client-factory/#configure) callback (the dotnet `AddHttpClient("name", c => ...)` analogue).

Turned into an immutable [`HttpClient`](/api/http/client/http-client/) once, then memoized by the factory.

## Synopsis

`final class HttpClientConfig`

|  |  |
|---|---|
| Source | `Http/Client/HttpClientConfig.php` |

## Methods

| Method | Description |
|---|---|
| [`baseUri(string $baseUri): HttpClientConfig`](#baseuri) | Base URI prepended to relative request paths (e.g. |
| [`getBaseUri(): string`](#getbaseuri) | Returns the configured base URI with any trailing slash removed, or an empty string when none was set. |
| [`getHeaders(): array<string, string>`](#getheaders) |  |
| [`getRetries(): int`](#getretries) | Returns how many extra attempts a transient failure earns; zero, the default, means no retrying. |
| [`getRetryBaseDelayMs(): int`](#getretrybasedelayms) | Returns the first backoff delay in milliseconds, from which later retries grow exponentially; 100 unless [`HttpClientConfig::retry()`](/api/http/client/http-client-config/#retry) changed it. |
| [`getTransport(): ClientInterface`](#gettransport) | Returns the PSR-18 transport this client will use. |
| [`header(string $name, string $value): HttpClientConfig`](#header) | A default header sent with every request unless the request already sets it. |
| [`headers(array<string, string> $headers): HttpClientConfig`](#headers) |  |
| [`retry(int $attempts, int $baseDelayMs = 100): HttpClientConfig`](#retry) | Retry transient failures (network errors, HTTP 429, HTTP 5xx) up to $attempts extra times, with exponential backoff from $baseDelayMs. |
| [`transport(ClientInterface $transport): HttpClientConfig`](#transport) | Override the underlying PSR-18 transport for this client (default: [`TransportFactory::default()`](/api/http/client/transport-factory/#default)). |

### baseUri()

`public function baseUri(string $baseUri): HttpClientConfig`

Base URI prepended to relative request paths (e.g.

"https://api.example.com").

| Parameter | Type | Description |
|---|---|---|
| `$baseUri` | `string` |  |

Returns [`HttpClientConfig`](/api/http/client/http-client-config/)

### getBaseUri()

`public function getBaseUri(): string`

Returns the configured base URI with any trailing slash removed, or an empty string when none was set.

Returns `string`

### getHeaders()

`public function getHeaders(): array<string, string>`

Returns `array``<``string``, ``string``>`

### getRetries()

`public function getRetries(): int`

Returns how many extra attempts a transient failure earns; zero, the default, means no retrying.

Returns `int`

### getRetryBaseDelayMs()

`public function getRetryBaseDelayMs(): int`

Returns the first backoff delay in milliseconds, from which later retries grow exponentially; 100 unless [`HttpClientConfig::retry()`](/api/http/client/http-client-config/#retry) changed it.

Returns `int`

### getTransport()

`public function getTransport(): ClientInterface`

Returns the PSR-18 transport this client will use.

When [`HttpClientConfig::transport()`](/api/http/client/http-client-config/#transport) was never called, [`TransportFactory::default()`](/api/http/client/transport-factory/#default) is asked for one and the result is memoised, so every request from this config shares a transport.

Returns [`ClientInterface`](https://www.php-fig.org/psr/psr-18/)

### header()

`public function header(string $name, string $value): HttpClientConfig`

A default header sent with every request unless the request already sets it.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `string` |  |

Returns [`HttpClientConfig`](/api/http/client/http-client-config/)

### headers()

`public function headers(array<string, string> $headers): HttpClientConfig`

| Parameter | Type | Description |
|---|---|---|
| `$headers` | `array``<``string``, ``string``>` |  |

Returns [`HttpClientConfig`](/api/http/client/http-client-config/)

### retry()

`public function retry(int $attempts, int $baseDelayMs = 100): HttpClientConfig`

Retry transient failures (network errors, HTTP 429, HTTP 5xx) up to $attempts extra times, with exponential backoff from $baseDelayMs.

| Parameter | Type | Description |
|---|---|---|
| `$attempts` | `int` |  |
| `$baseDelayMs` | `int` |  |

Returns [`HttpClientConfig`](/api/http/client/http-client-config/)

### transport()

`public function transport(ClientInterface $transport): HttpClientConfig`

Override the underlying PSR-18 transport for this client (default: [`TransportFactory::default()`](/api/http/client/transport-factory/#default)).

| Parameter | Type | Description |
|---|---|---|
| `$transport` | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |  |

Returns [`HttpClientConfig`](/api/http/client/http-client-config/)
