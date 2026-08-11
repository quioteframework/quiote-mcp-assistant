# StreamTemplateLayer

> Template layer implementation for templates fetched using a PHP stream.

Template layer implementation for templates fetched using a PHP stream.

## Synopsis

`class StreamTemplateLayer extends TemplateLayer`

|  |  |
|---|---|
| Extends | [`TemplateLayer`](/api/view/template-layer/) |
| Since | `1.0.0` |
| Source | `View/StreamTemplateLayer.php` |

## Constructor

### __construct()

`public function __construct(array<string, mixed> $parameters = []): mixed`

Constructor.

Initial parameters.

| Parameter | Type | Description |
|---|---|---|
| `$parameters` | `array``<``string``, ``mixed``>` | Initial parameters. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getResourceStreamIdentifier(): ?string`](#getresourcestreamidentifier) | Get the full, resolved stream location name to the template resource. |

### getResourceStreamIdentifier()

`public function getResourceStreamIdentifier(): ?string`

Get the full, resolved stream location name to the template resource.

Returns `?``string` — A PHP stream resource identifier, or null if no template is set.

| Throws | When |
|---|---|
| `QuioteException` | If the template could not be found. |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `execute()` | [`TemplateLayer`](/api/view/template-layer/) | A convenience function that renders all slots and then the main template. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `getRenderer()` | [`TemplateLayer`](/api/view/template-layer/) | Get the renderer instance used for this layer. |
| `getSlot()` | [`TemplateLayer`](/api/view/template-layer/) | Get the execution container for a slot. |
| `getSlots()` | [`TemplateLayer`](/api/view/template-layer/) | Get all slots. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `hasSlot()` | [`TemplateLayer`](/api/view/template-layer/) | Check whether or not a slot has been set. |
| `hasSlots()` | [`TemplateLayer`](/api/view/template-layer/) | Check if any slots have been set. |
| `initialize()` | [`TemplateLayer`](/api/view/template-layer/) | Initialize the layer. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `removeSlot()` | [`TemplateLayer`](/api/view/template-layer/) | Remove a slot. |
| `reset()` | [`TemplateLayer`](/api/view/template-layer/) | Drops the per-request rendering state so the layer can be reused. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `setRenderer()` | [`TemplateLayer`](/api/view/template-layer/) | Set a renderer instance to use for this layer. |
| `setSlot()` | [`TemplateLayer`](/api/view/template-layer/) | Set a slot that is rendered along with and available inside this layer. |
