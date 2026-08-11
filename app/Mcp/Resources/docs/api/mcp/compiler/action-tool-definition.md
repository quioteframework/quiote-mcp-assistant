# ActionToolDefinition

> Format-independent description of one action exposed as an MCP tool -- what ActionToolScanner discovers, consumed by McpServer to build the actual SDK registration.

Format-independent description of one action exposed as an MCP tool -- what [`ActionToolScanner`](/api/mcp/compiler/action-tool-scanner/) discovers, consumed by [`McpServer`](/api/mcp/mcp-server/) to build the actual SDK registration.

Deliberately carries no `mcp/sdk` types (mirrors `Quiote\Routing\Compiler\RouteDefinition`'s format-independence).

## Synopsis

`final class ActionToolDefinition`

|  |  |
|---|---|
| Source | `Compiler/ActionToolDefinition.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$description` | `?``string` | _readonly._ |
| `$httpMethod` | `string` | _readonly._ |
| `$inputSchema` | `?``array` | _readonly._ |
| `$outputSchema` | `?``array` | _readonly._ |
| `$routeName` | `string` | _readonly._ |
| `$toolName` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $toolName, ?string $description, string $routeName, string $httpMethod, array<string, mixed>|null $outputSchema, array<string, mixed>|null $inputSchema = null): mixed`

JSON Schema derived from the
       action's declared validators ([`ValidatorSchemaMapper`](/api/mcp/compiler/validator-schema-mapper/)), or null
       when none could be derived (caller falls back to a permissive schema).

| Parameter | Type | Description |
|---|---|---|
| `$toolName` | `string` |  |
| `$description` | `?``string` |  |
| `$routeName` | `string` |  |
| `$httpMethod` | `string` |  |
| `$outputSchema` | `array``<``string``, ``mixed``>``|``null` | JSON Schema for the tool's output, from `#[McpTool(outputSchema: ...)]` if the action author supplied one. |
| `$inputSchema` | `array``<``string``, ``mixed``>``|``null` | JSON Schema derived from the action's declared validators ([`ValidatorSchemaMapper`](/api/mcp/compiler/validator-schema-mapper/)), or null when none could be derived (caller falls back to a permissive schema). |

Returns `mixed`
