# HTTP client

> Named PSR-18 HTTP clients — configuration, retries, transports, and automatic trace propagation.

Quiote ships a PSR-18 HTTP client for outbound requests. It's a **named-client factory** (modelled on .NET's `IHttpClientFactory`): you configure a client once by name, resolve it by name, and the same instance is reused for the worker's lifetime rather than rebuilt per call. It's also the central egress seam that makes **outbound trace propagation** and CLIENT spans work (see [Telemetry](/architecture/telemetry/)).

Nothing here is on by default — the client is opt-in, and its default transport is a zero-dependency curl PSR-18 client. If Guzzle (which is a PSR-18 client) is installed, it's used automatically; it's never required.

## Configuring a named client

Clients are configured in code rather than in a `Config/*` file. The usual home for that call is a [plugin](/architecture/plugins/)'s `register()` method — the registrar exposes `httpClient()` for exactly this (shown in [Resolving the factory](#resolving-the-factory) below) — so every client is defined once at boot and resolved by name anywhere afterwards.

Register a named client's configuration on the `HttpClientFactory`, then resolve it:

```php
use Quiote\Http\Client\{HttpClientFactory, HttpClientConfig};

$factory->configure('github', function (HttpClientConfig $c): void {
    $c->baseUri('https://api.github.com')
      ->header('Accept', 'application/vnd.github+json')
      ->retry(attempts: 3, baseDelayMs: 100);
});

$response = $factory->client('github')->get('/repos/quioteframework/quiote');
```

`client($name)` builds the client on first use and memoizes it; `client()` with no name resolves the `default` client. The configurator runs lazily, once.

`HttpClientConfig` methods:

| Method | Effect |
|---|---|
| `baseUri(string)` | Prefix for relative request URIs. |
| `header(string $name, string $value)` | A default header sent on every request. |
| `headers(array)` | Multiple default headers at once. |
| `retry(int $attempts, int $baseDelayMs = 100)` | Retry policy — retries transient failures (network errors, 429, 5xx) with backoff. |
| `transport(ClientInterface)` | Use a specific PSR-18 client instead of the auto-selected default. |

## Making requests

`HttpClient` implements PSR-18 `ClientInterface` (`sendRequest()`), plus convenience methods:

```php
$client = $factory->client('github');

$client->get('/user');
$client->post('/repos/acme/app/issues', [
    'headers' => ['Content-Type' => 'application/json'],
    'body'    => json_encode(['title' => 'Bug']),
]);
$client->put('/gists/123', $options);
$client->delete('/gists/123');
$client->request('PATCH', '/issues/1', $options);
```

The options array these convenience methods accept has exactly two keys — `headers` (a `name => value` map) and `body` (a raw string). There is **no `json` option**: encode the payload yourself with `json_encode()` and set `Content-Type` in `headers`, as above. `$options` in the `put`/`request` calls is just such an array.

## Resolving the factory

`HttpClientFactory` is registered as a container singleton (alias `http_client_factory`), so inject it where you need it:

```php
use Quiote\Http\Client\HttpClientFactory;

final class GitHubService
{
    public function __construct(private HttpClientFactory $http) {}

    public function repo(string $full): array
    {
        $res = $this->http->client('github')->get("/repos/$full");
        return json_decode((string) $res->getBody(), true);
    }
}
```

See [The DI container](/architecture/container/) for injection. From a [plugin](/architecture/plugins/), contribute a named client with `$registrar->httpClient('github', fn($c) => ...)`.

## Transports

A "transport" is any PSR-18 `ClientInterface` — `HttpClient` doesn't talk to a socket itself, it delegates `sendRequest()` to whatever transport it was built with, and layers headers, retry and telemetry on top. Two transports are available out of the box:

- **`CurlTransport`** — the zero-dependency default; builds PSR-7 responses via Nyholm and maps curl connection/timeout failures to the PSR-18 network/request exceptions.
- **Guzzle** — used automatically if `guzzlehttp/guzzle` is installed (it already implements PSR-18 itself); no adapter needed.

`TransportFactory::default()` decides between them: Guzzle if `GuzzleHttp\Client` exists, otherwise `CurlTransport`. That means **the swap already happens automatically** — running `composer require guzzlehttp/guzzle` is enough on its own to move every client built without an explicit transport onto Guzzle, no code change required. `CurlTransport` exists so the framework carries no HTTP dependency by default; Guzzle buys connection pooling, HTTP/2, a PSR-7 middleware stack and `MockHandler`-based testing, at the cost of pulling in the package.

Retry (`HttpClientConfig::retry()`) lives in `HttpClient` itself, above whichever transport is underneath, so it behaves identically regardless of which one is active — there's no separate retry implementation to keep in sync between the curl and Guzzle paths.

Any other PSR-18 client works too, not just Guzzle — a Symfony HttpClient PSR-18 bridge, a test double, a client that signs requests for a specific API. Override the transport in two places:

**Per named client**, via `HttpClientConfig::transport()`:

```php
$factory->configure('github', function (HttpClientConfig $c): void {
    $c->baseUri('https://api.github.com')
      ->transport(new \GuzzleHttp\Client(['timeout' => 5]));
});
```

**Process-wide**, via `HttpClientFactory::setDefaultTransportFactory()` — every client built afterwards without its own `->transport()` call uses it, which is the one already-memoized clients don't retroactively pick up:

```php
$factory->setDefaultTransportFactory(fn() => new \GuzzleHttp\Client(['timeout' => 5]));
```

A configured `HttpClientConfig::transport()` always wins over the default factory — `HttpClientFactory::build()` applies the default first, then runs the named client's own configurator over it, so a per-client override is the last word.

## Trace propagation

When [telemetry](/architecture/telemetry/) is enabled, every request through `HttpClient` automatically:

- opens a `SpanKind::Client` span (category `Quiote.Http.Client`, name `"HTTP {method}"`),
- injects the W3C `traceparent` header into the outbound request, so the downstream service continues the same trace,
- records `http.request.method`, `url.full`, and `http.response.status_code`, and captures exceptions.

All of it is gated on `Trace::enabled()` and guarded — telemetry never changes whether a request succeeds. This is the outbound half of context propagation: requests made through this client are traced end to end; requests made with a raw `curl`/socket bypass it.
