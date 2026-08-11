# Controller

> The per-context registry and factory that dispatch routes through.

The per-context registry and factory that dispatch routes through.

One instance lives in each [`Context`](/api/context/)'s container; application code resolves it as `Controller::class` or receives it as a constructor dependency, and normally neither subclasses nor instantiates it. It answers the questions dispatch asks: does this thing exist ([`Controller::moduleExists()`](/api/controller/controller/#moduleexists), [`Controller::actionExists()`](/api/controller/controller/#actionexists), [`Controller::viewExists()`](/api/controller/controller/#viewexists), [`Controller::modelExists()`](/api/controller/controller/#modelexists)), give me an instance of it ([`Controller::createActionInstance()`](/api/controller/controller/#createactioninstance), [`Controller::createViewInstance()`](/api/controller/controller/#createviewinstance), both autowired through the container and type-checked against the Action and View contracts), and which [`OutputType`](/api/controller/output-type/) is in play ([`Controller::getOutputType()`](/api/controller/controller/#getoutputtype), [`Controller::getOutputTypeNames()`](/api/controller/controller/#getoutputtypenames)). Class lookups accept either the namespaced `App\Modules\<Module>\Actions\<Name>Action` form or the underscored `<Module>_<Name>Action` one.

Module initialization is its other responsibility. [`Controller::initializeModule()`](/api/controller/controller/#initializemodule) applies a module's own configuration, registers its config handlers, seeds the conventional per-module path and naming directives, and rejects a disabled module; the create and check methods call it themselves, so direct calls are rare. Output types are built from the compiled `output_types.xml` during [`Controller::initialize()`](/api/controller/controller/#initialize), and [`Controller::getGlobalResponse()`](/api/controller/controller/#getglobalresponse) hands out the response the whole request writes to.

[`Controller::countExecution()`](/api/controller/controller/#countexecution) caps how many dispatches one request may chain (the `max_executions` parameter, 20 by default) and throws once that is exceeded. [`Controller::reset()`](/api/controller/controller/#reset) restores the per-request baseline in worker mode, including putting back the configured default output type rather than leaving the previous request's choice in place.

## Synopsis

`class Controller extends ParameterHolder implements ControllerInterface`

|  |  |
|---|---|
| Extends | [`ParameterHolder`](/api/util/parameter-holder/) |
| Implements | [`ControllerInterface`](/api/controller/controller-interface/) |
| Source | `Controller/Controller.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `DEBUG` | `false` | Enable verbose controller lifecycle logging (worker diagnostics). |

## Constructor

### __construct()

`public function __construct(): mixed`

Constructor.

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`actionExists(string $moduleName, string $actionName): bool`](#actionexists) | Indicates whether or not a module has a specific action. |
| [`checkActionFile(string $moduleName, string $actionName): string|false`](#checkactionfile) | Indicates whether or not a module has a specific action file. |
| [`checkViewFile(string $moduleName, string $viewName): mixed`](#checkviewfile) | Indicates whether or not a module has a specific view file. |
| [`countExecution(): void`](#countexecution) | Increment the execution counter. |
| [`createActionInstance(string $moduleName, string $actionName): Action`](#createactioninstance) | Retrieve an Action implementation instance. |
| [`createViewInstance(string $moduleName, string $viewName): View`](#createviewinstance) | Retrieve a View implementation instance. |
| [`getContext(): Context`](#getcontext) | Retrieve the current application context. |
| [`getGlobalResponse(): WebResponse`](#getglobalresponse) | Get the global response instance. |
| [`getOutputType(string $name = null): OutputType`](#getoutputtype) | Retrieve an Output Type object |
| [`getOutputTypeNames(): array<string>`](#getoutputtypenames) | Return the registered output type names (lowercased keys as configured). |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this controller. |
| [`initializeModule(string $moduleName): void`](#initializemodule) | Initialize a module and load its autoload, module config etc. |
| [`modelExists(string $moduleName, string $modelName): bool`](#modelexists) | Indicates whether or not a module has a specific model. |
| [`moduleExists(string $moduleName): bool`](#moduleexists) | Indicates whether or not a module exists. |
| [`reset(): void`](#reset) | Reset the controller state for FrankenPHP worker mode. |
| [`shutdown(): void`](#shutdown) | Execute the shutdown procedure for this controller. |
| [`startup(): void`](#startup) | Do any necessary startup work after initialization. |
| [`viewExists(string $moduleName, string $viewName): bool`](#viewexists) | Indicates whether or not a module has a specific view. |

### actionExists()

`public function actionExists(string $moduleName, string $actionName): bool`

Indicates whether or not a module has a specific action.

A view name.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` | A module name. |
| `$actionName` | `string` | A view name. |

Returns `bool` — true, if the action exists, otherwise false.

### checkActionFile()

`public function checkActionFile(string $moduleName, string $actionName): string|false`

Indicates whether or not a module has a specific action file.

An action name.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` | A module name. |
| `$actionName` | `string` | An action name. |

Returns `string``|``false` — the path to the action file if the action file exists and is readable, false in any other case

### checkViewFile()

`public function checkViewFile(string $moduleName, string $viewName): mixed`

Indicates whether or not a module has a specific view file.

A view name.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` | A module name. |
| `$viewName` | `string` | A view name. |

Returns `mixed` — the path to the view file if the view file exists and is readable, false in any other case

### countExecution()

`public function countExecution(): void`

Increment the execution counter.

Will throw an exception if the maximum amount of runs is exceeded.

| Throws | When |
|---|---|
| `ControllerException` | If too many execution runs were made. |

### createActionInstance()

`public function createActionInstance(string $moduleName, string $actionName): Action`

Retrieve an Action implementation instance.

An action name.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` | A module name. |
| `$actionName` | `string` | An action name. |

Returns [`Action`](/api/action/action/) — An Action implementation instance

| Throws | When |
|---|---|
| `Exception` | if the action could not be found. |

### createViewInstance()

`public function createViewInstance(string $moduleName, string $viewName): View`

Retrieve a View implementation instance.

A view name.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` | A module name. |
| `$viewName` | `string` | A view name. |

Returns [`View`](/api/view/view/) — A View implementation instance,

| Throws | When |
|---|---|
| `Exception` | if the view could not be found. |

### getContext()

`final public function getContext(): Context`

Retrieve the current application context.

Returns [`Context`](/api/context/) — An Context instance.

### getGlobalResponse()

`public function getGlobalResponse(): WebResponse`

Get the global response instance.

Returns [`WebResponse`](/api/response/web-response/) — The global response.

### getOutputType()

`public function getOutputType(string $name = null): OutputType`

Retrieve an Output Type object

The optional output type name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The optional output type name. |

Returns [`OutputType`](/api/controller/output-type/) — An Output Type object.

### getOutputTypeNames()

`public function getOutputTypeNames(): array<string>`

Return the registered output type names (lowercased keys as configured).

Lightweight helper for middleware that needs the list for negotiation.

Returns `array``<``string``>`

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = []): void`

Initialize this controller.

An array of initialization parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | An Context instance. |
| `$parameters` | `array``<``string``, ``mixed``>` | An array of initialization parameters. |

### initializeModule()

`public function initializeModule(string $moduleName): void`

Initialize a module and load its autoload, module config etc.

The name of the module to initialize.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` | The name of the module to initialize. |

### modelExists()

`public function modelExists(string $moduleName, string $modelName): bool`

Indicates whether or not a module has a specific model.

A model name.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` | A module name. |
| `$modelName` | `string` | A model name. |

Returns `bool` — true, if the model exists, otherwise false.

### moduleExists()

`public function moduleExists(string $moduleName): bool`

Indicates whether or not a module exists.

A module name.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` | A module name. |

Returns `bool` — true, if the module exists, otherwise false.

### reset()

`public function reset(): void`

Reset the controller state for FrankenPHP worker mode.

This clears request-specific state that could leak between requests. Called automatically by FrankenPHP between requests when using worker mode.

### shutdown()

`public function shutdown(): void`

Execute the shutdown procedure for this controller.

### startup()

`public function startup(): void`

Do any necessary startup work after initialization.

This method is not called directly after initialize().

### viewExists()

`public function viewExists(string $moduleName, string $viewName): bool`

Indicates whether or not a module has a specific view.

A view name.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` | A module name. |
| `$viewName` | `string` | A view name. |

Returns `bool` — true, if the view exists, otherwise false.

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
