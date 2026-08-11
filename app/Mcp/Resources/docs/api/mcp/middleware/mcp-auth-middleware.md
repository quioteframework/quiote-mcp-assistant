# McpAuthMiddleware

> Bearer-token auth for the MCP HTTP endpoint.

Bearer-token auth for the MCP HTTP endpoint.

Registered by [`McpPlugin`](/api/mcp/mcp-plugin/) immediately *before* [`McpEndpointMiddleware`](/api/mcp/middleware/mcp-endpoint-middleware/) -- only when the "http" transport is enabled and `mcp.auth` isn't `'none'` -- so an invalid/missing token never reaches the SDK server at all. The actual validation is delegated to a [`McpAuthenticatorInterface`](/api/mcp/auth/mcp-authenticator-interface/) resolved from the DI container (default: [`StaticTokenAuthenticator`](/api/mcp/auth/static-token-authenticator/)), so an app can swap in its own credential store via `PluginRegistrar::service()`.

## Synopsis

`final class McpAuthMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/McpAuthMiddleware.php` |

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
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Rejects requests to the MCP path that carry no valid bearer token. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Rejects requests to the MCP path that carry no valid bearer token.

Passes the request straight down the pipeline when MCP is disabled, when `mcp.auth` is `'none'`, or when the path is not the configured `mcp.path`. Otherwise the `Authorization` header's Bearer credential is handed to the container-resolved [`McpAuthenticatorInterface`](/api/mcp/auth/mcp-authenticator-interface/); a missing, empty or rejected token yields a 401 problem-details response carrying `WWW-Authenticate: Bearer`, and the inner handler is never called.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
