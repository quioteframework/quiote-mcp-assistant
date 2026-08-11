# OutputType

> One configured output type -- `html`, `json`, or whatever else `output_types.xml` declares -- together with the renderers, layouts and parameters that belong to it.

One configured output type -- `html`, `json`, or whatever else `output_types.xml` declares -- together with the renderers, layouts and parameters that belong to it.

The [`Controller`](/api/controller/controller/) builds and initializes one instance per declared output type when it initializes and hands them out through [`Controller::getOutputType()`](/api/controller/controller/#getoutputtype); an application receives an instance rather than constructing or subclassing one. What it carries is the presentation side of a response: the renderers a template layer can be rendered with ([`OutputType::getRenderer()`](/api/controller/output-type/#getrenderer), [`OutputType::hasRenderers()`](/api/controller/output-type/#hasrenderers)), the layouts a view can load ([`OutputType::getLayout()`](/api/controller/output-type/#getlayout), [`OutputType::getDefaultLayoutName()`](/api/controller/output-type/#getdefaultlayoutname)), the template used when an exception has to be rendered in this type ([`OutputType::getExceptionTemplate()`](/api/controller/output-type/#getexceptiontemplate)), and the type's own parameter bag inherited from [`ParameterHolder`](/api/util/parameter-holder/).

A renderer is constructed and initialized on first request, and kept for later requests only when it declares itself reusable through [`IReusableRenderer`](/api/renderer/i-reusable-renderer/); one that does not is rebuilt on every call. Asking for a renderer or a layout by an unconfigured name, or by no name when the type declares no default, throws rather than returning null. The object stringifies to its own name, so it can stand in wherever the name is expected.

## Synopsis

`class OutputType extends ParameterHolder implements Stringable`

|  |  |
|---|---|
| Extends | [`ParameterHolder`](/api/util/parameter-holder/) |
| Implements | [`Stringable`](https://www.php.net/manual/en/class.stringable.php) |
| Source | `Controller/OutputType.php` |

## Methods

| Method | Description |
|---|---|
| [`__toString(): string`](#tostring) |  |
| [`getDefaultLayoutName(): ?string`](#getdefaultlayoutname) | Get the name of the default layout. |
| [`getExceptionTemplate(): ?string`](#getexceptiontemplate) | Get the exception template filename for this renderer. |
| [`getLayout(?string $name = null): array<string, mixed>`](#getlayout) | Get a layout. |
| [`getName(): string`](#getname) | Get the name of the Output Type. |
| [`getRenderer(?string $name = null): ?Renderer`](#getrenderer) | Get a renderer instance. |
| [`hasRenderers(): bool`](#hasrenderers) | Checks whether or not any renderers are defined for this Output Type. |
| [`initialize(Context $context, array<string, mixed> $parameters, string $name, array<string, array<string, mixed>> $renderers, ?string $defaultRenderer, array<string, array<string, mixed>> $layouts, ?string $defaultLayout, ?string $exceptionTemplate = null): void`](#initialize) | Initialize the Output Type. |
| [`reset(): void`](#reset) | Reset output type state for FrankenPHP worker compatibility. |

### __toString()

`final public function __toString(): string`

Returns `string`

### getDefaultLayoutName()

`public function getDefaultLayoutName(): ?string`

Get the name of the default layout.

Returns `?``string` — The name of the default layout, or null if none defined.

### getExceptionTemplate()

`public function getExceptionTemplate(): ?string`

Get the exception template filename for this renderer.

Returns `?``string` — A path to the exception template, or null if undefined.

### getLayout()

`public function getLayout(?string $name = null): array<string, mixed>`

Get a layout.

The optional name of the layout to fetch.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `?``string` | The optional name of the layout to fetch. |

Returns `array``<``string``, ``mixed``>` — An array of layout information.

| Throws | When |
|---|---|
| `QuioteException` | If the layout doesn't exist. |

### getName()

`public function getName(): string`

Get the name of the Output Type.

Returns `string` — The name of the Output Type.

### getRenderer()

`public function getRenderer(?string $name = null): ?Renderer`

Get a renderer instance.

The optional name of the Renderer to fetch.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `?``string` | The optional name of the Renderer to fetch. |

Returns `?`[`Renderer`](/api/renderer/renderer/) — A Renderer instance or null if none defined.

### hasRenderers()

`public function hasRenderers(): bool`

Checks whether or not any renderers are defined for this Output Type.

Returns `bool` — True, if renderers are defined, false otherwise.

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters, string $name, array<string, array<string, mixed>> $renderers, ?string $defaultRenderer, array<string, array<string, mixed>> $layouts, ?string $defaultLayout, ?string $exceptionTemplate = null): void`

Initialize the Output Type.

The name of the exception template for this output type.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | The current Context instance. |
| `$parameters` | `array``<``string``, ``mixed``>` | An array of initialization parameters. |
| `$name` | `string` | The name of the Output Type. |
| `$renderers` | `array``<``string``, ``array``<``string``, ``mixed``>``>` | An array of Renderers (settings and instances). |
| `$defaultRenderer` | `?``string` | The name of the default Renderer, if set. |
| `$layouts` | `array``<``string``, ``array``<``string``, ``mixed``>``>` | An array of configured layouts. |
| `$defaultLayout` | `?``string` | The name of the default layout, if set. |
| `$exceptionTemplate` | `?``string` | The name of the exception template for this output type. |

### reset()

`public function reset(): void`

Reset output type state for FrankenPHP worker compatibility.

Clears output type properties that could leak between requests.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
