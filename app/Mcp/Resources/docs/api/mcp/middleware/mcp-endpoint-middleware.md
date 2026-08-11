# McpEndpointMiddleware

> The Streamable-HTTP transport: matches the configured `mcp.path` (default `/mcp`) -- plus, when `mcp.auth` is `'oauth2'`, a GET to the RFC 9728 well-known metadata path, since that also has to reach McpServer::handleHttp() for the SDK's own `ProtectedResourceMetadataMiddleware` (composed there) to serve it -- and delegates everything else to the rest of the pipeline unchanged.

The Streamable-HTTP transport: matches the configured `mcp.path` (default `/mcp`) -- plus, when `mcp.auth` is `'oauth2'`, a GET to the RFC 9728 well-known metadata path, since that also has to reach [`McpServer::handleHttp()`](/api/mcp/mcp-server/#handlehttp) for the SDK's own `ProtectedResourceMetadataMiddleware` (composed there) to serve it -- and delegates everything else to the rest of the pipeline unchanged.

Registered by [`McpPlugin`](/api/mcp/mcp-plugin/) *before* `SecurityMiddleware` (MCP does its own auth, not session/CSRF), so it still inherits earlier bootstrap middleware (tracing, payload parsing) but never reaches MVC dispatch.

Resolves the DI container from a single named [`Context`](/api/context/) (default `core.default_context`) rather than "whichever context is handling this * request" -- same simplifying assumption `mcp:serve --context` makes -- since a request only reaches this middleware once it's already inside that context's own pipeline.

## Synopsis

`final class McpEndpointMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/McpEndpointMiddleware.php` |

## Constructor

### __construct()

`public function __construct(string $contextName): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$contextName` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Serves the request from the MCP server when it targets the MCP endpoint. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Serves the request from the MCP server when it targets the MCP endpoint.

Delegates to the rest of the pipeline unless MCP is enabled and the path is either the configured `mcp.path` or — under `mcp.auth = 'oauth2'` — a GET to the RFC 9728 protected-resource metadata path. The [`McpServer`](/api/mcp/mcp-server/) is built once on first match from the named context's container and reused. Any throwable escaping the server is converted to a 500 problem-details response rather than propagating.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
