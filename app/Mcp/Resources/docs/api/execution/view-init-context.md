# ViewInitContext

> ViewInitContext: minimal, presentation-focused initialization contract for views.

ViewInitContext: minimal, presentation-focused initialization contract for views.

Decouples views from action/request execution mechanics and legacy container.

## Synopsis

`interface ViewInitContext`

|  |  |
|---|---|
| Implemented by | [`ImmutableViewInitContext`](/api/execution/immutable-view-init-context/) |
| Source | `Execution/ViewInitContext.php` |

## Methods

| Method | Description |
|---|---|
| [`getActionAttributes(): array<string, mixed>`](#getactionattributes) |  |
| [`getActionModuleName(): ?string`](#getactionmodulename) | Returns the module of the action that selected this view. |
| [`getActionName(): ?string`](#getactionname) | Returns the name of the action that selected this view, or null when there was none. |
| [`getContext(): Context`](#getcontext) | Returns the application Context the view is rendering under. |
| [`getOutputTypeName(): string`](#getoutputtypename) | Returns the lowercase name of the output type the view renders for. |
| [`getPsrResponse(): ResponseInterface|null`](#getpsrresponse) | Optional PSR-7 response adapter backing the legacy response. |
| [`getResponse(): WebResponse`](#getresponse) | Returns the response the view writes its rendered output into. |
| [`getViewModuleName(): string`](#getviewmodulename) | Returns the canonical name of the module hosting the view. |
| [`getViewName(): string`](#getviewname) | Returns the canonical name of the view being rendered. |

### getActionAttributes()

`abstract public function getActionAttributes(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### getActionModuleName()

`abstract public function getActionModuleName(): ?string`

Returns the module of the action that selected this view.

Null when the view was reached without an originating action, so callers that need a module name should fall back to the view module.

Returns `?``string`

### getActionName()

`abstract public function getActionName(): ?string`

Returns the name of the action that selected this view, or null when there was none.

Returns `?``string`

### getContext()

`abstract public function getContext(): Context`

Returns the application Context the view is rendering under.

Returns [`Context`](/api/context/)

### getOutputTypeName()

`abstract public function getOutputTypeName(): string`

Returns the lowercase name of the output type the view renders for.

Returns `string`

### getPsrResponse()

`abstract public function getPsrResponse(): ResponseInterface|null`

Optional PSR-7 response adapter backing the legacy response.

Views may use this when interacting with PSR-aware middleware or code.

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)`|``null`

### getResponse()

`abstract public function getResponse(): WebResponse`

Returns the response the view writes its rendered output into.

Returns [`WebResponse`](/api/response/web-response/)

### getViewModuleName()

`abstract public function getViewModuleName(): string`

Returns the canonical name of the module hosting the view.

Returns `string`

### getViewName()

`abstract public function getViewName(): string`

Returns the canonical name of the view being rendered.

Returns `string`
