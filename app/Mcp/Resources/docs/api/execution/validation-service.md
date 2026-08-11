# ValidationService

> Adapter around legacy validation logic to enable container-less execution.

Adapter around legacy validation logic to enable container-less execution.

Calls Action::validate directly (manual validators unsupported without container).

## Synopsis

`class ValidationService`

|  |  |
|---|---|
| Source | `Execution/ValidationService.php` |

## Constructor

### __construct()

`public function __construct(?ValidationManager $manager = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$manager` | `?`[`ValidationManager`](/api/validator/validation-manager/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getContext(): ?Context`](#getcontext) | The context of the action being validated; validators are initialized with it. |
| [`getValidationManager(): ?ValidationManager`](#getvalidationmanager) | Returns the validation manager the service is working with. |
| [`validate(Action $action, WebRequest $request, string $moduleName = '', string $actionName = '', string $method = ''): ValidationResult`](#validate) | Perform validation for an action execution. |
| [`validateDeclaredOnly(Action $action, WebRequest $request, string $moduleName, string $actionName, string $method = ''): ValidationResult`](#validatedeclaredonly) | Runs the declared validators only, leaving the action's own validate* methods to the caller. |

### getContext()

`public function getContext(): ?Context`

The context of the action being validated; validators are initialized with it.

Returns `?`[`Context`](/api/context/)

### getValidationManager()

`public function getValidationManager(): ?ValidationManager`

Returns the validation manager the service is working with.

The manager captured by the most recent validation run wins, so callers inspecting errors afterwards see the one the validators actually ran against. Before any run it falls back to the manager injected at construction, and is null when neither exists.

Returns `?`[`ValidationManager`](/api/validator/validation-manager/)

### validate()

`public function validate(Action $action, WebRequest $request, string $moduleName = '', string $actionName = '', string $method = ''): ValidationResult`

Perform validation for an action execution.

Steps: 1. Load XML validation config (validators, dependencies) if present. 2. Allow action to register manual validators via register[Method]Validators(). 3. Execute validator manager then action validate[Method](). 4. Return ValidationResult with collected error messages (if retrievable) and a ValidationTrace meta object.

| Parameter | Type | Description |
|---|---|---|
| `$action` | [`Action`](/api/action/action/) |  |
| `$request` | [`WebRequest`](/api/request/web-request/) |  |
| `$moduleName` | `string` |  |
| `$actionName` | `string` |  |
| `$method` | `string` |  |

Returns [`ValidationResult`](/api/execution/validation-result/)

### validateDeclaredOnly()

`public function validateDeclaredOnly(Action $action, WebRequest $request, string $moduleName, string $actionName, string $method = ''): ValidationResult`

Runs the declared validators only, leaving the action's own validate* methods to the caller.

"Declared" is everything the validation configuration and the action's `register{Method}Validators()` put on the manager, whatever the declaration was written in. What this skips is the *other* kind of validation: the `validate()` / `validate{Method}()` methods an action implements in PHP. [`ValidationService::validate()`](/api/execution/validation-service/#validate) runs both and reports one combined outcome; this exists for a caller that needs the two apart -- [`ValidationMiddleware`](/api/middleware/validation-middleware/) runs the manual methods itself so it can tell a client which of the two rejected the request.

| Parameter | Type | Description |
|---|---|---|
| `$action` | [`Action`](/api/action/action/) |  |
| `$request` | [`WebRequest`](/api/request/web-request/) |  |
| `$moduleName` | `string` |  |
| `$actionName` | `string` |  |
| `$method` | `string` |  |

Returns [`ValidationResult`](/api/execution/validation-result/)
