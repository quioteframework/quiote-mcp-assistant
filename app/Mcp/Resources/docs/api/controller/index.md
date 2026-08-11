# Controller

> The Quiote\\Controller namespace — 4 documented types.

Everything under `Quiote\Controller`.

## Classes

| Class | Description |
|---|---|
| [`Controller`](/api/controller/controller/) | The per-context registry and factory that dispatch routes through. |
| [`OutputType`](/api/controller/output-type/) | One configured output type -- `html`, `json`, or whatever else `output_types.xml` declares -- together with the renderers, layouts and parameters that belong to it. |
| [`OutputTypeDefinitions`](/api/controller/output-type-definitions/) | What the compiled `output_types` configuration declares, as data. |

## Interfaces

| Interface | Description |
|---|---|
| [`ControllerInterface`](/api/controller/controller-interface/) | What the framework asks of a controller: resolve and build the action and view for a dispatch, answer questions about what a module contains, and hold the response being assembled. |
