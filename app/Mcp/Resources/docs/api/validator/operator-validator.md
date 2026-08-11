# OperatorValidator

> OperatorValidator Operators group a couple if validators...

OperatorValidator Operators group a couple if validators...

## Synopsis

`abstract class OperatorValidator extends Validator implements IValidatorContainer`

|  |  |
|---|---|
| Extends | [`Validator`](/api/validator/validator/) |
| Implements | [`IValidatorContainer`](/api/validator/i-validator-container/) |
| Since | `1.0.0` |
| Source | `Validator/OperatorValidator.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$children` | `mixed` | _protected._ |
| `$result` | `mixed` | _protected._ |

## Methods

| Method | Description |
|---|---|
| [`addArgumentResult(ValidationArgument $argument, int $result, Validator $validator = null): null`](#addargumentresult) | Adds a intermediate result of an validator for the given argument. |
| [`addChild(Validator $validator): void`](#addchild) | Adds new child validator. |
| [`addFieldResult(Validator $validator, string $fieldname, int $result): mixed`](#addfieldresult) | Adds a validation result for a given field. |
| [`addIncident(ValidationIncident $incident): null`](#addincident) | Adds an incident to the validation result. |
| [`checkValidSetup(): void`](#checkvalidsetup) | Method for checking the validity of child validators. |
| [`execute(WebRequest $parameters): int`](#execute) | Executes the validator. |
| [`getAcceptedParameters(): array<int, string>`](#getacceptedparameters) | Returns the base Validator parameters plus 'skip_errors', shared by every operator. |
| [`getChild(string $name): Validator`](#getchild) | Returns a named child validator. |
| [`getChilds(): array<string, Validator>`](#getchilds) | Returns all child validators. |
| [`getDependencyManager(): DependencyManager`](#getdependencymanager) | Gets parent's dependency manager. |
| [`getResult(): int`](#getresult) | Returns the result from the error manager. |
| [`registerValidators(array<Validator> $validators): void`](#registervalidators) | Registers an array of validators. |
| [`requireValidationParameters(): WebRequest`](#requirevalidationparameters) | Narrows $validationParameters (inherited from Validator, and typed nullable there because it's only populated once execute() runs) to a concrete WebRequest for dispatching to child validators. |
| [`reset(): void`](#reset) | Returns the operator to its initial state for reuse across requests. |
| [`shutdown(): void`](#shutdown) | Shutdown method, for shutting down the model etc. |

### addArgumentResult()

`public function addArgumentResult(ValidationArgument $argument, int $result, Validator $validator = null): null`

Adds a intermediate result of an validator for the given argument.

The validator (if the error was caused
                                    inside a validator).

| Parameter | Type | Description |
|---|---|---|
| `$argument` | [`ValidationArgument`](/api/validator/validation-argument/) | The argument |
| `$result` | `int` | The arguments result. |
| `$validator` | [`Validator`](/api/validator/validator/) | The validator (if the error was caused inside a validator). |

Returns `null`

### addChild()

`public function addChild(Validator $validator): void`

Adds new child validator.

The new child validator.

| Parameter | Type | Description |
|---|---|---|
| `$validator` | [`Validator`](/api/validator/validator/) | The new child validator. |

### addFieldResult()

`public function addFieldResult(Validator $validator, string $fieldname, int $result): mixed`

Adds a validation result for a given field.

The result of the validation.

| Parameter | Type | Description |
|---|---|---|
| `$validator` | [`Validator`](/api/validator/validator/) | The validator. |
| `$fieldname` | `string` | The name of the field which has been validated. |
| `$result` | `int` | The result of the validation. |

Returns `mixed`

### addIncident()

`public function addIncident(ValidationIncident $incident): null`

Adds an incident to the validation result.

The incident.

| Parameter | Type | Description |
|---|---|---|
| `$incident` | [`ValidationIncident`](/api/validator/validation-incident/) | The incident. |

Returns `null`

### checkValidSetup()

`protected function checkValidSetup(): void`

Method for checking the validity of child validators.

Some operators (XOR and NOT) need a specific quantity of child validators so they implement an algorithm that checks of the setup is valid. This method is run first when execute() is invoked and should throw an exception if the setup is invalid.

| Throws | When |
|---|---|
| `ValidatorException` | If the quantity of child validators is invalid |

### execute()

`public function execute(WebRequest $parameters): int`

Executes the validator.

The parameters which should be validated.

| Parameter | Type | Description |
|---|---|---|
| `$parameters` | [`WebRequest`](/api/request/web-request/) | The parameters which should be validated. |

Returns `int` — The result of validation (SUCCESS, NONE, NOTICE, ERROR, CRITICAL).

### getAcceptedParameters()

`public static function getAcceptedParameters(): array<int, string>`

Returns the base Validator parameters plus 'skip_errors', shared by every operator.

'skip_errors' keeps a child's CRITICAL result from being promoted to this group's own result, so a critical failure inside the group does not abort validation in the surrounding container. Concrete operators merge their own names onto this set.

Returns `array``<``int``, ``string``>` — The accepted parameter names.

### getChild()

`public function getChild(string $name): Validator`

Returns a named child validator.

The name of the child validator.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the child validator. |

Returns [`Validator`](/api/validator/validator/) — The named child validator.

### getChilds()

`public function getChilds(): array<string, Validator>`

Returns all child validators.

Returns `array``<``string``, `[`Validator`](/api/validator/validator/)`>` — An array of Validator instances.

### getDependencyManager()

`public function getDependencyManager(): DependencyManager`

Gets parent's dependency manager.

Returns [`DependencyManager`](/api/validator/dependency-manager/) — The parent's dependency manager.

### getResult()

`public function getResult(): int`

Returns the result from the error manager.

Returns `int` — The result of the validation process.

### registerValidators()

`public function registerValidators(array<Validator> $validators): void`

Registers an array of validators.

The array of validators.

| Parameter | Type | Description |
|---|---|---|
| `$validators` | `array``<`[`Validator`](/api/validator/validator/)`>` | The array of validators. |

### requireValidationParameters()

`protected function requireValidationParameters(): WebRequest`

Narrows $validationParameters (inherited from Validator, and typed nullable there because it's only populated once execute() runs) to a concrete WebRequest for dispatching to child validators.

Only ever null before this operator's own execute() has run, which validate() always happens after.

Returns [`WebRequest`](/api/request/web-request/) — The request supplied to this operator's execute().

### reset()

`public function reset(): void`

Returns the operator to its initial state for reuse across requests.

Resets every child first, then detaches them all, puts the accumulated result back to SUCCESS and discards the argument results and incidents that were being held back for the deferred flush. Children are not kept, so a reset operator validates nothing until it is registered again.

### shutdown()

`public function shutdown(): void`

Shutdown method, for shutting down the model etc.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getArguments()` | [`Validator`](/api/validator/validator/) | Returns all arguments which should be validated. |
| `getBase()` | [`Validator`](/api/validator/validator/) | Returns the base path of this validator. |
| `getBaseKeys()` | [`Validator`](/api/validator/validator/) | Returns the "keys" in the path of the base |
| `getContext()` | [`Validator`](/api/validator/validator/) | Retrieve the current application context. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getLastKey()` | [`Validator`](/api/validator/validator/) | Returns the last "keys" in the path of the base |
| `getMutatedRequest()` | [`Validator`](/api/validator/validator/) | The WebRequest this validator ended execute() with. |
| `getName()` | [`Validator`](/api/validator/validator/) | Returns the name of this validator. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `getParentContainer()` | [`Validator`](/api/validator/validator/) | Retrieve the parent container. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `initialize()` | [`Validator`](/api/validator/validator/) | Initialize this validator. |
| `mapErrorCode()` | [`Validator`](/api/validator/validator/) | Converts string severity codes into integer values (see severity constants) critical -> Validator::CRITICAL error -> Validator::ERROR notice -> Validator::NOTICE none -> Validator::NONE success -> not allowed to be specified by the user. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `setErrorMessage()` | [`Validator`](/api/validator/validator/) | Sets an error message override for the given index (the empty string is the default/generic message). |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `setParentContainer()` | [`Validator`](/api/validator/validator/) | Sets the parent container. |
