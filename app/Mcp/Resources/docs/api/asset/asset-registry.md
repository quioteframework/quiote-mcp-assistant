# AssetRegistry

> Request-scoped collection of page assets (stylesheets, scripts) accumulated while rendering a page and its nested slots.

Request-scoped collection of page assets (stylesheets, scripts) accumulated while rendering a page and its nested slots.

This exists because a page's render tree is not one object: the top-level View and every slot rendered via View::createSlotContent() get their own, separate Action/View instances (see SlotDispatcher::dispatch()), each with its own private attribute holder. Nothing local to any one View instance is visible to the layout template that finally emits <link>/<script> tags. The one thing every node in that tree shares is Context, so the registry lives there (Context::getAssetRegistry()) rather than on WebRequest or any View.

Reached from templates via the renderer "assigns" mechanism (see Quiote\Renderer\Renderer), e.g. a renderer parameter assigns.asset_registry = "assets" makes it available as $assets.

Deduplicates at insertion time (an asset appended by two different slots still renders once), preserving first-insertion order.

## Synopsis

`final class AssetRegistry implements ResetInterface`

|  |  |
|---|---|
| Implements | `ResetInterface` |
| Source | `Asset/AssetRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`addCss(string $href): void`](#addcss) | Registers a stylesheet href for this request. |
| [`addJavascript(string $src): void`](#addjavascript) | Registers a script src for this request. |
| [`css(): list<string>`](#css) |  |
| [`javascript(): list<string>`](#javascript) |  |
| [`reset(): void`](#reset) | Empties both asset sets so the registry can serve the next request. |

### addCss()

`public function addCss(string $href): void`

Registers a stylesheet href for this request.

Adding the same href again is a no-op: the asset keeps the position it had on first insertion and is rendered once.

| Parameter | Type | Description |
|---|---|---|
| `$href` | `string` |  |

### addJavascript()

`public function addJavascript(string $src): void`

Registers a script src for this request.

Adding the same src again is a no-op: the asset keeps the position it had on first insertion and is rendered once.

| Parameter | Type | Description |
|---|---|---|
| `$src` | `string` |  |

### css()

`public function css(): list<string>`

Returns `list``<``string``>`

### javascript()

`public function javascript(): list<string>`

Returns `list``<``string``>`

### reset()

`public function reset(): void`

Empties both asset sets so the registry can serve the next request.
