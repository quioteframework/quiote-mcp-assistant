# ValidationReport

> ValidationReport stores the result of a validation run.

ValidationReport stores the result of a validation run.

## Synopsis

`class ValidationReport implements IValidationReportQuery, ResetInterface`

|  |  |
|---|---|
| Implements | [`IValidationReportQuery`](/api/validator/i-validation-report-query/), `ResetInterface` |
| Since | `1.0.0` |
| Source | `Validator/ValidationReport.php` |

## Methods

| Method | Description |
|---|---|
| [`addArgumentResult(ValidationArgument $argument, int $result, Validator $validator = null): void`](#addargumentresult) | Adds a intermediate result of an validator for the given argument |
| [`addIncident(ValidationIncident $incident): void`](#addincident) | Adds an incident to the validation result. |
| [`byArgument(ValidationArgument|string|array<int, ValidationArgument|string> $argument): IValidationReportQuery`](#byargument) | Returns a new IValidationReportQuery which returns only the incidents for the given argument (and the other existing filter rules). |
| [`byErrorName(string|array<int, string> $name): IValidationReportQuery`](#byerrorname) | Returns a new IValidationReportQuery which contains only the incidents for the given error name (and the other existing filter rules). |
| [`byMaxSeverity(int $maxSeverity): IValidationReportQuery`](#bymaxseverity) | Returns a new IValidationReportQuery which contains only the incidents of the given severity or lower (and the other existing filter rules). |
| [`byMinSeverity(int $minSeverity): IValidationReportQuery`](#byminseverity) | Returns a new IValidationReportQuery which contains only the incidents of the given severity or higher (and the other existing filter rules). |
| [`byValidator(string|array<int, string> $name): IValidationReportQuery`](#byvalidator) | Returns a new IValidationReportQuery which contains only the incidents for the given validator (and the other existing filter rules). |
| [`count(): int`](#count) | Get the number of incidents matching the currently defined filter rules. |
| [`createQuery(): IValidationReportQuery`](#createquery) | Create a new ValidationReportQuery for this report. |
| [`getArgumentResults(): array<string, array<int, array{argument: ValidationArgument, severity: int, validator: ?Validator}>>`](#getargumentresults) | Retrieve the internal array (indexed by argument hash) of argument/severity/validator tuples. |
| [`getArguments(): array<int, ValidationArgument>`](#getarguments) | Retrieves all ValidationArgument objects in this report. |
| [`getAuthoritativeArgumentSeverity(ValidationArgument $argument, string $validatorName = null): ?int`](#getauthoritativeargumentseverity) | Will return the highest error severity for an argument. |
| [`getDependTokens(): array<int|string, mixed>`](#getdependtokens) | Check whether the given depend token was provided by the validation run. |
| [`getErrorMessages(): array<int, string>`](#geterrormessages) | Retrieves all error messages in this report. |
| [`getErrorMessagesWithFields(): array<int, array{message: string, errors: array<int, string>}>`](#geterrormessageswithfields) | Retrieves all error messages together with the fields that caused them. |
| [`getErrors(): array<int, ValidationError>`](#geterrors) | Retrieves all ValidationError objects in this report. |
| [`getFailedArguments(string $source = null): array<string, ValidationArgument>`](#getfailedarguments) | Returns all arguments which failed in the validation. |
| [`getIncidents(): array<int, ValidationIncident>`](#getincidents) | Returns all incidents which happened during the execution of the validation. |
| [`getResult(): ?int`](#getresult) | Retrieves the highest validation result code in this report. |
| [`getSucceededArguments(string $source = null): array<string, ValidationArgument>`](#getsucceededarguments) | Returns all arguments which validated successfully. |
| [`has(): bool`](#has) | Check if there are any incidents matching the currently defined filter rules. |
| [`hasDependToken(string $token): bool`](#hasdependtoken) | Check whether the given depend token was provided by the validation run. |
| [`hasIncidents(): bool`](#hasincidents) | Checks if any incidents occurred Returns all arguments which succeeded in the validation. |
| [`isArgumentFailed(ValidationArgument $argument): bool`](#isargumentfailed) | Checks whether an argument has failed in any validator. |
| [`isArgumentValidated(ValidationArgument $argument): bool`](#isargumentvalidated) | Checks whether an argument has been processed by a validator (this includes arguments which were skipped because their value was not set and the validator was not required) |
| [`reset(): void`](#reset) | Returns the report to its initial state for reuse across requests. |
| [`setDependTokens(array<int|string, mixed> $dependTokens = []): void`](#setdependtokens) | Sets dependency tokens provided by executed validators onto the result. |
| [`setResult(int $result): void`](#setresult) | Sets the validation result |

### addArgumentResult()

`public function addArgumentResult(ValidationArgument $argument, int $result, Validator $validator = null): void`

Adds a intermediate result of an validator for the given argument

The validator (if the error was cause inside 
                           a validator).

| Parameter | Type | Description |
|---|---|---|
| `$argument` | [`ValidationArgument`](/api/validator/validation-argument/) | The argument |
| `$result` | `int` | The arguments result. |
| `$validator` | [`Validator`](/api/validator/validator/) | The validator (if the error was cause inside a validator). |

### addIncident()

`public function addIncident(ValidationIncident $incident): void`

Adds an incident to the validation result.

The incident.

| Parameter | Type | Description |
|---|---|---|
| `$incident` | [`ValidationIncident`](/api/validator/validation-incident/) | The incident. |

### byArgument()

`public function byArgument(ValidationArgument|string|array<int, ValidationArgument|string> $argument): IValidationReportQuery`

Returns a new IValidationReportQuery which returns only the incidents for the given argument (and the other existing filter rules).

The argument instance, or
                                                 a parameter name, or an
                                                 array of these elements.

| Parameter | Type | Description |
|---|---|---|
| `$argument` | [`ValidationArgument`](/api/validator/validation-argument/)`|``string``|``array``<``int``, `[`ValidationArgument`](/api/validator/validation-argument/)`|``string``>` | The argument instance, or a parameter name, or an array of these elements. |

Returns [`IValidationReportQuery`](/api/validator/i-validation-report-query/)

### byErrorName()

`public function byErrorName(string|array<int, string> $name): IValidationReportQuery`

Returns a new IValidationReportQuery which contains only the incidents for the given error name (and the other existing filter rules).

The name of the error, or an array of names.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``array``<``int``, ``string``>` | The name of the error, or an array of names. |

Returns [`IValidationReportQuery`](/api/validator/i-validation-report-query/)

### byMaxSeverity()

`public function byMaxSeverity(int $maxSeverity): IValidationReportQuery`

Returns a new IValidationReportQuery which contains only the incidents of the given severity or lower (and the other existing filter rules).

The maximum severity.

| Parameter | Type | Description |
|---|---|---|
| `$maxSeverity` | `int` | The maximum severity. |

Returns [`IValidationReportQuery`](/api/validator/i-validation-report-query/)

### byMinSeverity()

`public function byMinSeverity(int $minSeverity): IValidationReportQuery`

Returns a new IValidationReportQuery which contains only the incidents of the given severity or higher (and the other existing filter rules).

The minimum severity.

| Parameter | Type | Description |
|---|---|---|
| `$minSeverity` | `int` | The minimum severity. |

Returns [`IValidationReportQuery`](/api/validator/i-validation-report-query/)

### byValidator()

`public function byValidator(string|array<int, string> $name): IValidationReportQuery`

Returns a new IValidationReportQuery which contains only the incidents for the given validator (and the other existing filter rules).

The name of the validator, or an array of names.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``array``<``int``, ``string``>` | The name of the validator, or an array of names. |

Returns [`IValidationReportQuery`](/api/validator/i-validation-report-query/)

### count()

`public function count(): int`

Get the number of incidents matching the currently defined filter rules.

Returns `int` — The number of incidents in this report.

### createQuery()

`public function createQuery(): IValidationReportQuery`

Create a new ValidationReportQuery for this report.

Returns [`IValidationReportQuery`](/api/validator/i-validation-report-query/)

### getArgumentResults()

`public function getArgumentResults(): array<string, array<int, array{argument: ValidationArgument, severity: int, validator: ?Validator}>>`

Retrieve the internal array (indexed by argument hash) of argument/severity/validator tuples.

This method exposes an internal data structure that may change at any time. You shouldn't have to use this method. Don't even think about using it to harm cute little animals, or you shall suffer the wrath of an angry god.

Returns `array``<``string``, ``array``<``int``, ``array{argument: ValidationArgument, severity: int, validator: ?Validator}``>``>` — An array of argument result info arrays.

### getArguments()

`public function getArguments(): array<int, ValidationArgument>`

Retrieves all ValidationArgument objects in this report.

Returns `array``<``int``, `[`ValidationArgument`](/api/validator/validation-argument/)`>` — An array of ValidationArgument objects.

### getAuthoritativeArgumentSeverity()

`public function getAuthoritativeArgumentSeverity(ValidationArgument $argument, string $validatorName = null): ?int`

Will return the highest error severity for an argument.

Optional name of a specific validator
                                    to get a result for.

| Parameter | Type | Description |
|---|---|---|
| `$argument` | [`ValidationArgument`](/api/validator/validation-argument/) | The argument. |
| `$validatorName` | `string` | Optional name of a specific validator to get a result for. |

Returns `?``int` — The error severity.

### getDependTokens()

`public function getDependTokens(): array<int|string, mixed>`

Check whether the given depend token was provided by the validation run.

Returns `array``<``int``|``string``, ``mixed``>` — All provided depend tokens.

### getErrorMessages()

`public function getErrorMessages(): array<int, string>`

Retrieves all error messages in this report.

Returns `array``<``int``, ``string``>` — An array of message strings.

### getErrorMessagesWithFields()

`public function getErrorMessagesWithFields(): array<int, array{message: string, errors: array<int, string>}>`

Retrieves all error messages together with the fields that caused them.

Returns the same array('message' => string, 'errors' => array) structure as the deprecated ValidationManager::getErrorMessages(), but as a non-deprecated accessor. Callers migrating off the deprecated method can use getReport()->getErrorMessagesWithFields() to keep the field-annotated shape.

Returns `array``<``int``, ``array{message: string, errors: array<int, string>}``>` — An array of array('message' => string, 'errors' => array).

### getErrors()

`public function getErrors(): array<int, ValidationError>`

Retrieves all ValidationError objects in this report.

Returns `array``<``int``, `[`ValidationError`](/api/validator/validation-error/)`>` — An array of ValidationError objects.

### getFailedArguments()

`public function getFailedArguments(string $source = null): array<string, ValidationArgument>`

Returns all arguments which failed in the validation.

Optional source name to limit the list of arguments to.

| Parameter | Type | Description |
|---|---|---|
| `$source` | `string` | Optional source name to limit the list of arguments to. |

Returns `array``<``string``, `[`ValidationArgument`](/api/validator/validation-argument/)`>` — An array of ValidationArgument objects.

### getIncidents()

`public function getIncidents(): array<int, ValidationIncident>`

Returns all incidents which happened during the execution of the validation.

Returns `array``<``int``, `[`ValidationIncident`](/api/validator/validation-incident/)`>` — The incidents.

### getResult()

`public function getResult(): ?int`

Retrieves the highest validation result code in this report.

Returns `?``int` — An Validator::* severity constant, or null if there is no result. Please remember to do a strict === comparison if you are comparing against Validator::SUCCESS.

### getSucceededArguments()

`public function getSucceededArguments(string $source = null): array<string, ValidationArgument>`

Returns all arguments which validated successfully.

Optional source name to limit the list of arguments to.

| Parameter | Type | Description |
|---|---|---|
| `$source` | `string` | Optional source name to limit the list of arguments to. |

Returns `array``<``string``, `[`ValidationArgument`](/api/validator/validation-argument/)`>` — An array of ValidationArgument objects.

### has()

`public function has(): bool`

Check if there are any incidents matching the currently defined filter rules.

Returns `bool` — Whether or not any incidents exist in this report.

### hasDependToken()

`public function hasDependToken(string $token): bool`

Check whether the given depend token was provided by the validation run.

Name of depend token suspected to have been provided.

| Parameter | Type | Description |
|---|---|---|
| `$token` | `string` | Name of depend token suspected to have been provided. |

Returns `bool` — True if depend token was provided.

### hasIncidents()

`public function hasIncidents(): bool`

Checks if any incidents occurred Returns all arguments which succeeded in the validation.

Includes arguments which were not processed (happens when the argument is "not set" and the validator is not required)

Returns `bool` — The result.

### isArgumentFailed()

`public function isArgumentFailed(ValidationArgument $argument): bool`

Checks whether an argument has failed in any validator.

The argument.

| Parameter | Type | Description |
|---|---|---|
| `$argument` | [`ValidationArgument`](/api/validator/validation-argument/) | The argument. |

Returns `bool` — Whether the validating that argument has failed.

### isArgumentValidated()

`public function isArgumentValidated(ValidationArgument $argument): bool`

Checks whether an argument has been processed by a validator (this includes arguments which were skipped because their value was not set and the validator was not required)

The argument.

| Parameter | Type | Description |
|---|---|---|
| `$argument` | [`ValidationArgument`](/api/validator/validation-argument/) | The argument. |

Returns `bool` — Whether the argument was validated.

### reset()

`public function reset(): void`

Returns the report to its initial state for reuse across requests.

Clears the per-argument results, the incidents and the provided dependency tokens, and puts the cached overall result back to null so that the next query recomputes it from scratch.

### setDependTokens()

`public function setDependTokens(array<int|string, mixed> $dependTokens = []): void`

Sets dependency tokens provided by executed validators onto the result.

The depend tokens of the DependencyManager.

| Parameter | Type | Description |
|---|---|---|
| `$dependTokens` | `array``<``int``|``string``, ``mixed``>` | The depend tokens of the DependencyManager. |

### setResult()

`public function setResult(int $result): void`

Sets the validation result

The new validation result

| Parameter | Type | Description |
|---|---|---|
| `$result` | `int` | The new validation result |
