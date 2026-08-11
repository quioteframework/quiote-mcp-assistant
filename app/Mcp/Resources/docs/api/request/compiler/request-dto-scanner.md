# RequestDtoScanner

> Reflects a #[MapRequest] DTO class exactly once (results are cached by RequestDtoRegistry) to produce two independent things from the same walk of its constructor-promoted properties:

Reflects a #[MapRequest] DTO class exactly once (results are cached by RequestDtoRegistry) to produce two independent things from the same walk of its constructor-promoted properties:

- registerValidators(): translates each property's Quiote\Request\Attribute\Constraint\* attributes into the same ValidatorBuilder fluent calls a developer would write by hand in Action::register{Method}Validators() (see FluentValidatorAction) -- registering real Validator objects on the action's ValidationManager, so DTO-derived constraints get identical ValidationReport/ProblemDetails failure handling, and remain visible to Quiote\Validator\Compiler\JsonSchema\ActionInputSchemaResolver for JSON Schema derivation (MCP tool inputSchema, OpenAPI operation parameters). - scan(): a pure RequestDtoDefinition used by RequestDtoMapper to instantiate the DTO once validation has passed.

A property without any constraint attribute still gets a minimal type-inferred validator registered (see registerInferredValidator()) -- this is not optional decoration, it's what gets the property's argument name onto WebRequest's strict-validation whitelist at all (see ValidationManager::execute()'s whitelist-from-registered-arguments step).

## Synopsis

`final class RequestDtoScanner`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Request/Compiler/RequestDtoScanner.php` |

## Methods

| Method | Description |
|---|---|
| [`isMapRequestDto(string $class): bool`](#ismaprequestdto) | $class is an arbitrary reflected type name, not necessarily an existing class -- verified here via class_exists(), not assumed by the parameter type. |
| [`registerValidators(string $dtoClass, IValidatorContainer $validationManager, Context $context, ?string $method = null): void`](#registervalidators) | Translates the DTO's constraint attributes into real validators on $validationManager. |
| [`scan(string $dtoClass): RequestDtoDefinition`](#scan) | Reflects the DTO's constructor into a [`RequestDtoDefinition`](/api/request/compiler/request-dto-definition/) describing one property per promoted parameter, in declaration order. |

### isMapRequestDto()

`public static function isMapRequestDto(string $class): bool`

$class is an arbitrary reflected type name, not necessarily an existing class -- verified here via class_exists(), not assumed by the parameter type.

| Parameter | Type | Description |
|---|---|---|
| `$class` | `string` |  |

Returns `bool`

### registerValidators()

`public static function registerValidators(string $dtoClass, IValidatorContainer $validationManager, Context $context, ?string $method = null): void`

Translates the DTO's constraint attributes into real validators on $validationManager.

One validator is registered per promoted property — a type-inferred minimal one when the property carries no constraint attribute — which is also what puts the property's name on the request's strict-validation whitelist. $method scopes the registration to a single request method; null registers for all of them.

| Parameter | Type | Description |
|---|---|---|
| `$dtoClass` | `string` |  |
| `$validationManager` | [`IValidatorContainer`](/api/validator/i-validator-container/) |  |
| `$context` | [`Context`](/api/context/) |  |
| `$method` | `?``string` |  |

| Throws | When |
|---|---|
| `InvalidArgumentException` | when $dtoClass does not exist, carries no `#[MapRequest]` attribute, has no constructor, or declares a property whose type cannot be mapped |

### scan()

`public static function scan(string $dtoClass): RequestDtoDefinition`

Reflects the DTO's constructor into a [`RequestDtoDefinition`](/api/request/compiler/request-dto-definition/) describing one property per promoted parameter, in declaration order.

Pure reflection: nothing is registered and no request is touched. Callers should go through [`RequestDtoRegistry::definitionFor()`](/api/request/request-dto-registry/#definitionfor) so the walk happens once per class.

| Parameter | Type | Description |
|---|---|---|
| `$dtoClass` | `string` |  |

Returns [`RequestDtoDefinition`](/api/request/compiler/request-dto-definition/)

| Throws | When |
|---|---|
| `InvalidArgumentException` | when $dtoClass does not exist, carries no `#[MapRequest]` attribute, has no constructor, or declares a property whose type cannot be mapped |
