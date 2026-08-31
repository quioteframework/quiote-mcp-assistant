# ActionInitContext

> What an action is handed by `Action::initialize()`: the identity of the dispatch it is running under, the request and response it works with, and the slot for the view it wants rendered.

What an action is handed by `Action::initialize()`: the identity of the dispatch it is running under, the request and response it works with, and the slot for the view it wants rendered.

Constructed by whoever is dispatching — the executor, the middleware pipeline, the slot dispatcher — and never resolved from the container, which does not own per-execution state and refuses to autowire this type into a `#[Required]` method.

Implementors must answer the module, action, request method and output type of the current dispatch, expose the [`Context`](/api/context/) and the [`WebResponse`](/api/response/web-response/) being written into, and remember the view module and view name set on them so the dispatcher can read them back after the action returns. Attribute storage comes from [`AttributeHolder`](/api/util/attribute-holder/) on the implementations rather than from this interface.

## Synopsis

`interface ActionInitContext`

|  |  |
|---|---|
| Implemented by | [`LightweightActionInitContext`](/api/execution/lightweight-action-init-context/) |
| Source | `Execution/ActionInitContext.php` |

## Methods

| Method | Description |
|---|---|
| [`getActionName(): string`](#getactionname) | Returns the name of the action being executed. |
| [`getContext(): Context`](#getcontext) | Returns the application Context the action is executing under. |
| [`getModuleName(): string`](#getmodulename) | Returns the name of the module the action was dispatched from. |
| [`getOutputTypeName(): string`](#getoutputtypename) | Returns the name of the output type selected for this dispatch. |
| [`getRequestData(): ?ServerRequestInterface`](#getrequestdata) | Returns the PSR-7 server request backing this dispatch. |
| [`getRequestMethod(): string`](#getrequestmethod) | Returns the request method token the action was dispatched with. |
| [`getResponse(): WebResponse`](#getresponse) | Returns the response the action and its view write into. |
| [`getValidationManager(): ?ValidationManager`](#getvalidationmanager) | Returns the validation manager carrying this dispatch's error state, or null when none is available. |
| [`getViewModuleName(): ?string`](#getviewmodulename) | Returns the view module recorded by setViewModuleName(), or null when none was set. |
| [`getViewName(): ?string`](#getviewname) | Returns the view name recorded by setViewName(), or null when none was set. |
| [`setViewModuleName(?string $module): void`](#setviewmodulename) | Records the module hosting the view to render, overriding the action's own module. |
| [`setViewName(?string $name): void`](#setviewname) | Records the name of the view to render for this action. |

### getActionName()

`abstract public function getActionName(): string`

Returns the name of the action being executed.

Returns `string`

### getContext()

`abstract public function getContext(): Context`

Returns the application Context the action is executing under.

Returns [`Context`](/api/context/)

### getModuleName()

`abstract public function getModuleName(): string`

Returns the name of the module the action was dispatched from.

Returns `string`

### getOutputTypeName()

`abstract public function getOutputTypeName(): string`

Returns the name of the output type selected for this dispatch.

Returns `string`

### getRequestData()

`abstract public function getRequestData(): ?ServerRequestInterface`

Returns the PSR-7 server request backing this dispatch.

Null when the action is executed without a request, as in a slot or test dispatch assembled directly rather than from an incoming HTTP request.

Returns `?`[`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/)

### getRequestMethod()

`abstract public function getRequestMethod(): string`

Returns the request method token the action was dispatched with.

Returns `string`

### getResponse()

`abstract public function getResponse(): WebResponse`

Returns the response the action and its view write into.

Returns [`WebResponse`](/api/response/web-response/)

### getValidationManager()

`abstract public function getValidationManager(): ?ValidationManager`

Returns the validation manager carrying this dispatch's error state, or null when none is available.

Returns `?`[`ValidationManager`](/api/validator/validation-manager/)

### getViewModuleName()

`abstract public function getViewModuleName(): ?string`

Returns the view module recorded by setViewModuleName(), or null when none was set.

Returns `?``string`

### getViewName()

`abstract public function getViewName(): ?string`

Returns the view name recorded by setViewName(), or null when none was set.

Returns `?``string`

### setViewModuleName()

`abstract public function setViewModuleName(?string $module): void`

Records the module hosting the view to render, overriding the action's own module.

Passing null clears the override so the action's module is used.

| Parameter | Type | Description |
|---|---|---|
| `$module` | `?``string` |  |

### setViewName()

`abstract public function setViewName(?string $name): void`

Records the name of the view to render for this action.

Passing null clears the selection, leaving the view to be resolved from the action's own return value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `?``string` |  |
