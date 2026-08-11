# ActionInputSchemaResolver

> Derives a JSON Schema for one action+method's request parameters from whatever validators that action declares, so a single declaration can drive HTTP validation, an MCP tool's `inputSchema` and an OpenAPI operation's parameters/requestBody.

Derives a JSON Schema for one action+method's request parameters from whatever validators that action declares, so a single declaration can drive HTTP validation, an MCP tool's `inputSchema` and an OpenAPI operation's parameters/requestBody.

Both "validator file" conventions feed the same [`ValidatorSchemaMapper`](/api/validator/compiler/json-schema/validator-schema-mapper/): the `{module}/Validate/{action}.xml` file convention ([`CompiledValidatorRegistry`](/api/validator/compiler/runtime/compiled-validator-registry/) uses the same path) is tried first, and failing that the action's fluent `register{Method}Validators()`/`registerValidators()` hook (the convention every documented example uses -- see [`ValidatorBuilder`](/api/validator/compiler/runtime/validator-builder/)) is registered against a throwaway ValidationManager and read back. That throwaway manager is never executed, so no request-validation side effect (exports, incidents) occurs.

Returns null -- callers fall back to a permissive schema, or to describing nothing -- when neither source yields anything describable. Never throws: a schema-derivation failure must not break tool discovery or doc generation.

## Synopsis

`final class ActionInputSchemaResolver`

|  |  |
|---|---|
| Since | `1.2.5` |
| Source | `Validator/Compiler/JsonSchema/ActionInputSchemaResolver.php` |

## Constructor

### __construct()

`public function __construct(?ValidatorSchemaMapper $mapper = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$mapper` | `?`[`ValidatorSchemaMapper`](/api/validator/compiler/json-schema/validator-schema-mapper/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`resolve(Controller $controller, string $module, string $action, string $methodToken): array<string, mixed>|null`](#resolve) | Resolve for a module/action pair, instantiating the action the same way [`Controller::createActionInstance()`](/api/controller/controller/#createactioninstance) does for a real request. |
| [`resolveForAction(Controller $controller, Action $action, string $module, string $actionName, string $methodToken): array<string, mixed>|null`](#resolveforaction) | Resolve for an action instance the caller already has. |

### resolve()

`public function resolve(Controller $controller, string $module, string $action, string $methodToken): array<string, mixed>|null`

Resolve for a module/action pair, instantiating the action the same way [`Controller::createActionInstance()`](/api/controller/controller/#createactioninstance) does for a real request.

read/write/update/remove/... (see [`HttpMethodMapper`](/api/execution/http-method-mapper/)).

| Parameter | Type | Description |
|---|---|---|
| `$controller` | [`Controller`](/api/controller/controller/) |  |
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$methodToken` | `string` | read/write/update/remove/... (see [`HttpMethodMapper`](/api/execution/http-method-mapper/)). |

Returns `array``<``string``, ``mixed``>``|``null`

### resolveForAction()

`public function resolveForAction(Controller $controller, Action $action, string $module, string $actionName, string $methodToken): array<string, mixed>|null`

Resolve for an action instance the caller already has.

The instance is initialized and its validator hook called, so pass a freshly created one (registering the same validators twice would duplicate them).

| Parameter | Type | Description |
|---|---|---|
| `$controller` | [`Controller`](/api/controller/controller/) |  |
| `$action` | [`Action`](/api/action/action/) |  |
| `$module` | `string` |  |
| `$actionName` | `string` |  |
| `$methodToken` | `string` |  |

Returns `array``<``string``, ``mixed``>``|``null`
