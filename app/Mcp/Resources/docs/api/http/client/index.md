# Client

> The Quiote\\Http\\Client namespace — 8 documented types.

Everything under `Quiote\Http\Client`.

## Classes

| Class | Description |
|---|---|
| [`CurlTransport`](/api/http/client/curl-transport/) | Zero-dependency PSR-18 transport built on ext-curl and the Nyholm PSR-17 factory (already a hard framework dependency). |
| [`HttpClient`](/api/http/client/http-client/) | The framework HTTP client: a PSR-18 `ClientInterface` wrapping an underlying transport, adding base-URI resolution, default headers, a transient-failure retry policy, ergonomic verb helpers, and — the payoff for the whole abstraction — the central egress seam for telemetry. |
| [`HttpClientConfig`](/api/http/client/http-client-config/) | Mutable, fluent configuration for a named HTTP client, populated inside a [`HttpClientFactory::configure()`](/api/http/client/http-client-factory/#configure) callback (the dotnet `AddHttpClient("name", c => ...)` analogue). |
| [`HttpClientFactory`](/api/http/client/http-client-factory/) | Registry + factory for named HTTP clients, modelled on .NET's `services.AddHttpClient("name", c => ...)` / `IHttpClientFactory`: you register a named client's configuration once, then resolve it by name, and the same [`HttpClient`](/api/http/client/http-client/) instance is reused for that name for the lifetime of the process (a FrankenPHP worker keeps one per name) rather than being rebuilt on every call. |
| [`TransportFactory`](/api/http/client/transport-factory/) | Chooses the default underlying PSR-18 transport: Guzzle if it is installed (its `GuzzleHttp\Client` already implements PSR-18 `ClientInterface`, so it is used directly — no adapter needed), otherwise the zero-dependency [`CurlTransport`](/api/http/client/curl-transport/). |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Exception`](/api/http/client/exception/) | 3 types |
