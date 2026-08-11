# ValidationReportQuery

> ValidationReportQuery allows queries against the validation run report.

ValidationReportQuery allows queries against the validation run report.

## Synopsis

`class ValidationReportQuery implements IValidationReportQuery`

|  |  |
|---|---|
| Implements | [`IValidationReportQuery`](/api/validator/i-validation-report-query/) |
| Since | `1.0.0` |
| Source | `Validator/ValidationReportQuery.php` |

## Constructor

### __construct()

`public function __construct(ValidationReport $report): mixed`

Constructor.

The validation report instance.

| Parameter | Type | Description |
|---|---|---|
| `$report` | [`ValidationReport`](/api/validator/validation-report/) | The validation report instance. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`byArgument(ValidationArgument|string|array<int, ValidationArgument|string> $argument): IValidationReportQuery`](#byargument) | Returns a new IValidationReportQuery which returns only the incidents for the given argument (and the other existing filter rules). |
| [`byErrorName(string|array<int, string> $name): IValidationReportQuery`](#byerrorname) | Returns a new IValidationReportQuery which contains only the incidents for the given error name (and the other existing filter rules). |
| [`byMaxSeverity(int $maxSeverity): IValidationReportQuery`](#bymaxseverity) | Returns a new IValidationReportQuery which contains only the incidents of the given severity or lower (and the other existing filter rules). |
| [`byMinSeverity(int $minSeverity): IValidationReportQuery`](#byminseverity) | Returns a new IValidationReportQuery which contains only the incidents of the given severity or higher (and the other existing filter rules). |
| [`byValidator(string|array<int, string> $name): IValidationReportQuery`](#byvalidator) | Returns a new IValidationReportQuery which contains only the incidents for the given validator (and the other existing filter rules). |
| [`count(): int`](#count) | Get the number of incidents matching the currently defined filter rules. |
| [`getArguments(): array<int, ValidationArgument>`](#getarguments) | Retrieves all ValidationArgument objects which match the currently defined filter rules. |
| [`getErrorMessages(): array<int, string>`](#geterrormessages) | Retrieves all error messages which match the currently defined filter rules. |
| [`getErrorMessagesWithFields(): array<int, array{message: string, errors: array<int, string>}>`](#geterrormessageswithfields) | Retrieves all error messages together with the fields that caused them, matching the currently defined filter rules. |
| [`getErrors(): array<int, ValidationError>`](#geterrors) | Retrieves all ValidationError objects which match the currently defined filter rules. |
| [`getIncidents(): array<int, ValidationIncident>`](#getincidents) | Retrieves all incidents which match the currently defined filter rules. |
| [`getResult(): ?int`](#getresult) | Retrieves the highest validation result code of the collection composed of the currently defined filter rules. |
| [`has(): bool`](#has) | Check if there are any incidents matching the currently defined filter rules. |

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

Returns `int` — The number of incidents matching the currently defined filter rules.

### getArguments()

`public function getArguments(): array<int, ValidationArgument>`

Retrieves all ValidationArgument objects which match the currently defined filter rules.

Returns `array``<``int``, `[`ValidationArgument`](/api/validator/validation-argument/)`>` — An array of ValidationArgument objects.

### getErrorMessages()

`public function getErrorMessages(): array<int, string>`

Retrieves all error messages which match the currently defined filter rules.

Returns `array``<``int``, ``string``>` — An array of message strings.

### getErrorMessagesWithFields()

`public function getErrorMessagesWithFields(): array<int, array{message: string, errors: array<int, string>}>`

Retrieves all error messages together with the fields that caused them, matching the currently defined filter rules.

Returns the same array('message' => string, 'errors' => array) structure as the deprecated ValidationManager::getErrorMessages(), but as a non-deprecated report-query accessor.

Returns `array``<``int``, ``array{message: string, errors: array<int, string>}``>` — An array of array('message' => string, 'errors' => array).

### getErrors()

`public function getErrors(): array<int, ValidationError>`

Retrieves all ValidationError objects which match the currently defined filter rules.

Returns `array``<``int``, `[`ValidationError`](/api/validator/validation-error/)`>` — An array of ValidationError objects.

### getIncidents()

`public function getIncidents(): array<int, ValidationIncident>`

Retrieves all incidents which match the currently defined filter rules.

Returns `array``<``int``, `[`ValidationIncident`](/api/validator/validation-incident/)`>` — An array of ValidationIncident objects.

### getResult()

`public function getResult(): ?int`

Retrieves the highest validation result code of the collection composed of the currently defined filter rules.

Returns `?``int` — An Validator::* severity constant, or null if there is no result for this filter combination. Please remember to do a strict === comparison if you are comparing against Validator::SUCCESS.

### has()

`public function has(): bool`

Check if there are any incidents matching the currently defined filter rules.

Returns `bool` — Whether or not any incidents exist for the currently defined filter rules.
