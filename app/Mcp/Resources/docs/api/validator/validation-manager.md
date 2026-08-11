# ValidationManager

> ValidationManager provides management for request parameters and their associated validators.

ValidationManager provides management for request parameters and their associated validators.

## Synopsis

`class ValidationManager extends ParameterHolder implements IValidatorContainer`

|  |  |
|---|---|
| Extends | [`ParameterHolder`](/api/util/parameter-holder/) |
| Implements | [`IValidatorContainer`](/api/validator/i-validator-container/) |
| Since | `1.0.0` |
| Source | `Validator/ValidationManager.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `MODE_CONDITIONAL` | `'conditional'` | All request variables are available when no validation defined else only validated request variables are available. |
| `MODE_RELAXED` | `'relaxed'` | All request variables are always available. |
| `MODE_STRICT` | `'strict'` | Only validated request variables are available. |

## Methods

| Method | Description |
|---|---|
| [`addArgumentResult(ValidationArgument $argument, int $result, Validator $validator = null): void`](#addargumentresult) | Adds a intermediate result of an validator for the given argument |
| [`addChild(Validator $validator): mixed`](#addchild) | Adds a new child validator. |
| [`addFieldResult(Validator $validator, string $fieldname, int $result): void`](#addfieldresult) | Adds a validation result for a given field. |
| [`addIncident(ValidationIncident $incident): void`](#addincident) | Adds an incident to the validation result. |
| [`clear(): void`](#clear) | Clears the validation manager for reuse clears the validator manager by resetting the dependency and error manager and removing all validators after calling their shutdown method so they can do a save shutdown. |
| [`createValidator(class-string<T> $class, array<int|string, mixed> $arguments, array<string, string> $errors = [], array<string, mixed> $parameters = [], ?IValidatorContainer $parent = null): T&Validator`](#createvalidator) | Creates a new validator instance. |
| [`execute(WebRequest $request): bool`](#execute) | Starts the validation process. |
| [`getBase(): VirtualArrayPath`](#getbase) | Gets the base path of the validator. |
| [`getChild(string $name): mixed`](#getchild) | Returns a named child validator. |
| [`getChilds(): array<string, Validator>`](#getchilds) | Returns all child validators. |
| [`getContext(): Context`](#getcontext) | Retrieve the current application context. |
| [`getDependencyManager(): DependencyManager`](#getdependencymanager) | Returns the dependency manager. |
| [`getError(string $name): ?string`](#geterror) | Retrieve an error message. |
| [`getErrorMessages(string $name = null): array<int, mixed>`](#geterrormessages) | Retrieve an array of error Messages. |
| [`getErrorNames(): array<int, string>`](#geterrornames) | Retrieve an array of error names. |
| [`getErrors(string $name = null): array<string, mixed>|null`](#geterrors) | Retrieve an array of errors. |
| [`getFailedFields(int $minSeverity = null): array<int, string>`](#getfailedfields) | Returns all failed fields (this are all fields including those with severity none and notice). |
| [`getFieldErrorCode(string $fieldname, string $validatorName = null): ?int`](#getfielderrorcode) | Will return the highest error code for a field. |
| [`getFieldErrors(string $fieldname, int $minSeverity = null): array<int, ValidationError>`](#getfielderrors) | Returns all errors of a given field. |
| [`getFieldIncidents(string $fieldname, int $minSeverity = null): array<int, ValidationIncident>`](#getfieldincidents) | Returns all incidents of a given field. |
| [`getIncidents(int $minSeverity = null): array<int, ValidationIncident>`](#getincidents) | Returns all incidents which happened during the execution of the validation. |
| [`getRawParameterSnapshot(): array<string, mixed>`](#getrawparametersnapshot) | Framework-internal accessor for the raw, unvalidated parameters as submitted, captured before any pruning by execute(). |
| [`getReport(): ValidationReport`](#getreport) | Retrieve the validation result report container of the last validation run. |
| [`getResult(): int`](#getresult) | Returns the final validation result. |
| [`getSucceededFields(string $source): array<int, string>`](#getsucceededfields) | Returns all fields which succeeded in the validation. |
| [`getValidatorFieldErrors(string $validatorName, string $fieldname, ?int $minSeverity = null): array<int, ValidationIncident>`](#getvalidatorfielderrors) | Returns all errors of a given field in a given validator. |
| [`getValidatorIncidents(string $validatorName, int $minSeverity = null): array<int, ValidationIncident>`](#getvalidatorincidents) | Returns all incidents of a given validator. |
| [`hasError(string $name): bool`](#haserror) | Indicates whether or not a field has an error. |
| [`hasErrors(): bool`](#haserrors) | Indicates whether or not any errors exist. |
| [`hasIncidents(int $minSeverity = null): bool`](#hasincidents) | Checks if any incidents occurred Returns all fields which succeeded in the validation. |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | initializes the validator manager. |
| [`isFieldFailed(string $fieldname): bool`](#isfieldfailed) | Checks whether a field has failed in any validator. |
| [`isFieldValidated(string $fieldname): bool`](#isfieldvalidated) | Checks whether a field has been processed by a validator (this includes fields which were skipped because their value was not set and the validator was not required) |
| [`registerValidators(array<int, Validator> $validators): void`](#registervalidators) | Registers multiple validators. |
| [`reset(): void`](#reset) | Returns the manager to its initial state for reuse across requests. |
| [`setError(string $name, string $message): void`](#seterror) | Set an error. |
| [`setErrors(array<string, string> $errors): void`](#seterrors) | Set an array of errors If an existing error name matches any of the keys in the supplied array, the associated message will be appended to the messages array. |
| [`shutdown(): void`](#shutdown) | Shuts the validation system down. |

### addArgumentResult()

`public function addArgumentResult(ValidationArgument $argument, int $result, Validator $validator = null): void`

Adds a intermediate result of an validator for the given argument

The validator (if the error was caused
                                    inside a validator).

| Parameter | Type | Description |
|---|---|---|
| `$argument` | [`ValidationArgument`](/api/validator/validation-argument/) | The argument |
| `$result` | `int` | The arguments result. |
| `$validator` | [`Validator`](/api/validator/validator/) | The validator (if the error was caused inside a validator). |

### addChild()

`public function addChild(Validator $validator): mixed`

Adds a new child validator.

The new child validator.

| Parameter | Type | Description |
|---|---|---|
| `$validator` | [`Validator`](/api/validator/validator/) | The new child validator. |

Returns `mixed`

### addFieldResult()

`public function addFieldResult(Validator $validator, string $fieldname, int $result): void`

Adds a validation result for a given field.

The result of the validation.

| Parameter | Type | Description |
|---|---|---|
| `$validator` | [`Validator`](/api/validator/validator/) | The validator. |
| `$fieldname` | `string` | The name of the field which has been validated. |
| `$result` | `int` | The result of the validation. |

### addIncident()

`public function addIncident(ValidationIncident $incident): void`

Adds an incident to the validation result.

The incident.

| Parameter | Type | Description |
|---|---|---|
| `$incident` | [`ValidationIncident`](/api/validator/validation-incident/) | The incident. |

### clear()

`public function clear(): void`

Clears the validation manager for reuse clears the validator manager by resetting the dependency and error manager and removing all validators after calling their shutdown method so they can do a save shutdown.

### createValidator()

`public function createValidator(class-string<T> $class, array<int|string, mixed> $arguments, array<string, string> $errors = [], array<string, mixed> $parameters = [], ?IValidatorContainer $parent = null): T&Validator`

Creates a new validator instance.

The parent (will use the validation
                                     manager if null is given)

| Parameter | Type | Description |
|---|---|---|
| `$class` | `class-string``<``T``>` | The name of the class implementing the validator. |
| `$arguments` | `array``<``int``|``string``, ``mixed``>` | The argument names. |
| `$errors` | `array``<``string``, ``string``>` | The error messages. |
| `$parameters` | `array``<``string``, ``mixed``>` | The validator parameters. |
| `$parent` | `?`[`IValidatorContainer`](/api/validator/i-validator-container/) | The parent (will use the validation manager if null is given) |

Returns `T``&`[`Validator`](/api/validator/validator/)

### execute()

`public function execute(WebRequest $request): bool`

Starts the validation process.

The data which should be validated.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`WebRequest`](/api/request/web-request/) | The data which should be validated. |

Returns `bool` — true, if validation succeeded.

### getBase()

`public function getBase(): VirtualArrayPath`

Gets the base path of the validator.

Returns [`VirtualArrayPath`](/api/util/virtual-array-path/) — The base path.

### getChild()

`public function getChild(string $name): mixed`

Returns a named child validator.

The name of the child validator.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the child validator. |

Returns `mixed`

### getChilds()

`public function getChilds(): array<string, Validator>`

Returns all child validators.

Returns `array``<``string``, `[`Validator`](/api/validator/validator/)`>` — An array of Validator instances.

### getContext()

`final public function getContext(): Context`

Retrieve the current application context.

Returns [`Context`](/api/context/) — The current Context instance.

### getDependencyManager()

`public function getDependencyManager(): DependencyManager`

Returns the dependency manager.

Returns [`DependencyManager`](/api/validator/dependency-manager/) — The dependency manager instance.

### getError()

`public function getError(string $name): ?string`

Retrieve an error message.

An error name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An error name. |

Returns `?``string` — The error message, or null if there is no such error.

### getErrorMessages()

`public function getErrorMessages(string $name = null): array<int, mixed>`

Retrieve an array of error Messages.

An optional error name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An optional error name. |

Returns `array``<``int``, ``mixed``>` — An indexed array of error messages (if a name was given) or an indexed array in this format: array('message' => string, 'errors' => array(string))

### getErrorNames()

`public function getErrorNames(): array<int, string>`

Retrieve an array of error names.

Returns `array``<``int``, ``string``>` — An indexed array of error names.

### getErrors()

`public function getErrors(string $name = null): array<string, mixed>|null`

Retrieve an array of errors.

An optional error name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An optional error name. |

Returns `array``<``string``, ``mixed``>``|``null` — An associative array of errors(if no name was given) as an array with the error messages (key 'messages') and the validators (key 'validators') which failed.

### getFailedFields()

`public function getFailedFields(int $minSeverity = null): array<int, string>`

Returns all failed fields (this are all fields including those with severity none and notice).

The minimum severity a field needs to have.

| Parameter | Type | Description |
|---|---|---|
| `$minSeverity` | `int` | The minimum severity a field needs to have. |

Returns `array``<``int``, ``string``>` — The names of the fields.

### getFieldErrorCode()

`public function getFieldErrorCode(string $fieldname, string $validatorName = null): ?int`

Will return the highest error code for a field.

The Validator name

| Parameter | Type | Description |
|---|---|---|
| `$fieldname` | `string` | The name of the field. |
| `$validatorName` | `string` | The Validator name |

Returns `?``int` — The error code, or null if the field was never touched by a validator.

### getFieldErrors()

`public function getFieldErrors(string $fieldname, int $minSeverity = null): array<int, ValidationError>`

Returns all errors of a given field.

The minimum severity a returned incident of the error
                needs to have.

| Parameter | Type | Description |
|---|---|---|
| `$fieldname` | `string` | The name of the field. |
| `$minSeverity` | `int` | The minimum severity a returned incident of the error needs to have. |

Returns `array``<``int``, `[`ValidationError`](/api/validator/validation-error/)`>` — The errors.

### getFieldIncidents()

`public function getFieldIncidents(string $fieldname, int $minSeverity = null): array<int, ValidationIncident>`

Returns all incidents of a given field.

The minimum severity a returned incident needs to have.

| Parameter | Type | Description |
|---|---|---|
| `$fieldname` | `string` | The name of the field. |
| `$minSeverity` | `int` | The minimum severity a returned incident needs to have. |

Returns `array``<``int``, `[`ValidationIncident`](/api/validator/validation-incident/)`>` — The incidents.

### getIncidents()

`public function getIncidents(int $minSeverity = null): array<int, ValidationIncident>`

Returns all incidents which happened during the execution of the validation.

The minimum severity a returned incident needs to have.

| Parameter | Type | Description |
|---|---|---|
| `$minSeverity` | `int` | The minimum severity a returned incident needs to have. |

Returns `array``<``int``, `[`ValidationIncident`](/api/validator/validation-incident/)`>` — The incidents.

### getRawParameterSnapshot()

`public function getRawParameterSnapshot(): array<string, mixed>`

Framework-internal accessor for the raw, unvalidated parameters as submitted, captured before any pruning by execute().

NOT reachable via WebRequest::getParameter()/getParameters() -- this exists solely so FormPopulationEngine can redisplay a submitted value in an HTML form after a validation failure scrubbed it from the request (see the class docblock on $rawParameterSnapshot). Never use this for business logic.

Returns `array``<``string``, ``mixed``>`

### getReport()

`public function getReport(): ValidationReport`

Retrieve the validation result report container of the last validation run.

Returns [`ValidationReport`](/api/validator/validation-report/) — The result report container.

### getResult()

`public function getResult(): int`

Returns the final validation result.

Returns `int` — The result of the validation process.

### getSucceededFields()

`public function getSucceededFields(string $source): array<int, string>`

Returns all fields which succeeded in the validation.

The source for which the fields should be returned.

| Parameter | Type | Description |
|---|---|---|
| `$source` | `string` | The source for which the fields should be returned. |

Returns `array``<``int``, ``string``>` — An array of field names.

### getValidatorFieldErrors()

`public function getValidatorFieldErrors(string $validatorName, string $fieldname, ?int $minSeverity = null): array<int, ValidationIncident>`

Returns all errors of a given field in a given validator.

The minimum severity a returned incident of the error
                needs to have.

| Parameter | Type | Description |
|---|---|---|
| `$validatorName` | `string` | The name of the validator. |
| `$fieldname` | `string` | The name of the field. |
| `$minSeverity` | `?``int` | The minimum severity a returned incident of the error needs to have. |

Returns `array``<``int``, `[`ValidationIncident`](/api/validator/validation-incident/)`>` — The incidents.

### getValidatorIncidents()

`public function getValidatorIncidents(string $validatorName, int $minSeverity = null): array<int, ValidationIncident>`

Returns all incidents of a given validator.

The minimum severity a returned incident needs to have.

| Parameter | Type | Description |
|---|---|---|
| `$validatorName` | `string` | The name of the validator. |
| `$minSeverity` | `int` | The minimum severity a returned incident needs to have. |

Returns `array``<``int``, `[`ValidationIncident`](/api/validator/validation-incident/)`>` — The incidents.

### hasError()

`public function hasError(string $name): bool`

Indicates whether or not a field has an error.

A field name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | A field name. |

Returns `bool` — true, if the field has an error, false otherwise.

### hasErrors()

`public function hasErrors(): bool`

Indicates whether or not any errors exist.

Returns `bool` — true, if any error exist, otherwise false.

### hasIncidents()

`public function hasIncidents(int $minSeverity = null): bool`

Checks if any incidents occurred Returns all fields which succeeded in the validation.

The minimum severity which shall be checked for.

| Parameter | Type | Description |
|---|---|---|
| `$minSeverity` | `int` | The minimum severity which shall be checked for. |

Returns `bool` — The result.

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = []): void`

initializes the validator manager.

The initialization parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | The context instance. |
| `$parameters` | `array``<``string``, ``mixed``>` | The initialization parameters. |

### isFieldFailed()

`public function isFieldFailed(string $fieldname): bool`

Checks whether a field has failed in any validator.

The name of the field.

| Parameter | Type | Description |
|---|---|---|
| `$fieldname` | `string` | The name of the field. |

Returns `bool` — Whether the field has failed.

### isFieldValidated()

`public function isFieldValidated(string $fieldname): bool`

Checks whether a field has been processed by a validator (this includes fields which were skipped because their value was not set and the validator was not required)

The name of the field.

| Parameter | Type | Description |
|---|---|---|
| `$fieldname` | `string` | The name of the field. |

Returns `bool` — Whether the field was validated.

### registerValidators()

`public function registerValidators(array<int, Validator> $validators): void`

Registers multiple validators.

An array of validators.

| Parameter | Type | Description |
|---|---|---|
| `$validators` | `array``<``int``, `[`Validator`](/api/validator/validator/)`>` | An array of validators. |

### reset()

`public function reset(): void`

Returns the manager to its initial state for reuse across requests.

Resets and then detaches every registered validator, clears the dependency manager, and installs a fresh report, so results and incidents from the previous run cannot leak into the next one. The manager's own parameters are left alone; validators must be registered again before execute() has anything to run.

### setError()

`public function setError(string $name, string $message): void`

Set an error.

An error message.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An error name. |
| `$message` | `string` | An error message. |

### setErrors()

`public function setErrors(array<string, string> $errors): void`

Set an array of errors If an existing error name matches any of the keys in the supplied array, the associated message will be appended to the messages array.

An associative array of errors and their associated
                  messages.

| Parameter | Type | Description |
|---|---|---|
| `$errors` | `array``<``string``, ``string``>` | An associative array of errors and their associated messages. |

### shutdown()

`public function shutdown(): void`

Shuts the validation system down.

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
