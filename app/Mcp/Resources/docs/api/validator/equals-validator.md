# EqualsValidator

> EqualsValidator verifies if a parameter equals to a given value The input is compared to a value and the validator fails if they differ.

EqualsValidator verifies if a parameter equals to a given value The input is compared to a value and the validator fails if they differ.

When the parameter 'asparam' is true, the content in 'value' is taken as a parameter name and the check is performed against it's value otherwise the content in 'value' is taken. Parameters: 'value'   value which the input should equals to 'asparam' whether the 'value' should be treated as a parameter name 'strict'  whether or no to perform strict equality check (default: false)

## Synopsis

`class EqualsValidator extends Validator`

|  |  |
|---|---|
| Extends | [`Validator`](/api/validator/validator/) |
| Since | `1.0.0` |
| Source | `Validator/EqualsValidator.php` |

## Methods

| Method | Description |
|---|---|
| [`getAcceptedParameters(): array<int, string>`](#getacceptedparameters) | Returns the base Validator parameters plus 'value', 'asparam' and 'strict'. |

### getAcceptedParameters()

`public static function getAcceptedParameters(): array<int, string>`

Returns the base Validator parameters plus 'value', 'asparam' and 'strict'.

'value' is what every argument is compared against; leave it out and the first argument's own value becomes the comparand, which turns the validator into an all-arguments-equal check. 'asparam' reinterprets 'value' as the name of another parameter and compares against that parameter's value instead of the literal. 'strict' selects identity (===) over loose (==) comparison and defaults to false.

Returns `array``<``int``, ``string``>` — The accepted parameter names.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `execute()` | [`Validator`](/api/validator/validator/) | Executes the validator. |
| `getArguments()` | [`Validator`](/api/validator/validator/) | Returns all arguments which should be validated. |
| `getBase()` | [`Validator`](/api/validator/validator/) | Returns the base path of this validator. |
| `getBaseKeys()` | [`Validator`](/api/validator/validator/) | Returns the "keys" in the path of the base |
| `getContext()` | [`Validator`](/api/validator/validator/) | Retrieve the current application context. |
| `getDependencyManager()` | [`Validator`](/api/validator/validator/) | Returns the depency manager of the parent container if any. |
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
| `reset()` | [`Validator`](/api/validator/validator/) | Returns the validator to its uninitialized state for reuse across requests. |
| `setErrorMessage()` | [`Validator`](/api/validator/validator/) | Sets an error message override for the given index (the empty string is the default/generic message). |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `setParentContainer()` | [`Validator`](/api/validator/validator/) | Sets the parent container. |
| `shutdown()` | [`Validator`](/api/validator/validator/) | Shuts the validator down. |
