# PhptalRenderer

> Renders PHPTAL (`.tal`) templates through the standalone phptal/phptal engine.

Renders PHPTAL (`.tal`) templates through the standalone phptal/phptal engine.

Compiled template classes are cached under `<core.cache_dir>/templates/phptal/`, mirroring the layout the other on-disk template caches (e.g. the config cache) use.

## Synopsis

`final class PhptalRenderer extends Renderer`

|  |  |
|---|---|
| Extends | [`Renderer`](/api/renderer/renderer/) |
| Source | `PhptalRenderer.php` |

## Methods

| Method | Description |
|---|---|
| [`__sleep(): mixed`](#sleep) | Pre-serialization callback. |
| [`getStarterTemplate(): string`](#getstartertemplate) | Returns the skeleton `.tal` template written for a newly scaffolded view. |
| [`render(TemplateLayer $layer, array &$attributes = [], array &$slots = [], array &$moreAssigns = []): mixed`](#render) | Renders the layer's `.tal` template through PHPTAL and returns the result. |
| [`reset(): void`](#reset) | Returns the renderer to its post-construction state for reuse. |

### __sleep()

`public function __sleep(): mixed`

Pre-serialization callback.

Will set the name of the context and exclude the instance from serializing.

Returns `mixed`

### getStarterTemplate()

`public function getStarterTemplate(): string`

Returns the skeleton `.tal` template written for a newly scaffolded view.

The `tal:content` path follows the renderer's current variable configuration: a bare `title` when `extract_vars` is on, otherwise `title` under the configured template variable.

Returns `string`

### render()

`public function render(TemplateLayer $layer, array &$attributes = [], array &$slots = [], array &$moreAssigns = []): mixed`

Renders the layer's `.tal` template through PHPTAL and returns the result.

Attributes are pushed into the engine either individually (when `extract_vars` is on) or as a single array under the configured variable name; the slots array, the renderer's own assigns and the filtered `$moreAssigns` are set as further template variables. The PHPTAL engine is built lazily on first use and reused afterwards.

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

Drops the cached PHPTAL engine — so the next render rebuilds it against the then-current cache directory and `encoding` parameter — and then lets the parent clear the layer, variable names and assigns.

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
