# SlotContent

> Immutable value object representing rendered slot content plus metadata.

Immutable value object representing rendered slot content plus metadata.

It intentionally carries only the data needed by template layers and renderers, not a full execution lifecycle.

## Synopsis

`final readonly class SlotContent implements SlotRenderable, Stringable`

|  |  |
|---|---|
| Implements | [`SlotRenderable`](/api/execution/slot-renderable/), [`Stringable`](https://www.php.net/manual/en/class.stringable.php) |
| Source | `Execution/SlotContent.php` |

## Constructor

### __construct()

`public function __construct(string $module, string $action, ?string $outputType, string $content, array<string, mixed> $arguments = []): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$outputType` | `?``string` |  |
| `$content` | `string` |  |
| `$arguments` | `array``<``string``, ``mixed``>` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`__toString(): string`](#tostring) |  |
| [`getAction(): string`](#getaction) | Returns the name of the slot action that produced this content. |
| [`getArguments(): array<string, mixed>`](#getarguments) |  |
| [`getContent(): string`](#getcontent) | Return the already rendered slot content. |
| [`getModule(): string`](#getmodule) | Returns the module the slot action was dispatched from. |
| [`getOutputType(): ?string`](#getoutputtype) | Returns the output type the slot was rendered for, or null when the caller did not pin one. |
| [`toArray(): array{module: string, action: string, output_type: ?string, arguments: array<string, mixed>, content_length: int}`](#toarray) |  |

### __toString()

`public function __toString(): string`

Returns `string`

### getAction()

`public function getAction(): string`

Returns the name of the slot action that produced this content.

Returns `string`

### getArguments()

`public function getArguments(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### getContent()

`public function getContent(): string`

Return the already rendered slot content.

Returns `string`

### getModule()

`public function getModule(): string`

Returns the module the slot action was dispatched from.

Returns `string`

### getOutputType()

`public function getOutputType(): ?string`

Returns the output type the slot was rendered for, or null when the caller did not pin one.

Returns `?``string`

### toArray()

`public function toArray(): array{module: string, action: string, output_type: ?string, arguments: array<string, mixed>, content_length: int}`

Returns `array{module: string, action: string, output_type: ?string, arguments: array<string, mixed>, content_length: int}`
