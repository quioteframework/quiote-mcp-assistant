# Renderer

> A renderer produces the output as defined by a View

A renderer produces the output as defined by a View

## Synopsis

`abstract class Renderer extends ParameterHolder`

|  |  |
|---|---|
| Extends | [`ParameterHolder`](/api/util/parameter-holder/) |
| Since | `1.0.0` |
| Source | `Renderer/Renderer.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$assigns` | `mixed` | _protected._ How to resolve each template variable the `assigns` parameter names, keyed by the variable name. |
| `$context` | `mixed` | _protected._ |
| `$contextName` | `mixed` | _protected._ |
| `$defaultExtension` | `mixed` | _protected._ |
| `$extractVars` | `mixed` | _protected._ |
| `$moreAssignNames` | `mixed` | _protected._ |
| `$slotsVarName` | `mixed` | _protected._ |
| `$varName` | `mixed` | _protected._ |

## Methods

| Method | Description |
|---|---|
| [`__sleep(): mixed`](#sleep) | Pre-serialization callback. |
| [`__wakeup(): mixed`](#wakeup) | Post-unserialization callback. |
| [`buildMoreAssigns(array<int|string, mixed> &$moreAssigns, array<int|string, mixed> $moreAssignNames): array<int|string, mixed>`](#buildmoreassigns) | Build an array of "more" assigns. |
| [`getContext(): Context`](#getcontext) | Retrieve the current application context. |
| [`getDefaultExtension(): string`](#getdefaultextension) | Get the template file extension |
| [`getStarterTemplate(): ?string`](#getstartertemplate) | A minimal, syntactically valid starter template in this renderer's own templating syntax, rendering a "title" template variable -- or null if this renderer has no sensible starter to offer (the default). |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this Renderer. |
| [`render(TemplateLayer $layer, array<string, mixed> &$attributes = [], array<string, mixed> &$slots = [], array<int|string, mixed> &$moreAssigns = []): string`](#render) | Render the presentation and return the result. |
| [`reset(): void`](#reset) | Returns the renderer to its post-construction state so the instance can be reused for another rendering. |

### __sleep()

`public function __sleep(): mixed`

Pre-serialization callback.

Will set the name of the context and exclude the instance from serializing.

Returns `mixed`

### __wakeup()

`public function __wakeup(): mixed`

Post-unserialization callback.

Will restore the context based on the names set by __sleep.

Returns `mixed`

### buildMoreAssigns()

`protected static function buildMoreAssigns(array<int|string, mixed> &$moreAssigns, array<int|string, mixed> $moreAssignNames): array<int|string, mixed>`

Build an array of "more" assigns.

Assigns name map.

| Parameter | Type | Description |
|---|---|---|
| `$moreAssigns` | `array``<``int``|``string``, ``mixed``>` | The values to be assigned. |
| `$moreAssignNames` | `array``<``int``|``string``, ``mixed``>` | Assigns name map. |

Returns `array``<``int``|``string``, ``mixed``>` — The data.

### getContext()

`final public function getContext(): Context`

Retrieve the current application context.

Returns [`Context`](/api/context/) — The current Context instance.

| Throws | When |
|---|---|
| `QuioteException` | If this Renderer has not been initialize()d yet. |

### getDefaultExtension()

`public function getDefaultExtension(): string`

Get the template file extension

Returns `string` — The extension, including a leading dot.

### getStarterTemplate()

`public function getStarterTemplate(): ?string`

A minimal, syntactically valid starter template in this renderer's own templating syntax, rendering a "title" template variable -- or null if this renderer has no sensible starter to offer (the default).

Returns `?``string` — The starter template content, or null.

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = []): void`

Initialize this Renderer.

An associative array of initialization parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | The current application context. |
| `$parameters` | `array``<``string``, ``mixed``>` | An associative array of initialization parameters. |

### render()

`abstract public function render(TemplateLayer $layer, array<string, mixed> &$attributes = [], array<string, mixed> &$slots = [], array<int|string, mixed> &$moreAssigns = []): string`

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

Returns the renderer to its post-construction state so the instance can be reused for another rendering.

Drops the context, resets the variable names, extraction flag and default extension to their defaults, empties the assigns and "more assign" name map, clears the inherited parameters, and unsets the per-render layer, attributes, slots and more-assigns references.

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
