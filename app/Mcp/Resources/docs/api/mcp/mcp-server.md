# McpServer

> Our own facade over the official `mcp/sdk` `Server::builder()` API: every `Mcp\\*` symbol the app touches is confined to this class (plus ContainerAdapter), so an SDK breaking change (it is pre-1.0) touches one file, not the whole feature.

Our own facade over the official `mcp/sdk` `Server::builder()` API: every `Mcp\*` symbol the app touches is confined to this class (plus `ContainerAdapter`), so an SDK breaking change (it is pre-1.0) touches one file, not the whole feature.

Builds an SDK server from [`McpCatalog`](/api/mcp/mcp-catalog/)'s registered tools/resources/ prompts, resolving each handler through Quiote's own DI [`Container`](/api/di/container/).

## Synopsis

`final class McpServer`

|  |  |
|---|---|
| Source | `McpServer.php` |

## Constructor

### __construct()

`public function __construct(Container $container, string $contextName, ?ClientInterface $oauthHttpClient = null): mixed`

`$oauthHttpClient` overrides the PSR-18 client `OidcDiscovery`/`JwksProvider` (see [`McpServer::buildHttpMiddleware()`](/api/mcp/mcp-server/#buildhttpmiddleware)) would otherwise auto-discover via `php-http/discovery`.

Production code always omits it; tests use it to stub OIDC discovery/JWKS responses without a real network call.

| Parameter | Type | Description |
|---|---|---|
| `$container` | [`Container`](/api/di/container/) |  |
| `$contextName` | `string` |  |
| `$oauthHttpClient` | `?`[`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`build(McpConfig $config): Server`](#build) | Assemble (and cache) the SDK server from the current [`McpCatalog`](/api/mcp/mcp-catalog/) contents. |
| [`handleHttp(McpConfig $config, ServerRequestInterface $request): ResponseInterface`](#handlehttp) | Drive one Streamable-HTTP request/response cycle. |
| [`runStdio(McpConfig $config, resource|null $input = null, resource|null $output = null): int`](#runstdio) | Run the stdio transport loop (blocks until the client disconnects or the process is signalled). |

### build()

`public function build(McpConfig $config): Server`

Assemble (and cache) the SDK server from the current [`McpCatalog`](/api/mcp/mcp-catalog/) contents.

| Parameter | Type | Description |
|---|---|---|
| `$config` | [`McpConfig`](/api/mcp/mcp-config/) |  |

Returns `Server`

### handleHttp()

`public function handleHttp(McpConfig $config, ServerRequestInterface $request): ResponseInterface`

Drive one Streamable-HTTP request/response cycle.

The SDK server is stateless per PHP request either way (no shared state survives beyond this call other than what its session store persists) so it's safe to reuse the cached [`McpServer::build()`](/api/mcp/mcp-server/#build) result across requests within a worker.

`StreamableHttpTransport` reads the JSON-RPC payload by re-reading the request's raw body stream itself -- but earlier in the real pipeline, `PayloadParsingMiddleware` already consumed that stream to populate `getParsedBody()` and does not rewind it, so by the time this runs the stream is at EOF. Rebuilding the body from the already-parsed data instead of re-parsing it avoids a spurious JSON parse error on every call.

| Parameter | Type | Description |
|---|---|---|
| `$config` | [`McpConfig`](/api/mcp/mcp-config/) |  |
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### runStdio()

`public function runStdio(McpConfig $config, resource|null $input = null, resource|null $output = null): int`

Run the stdio transport loop (blocks until the client disconnects or the process is signalled).

| Parameter | Type | Description |
|---|---|---|
| `$config` | [`McpConfig`](/api/mcp/mcp-config/) |  |
| `$input` | `resource``|``null` |  |
| `$output` | `resource``|``null` |  |

Returns `int`
