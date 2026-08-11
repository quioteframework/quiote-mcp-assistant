# HttpClientFactory

> Registry + factory for named HTTP clients, modelled on .NET's `services.AddHttpClient(\"name\", c => ...)` / `IHttpClientFactory`: you register a named client's configuration once, then resolve it by name, and the same HttpClient instance is reused for that name for the lifetime of the process (a FrankenPHP worker keeps one per name) rather than being rebuilt on every call.

Registry + factory for named HTTP clients, modelled on .NET's `services.AddHttpClient("name", c => ...)` / `IHttpClientFactory`: you register a named client's configuration once, then resolve it by name, and the same [`HttpClient`](/api/http/client/http-client/) instance is reused for that name for the lifetime of the process (a FrankenPHP worker keeps one per name) rather than being rebuilt on every call.

Registered as a container singleton (see [`Context::registerCoreServicesInContainer()`](/api/context/#registercoreservicesincontainer)), so app/plugin code can constructor-inject `HttpClientFactory` and pull named clients — and plugins contribute named-client configs via [`PluginRegistrar::httpClient()`](/api/plugin/plugin-registrar/#httpclient).

## Synopsis

`final class HttpClientFactory`

|  |  |
|---|---|
| Source | `Http/Client/HttpClientFactory.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `DEFAULT` | `'default'` |  |

## Methods

| Method | Description |
|---|---|
| [`client(string $name = self::DEFAULT): HttpClient`](#client) | Resolve a named client, building + memoizing it on first use. |
| [`configure(string $name, callable(HttpClientConfig): void $configurator): void`](#configure) | Register (or overwrite) a named client's configuration. |
| [`has(string $name): bool`](#has) | Reports whether [`HttpClientFactory::client()`](/api/http/client/http-client-factory/#client) can resolve this name. |
| [`reset(): void`](#reset) | Empties the registry: every registered configurator, every memoized client and any default transport factory are discarded, leaving the factory as freshly constructed. |
| [`setDefaultTransportFactory(?callable $factory): void`](#setdefaulttransportfactory) | Override the transport used by clients that don't set their own (default: [`TransportFactory::default()`](/api/http/client/transport-factory/#default)). |

### client()

`public function client(string $name = self::DEFAULT): HttpClient`

Resolve a named client, building + memoizing it on first use.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns [`HttpClient`](/api/http/client/http-client/)

### configure()

`public function configure(string $name, callable(HttpClientConfig): void $configurator): void`

Register (or overwrite) a named client's configuration.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$configurator` | `callable(HttpClientConfig): void` |  |

### has()

`public function has(string $name): bool`

Reports whether [`HttpClientFactory::client()`](/api/http/client/http-client-factory/#client) can resolve this name.

True for any registered configurator, and always true for `DEFAULT`, which builds from an unconfigured [`HttpClientConfig`](/api/http/client/http-client-config/) when nobody registered it.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `bool`

### reset()

`public function reset(): void`

Empties the registry: every registered configurator, every memoized client and any default transport factory are discarded, leaving the factory as freshly constructed.

Clients already handed out keep working; they simply are no longer the ones this factory will return.

### setDefaultTransportFactory()

`public function setDefaultTransportFactory(?callable $factory): void`

Override the transport used by clients that don't set their own (default: [`TransportFactory::default()`](/api/http/client/transport-factory/#default)).

| Parameter | Type | Description |
|---|---|---|
| `$factory` | `?``callable` |  |
