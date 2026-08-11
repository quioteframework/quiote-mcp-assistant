# SlotRenderable

> Marker interface for renderable slot results.

Marker interface for renderable slot results.

## Synopsis

`interface SlotRenderable`

|  |  |
|---|---|
| Implemented by | [`DeferredSlotRenderable`](/api/execution/deferred-slot-renderable/), [`SlotContent`](/api/execution/slot-content/) |
| Source | `Execution/SlotRenderable.php` |

## Methods

| Method | Description |
|---|---|
| [`getContent(): string`](#getcontent) | Return already-rendered slot content. |

### getContent()

`abstract public function getContent(): string`

Return already-rendered slot content.

Returns `string`
