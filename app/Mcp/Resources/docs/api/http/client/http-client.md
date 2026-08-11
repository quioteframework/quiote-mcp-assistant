# HttpClient

> The framework HTTP client: a PSR-18 `ClientInterface` wrapping an underlying transport, adding base-URI resolution, default headers, a transient-failure retry policy, ergonomic verb helpers, and — the payoff for the whole abstraction — the central egress seam for telemetry.

The framework HTTP client: a PSR-18 `ClientInterface` wrapping an underlying transport, adding base-URI resolution, default headers, a transient-failure retry policy, ergonomic verb helpers, and — the payoff for the whole abstraction — the central egress seam for telemetry.

Every outbound request opens a CLIENT-kind span and injects W3C `traceparent` so downstream services continue the trace (the outbound half of the request-tracing story, previously blocked on the absence of exactly this client).

Obtain instances via [`HttpClientFactory`](/api/http/client/http-client-factory/) (memoized, named) rather than constructing directly, so a worker reuses one client per name for its lifetime instead of rebuilding on every call.

## Synopsis

`final class HttpClient implements ClientInterface`

|  |  |
|---|---|
| Implements | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |
| Source | `Http/Client/HttpClient.php` |

## Constructor

### __construct()

`public function __construct(ClientInterface $transport, string $baseUri = '', array $defaultHeaders = [], int $retries = 0, int $retryBaseDelayMs = 100, Psr17Factory $psr17 = new Psr17Factory(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$transport` | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |  |
| `$baseUri` | `string` |  |
| `$defaultHeaders` | `array` |  |
| `$retries` | `int` |  |
| `$retryBaseDelayMs` | `int` |  |
| `$psr17` | `Psr17Factory` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(string $uri, array{headers?: array<string, string>} $options = []): ResponseInterface`](#delete) |  |
| [`fromConfig(HttpClientConfig $config): HttpClient`](#fromconfig) | Builds a client from a resolved [`HttpClientConfig`](/api/http/client/http-client-config/), taking its transport, base URI, default headers and retry policy. |
| [`get(string $uri, array{headers?: array<string, string>} $options = []): ResponseInterface`](#get) |  |
| [`post(string $uri, array{headers?: array<string, string>, body?: string} $options = []): ResponseInterface`](#post) |  |
| [`put(string $uri, array{headers?: array<string, string>, body?: string} $options = []): ResponseInterface`](#put) |  |
| [`request(string $method, string $uri, array{headers?: array<string, string>, body?: string} $options = []): ResponseInterface`](#request) | Ergonomic request builder. |
| [`sendRequest(RequestInterface $request): ResponseInterface`](#sendrequest) | PSR-18 entry point. |

### delete()

`public function delete(string $uri, array{headers?: array<string, string>} $options = []): ResponseInterface`

| Parameter | Type | Description |
|---|---|---|
| `$uri` | `string` |  |
| `$options` | `array{headers?: array<string, string>}` |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### fromConfig()

`public static function fromConfig(HttpClientConfig $config): HttpClient`

Builds a client from a resolved [`HttpClientConfig`](/api/http/client/http-client-config/), taking its transport, base URI, default headers and retry policy.

The PSR-17 factory is not configurable this way: the client uses its own default.

| Parameter | Type | Description |
|---|---|---|
| `$config` | [`HttpClientConfig`](/api/http/client/http-client-config/) |  |

Returns [`HttpClient`](/api/http/client/http-client/)

### get()

`public function get(string $uri, array{headers?: array<string, string>} $options = []): ResponseInterface`

| Parameter | Type | Description |
|---|---|---|
| `$uri` | `string` |  |
| `$options` | `array{headers?: array<string, string>}` |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### post()

`public function post(string $uri, array{headers?: array<string, string>, body?: string} $options = []): ResponseInterface`

| Parameter | Type | Description |
|---|---|---|
| `$uri` | `string` |  |
| `$options` | `array{headers?: array<string, string>, body?: string}` |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### put()

`public function put(string $uri, array{headers?: array<string, string>, body?: string} $options = []): ResponseInterface`

| Parameter | Type | Description |
|---|---|---|
| `$uri` | `string` |  |
| `$options` | `array{headers?: array<string, string>, body?: string}` |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### request()

`public function request(string $method, string $uri, array{headers?: array<string, string>, body?: string} $options = []): ResponseInterface`

Ergonomic request builder.

| Parameter | Type | Description |
|---|---|---|
| `$method` | `string` |  |
| `$uri` | `string` |  |
| `$options` | `array{headers?: array<string, string>, body?: string}` |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### sendRequest()

`public function sendRequest(RequestInterface $request): ResponseInterface`

PSR-18 entry point.

Applies default headers, telemetry, and the retry policy.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`RequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
