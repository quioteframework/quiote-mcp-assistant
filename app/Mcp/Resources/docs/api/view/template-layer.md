# TemplateLayer

> A template layer wraps information necessary to render a template.

A template layer wraps information necessary to render a template.

## Synopsis

`abstract class TemplateLayer extends ParameterHolder`

|  |  |
|---|---|
| Extends | [`ParameterHolder`](/api/util/parameter-holder/) |
| Since | `1.0.0` |
| Source | `View/TemplateLayer.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$context` | `mixed` | _protected._ |
| `$contextName` | `mixed` | _protected._ |
| `$renderer` | `mixed` | _protected._ |
| `$slots` | `mixed` | _protected._ Slots are always [`SlotRenderable`](/api/execution/slot-renderable/)s: setSlot() is the only writer and rejects anything else outright (the legacy execution-container form is gone). |

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
| [`__call(string $name, array<int, mixed> $args): mixed`](#call) | Convenience overload for accessing parameters using a method. |
| [`__clone(): mixed`](#clone) | Object cloning callback. |
| [`__sleep(): mixed`](#sleep) | Pre-serialization callback. |
| [`__wakeup(): mixed`](#wakeup) | Post-unserialization callback. |
| [`execute(Renderer $renderer = null, array<string, mixed> &$attributes = [], array<int|string, mixed> &$moreAssigns = []): string`](#execute) | A convenience function that renders all slots and then the main template. |
| [`getRenderer(): ?Renderer`](#getrenderer) | Get the renderer instance used for this layer. |
| [`getResourceStreamIdentifier(): ?string`](#getresourcestreamidentifier) | Get the full, resolved stream location name to the template resource. |
| [`getSlot(string $name): SlotRenderable|null`](#getslot) | Get the execution container for a slot. |
| [`getSlots(): array<string, SlotRenderable>`](#getslots) | Get all slots. |
| [`hasSlot(string $name): bool`](#hasslot) | Check whether or not a slot has been set. |
| [`hasSlots(): bool`](#hasslots) | Check if any slots have been set. |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize the layer. |
| [`removeSlot(string $name): void`](#removeslot) | Remove a slot. |
| [`reset(): void`](#reset) | Drops the per-request rendering state so the layer can be reused. |
| [`setRenderer(Renderer $renderer): void`](#setrenderer) | Set a renderer instance to use for this layer. |
| [`setSlot(string $name, SlotRenderable|string $c): void`](#setslot) | Set a slot that is rendered along with and available inside this layer. |

### __call()

`public function __call(string $name, array<int, mixed> $args): mixed`

Convenience overload for accessing parameters using a method.

The method arguments.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The method name. |
| `$args` | `array``<``int``, ``mixed``>` | The method arguments. |

Returns `mixed`

### __clone()

`public function __clone(): mixed`

Object cloning callback.

Will clone each individual slot (which are execution containers).

Returns `mixed`

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

### execute()

`public function execute(Renderer $renderer = null, array<string, mixed> &$attributes = [], array<int|string, mixed> &$moreAssigns = []): string`

A convenience function that renders all slots and then the main template.

Associative array of additional assigns.

| Parameter | Type | Description |
|---|---|---|
| `$renderer` | [`Renderer`](/api/renderer/renderer/) | An optional renderer instance that will be used instead of the one set on the layer. |
| `$attributes` | `array``<``string``, ``mixed``>` | The template variables. |
| `$moreAssigns` | `array``<``int``|``string``, ``mixed``>` | Associative array of additional assigns. |

Returns `string` — The rendered result.

### getRenderer()

`public function getRenderer(): ?Renderer`

Get the renderer instance used for this layer.

Returns `?`[`Renderer`](/api/renderer/renderer/) — A renderer instance.

### getResourceStreamIdentifier()

`abstract public function getResourceStreamIdentifier(): ?string`

Get the full, resolved stream location name to the template resource.

Returns `?``string` — A PHP stream resource identifier, or null if no template is set.

| Throws | When |
|---|---|
| `Exception` | If the template could not be found. |

### getSlot()

`public function getSlot(string $name): SlotRenderable|null`

Get the execution container for a slot.

The name of the slot.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the slot. |

Returns [`SlotRenderable`](/api/execution/slot-renderable/)`|``null` — The slot's renderable, or null if no slot with that name is set.

### getSlots()

`public function getSlots(): array<string, SlotRenderable>`

Get all slots.

Returns `array``<``string``, `[`SlotRenderable`](/api/execution/slot-renderable/)`>` — An associative array of slot renderables, keyed by slot name.

### hasSlot()

`public function hasSlot(string $name): bool`

Check whether or not a slot has been set.

The name of the slot.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the slot. |

Returns `bool` — True if the slot exists, false otherwise.

### hasSlots()

`public function hasSlots(): bool`

Check if any slots have been set.

Returns `bool` — true if any slots are defined, false otherwise.

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = []): void`

Initialize the layer.

An array of initialization parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | The current Context instance. |
| `$parameters` | `array``<``string``, ``mixed``>` | An array of initialization parameters. |

### removeSlot()

`public function removeSlot(string $name): void`

Remove a slot.

The name of the slot.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the slot. |

### reset()

`public function reset(): void`

Drops the per-request rendering state so the layer can be reused.

Releases the context and its name, the renderer and any registered slots, then delegates to the parent for the parameter state and finally unsets the layer name, template attributes and extra assigns.

### setRenderer()

`public function setRenderer(Renderer $renderer): void`

Set a renderer instance to use for this layer.

A renderer instance.

| Parameter | Type | Description |
|---|---|---|
| `$renderer` | [`Renderer`](/api/renderer/renderer/) | A renderer instance. |

### setSlot()

`public function setSlot(string $name, SlotRenderable|string $c): void`

Set a slot that is rendered along with and available inside this layer.

Deprecated legacy container parameter now supports SlotRenderable only.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the slot. |
| `$c` | [`SlotRenderable`](/api/execution/slot-renderable/)`|``string` | Deprecated legacy container parameter now supports SlotRenderable only. |

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
