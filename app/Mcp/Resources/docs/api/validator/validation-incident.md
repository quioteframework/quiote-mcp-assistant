# ValidationIncident

> ValidationIncident is erroneous result of an validation run.

ValidationIncident is erroneous result of an validation run.

## Synopsis

`class ValidationIncident implements ResetInterface`

|  |  |
|---|---|
| Implements | `ResetInterface` |
| Since | `1.0.0` |
| Source | `Validator/ValidationIncident.php` |

## Constructor

### __construct()

`public function __construct(Validator $validator, int $severity = Quiote\Validator\Validator::ERROR): mixed`

Constructor

The severity of the incident

| Parameter | Type | Description |
|---|---|---|
| `$validator` | [`Validator`](/api/validator/validator/) | The validator which caused this incident (null for errors thrown not in the validation) |
| `$severity` | `int` | The severity of the incident |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`addError(ValidationError $error): void`](#adderror) | Adds an error to this incident. |
| [`getArguments(): array<string, ValidationArgument>`](#getarguments) | Retrieves a list of all erroneous arguments of this incident. |
| [`getErrors(): array<int, ValidationError>`](#geterrors) | Retrieves the errors of this incident. |
| [`getFields(): array<int, string>`](#getfields) | Retrieves a list of all fields of all the containing errors. |
| [`getSeverity(): int`](#getseverity) | Retrieves the severity of this incident. |
| [`getValidator(): ?Validator`](#getvalidator) | Retrieves the validator of this incident. |
| [`reset(): void`](#reset) | Returns the incident to its initial state for reuse across requests. |
| [`setErrors(array<int, ValidationError> $errors): void`](#seterrors) | Sets the errors of this incident. |
| [`setSeverity(int $severity): int`](#setseverity) | Sets the severity of this incident. |
| [`setValidator(?Validator $validator): ?Validator`](#setvalidator) | Sets the validator of this incident. |

### addError()

`public function addError(ValidationError $error): void`

Adds an error to this incident.

The error.

| Parameter | Type | Description |
|---|---|---|
| `$error` | [`ValidationError`](/api/validator/validation-error/) | The error. |

### getArguments()

`public function getArguments(): array<string, ValidationArgument>`

Retrieves a list of all erroneous arguments of this incident.

Returns `array``<``string``, `[`ValidationArgument`](/api/validator/validation-argument/)`>` — An array of ValidationArgument.

### getErrors()

`public function getErrors(): array<int, ValidationError>`

Retrieves the errors of this incident.

Returns `array``<``int``, `[`ValidationError`](/api/validator/validation-error/)`>` — The errors.

### getFields()

`public function getFields(): array<int, string>`

Retrieves a list of all fields of all the containing errors.

Returns `array``<``int``, ``string``>` — An array of field names.

### getSeverity()

`public function getSeverity(): int`

Retrieves the severity of this incident.

Returns `int` — The severity.

### getValidator()

`public function getValidator(): ?Validator`

Retrieves the validator of this incident.

Returns `?`[`Validator`](/api/validator/validator/) — The validator.

### reset()

`public function reset(): void`

Returns the incident to its initial state for reuse across requests.

Detaches the validator that raised it, drops the collected errors and puts the severity back to the default [`Validator::ERROR`](/api/validator/validator/#error). The discarded errors are not themselves reset.

### setErrors()

`public function setErrors(array<int, ValidationError> $errors): void`

Sets the errors of this incident.

An array of ValidationErrors.

| Parameter | Type | Description |
|---|---|---|
| `$errors` | `array``<``int``, `[`ValidationError`](/api/validator/validation-error/)`>` | An array of ValidationErrors. |

### setSeverity()

`public function setSeverity(int $severity): int`

Sets the severity of this incident.

The severity.

| Parameter | Type | Description |
|---|---|---|
| `$severity` | `int` | The severity. |

Returns `int`

### setValidator()

`public function setValidator(?Validator $validator): ?Validator`

Sets the validator of this incident.

The validator.

| Parameter | Type | Description |
|---|---|---|
| `$validator` | `?`[`Validator`](/api/validator/validator/) | The validator. |

Returns `?`[`Validator`](/api/validator/validator/)
