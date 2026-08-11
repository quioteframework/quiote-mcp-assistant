# ValidationError

> ValidationError stores an error message and the fields of an error.

ValidationError stores an error message and the fields of an error.

## Synopsis

`class ValidationError implements ResetInterface`

|  |  |
|---|---|
| Implements | `ResetInterface` |
| Since | `1.0.0` |
| Source | `Validator/ValidationError.php` |

## Constructor

### __construct()

`public function __construct(string $message, string $name, array<int, ValidationArgument|string> $arguments): mixed`

Constructor

The arguments affected by this error.

| Parameter | Type | Description |
|---|---|---|
| `$message` | `string` | The message of this error. |
| `$name` | `string` | The name of the message. |
| `$arguments` | `array``<``int``, `[`ValidationArgument`](/api/validator/validation-argument/)`|``string``>` | The arguments affected by this error. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getArguments(): array<string, ValidationArgument>`](#getarguments) | Retrieves the arguments which caused this error. |
| [`getFields(): array<int, string>`](#getfields) | Retrieves the fields which caused this error. |
| [`getIncident(): ?ValidationIncident`](#getincident) | Retrieves the incident which caused this error. |
| [`getMessage(): string`](#getmessage) | Retrieves the message of this error. |
| [`getName(): string`](#getname) | Retrieves the name of this error. |
| [`hasArgument(ValidationArgument $argument): bool`](#hasargument) | Checks if this error was caused for the given argument |
| [`hasField(string $fieldname): bool`](#hasfield) | Checks if this error was caused for the given field |
| [`reset(): void`](#reset) | Returns the error to its initial state for reuse across requests. |
| [`setIncident(ValidationIncident $incident): void`](#setincident) | Sets the incident which caused this error. |
| [`setMessage(string $message): void`](#setmessage) | Sets the message of this error. |
| [`setName(string $name): void`](#setname) | Sets the name of this error. |

### getArguments()

`public function getArguments(): array<string, ValidationArgument>`

Retrieves the arguments which caused this error.

Returns `array``<``string``, `[`ValidationArgument`](/api/validator/validation-argument/)`>` — An array of ValidationArgument.

### getFields()

`public function getFields(): array<int, string>`

Retrieves the fields which caused this error.

Returns `array``<``int``, ``string``>` — An array of field names.

### getIncident()

`public function getIncident(): ?ValidationIncident`

Retrieves the incident which caused this error.

Returns `?`[`ValidationIncident`](/api/validator/validation-incident/) — The incident.

### getMessage()

`public function getMessage(): string`

Retrieves the message of this error.

Returns `string` — The message.

### getName()

`public function getName(): string`

Retrieves the name of this error.

Returns `string` — The error name.

### hasArgument()

`public function hasArgument(ValidationArgument $argument): bool`

Checks if this error was caused for the given argument

The argument.

| Parameter | Type | Description |
|---|---|---|
| `$argument` | [`ValidationArgument`](/api/validator/validation-argument/) | The argument. |

Returns `bool` — The result.

### hasField()

`public function hasField(string $fieldname): bool`

Checks if this error was caused for the given field

The name of the field to check.

| Parameter | Type | Description |
|---|---|---|
| `$fieldname` | `string` | The name of the field to check. |

Returns `bool` — The result.

### reset()

`public function reset(): void`

Returns the error to its initial state for reuse across requests.

Drops the affected arguments, the message and the name, and detaches the error from the incident it belonged to, without touching that incident.

### setIncident()

`public function setIncident(ValidationIncident $incident): void`

Sets the incident which caused this error.

The incident.

| Parameter | Type | Description |
|---|---|---|
| `$incident` | [`ValidationIncident`](/api/validator/validation-incident/) | The incident. |

### setMessage()

`public function setMessage(string $message): void`

Sets the message of this error.

The message.

| Parameter | Type | Description |
|---|---|---|
| `$message` | `string` | The message. |

### setName()

`public function setName(string $name): void`

Sets the name of this error.

The error name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The error name. |
