# DateTimeValidator

> DateTimeValidator verifies that a parameter is of a date and/or time format using native \\DateTimeImmutable and IntlDateFormatter APIs.

DateTimeValidator verifies that a parameter is of a date and/or time format using native \DateTimeImmutable and IntlDateFormatter APIs.

Inputs can be supplied as a formatted string, UNIX timestamp, or a set of discrete date components. All legacy Quiote calendar classes have been removed in favour of first-party PHP primitives. Arguments: This can be: * a single argument which will then be parsed with the formats in the 'formats' parameter. * multiple arguments with the calendar constants (DateDefinitions::MONTH, etc) as key and the argument field as value. * multiple arguments and the 'arguments_format' parameter defined. This will use the string in 'arguments_format' as input string to sprintf and will use the arguments in the given order as argument to sprintf. Parameters: 'check'       check date if the specified day really exists 'formats'     an array of arrays with these keys: 'type'       The type of the string in 'format'. 'format'     The input string dependent on the type. These types are allowed: format:   The value is a date format string. time:     The value is a time specifier (full,...) or null date:     The value is a date specifier or null datetime: The value is a date specifier or null translation_domain: The value will be translated in the domain given in the 'translation_domain' key. unix:     Always null/empty unix_milliseconds: Always null/empty 'locale'     The optional locale which will be used for this format. 'translation_domain' Only applicable when the type is translation_domain 'cast_to'     Optional post-processing. Strings: 'unix', 'string', 'datetime'. Arrays: ['type' => 'format|time|date|datetime', 'format' => pattern or specifier]. Exported values always derive from native DateTimeImmutable instances. 'arguments_format' A string which will be used as the format string for sprintf. 'min'         Either an string or an array. When its a string the the its assumed to be in the format 'yyyy-MM-dd[ HH:mm:ss[.S]]'. When its an array it will take the minimum value from a request field. These indizes apply: 'format'      A custom format string which should be used when the field is an string. 'field'       The name of the field to use as minimum value (could be a previous exported calendar object). Do NOT use unvalidated fields here. Lax parsing will be used. This value is inclusive. 'max'         The same as min except that the max is exclusive.

## Synopsis

`class DateTimeValidator extends Validator`

|  |  |
|---|---|
| Extends | [`Validator`](/api/validator/validator/) |
| Since | `1.0.0` |
| Source | `Validator/DateTimeValidator.php` |

## Methods

| Method | Description |
|---|---|
| [`getAcceptedParameters(): array<int, string>`](#getacceptedparameters) | Returns the base Validator parameters plus 'check', 'formats', 'cast_to', 'arguments_format', 'min', 'max' and 'locale'. |

### getAcceptedParameters()

`public static function getAcceptedParameters(): array<int, string>`

Returns the base Validator parameters plus 'check', 'formats', 'cast_to', 'arguments_format', 'min', 'max' and 'locale'.

'formats' lists the input formats to try, each an array of a 'type' (format, time, date, datetime, translation_domain, unix, unix_milliseconds) with its matching 'format' and optional per-entry 'locale'. 'arguments_format' is an sprintf pattern that joins several arguments into the one string to parse. 'check', on by default, rejects a date whose day does not exist in the given month. 'min' and 'max' bound the resulting instant -- inclusive and exclusive respectively -- given either as a literal date string or as an array naming another request field to read the bound from. 'locale' overrides the current locale for parsing and formatting, and 'cast_to' selects the shape of the exported value ('unix', 'string', 'datetime', or an array naming a format).

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
