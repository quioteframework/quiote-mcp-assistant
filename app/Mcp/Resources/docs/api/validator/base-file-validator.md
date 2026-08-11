# BaseFileValidator

> BaseFileValidator is the base validator when validating files.

BaseFileValidator is the base validator when validating files.

It provides checking of the size and extension of a file for implementing validators. Parameters: 'min_size'     The minimum file size in byte, default 1 'max_size'     The maximum file size in byte 'extension'    list of valid extensions (delimited by ' ') 'mime_type'    A regular expression checked against the MIME type of the file as returned by the fileinfo extension. The mime type string to match against is something like "application/pdf". 'mime_type_include_charset' Whether the regex in parameter 'mime_type' should be matched against a string containing the charset info (as defined in RFC 2045), e.g. "text/csv; charset=iso-8859-1". Errors: 'upload_failed' The upload of the file failed 'min_size' 'max_size' 'extension'     The file doesn't have the required extension 'mime_type'     The MIME type check failed

## Synopsis

`abstract class BaseFileValidator extends Validator`

|  |  |
|---|---|
| Extends | [`Validator`](/api/validator/validator/) |
| Since | `1.0.0` |
| Source | `Validator/BaseFileValidator.php` |

## Methods

| Method | Description |
|---|---|
| [`getAcceptedParameters(): array<int, string>`](#getacceptedparameters) | Returns the base Validator parameters plus 'min_size', 'max_size', 'extension', 'mime_type' and 'mime_type_include_charset', shared by every file validator. |
| [`initialize(Context $context, array<string, mixed> $parameters = [], array<int|string, mixed> $arguments = [], array<string, string> $errors = []): void`](#initialize) | Initialize this validator. |
| [`validate(): bool`](#validate) | Validates the input |

### getAcceptedParameters()

`public static function getAcceptedParameters(): array<int, string>`

Returns the base Validator parameters plus 'min_size', 'max_size', 'extension', 'mime_type' and 'mime_type_include_charset', shared by every file validator.

'min_size' and 'max_size' bound the uploaded file's size in bytes, the minimum defaulting to 1 so a zero-byte upload fails. 'extension' is a list of acceptable filename extensions, given either as an array or as a space-delimited string, matched case-insensitively against the client filename. 'mime_type' is a PCRE matched against the type fileinfo detects from the file's own content, and requires the fileinfo extension to be loaded; 'mime_type_include_charset' makes that match run against the type with the charset appended ("text/csv; charset=iso-8859-1") rather than the bare type. Subclasses merge their own names onto this set.

Returns `array``<``int``, ``string``>` — The accepted parameter names.

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = [], array<int|string, mixed> $arguments = [], array<string, string> $errors = []): void`

Initialize this validator.

An array of error messages.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | The Context. |
| `$parameters` | `array``<``string``, ``mixed``>` | An array of validator parameters. |
| `$arguments` | `array``<``int``|``string``, ``mixed``>` | An array of argument names which should be validated. |
| `$errors` | `array``<``string``, ``string``>` | An array of error messages. |

### validate()

`protected function validate(): bool`

Validates the input

Returns `bool` — The file is valid according to given parameters.

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
