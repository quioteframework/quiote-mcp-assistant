# Compiler

> The Quiote\\Mcp\\Compiler namespace — 4 documented types.

Everything under `Quiote\Mcp\Compiler`.

## Classes

| Class | Description |
|---|---|
| [`ActionToolDefinition`](/api/mcp/compiler/action-tool-definition/) | Format-independent description of one action exposed as an MCP tool -- what [`ActionToolScanner`](/api/mcp/compiler/action-tool-scanner/) discovers, consumed by [`McpServer`](/api/mcp/mcp-server/) to build the actual SDK registration. |
| [`ActionToolScanner`](/api/mcp/compiler/action-tool-scanner/) | Discovers `#[Route]` action classes that are also decorated with the SDK's own `#[McpTool]` attribute -- "add one attribute to an existing action" is the headline feature. |
| [`McpDirectoryResolver`](/api/mcp/compiler/mcp-directory-resolver/) | Resolves the plain-class attribute-discovery scan set: every existing `{ModuleDir}/{Module}/Mcp/` subdirectory across the app's module directory plus any plugin-contributed module directories -- mirroring the `{Module}/Actions/`, `{Module}/Validate/` per-module convention the rest of the framework already uses, scoped to a `Mcp/` subtree so this scan is cheap and doesn't also walk every action/controller class in the app. |
| [`ValidatorSchemaMapper`](/api/mcp/compiler/validator-schema-mapper/) |  |
