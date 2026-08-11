# ControllerInterface

> What the framework asks of a controller: resolve and build the action and view for a dispatch, answer questions about what a module contains, and hold the response being assembled.

What the framework asks of a controller: resolve and build the action and view for a dispatch, answer questions about what a module contains, and hold the response being assembled.

Narrower than [`Controller`](/api/controller/controller/): startup(), shutdown(), reset() and initialize() drive the controller's own lifecycle and belong to the context that owns it, not to the middleware and services that dispatch through it.

## Synopsis

`interface ControllerInterface`

|  |  |
|---|---|
| Implemented by | [`Controller`](/api/controller/controller/) |
| Since | `3.2.0` |
| Source | `Controller/ControllerInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`actionExists(string $moduleName, string $actionName): bool`](#actionexists) | Whether an action exists in a module. |
| [`createActionInstance(string $moduleName, string $actionName): Action`](#createactioninstance) | Build (and initialize) an action instance for a module. |
| [`createViewInstance(string $moduleName, string $viewName): View`](#createviewinstance) | Build a view instance for a module. |
| [`getContext(): Context`](#getcontext) | The context this controller belongs to. |
| [`getGlobalResponse(): WebResponse`](#getglobalresponse) | The response being assembled for this request. |
| [`getOutputType(?string $name = null): OutputType`](#getoutputtype) | A configured output type by name, or the default when $name is null. |
| [`getOutputTypeNames(): array<int, string>`](#getoutputtypenames) | The names of every configured output type. |
| [`initializeModule(string $moduleName): mixed`](#initializemodule) | Load a module's autoload and configuration, once per process. |
| [`modelExists(string $moduleName, string $modelName): bool`](#modelexists) | Whether a model exists in a module. |
| [`moduleExists(string $moduleName): bool`](#moduleexists) | Whether a module exists. |
| [`viewExists(string $moduleName, string $viewName): bool`](#viewexists) | Whether a view exists in a module. |

### actionExists()

`abstract public function actionExists(string $moduleName, string $actionName): bool`

Whether an action exists in a module.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` |  |
| `$actionName` | `string` |  |

Returns `bool`

### createActionInstance()

`abstract public function createActionInstance(string $moduleName, string $actionName): Action`

Build (and initialize) an action instance for a module.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` |  |
| `$actionName` | `string` |  |

Returns [`Action`](/api/action/action/)

### createViewInstance()

`abstract public function createViewInstance(string $moduleName, string $viewName): View`

Build a view instance for a module.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` |  |
| `$viewName` | `string` |  |

Returns [`View`](/api/view/view/)

### getContext()

`abstract public function getContext(): Context`

The context this controller belongs to.

Returns [`Context`](/api/context/)

### getGlobalResponse()

`abstract public function getGlobalResponse(): WebResponse`

The response being assembled for this request.

Returns [`WebResponse`](/api/response/web-response/)

### getOutputType()

`abstract public function getOutputType(?string $name = null): OutputType`

A configured output type by name, or the default when $name is null.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `?``string` |  |

Returns [`OutputType`](/api/controller/output-type/)

### getOutputTypeNames()

`abstract public function getOutputTypeNames(): array<int, string>`

The names of every configured output type.

Returns `array``<``int``, ``string``>`

### initializeModule()

`abstract public function initializeModule(string $moduleName): mixed`

Load a module's autoload and configuration, once per process.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` |  |

Returns `mixed`

| Throws | When |
|---|---|
| `DisabledModuleException` | If the module is disabled. |

### modelExists()

`abstract public function modelExists(string $moduleName, string $modelName): bool`

Whether a model exists in a module.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` |  |
| `$modelName` | `string` |  |

Returns `bool`

### moduleExists()

`abstract public function moduleExists(string $moduleName): bool`

Whether a module exists.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` |  |

Returns `bool`

### viewExists()

`abstract public function viewExists(string $moduleName, string $viewName): bool`

Whether a view exists in a module.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` |  |
| `$viewName` | `string` |  |

Returns `bool`
