# NotoperatorValidator

> NOTOperatorValidator succeeds if the sub-validator failed Parameters: 'skip_errors' do not submit errors of child validators to validator manager

NOTOperatorValidator succeeds if the sub-validator failed Parameters: 'skip_errors' do not submit errors of child validators to validator manager

## Synopsis

`class NotoperatorValidator extends OperatorValidator`

|  |  |
|---|---|
| Extends | [`OperatorValidator`](/api/validator/operator-validator/) |
| Since | `1.0.0` |
| Source | `Validator/NotoperatorValidator.php` |

## Methods

| Method | Description |
|---|---|
| [`addArgumentResult(ValidationArgument $argument, int $result, ?Validator $validator = null): null`](#addargumentresult) | Adds a intermediate result of an validator for the given argument |
| [`addFieldResult(Validator $validator, string $fieldname, int $result): void`](#addfieldresult) | Adds a validation result for a given field. |
| [`addIncident(ValidationIncident $incident): null`](#addincident) | Adds an incident to the validation result. |
| [`reset(): void`](#reset) | Returns the operator to its initial state for reuse across requests. |

### addArgumentResult()

`public function addArgumentResult(ValidationArgument $argument, int $result, ?Validator $validator = null): null`

Adds a intermediate result of an validator for the given argument

The validator (if the error was caused
                                    inside a validator).

| Parameter | Type | Description |
|---|---|---|
| `$argument` | [`ValidationArgument`](/api/validator/validation-argument/) | The argument |
| `$result` | `int` | The arguments result. |
| `$validator` | `?`[`Validator`](/api/validator/validator/) | The validator (if the error was caused inside a validator). |

Returns `null`

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

`public function addIncident(ValidationIncident $incident): null`

Adds an incident to the validation result.

The incident.

| Parameter | Type | Description |
|---|---|---|
| `$incident` | [`ValidationIncident`](/api/validator/validation-incident/) | The incident. |

Returns `null`

### reset()

`public function reset(): void`

Returns the operator to its initial state for reuse across requests.

Resets the inherited state through OperatorValidator::reset(), then drops the single child and puts the result back to SUCCESS, so the validator has to be re-registered before it does anything again.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `addChild()` | [`OperatorValidator`](/api/validator/operator-validator/) | Adds new child validator. |
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `execute()` | [`OperatorValidator`](/api/validator/operator-validator/) | Executes the validator. |
| `getAcceptedParameters()` | [`OperatorValidator`](/api/validator/operator-validator/) | Returns the base Validator parameters plus 'skip_errors', shared by every operator. |
| `getArguments()` | [`Validator`](/api/validator/validator/) | Returns all arguments which should be validated. |
| `getBase()` | [`Validator`](/api/validator/validator/) | Returns the base path of this validator. |
| `getBaseKeys()` | [`Validator`](/api/validator/validator/) | Returns the "keys" in the path of the base |
| `getChild()` | [`OperatorValidator`](/api/validator/operator-validator/) | Returns a named child validator. |
| `getChilds()` | [`OperatorValidator`](/api/validator/operator-validator/) | Returns all child validators. |
| `getContext()` | [`Validator`](/api/validator/validator/) | Retrieve the current application context. |
| `getDependencyManager()` | [`OperatorValidator`](/api/validator/operator-validator/) | Gets parent's dependency manager. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getLastKey()` | [`Validator`](/api/validator/validator/) | Returns the last "keys" in the path of the base |
| `getMutatedRequest()` | [`Validator`](/api/validator/validator/) | The WebRequest this validator ended execute() with. |
| `getName()` | [`Validator`](/api/validator/validator/) | Returns the name of this validator. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `getParentContainer()` | [`Validator`](/api/validator/validator/) | Retrieve the parent container. |
| `getResult()` | [`OperatorValidator`](/api/validator/operator-validator/) | Returns the result from the error manager. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `initialize()` | [`Validator`](/api/validator/validator/) | Initialize this validator. |
| `mapErrorCode()` | [`Validator`](/api/validator/validator/) | Converts string severity codes into integer values (see severity constants) critical -> Validator::CRITICAL error -> Validator::ERROR notice -> Validator::NOTICE none -> Validator::NONE success -> not allowed to be specified by the user. |
| `registerValidators()` | [`OperatorValidator`](/api/validator/operator-validator/) | Registers an array of validators. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `setErrorMessage()` | [`Validator`](/api/validator/validator/) | Sets an error message override for the given index (the empty string is the default/generic message). |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `setParentContainer()` | [`Validator`](/api/validator/validator/) | Sets the parent container. |
| `shutdown()` | [`OperatorValidator`](/api/validator/operator-validator/) | Shutdown method, for shutting down the model etc. |
