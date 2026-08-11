# Validator

> Validator allows you to validate input Parameters for use in most validators: 'name' name of validator 'base' base path for validation of arrays 'arguments' an array of input parameter keys to validate 'export' destination for exported data 'depends' list of dependencies needed by the validator 'provides' list of dependencies the validator provides after success 'severity' error severity in case of failure 'error' error message when validation fails 'errors' an array of errors with the reason as key 'required' if true the validator will fail when the input parameter is not set

Validator allows you to validate input Parameters for use in most validators: 'name'       name of validator 'base'       base path for validation of arrays 'arguments'  an array of input parameter keys to validate 'export'     destination for exported data 'depends'    list of dependencies needed by the validator 'provides'   list of dependencies the validator provides after success 'severity'   error severity in case of failure 'error'      error message when validation fails 'errors'     an array of errors with the reason as key 'required'   if true the validator will fail when the input parameter is not set

## Synopsis

`abstract class Validator extends ParameterHolder implements ValidatorInterface`

|  |  |
|---|---|
| Extends | [`ParameterHolder`](/api/util/parameter-holder/) |
| Implements | [`ValidatorInterface`](/api/validator/validator-interface/) |
| Since | `1.0.0` |
| Source | `Validator/Validator.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `CRITICAL` | `500` | validation error severity (validator failed and validation process will be aborted) |
| `ERROR` | `400` | validation error severity (validator failed but validation process continues) |
| `INFO` | `100` | validator error severity (validator failed but without impact on result of whole validation process, completely silent and does not remove the "failed" parameters from the input parameters) |
| `NONE` | `200` |  |
| `NOTICE` | `300` | validator error severity (validator failed but without impact on result of whole validation process) |
| `NOT_PROCESSED` | `-1` | validator field success flag |
| `SILENT` | `200` | validator error severity (validator failed but without impact on result of whole validation process and completely silent) |
| `SUCCESS` | `0` | validator error severity (the validator succeeded) |

## Properties

| Property | Type | Description |
|---|---|---|
| `$affectedArguments` | `mixed` | _protected._ |
| `$arguments` | `mixed` | _protected._ |
| `$context` | `mixed` | _protected._ |
| `$curBase` | `mixed` | _protected._ |
| `$errorMessages` | `mixed` | _protected._ |
| `$incident` | `mixed` | _protected._ |
| `$name` | `mixed` | _protected._ |
| `$parentContainer` | `mixed` | _protected._ |
| `$validationParameters` | `mixed` | _protected._ |

## Methods

| Method | Description |
|---|---|
| [`checkAllArgumentsSet(bool $throwError = true, ?array<int, string> $fullArgumentNames = null): bool`](#checkallargumentsset) | Returns whether all arguments are set in the validation input parameters. |
| [`execute(WebRequest $parameters): int`](#execute) | Executes the validator. |
| [`export(mixed $value, ValidationArgument|string|null $argument = null, ?int $result = null): void`](#export) | Exports a value back into the request. |
| [`getAcceptedParameters(): array<int, string>`](#getacceptedparameters) | Returns the set of parameter names this validator understands. |
| [`getArgument(string $name = null): ?string`](#getargument) | Returns the name of the argument which should be validated. |
| [`getArguments(): array<int|string, string>`](#getarguments) | Returns all arguments which should be validated. |
| [`getBase(): VirtualArrayPath`](#getbase) | Returns the base path of this validator. |
| [`getBaseKeys(): array<int, mixed>`](#getbasekeys) | Returns the "keys" in the path of the base |
| [`getBaseParameter(): string|int|null`](#getbaseparameter) | Returns the 'base' parameter narrowed to the type VirtualArrayPath's constructor accepts. |
| [`getContext(): Context`](#getcontext) | Retrieve the current application context. |
| [`getData(string $paramName): mixed`](#getdata) | Returns the specified input value. |
| [`getDependencyManager(): ?DependencyManager`](#getdependencymanager) | Returns the depency manager of the parent container if any. |
| [`getDependsParameter(): array<int, string>`](#getdependsparameter) | Returns the 'depends' parameter narrowed to a list of strings. |
| [`getErrorMessage(string $index = null, string $backupMessage = null): ?string`](#geterrormessage) | Retrieves the error message for the given index with fallback. |
| [`getFullArgumentNames(): array<int, string>`](#getfullargumentnames) | Returns all arguments with their full path. |
| [`getKeysInCurrentBase(): array<int, int|string>`](#getkeysincurrentbase) | Returns all available keys in the currently set base. |
| [`getLastKey(): mixed`](#getlastkey) | Returns the last "keys" in the path of the base |
| [`getMutatedRequest(): ?WebRequest`](#getmutatedrequest) | The WebRequest this validator ended execute() with. |
| [`getName(): ?string`](#getname) | Returns the name of this validator. |
| [`getParentContainer(): ?IValidatorContainer`](#getparentcontainer) | Retrieve the parent container. |
| [`getProvidesParameter(): array<int, string>`](#getprovidesparameter) | Returns the 'provides' parameter narrowed to a list of strings. |
| [`getSeverityParameter(): string`](#getseverityparameter) | Returns the 'severity' parameter narrowed to string. |
| [`getSourceParameter(): string`](#getsourceparameter) | Returns the 'source' parameter (the request data holder to validate against, e.g. |
| [`getTranslationDomainParameter(): ?string`](#gettranslationdomainparameter) | Returns the 'translation_domain' parameter narrowed to string\|null. |
| [`hasMultipleArguments(): bool`](#hasmultiplearguments) | Returns true if this validator has multiple arguments which need to be validated. |
| [`initialize(Context $context, array<string, mixed> $parameters = [], array<int|string, mixed> $arguments = [], array<string, string> $errors = []): void`](#initialize) | Initialize this validator. |
| [`invalidParameterType(string $paramName, string $expectedType, mixed $value): ConfigurationException`](#invalidparametertype) | Builds a ConfigurationException for a validator parameter whose runtime value doesn't match the type the validator requires. |
| [`isRequiredParameter(): bool`](#isrequiredparameter) | Returns the 'required' parameter narrowed to bool. |
| [`mapErrorCode(string $code): int`](#maperrorcode) | Converts string severity codes into integer values (see severity constants) critical -> Validator::CRITICAL error -> Validator::ERROR notice -> Validator::NOTICE none -> Validator::NONE success -> not allowed to be specified by the user. |
| [`reset(): void`](#reset) | Returns the validator to its uninitialized state for reuse across requests. |
| [`setAffectedArguments(array<int, string> $arguments): void`](#setaffectedarguments) | Sets the arguments which should be flagged with the result of the validator |
| [`setErrorMessage(string $index, string $message): void`](#seterrormessage) | Sets an error message override for the given index (the empty string is the default/generic message). |
| [`setParentContainer(IValidatorContainer $parent): void`](#setparentcontainer) | Sets the parent container. |
| [`shutdown(): void`](#shutdown) | Shuts the validator down. |
| [`throwError(string $index = null, string|array<int, string>|null $affectedArgument = null, boolean $argumentsRelative = false, boolean $setAffected = false): void`](#throwerror) | Submits an error to the error manager. |
| [`validate(): bool`](#validate) | Validates the input. |
| [`validateInBase(VirtualArrayPath $base): int`](#validateinbase) | Validates this validator in the given base. |

### checkAllArgumentsSet()

`protected function checkAllArgumentsSet(bool $throwError = true, ?array<int, string> $fullArgumentNames = null): bool`

Returns whether all arguments are set in the validation input parameters.

Precomputed full path per
                 argument (same order as getArguments()), e.g. already produced
                 by getFullArgumentNames() by the caller -- avoids resolving the
                 same base+argument path twice per validator run. Computed
                 locally when omitted.

| Parameter | Type | Description |
|---|---|---|
| `$throwError` | `bool` | Whether an error should be thrown for each missing argument if this validator is required. |
| `$fullArgumentNames` | `?``array``<``int``, ``string``>` | Precomputed full path per argument (same order as getArguments()), e.g. already produced by getFullArgumentNames() by the caller -- avoids resolving the same base+argument path twice per validator run. Computed locally when omitted. |

Returns `bool` — Whether the arguments are set.

### execute()

`public function execute(WebRequest $parameters): int`

Executes the validator.

The data which should be validated.

| Parameter | Type | Description |
|---|---|---|
| `$parameters` | [`WebRequest`](/api/request/web-request/) | The data which should be validated. |

Returns `int` — The validation result (see severity constants).

### export()

`protected function export(mixed $value, ValidationArgument|string|null $argument = null, ?int $result = null): void`

Exports a value back into the request.

The result status code to use for the exported value.
                  Defaults to Validator::SUCCESS.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `mixed` | The value to be exported. |
| `$argument` | [`ValidationArgument`](/api/validator/validation-argument/)`|``string``|``null` | An optional parameter name which should be used for exporting instead of the "export" attribute value, or an ValidationArgument object if the value should be exported to a different source. |
| `$result` | `?``int` | The result status code to use for the exported value. Defaults to Validator::SUCCESS. |

### getAcceptedParameters()

`public static function getAcceptedParameters(): array<int, string>`

Returns the set of parameter names this validator understands.

ValidatorConfigHandler uses this to reject unknown/misspelled attributes and <ae:parameter> names at config-compile time instead of silently absorbing and ignoring them (see the SecureStringValidator `values` incident: a nonexistent allowlist attribute was silently stored and never enforced).

This base set covers every parameter the base Validator class itself reads (directly or via getAttributes() picking up structural XML attributes like 'class'/'name'/'method'). Subclasses that accept additional parameters MUST override this and merge onto the parent set — never replace it outright.

Returns `array``<``int``, ``string``>` — The accepted parameter names.

### getArgument()

`protected function getArgument(string $name = null): ?string`

Returns the name of the argument which should be validated.

The optional argument identifier, as configured.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The optional argument identifier, as configured. |

Returns `?``string` — The resulting name of the argument in the request data, or null if no argument is registered under that identifier.

### getArguments()

`public function getArguments(): array<int|string, string>`

Returns all arguments which should be validated.

Public (rather than the framework-internal default) so tooling that introspects a live, already-registered validator tree without running a real request -- e.g. the MCP package deriving a tool's input schema from validators registered via the fluent [`ValidatorBuilder`](/api/validator/compiler/runtime/validator-builder/) rather than an XML file -- can read back which request parameters a validator targets.

Returns `array``<``int``|``string``, ``string``>` — A list of input arguments names.

### getBase()

`public function getBase(): VirtualArrayPath`

Returns the base path of this validator.

Returns [`VirtualArrayPath`](/api/util/virtual-array-path/) — The basepath of this validator

### getBaseKeys()

`public function getBaseKeys(): array<int, mixed>`

Returns the "keys" in the path of the base

Returns `array``<``int``, ``mixed``>` — The keys from left to right

### getBaseParameter()

`protected function getBaseParameter(): string|int|null`

Returns the 'base' parameter narrowed to the type VirtualArrayPath's constructor accepts.

Returns `string``|``int``|``null`

### getContext()

`final public function getContext(): Context`

Retrieve the current application context.

Returns [`Context`](/api/context/) — The current Context instance.

### getData()

`protected function getData(string $paramName): mixed`

Returns the specified input value.

The name of the parameter to fetch from request.

| Parameter | Type | Description |
|---|---|---|
| `$paramName` | `string` | The name of the parameter to fetch from request. |

Returns `mixed` — The input value from the validation input.

### getDependencyManager()

`public function getDependencyManager(): ?DependencyManager`

Returns the depency manager of the parent container if any.

Returns `?`[`DependencyManager`](/api/validator/dependency-manager/) — The parent's dependency manager.

### getDependsParameter()

`protected function getDependsParameter(): array<int, string>`

Returns the 'depends' parameter narrowed to a list of strings.

initialize() always normalizes it to an array; this only re-validates the element types.

Returns `array``<``int``, ``string``>`

### getErrorMessage()

`protected function getErrorMessage(string $index = null, string $backupMessage = null): ?string`

Retrieves the error message for the given index with fallback.

The backup error message.

| Parameter | Type | Description |
|---|---|---|
| `$index` | `string` | The name of the error. |
| `$backupMessage` | `string` | The backup error message. |

Returns `?``string`

### getFullArgumentNames()

`protected function getFullArgumentNames(): array<int, string>`

Returns all arguments with their full path.

Returns `array``<``int``, ``string``>` — The arguments.

### getKeysInCurrentBase()

`protected function getKeysInCurrentBase(): array<int, int|string>`

Returns all available keys in the currently set base.

Returns `array``<``int``, ``int``|``string``>` — The available keys.

### getLastKey()

`public function getLastKey(): mixed`

Returns the last "keys" in the path of the base

Returns `mixed` — The key

### getMutatedRequest()

`public function getMutatedRequest(): ?WebRequest`

The WebRequest this validator ended execute() with.

WebRequest is immutable, so export()'s setParameter()/enforceValidatedParameters() calls replace $this->validationParameters with a new instance rather than mutating it in place — callers (ValidationManager) must fetch the final instance back out via this accessor after execute() returns.

Returns `?`[`WebRequest`](/api/request/web-request/)

### getName()

`public function getName(): ?string`

Returns the name of this validator.

Returns `?``string` — The name

### getParentContainer()

`final public function getParentContainer(): ?IValidatorContainer`

Retrieve the parent container.

Returns `?`[`IValidatorContainer`](/api/validator/i-validator-container/) — The parent container.

### getProvidesParameter()

`protected function getProvidesParameter(): array<int, string>`

Returns the 'provides' parameter narrowed to a list of strings.

Returns `array``<``int``, ``string``>`

### getSeverityParameter()

`protected function getSeverityParameter(): string`

Returns the 'severity' parameter narrowed to string.

Returns `string`

### getSourceParameter()

`protected function getSourceParameter(): string`

Returns the 'source' parameter (the request data holder to validate against, e.g.

"parameters", "files", "headers", "cookies"), narrowed to string. initialize() always seeds a string default, so a non-string here means something set the parameter after the fact with the wrong type.

Returns `string`

### getTranslationDomainParameter()

`protected function getTranslationDomainParameter(): ?string`

Returns the 'translation_domain' parameter narrowed to string|null.

Returns `?``string`

### hasMultipleArguments()

`protected function hasMultipleArguments(): bool`

Returns true if this validator has multiple arguments which need to be validated.

Returns `bool` — Whether this validator has multiple arguments or not.

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

### invalidParameterType()

`protected function invalidParameterType(string $paramName, string $expectedType, mixed $value): ConfigurationException`

Builds a ConfigurationException for a validator parameter whose runtime value doesn't match the type the validator requires.

| Parameter | Type | Description |
|---|---|---|
| `$paramName` | `string` |  |
| `$expectedType` | `string` |  |
| `$value` | `mixed` |  |

Returns [`ConfigurationException`](/api/exception/configuration-exception/)

### isRequiredParameter()

`protected function isRequiredParameter(): bool`

Returns the 'required' parameter narrowed to bool.

Returns `bool`

### mapErrorCode()

`public static function mapErrorCode(string $code): int`

Converts string severity codes into integer values (see severity constants) critical -> Validator::CRITICAL error    -> Validator::ERROR notice   -> Validator::NOTICE none     -> Validator::NONE success  -> not allowed to be specified by the user.

The error severity as string.

| Parameter | Type | Description |
|---|---|---|
| `$code` | `string` | The error severity as string. |

Returns `int` — The error severity as in (see severity constants).

| Throws | When |
|---|---|
| `ValidatorException` | if the input was no known severity |

### reset()

`public function reset(): void`

Returns the validator to its uninitialized state for reuse across requests.

Detaches the context and the parent container, and drops the name, base, arguments, error messages, affected arguments and any incident raised on the last run, then clears the parameters through the ParameterHolder base. A reset validator has to go through initialize() again before it can validate anything.

### setAffectedArguments()

`protected function setAffectedArguments(array<int, string> $arguments): void`

Sets the arguments which should be flagged with the result of the validator

A list of (absolute) argument names

| Parameter | Type | Description |
|---|---|---|
| `$arguments` | `array``<``int``, ``string``>` | A list of (absolute) argument names |

### setErrorMessage()

`public function setErrorMessage(string $index, string $message): void`

Sets an error message override for the given index (the empty string is the default/generic message).

The error message.

| Parameter | Type | Description |
|---|---|---|
| `$index` | `string` | The error index ('' for the default message). |
| `$message` | `string` | The error message. |

### setParentContainer()

`public function setParentContainer(IValidatorContainer $parent): void`

Sets the parent container.

The parent container.

| Parameter | Type | Description |
|---|---|---|
| `$parent` | [`IValidatorContainer`](/api/validator/i-validator-container/) | The parent container. |

### shutdown()

`public function shutdown(): void`

Shuts the validator down.

This method can be used in validators to shut down used models or other activities before the validator is killed.

### throwError()

`protected function throwError(string $index = null, string|array<int, string>|null $affectedArgument = null, boolean $argumentsRelative = false, boolean $setAffected = false): void`

Submits an error to the error manager.

Whether to set the affected fields of the validator
                    to the $affectedArguments

| Parameter | Type | Description |
|---|---|---|
| `$index` | `string` | The name of the error parameter to fetch the message from. |
| `$affectedArgument` | `string``|``array``<``int``, ``string``>``|``null` | The arguments which are affected by this error. If null is given it will affect all fields. |
| `$argumentsRelative` | `boolean` | Whether the argument names in $affectedArgument are relative or absolute. |
| `$setAffected` | `boolean` | Whether to set the affected fields of the validator to the $affectedArguments |

### validate()

`abstract protected function validate(): bool`

Validates the input.

This is the method where all the validation stuff is going to happen. Inherited classes have to implement their validation logic here. It returns only true or false as validation results. The handling of error severities is done by the validator itself and should not concern the writer of a new validator.

Returns `bool` — The result of the validation.

### validateInBase()

`protected function validateInBase(VirtualArrayPath $base): int`

Validates this validator in the given base.

The base in which the input should be 
                                  validated.

| Parameter | Type | Description |
|---|---|---|
| `$base` | [`VirtualArrayPath`](/api/util/virtual-array-path/) | The base in which the input should be validated. |

Returns `int` — Validator::SUCCESS if validation succeeded or given error severity.

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
