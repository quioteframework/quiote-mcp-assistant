# View

> Base class for the presentation half of a dispatch: turns the attributes an action left behind into the body of the response.

Base class for the presentation half of a dispatch: turns the attributes an action left behind into the body of the response.

An application subclasses this per view. The framework builds the instance through the container, calls [`View::initialize()`](/api/view/view/#initialize) with the init context -- which seeds the view's attribute store from the action's attributes so templates see them -- and then calls the `execute<OutputType>()` method for the output type in play (`executeHtml()`, `executeJson()`, and so on), with the abstract [`View::execute()`](/api/view/view/#execute) as the catch-all every subclass implements. Returning a string makes it the body; returning null hands rendering to the template layers, which [`View::renderLayers()`](/api/view/view/#renderlayers) runs in order, each layer's output becoming the next one's `inner` attribute.

Layers usually come from [`View::loadLayout()`](/api/view/view/#loadlayout), which materializes a layout declared for the current [`OutputType`](/api/controller/output-type/) together with its slots; [`View::createLayer()`](/api/view/view/#createlayer), [`View::appendLayer()`](/api/view/view/#appendlayer), [`View::prependLayer()`](/api/view/view/#prependlayer), [`View::removeLayer()`](/api/view/view/#removelayer) and [`View::clearLayers()`](/api/view/view/#clearlayers) shape the stack by hand. Slot dispatch is deferred: [`View::createSlotContent()`](/api/view/view/#createslotcontent) returns a renderable that only runs its module/action when the template asks for the content, and yields empty content when a slot points back at the view rendering it, so a self-referential layout cannot recurse. [`View::renderSlot()`](/api/view/view/#renderslot) is the eager, string-returning form.

[`View::addCss()`](/api/view/view/#addcss) and [`View::addJavascript()`](/api/view/view/#addjavascript) register assets on the request's shared registry, so a slot-nested view contributes to the same page as the top-level one. [`View::returnProblemDetailsFromValidationIncidents()`](/api/view/view/#returnproblemdetailsfromvalidationincidents) builds an RFC 9457 body from the live validation errors for an API-style view. [`View::reset()`](/api/view/view/#reset) drops the per-request context and layers so the instance can be reused in worker mode.

## Synopsis

`abstract class View implements ResetInterface`

|  |  |
|---|---|
| Implements | `ResetInterface` |
| Uses | [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/) |
| Source | `View/View.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `NONE` | `null` |  |

## Properties

| Property | Type | Description |
|---|---|---|
| `$context` | `mixed` | _protected._ |
| `$initContext` | `mixed` | _protected._ |
| `$layers` | `mixed` | _protected._ |
| `$localAttributes` | `mixed` | _protected._ The consumer's own mutable attribute store, or null when it has none and the init context's holder is the only storage. |

## Methods

| Method | Description |
|---|---|
| [`addCss(string $href): void`](#addcss) | Register a stylesheet for this page's render tree. |
| [`addJavascript(string $src): void`](#addjavascript) | Register a script for this page's render tree. |
| [`appendAttribute(string $name, mixed $value): void`](#appendattribute) |  |
| [`appendAttributeByRef(string $name, mixed &$value): void`](#appendattributebyref) |  |
| [`appendLayer(TemplateLayer $layer, TemplateLayer $otherLayer = null): TemplateLayer`](#appendlayer) | Append a layer to the list of layers. |
| [`clearAttributes(): void`](#clearattributes) |  |
| [`clearLayers(): void`](#clearlayers) | Remove all layers from the list. |
| [`createForwardContainer(string $moduleName, string $actionName, mixed $arguments = null, string $outputType = null, string $requestMethod = null): mixed`](#createforwardcontainer) | Creates a new container with the same output type and request method as this view's container. |
| [`createLayer(string $class, string $name, mixed $renderer = null): TemplateLayer`](#createlayer) | Create a new template layer object. |
| [`createSlotContainer(string $moduleName, string $actionName, mixed $arguments = null, string $outputType = null, string $requestMethod = null): SlotRenderable`](#createslotcontainer) | Creates a new container with the same output type and request method as this view's container. |
| [`createSlotContent(string $moduleName, string $actionName, mixed $arguments = null, ?string $outputType = null): SlotRenderable`](#createslotcontent) | New API returning SlotContent value object explicitly, bypassing container wrapper regardless of flag. |
| [`execute(WebRequest $rd): mixed`](#execute) | Execute any presentation logic and set template attributes. |
| [`getAttribute(string $name, mixed $default = null): mixed`](#getattribute) |  |
| [`getAttributeNames(): array<int, int|string>`](#getattributenames) |  |
| [`getAttributes(): array<int|string, mixed>`](#getattributes) |  |
| [`getContainer(): ActionInitContext|ViewInitContext|null`](#getcontainer) |  |
| [`getContext(): ?Context`](#getcontext) | Retrieve the current application context. |
| [`getCurrentOutputType(): OutputType`](#getcurrentoutputtype) | Resolve current OutputType regardless of whether container is legacy execution container or a lightweight ActionInitContext lacking getOutputType(). |
| [`getInitContext(): ActionInitContext|ViewInitContext|null`](#getinitcontext) | Returns the initialization context this view was handed. |
| [`getLayer(string $name): FileTemplateLayer|TemplateLayer|null`](#getlayer) | Retrieve a layer from the list. |
| [`getLayers(): array<int, TemplateLayer>`](#getlayers) | Get all layers from the list. |
| [`getResolvedViewModule(): ?string`](#getresolvedviewmodule) | Convenience: unify access to resolved view module via ActionInitContext interface. |
| [`getResolvedViewName(): ?string`](#getresolvedviewname) | Convenience: unify access to resolved view name via ActionInitContext interface. |
| [`getResponse(): WebResponse`](#getresponse) | Retrieve the Response instance for this View. |
| [`hasAttribute(string $name): bool`](#hasattribute) |  |
| [`initialize(ActionInitContext|ViewInitContext $context): void`](#initialize) | Initialize this view. |
| [`loadLayout(string $layoutName = null): array<string, mixed>`](#loadlayout) | Load a pre-configured layout. |
| [`prependLayer(TemplateLayer $layer, TemplateLayer $otherLayer = null): TemplateLayer`](#prependlayer) | Prepend a layer to the list of layers. |
| [`removeAttribute(string $name): mixed`](#removeattribute) |  |
| [`removeLayer(TemplateLayer $layer): void`](#removelayer) | Remove a layer from the list. |
| [`renderLayers(): string`](#renderlayers) | Render all configured template layers (in order) and return concatenated output. |
| [`renderSlot(string $moduleName, string $actionName, ?array<string, mixed> $arguments = null, ?string $outputType = null): string`](#renderslot) | Convenience helper: directly render a slot and return its string content. |
| [`renderSystemForward(string $name, ?WebRequest $arguments = null, ?string $outputType = null): string`](#rendersystemforward) | Render a system forward (login or secure) using ForwardService without creating a forward container. |
| [`reset(): void`](#reset) | Drops the per-request state so the view instance can be reused. |
| [`returnProblemDetailsFromValidationIncidents(?string $title = null, int $status = 400, ?string $type = null, ?string $detail = null, array<string, mixed> $extensions = []): string`](#returnproblemdetailsfromvalidationincidents) | Build an RFC 9457 Problem Details body from the current request's validation errors, set the response status and `application/problem+json` content type, and return the JSON string — designed to be returned directly from an executeJson() (or any execute*()) method: public function executeJson(WebRequest $rd) { return $this->returnProblemDetailsFromValidationIncidents(title: 'Invalid order'); } The `errors` map (field => messages) is taken from the live validation manager. |
| [`setAttribute(string $name, mixed $value): void`](#setattribute) |  |
| [`setAttributeByRef(string $name, mixed &$value): void`](#setattributebyref) |  |
| [`setAttributes(array<int|string, mixed> $attributes): void`](#setattributes) |  |
| [`setAttributesByRef(array<int|string, mixed> &$attributes): void`](#setattributesbyref) |  |

### addCss()

`public function addCss(string $href): void`

Register a stylesheet for this page's render tree.

Unlike appendAttribute(), this reaches the request's shared AssetRegistry directly, so it works from a top-level view or a slot-nested one alike, and is unaffected by the immutable-snapshot no-op that appendAttribute() hits under the modern container-less execution path.

Silently does nothing when the view has no context yet, and so no registry to register with.

| Parameter | Type | Description |
|---|---|---|
| `$href` | `string` |  |

### addJavascript()

`public function addJavascript(string $src): void`

Register a script for this page's render tree.

See addCss().

| Parameter | Type | Description |
|---|---|---|
| `$src` | `string` |  |

### appendAttribute()

`public function appendAttribute(string $name, mixed $value): void`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

An attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$value` | `mixed` | An attribute value. |

### appendAttributeByRef()

`public function appendAttributeByRef(string $name, mixed &$value): void`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

A reference to an attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$value` | `mixed` | A reference to an attribute value. |

### appendLayer()

`public function appendLayer(TemplateLayer $layer, TemplateLayer $otherLayer = null): TemplateLayer`

Append a layer to the list of layers.

An optional other layer to insert after.

| Parameter | Type | Description |
|---|---|---|
| `$layer` | [`TemplateLayer`](/api/view/template-layer/) | The layer to insert. |
| `$otherLayer` | [`TemplateLayer`](/api/view/template-layer/) | An optional other layer to insert after. |

Returns [`TemplateLayer`](/api/view/template-layer/) — The template layer that was inserted.

### clearAttributes()

`public function clearAttributes(): void`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

### clearLayers()

`public function clearLayers(): void`

Remove all layers from the list.

### createForwardContainer()

`public function createForwardContainer(string $moduleName, string $actionName, mixed $arguments = null, string $outputType = null, string $requestMethod = null): mixed`

Creates a new container with the same output type and request method as this view's container.

Optional name of the request method to be used in this
                   container.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` | The name of the module. |
| `$actionName` | `string` | The name of the action. |
| `$arguments` | `mixed` | An array of request parameters. |
| `$outputType` | `string` | Optional name of an initial output type to set. |
| `$requestMethod` | `string` | Optional name of the request method to be used in this container. |

Returns `mixed` — Forward descriptor or content (string) depending on usage.

### createLayer()

`public function createLayer(string $class, string $name, mixed $renderer = null): TemplateLayer`

Create a new template layer object.

An optional name of the non-default renderer to use, or
                   an Renderer instance to use.

| Parameter | Type | Description |
|---|---|---|
| `$class` | `string` | The class name of the TemplateLayer implementation. |
| `$name` | `string` | The name of the layer. |
| `$renderer` | `mixed` | An optional name of the non-default renderer to use, or an Renderer instance to use. |

Returns [`TemplateLayer`](/api/view/template-layer/) — A template layer instance.

### createSlotContainer()

`public function createSlotContainer(string $moduleName, string $actionName, mixed $arguments = null, string $outputType = null, string $requestMethod = null): SlotRenderable`

Creates a new container with the same output type and request method as this view's container.

Optional name of the request method to be used in this
                   container.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` | The name of the module. |
| `$actionName` | `string` | The name of the action. |
| `$arguments` | `mixed` | Array of request parameters. |
| `$outputType` | `string` | Optional name of an initial output type to set. |
| `$requestMethod` | `string` | Optional name of the request method to be used in this container. |

Returns [`SlotRenderable`](/api/execution/slot-renderable/) — Slot content value object.

### createSlotContent()

`public function createSlotContent(string $moduleName, string $actionName, mixed $arguments = null, ?string $outputType = null): SlotRenderable`

New API returning SlotContent value object explicitly, bypassing container wrapper regardless of flag.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` |  |
| `$actionName` | `string` |  |
| `$arguments` | `mixed` |  |
| `$outputType` | `?``string` |  |

Returns [`SlotRenderable`](/api/execution/slot-renderable/)

### execute()

`abstract public function execute(WebRequest $rd): mixed`

Execute any presentation logic and set template attributes.

The action's request data holder.

| Parameter | Type | Description |
|---|---|---|
| `$rd` | [`WebRequest`](/api/request/web-request/) | The action's request data holder. |

Returns `mixed` — Array forward descriptor (legacy) or null.

### getAttribute()

`public function getAttribute(string $name, mixed $default = null): mixed`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

A default attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$default` | `mixed` | A default attribute value. |

Returns `mixed`

### getAttributeNames()

`public function getAttributeNames(): array<int, int|string>`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

Returns `array``<``int``, ``int``|``string``>`

### getAttributes()

`public function getAttributes(): array<int|string, mixed>`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

Returns `array``<``int``|``string``, ``mixed``>`

### getContainer()

`final public function getContainer(): ActionInitContext|ViewInitContext|null`

Returns [`ActionInitContext`](/api/execution/action-init-context/)`|`[`ViewInitContext`](/api/execution/view-init-context/)`|``null`

### getContext()

`final public function getContext(): ?Context`

Retrieve the current application context.

Returns `?`[`Context`](/api/context/) — The current Context instance.

### getCurrentOutputType()

`protected function getCurrentOutputType(): OutputType`

Resolve current OutputType regardless of whether container is legacy execution container or a lightweight ActionInitContext lacking getOutputType().

Returns [`OutputType`](/api/controller/output-type/)

### getInitContext()

`final public function getInitContext(): ActionInitContext|ViewInitContext|null`

Returns the initialization context this view was handed.

An [`ActionInitContext`](/api/execution/action-init-context/) when the view was reached through an action (and therefore carries the output type and the selected view module/name), a [`ViewInitContext`](/api/execution/view-init-context/) otherwise. Null before [`View::initialize()`](/api/view/view/#initialize) has run, and again after the view is cleaned up for reuse.

Returns [`ActionInitContext`](/api/execution/action-init-context/)`|`[`ViewInitContext`](/api/execution/view-init-context/)`|``null`

### getLayer()

`public function getLayer(string $name): FileTemplateLayer|TemplateLayer|null`

Retrieve a layer from the list.

The name of the layer.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the layer. |

Returns [`FileTemplateLayer`](/api/view/file-template-layer/)`|`[`TemplateLayer`](/api/view/template-layer/)`|``null` — The layer instance, or null if not found.

### getLayers()

`public function getLayers(): array<int, TemplateLayer>`

Get all layers from the list.

Returns `array``<``int``, `[`TemplateLayer`](/api/view/template-layer/)`>` — An array of template layer instances.

### getResolvedViewModule()

`protected function getResolvedViewModule(): ?string`

Convenience: unify access to resolved view module via ActionInitContext interface.

Returns `?``string`

### getResolvedViewName()

`protected function getResolvedViewName(): ?string`

Convenience: unify access to resolved view name via ActionInitContext interface.

Returns `?``string`

### getResponse()

`final public function getResponse(): WebResponse`

Retrieve the Response instance for this View.

Returns [`WebResponse`](/api/response/web-response/) — The Response instance.

### hasAttribute()

`public function hasAttribute(string $name): bool`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

An attribute name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |

Returns `bool`

### initialize()

`public function initialize(ActionInitContext|ViewInitContext $context): void`

Initialize this view.

Initialization context.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`ActionInitContext`](/api/execution/action-init-context/)`|`[`ViewInitContext`](/api/execution/view-init-context/) | Initialization context. |

### loadLayout()

`public function loadLayout(string $layoutName = null): array<string, mixed>`

Load a pre-configured layout.

The (optional) name of the layout.

| Parameter | Type | Description |
|---|---|---|
| `$layoutName` | `string` | The (optional) name of the layout. |

Returns `array``<``string``, ``mixed``>` — An array of parameters set for the layout.

| Throws | When |
|---|---|
| `Exception` | If the layout doesn't exist. |

### prependLayer()

`public function prependLayer(TemplateLayer $layer, TemplateLayer $otherLayer = null): TemplateLayer`

Prepend a layer to the list of layers.

An optional other layer to insert before.

| Parameter | Type | Description |
|---|---|---|
| `$layer` | [`TemplateLayer`](/api/view/template-layer/) | The layer to insert. |
| `$otherLayer` | [`TemplateLayer`](/api/view/template-layer/) | An optional other layer to insert before. |

Returns [`TemplateLayer`](/api/view/template-layer/) — The template layer that was inserted.

### removeAttribute()

`public function removeAttribute(string $name): mixed`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

An attribute name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |

Returns `mixed` — The removed value, or null when the name was not set.

### removeLayer()

`public function removeLayer(TemplateLayer $layer): void`

Remove a layer from the list.

The layer to remove.

| Parameter | Type | Description |
|---|---|---|
| `$layer` | [`TemplateLayer`](/api/view/template-layer/) | The layer to remove. |

### renderLayers()

`public function renderLayers(): string`

Render all configured template layers (in order) and return concatenated output.

Legacy compatibility: classic views called setupHtml()/loadLayout() and returned null; older pipeline later rendered layers implicitly. New middleware/dispatch paths invoke this on-demand when execute* returns null and layers are present.

Returns `string`

### renderSlot()

`public function renderSlot(string $moduleName, string $actionName, ?array<string, mixed> $arguments = null, ?string $outputType = null): string`

Convenience helper: directly render a slot and return its string content.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` |  |
| `$actionName` | `string` |  |
| `$arguments` | `?``array``<``string``, ``mixed``>` |  |
| `$outputType` | `?``string` |  |

Returns `string`

### renderSystemForward()

`public function renderSystemForward(string $name, ?WebRequest $arguments = null, ?string $outputType = null): string`

Render a system forward (login or secure) using ForwardService without creating a forward container.

Falls back to legacy createForwardContainer if ForwardService fails.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$arguments` | `?`[`WebRequest`](/api/request/web-request/) |  |
| `$outputType` | `?``string` |  |

Returns `string`

### reset()

`public function reset(): void`

Drops the per-request state so the view instance can be reused.

Releases both the initialization context and the current context along with any registered layers; the view must be initialized again before it can execute.

### returnProblemDetailsFromValidationIncidents()

`protected function returnProblemDetailsFromValidationIncidents(?string $title = null, int $status = 400, ?string $type = null, ?string $detail = null, array<string, mixed> $extensions = []): string`

Build an RFC 9457 Problem Details body from the current request's validation errors, set the response status and `application/problem+json` content type, and return the JSON string — designed to be returned directly from an executeJson() (or any execute*()) method: public function executeJson(WebRequest $rd) { return $this->returnProblemDetailsFromValidationIncidents(title: 'Invalid order'); } The `errors` map (field => messages) is taken from the live validation manager.

Extra top-level Problem Details members.

| Parameter | Type | Description |
|---|---|---|
| `$title` | `?``string` |  |
| `$status` | `int` |  |
| `$type` | `?``string` |  |
| `$detail` | `?``string` |  |
| `$extensions` | `array``<``string``, ``mixed``>` | Extra top-level Problem Details members. |

Returns `string`

### setAttribute()

`public function setAttribute(string $name, mixed $value): void`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

An attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$value` | `mixed` | An attribute value. |

### setAttributeByRef()

`public function setAttributeByRef(string $name, mixed &$value): void`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

A reference to an attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$value` | `mixed` | A reference to an attribute value. |

### setAttributes()

`public function setAttributes(array<int|string, mixed> $attributes): void`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array``<``int``|``string``, ``mixed``>` |  |

### setAttributesByRef()

`public function setAttributesByRef(array<int|string, mixed> &$attributes): void`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array``<``int``|``string``, ``mixed``>` |  |
