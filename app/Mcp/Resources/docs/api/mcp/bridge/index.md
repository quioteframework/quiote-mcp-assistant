# Bridge

> The Quiote\\Mcp\\Bridge namespace — 2 documented types.

Everything under `Quiote\Mcp\Bridge`.

## Classes

| Class | Description |
|---|---|
| [`ActionToolAdapter`](/api/mcp/bridge/action-tool-adapter/) | The actions-as-tools bridge (the headline feature): maps one `tools/call` to a specific `#[Route]` action's own execution path. |
| [`ContainerAdapter`](/api/mcp/bridge/container-adapter/) | Wraps Quiote's DI [`Container`](/api/di/container/) as the PSR-11 container `mcp/sdk` uses (`Mcp\Server\Builder::setContainer()`) to resolve string/array tool handlers (`Mcp\Capability\Registry\ReferenceHandler::getClassInstance()`). |
