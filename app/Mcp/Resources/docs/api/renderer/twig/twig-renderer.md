# TwigRenderer

> Renders Twig (`.twig`) templates via twig/twig.

Renders Twig (`.twig`) templates via twig/twig.

Compiled templates are cached under `<core.cache_dir>/templates/twig/`.

## Synopsis

`final class TwigRenderer extends Renderer implements IReusableRenderer`

|  |  |
|---|---|
| Extends | [`Renderer`](/api/renderer/renderer/) |
| Implements | [`IReusableRenderer`](/api/renderer/i-reusable-renderer/) |
| Source | `TwigRenderer.php` |

## Methods

| Method | Description |
|---|---|
| [`getStarterTemplate(): string`](#getstartertemplate) | Returns the skeleton `.twig` template written for a newly scaffolded view. |
| [`render(TemplateLayer $layer, array &$attributes = [], array &$slots = [], array &$moreAssigns = []): mixed`](#render) | Renders the layer's `.twig` template and returns the result. |
| [`reset(): void`](#reset) | Returns the renderer to its post-construction state for reuse. |

### getStarterTemplate()

`public function getStarterTemplate(): string`

Returns the skeleton `.twig` template written for a newly scaffolded view.

The printed expression follows the renderer's current variable configuration: a bare `title` when `extract_vars` is on, otherwise `title` under the configured template variable.

Returns `string`

### render()

`public function render(TemplateLayer $layer, array &$attributes = [], array &$slots = [], array &$moreAssigns = []): mixed`

Renders the layer's `.twig` template and returns the result.

Builds the Twig variable set from the attributes (spread individually when `extract_vars` is on, otherwise nested under the configured template variable), the slots, the renderer's assigns and the filtered `$moreAssigns`, then hands the layer's resolved template path straight to Twig — [`TemplateLayerLoader`](/api/renderer/twig/template-layer-loader/) treats it as a literal file path. The Twig environment is built lazily on first use and reused afterwards.

| Parameter | Type | Description |
|---|---|---|
| `$layer` | [`TemplateLayer`](/api/view/template-layer/) |  |
| `$attributes` | `array` |  |
| `$slots` | `array` |  |
| `$moreAssigns` | `array` |  |

Returns `mixed`

| Throws | When |
|---|---|
| `RenderException` | if the layer carries no template. |

### reset()

`public function reset(): void`

Returns the renderer to its post-construction state for reuse.

Drops the cached Twig environment — so the next render rebuilds it against the then-current cache directory and `auto_reload`, `strict_variables` and `autoescape` parameters — and then lets the parent clear the layer, variable names and assigns.

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
