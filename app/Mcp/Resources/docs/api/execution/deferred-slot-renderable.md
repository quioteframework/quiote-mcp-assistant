# DeferredSlotRenderable

> A slot whose action is not dispatched until its content is actually asked for.

A slot whose action is not dispatched until its content is actually asked for.

Returned by `View::slot()`, which captures the target module, action, parameters and output type and hands the template this object. Because it is `\Stringable`, echoing it inside a template is what triggers the dispatch; a slot a template never prints costs nothing. The rendered content is memoized, so the slot action runs at most once per instance.

Dispatch resolves the parent [`WebRequest`](/api/request/web-request/) and the [`SlotDispatcher`](/api/execution/slot-dispatcher/) from the container at that moment. A failure is rethrown so the error-handling middleware decides what the client sees, and nothing is memoized.

[`DeferredSlotRenderable::getModule()`](/api/execution/deferred-slot-renderable/#getmodule), [`DeferredSlotRenderable::getAction()`](/api/execution/deferred-slot-renderable/#getaction), [`DeferredSlotRenderable::getOutputType()`](/api/execution/deferred-slot-renderable/#getoutputtype) and [`DeferredSlotRenderable::getArguments()`](/api/execution/deferred-slot-renderable/#getarguments) describe the pending dispatch without performing it; [`DeferredSlotRenderable::toArray()`](/api/execution/deferred-slot-renderable/#toarray) does perform it, since it reports the content length.

## Synopsis

`class DeferredSlotRenderable implements SlotRenderable, Stringable`

|  |  |
|---|---|
| Implements | [`SlotRenderable`](/api/execution/slot-renderable/), [`Stringable`](https://www.php.net/manual/en/class.stringable.php) |
| Source | `Execution/DeferredSlotRenderable.php` |

## Constructor

### __construct()

`public function __construct(Context $context, string $module, string $action, array<string, mixed> $parameters = [], ?string $outputType = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |
| `$outputType` | `?``string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`__toString(): string`](#tostring) |  |
| [`getAction(): string`](#getaction) | Returns the name of the slot action to dispatch. |
| [`getArguments(): array<string, mixed>`](#getarguments) |  |
| [`getContent(): string`](#getcontent) | Renders the slot on first call and returns its content. |
| [`getModule(): string`](#getmodule) | Returns the module the slot action will be dispatched from. |
| [`getOutputType(): ?string`](#getoutputtype) | Returns the output type the slot will render for, or null to let dispatch pick one. |
| [`toArray(): array<string, mixed>`](#toarray) |  |

### __toString()

`public function __toString(): string`

Returns `string`

### getAction()

`public function getAction(): string`

Returns the name of the slot action to dispatch.

Returns `string`

### getArguments()

`public function getArguments(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### getContent()

`public function getContent(): string`

Renders the slot on first call and returns its content.

The result is memoized, so the slot action is dispatched at most once per instance no matter how often a template stringifies it. Dispatch resolves the parent WebRequest and the SlotDispatcher from the container and hands them the module, action, parameters and output type captured at construction. A failure during dispatch is recorded to PHP's own error log with the slot's identity and a truncated trace when debug logging is on, then rethrown so the error-handling middleware decides what the client sees; nothing is memoized in that case.

Returns `string`

### getModule()

`public function getModule(): string`

Returns the module the slot action will be dispatched from.

Returns `string`

### getOutputType()

`public function getOutputType(): ?string`

Returns the output type the slot will render for, or null to let dispatch pick one.

Returns `?``string`

### toArray()

`public function toArray(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`
