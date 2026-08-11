# PhpRenderer

> A renderer produces the output as defined by a View

A renderer produces the output as defined by a View

## Synopsis

`class PhpRenderer extends Renderer implements IReusableRenderer`

|  |  |
|---|---|
| Extends | [`Renderer`](/api/renderer/renderer/) |
| Implements | [`IReusableRenderer`](/api/renderer/i-reusable-renderer/) |
| Since | `1.0.0` |
| Source | `Renderer/PhpRenderer.php` |

## Methods

| Method | Description |
|---|---|
| [`getStarterTemplate(): string`](#getstartertemplate) | Returns the skeleton PHP template written for a newly scaffolded view. |
| [`render(TemplateLayer $layer, array<string, mixed> &$attributes = [], array<string, mixed> &$slots = [], array<int|string, mixed> &$moreAssigns = []): string`](#render) | Render the presentation and return the result. |
| [`reset(): void`](#reset) | Clears the per-render state held for the template being included. |

### getStarterTemplate()

`public function getStarterTemplate(): string`

Returns the skeleton PHP template written for a newly scaffolded view.

The echoed expression follows the renderer's current variable configuration: a bare `$title` when `extract_vars` is on, otherwise the `title` key of the configured template variable. The value is escaped in the template itself, since a plain PHP template has no auto-escaping.

Returns `string`

### render()

`public function render(TemplateLayer $layer, array<string, mixed> &$attributes = [], array<string, mixed> &$slots = [], array<int|string, mixed> &$moreAssigns = []): string`

Render the presentation and return the result.

Associative array of additional assigns.

| Parameter | Type | Description |
|---|---|---|
| `$layer` | [`TemplateLayer`](/api/view/template-layer/) | The template layer to render. |
| `$attributes` | `array``<``string``, ``mixed``>` | The template variables. |
| `$slots` | `array``<``string``, ``mixed``>` | The slots. |
| `$moreAssigns` | `array``<``int``|``string``, ``mixed``>` | Associative array of additional assigns. |

Returns `string` — A rendered result.

### reset()

`public function reset(): void`

Clears the per-render state held for the template being included.

Only the layer, attributes, slots and more-assigns are dropped; the parent reset is deliberately not invoked, so the renderer's configured variable names, extraction flag and assigns survive for the next render.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getContext()` | [`Renderer`](/api/renderer/renderer/) | Retrieve the current application context. |
| `getDefaultExtension()` | [`Renderer`](/api/renderer/renderer/) | Get the template file extension |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `initialize()` | [`Renderer`](/api/renderer/renderer/) | Initialize this Renderer. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
