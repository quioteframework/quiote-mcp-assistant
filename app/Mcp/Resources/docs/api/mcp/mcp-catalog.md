# McpCatalog

> Process-global registry of MCP tools/resources/prompts, mirroring the static, worker-lifetime pattern of MiddlewareCatalog and PluginManager: entries are added once at boot (via PluginRegistrar or attribute discovery, once that lands) and read once by McpServer::build() when the server is assembled.

Process-global registry of MCP tools/resources/prompts, mirroring the static, worker-lifetime pattern of [`MiddlewareCatalog`](/api/middleware/middleware-catalog/) and [`PluginManager`](/api/plugin/plugin-manager/): entries are added once at boot (via [`PluginRegistrar`](/api/plugin/plugin-registrar/) or attribute discovery, once that lands) and read once by [`McpServer::build()`](/api/mcp/mcp-server/#build) when the server is assembled.

Each entry is the argument set for the matching `Mcp\Server\Builder::add*()` call, stored verbatim so `McpServer` can forward it without this class knowing anything about the SDK's types.

## Synopsis

`final class McpCatalog`

|  |  |
|---|---|
| Source | `McpCatalog.php` |

## Methods

| Method | Description |
|---|---|
| [`addPrompt(Closure|array{0: (object | string), 1: string}|string $handler, ?string $name = null, ?string $title = null, ?string $description = null): void`](#addprompt) |  |
| [`addResource(Closure|array{0: (object | string), 1: string}|string $handler, string $uri, ?string $name = null, ?string $title = null, ?string $description = null, ?string $mimeType = null): void`](#addresource) |  |
| [`addTool(Closure|array{0: (object | string), 1: string}|string $handler, ?string $name = null, ?string $title = null, ?string $description = null, array<string, mixed>|null $inputSchema = null, array<string, mixed>|null $outputSchema = null): void`](#addtool) |  |
| [`prompts(): list<array{handler: Handler, name: ?string, title: ?string, description: ?string}>`](#prompts) |  |
| [`reset(): void`](#reset) | Test-only reset (mirrors [`MiddlewareCatalog::reset()`](/api/middleware/middleware-catalog/#reset)). |
| [`resources(): list<array{handler: Handler, uri: string, name: ?string, title: ?string, description: ?string, mimeType: ?string}>`](#resources) |  |
| [`tools(): list<array{handler: Handler, name: ?string, title: ?string, description: ?string, inputSchema: ?array<string, mixed>, outputSchema: ?array<string, mixed>}>`](#tools) |  |

### addPrompt()

`public static function addPrompt(Closure|array{0: (object | string), 1: string}|string $handler, ?string $name = null, ?string $title = null, ?string $description = null): void`

| Parameter | Type | Description |
|---|---|---|
| `$handler` | [`Closure`](https://www.php.net/manual/en/class.closure.php)`|``array{0: (object | string), 1: string}``|``string` |  |
| `$name` | `?``string` |  |
| `$title` | `?``string` |  |
| `$description` | `?``string` |  |

### addResource()

`public static function addResource(Closure|array{0: (object | string), 1: string}|string $handler, string $uri, ?string $name = null, ?string $title = null, ?string $description = null, ?string $mimeType = null): void`

| Parameter | Type | Description |
|---|---|---|
| `$handler` | [`Closure`](https://www.php.net/manual/en/class.closure.php)`|``array{0: (object | string), 1: string}``|``string` |  |
| `$uri` | `string` |  |
| `$name` | `?``string` |  |
| `$title` | `?``string` |  |
| `$description` | `?``string` |  |
| `$mimeType` | `?``string` |  |

### addTool()

`public static function addTool(Closure|array{0: (object | string), 1: string}|string $handler, ?string $name = null, ?string $title = null, ?string $description = null, array<string, mixed>|null $inputSchema = null, array<string, mixed>|null $outputSchema = null): void`

| Parameter | Type | Description |
|---|---|---|
| `$handler` | [`Closure`](https://www.php.net/manual/en/class.closure.php)`|``array{0: (object | string), 1: string}``|``string` |  |
| `$name` | `?``string` |  |
| `$title` | `?``string` |  |
| `$description` | `?``string` |  |
| `$inputSchema` | `array``<``string``, ``mixed``>``|``null` |  |
| `$outputSchema` | `array``<``string``, ``mixed``>``|``null` |  |

### prompts()

`public static function prompts(): list<array{handler: Handler, name: ?string, title: ?string, description: ?string}>`

Returns `list``<``array{handler: Handler, name: ?string, title: ?string, description: ?string}``>`

### reset()

`public static function reset(): void`

Test-only reset (mirrors [`MiddlewareCatalog::reset()`](/api/middleware/middleware-catalog/#reset)).

### resources()

`public static function resources(): list<array{handler: Handler, uri: string, name: ?string, title: ?string, description: ?string, mimeType: ?string}>`

Returns `list``<``array{handler: Handler, uri: string, name: ?string, title: ?string, description: ?string, mimeType: ?string}``>`

### tools()

`public static function tools(): list<array{handler: Handler, name: ?string, title: ?string, description: ?string, inputSchema: ?array<string, mixed>, outputSchema: ?array<string, mixed>}>`

Returns `list``<``array{handler: Handler, name: ?string, title: ?string, description: ?string, inputSchema: ?array<string, mixed>, outputSchema: ?array<string, mixed>}``>`
