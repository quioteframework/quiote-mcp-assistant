# IValidatorContainer

> IValidatorContainer is an interface for classes which contains several child validators

IValidatorContainer is an interface for classes which contains several child validators

## Synopsis

`interface IValidatorContainer`

|  |  |
|---|---|
| Implemented by | [`OperatorValidator`](/api/validator/operator-validator/), [`ValidationManager`](/api/validator/validation-manager/) |
| Since | `1.0.0` |
| Source | `Validator/IValidatorContainer.php` |

## Methods

| Method | Description |
|---|---|
| [`addArgumentResult(ValidationArgument $argument, int $result, ?Validator $validator = null): void`](#addargumentresult) | Adds a intermediate result of an validator for the given argument |
| [`addChild(Validator $validator): void`](#addchild) | Adds a new validator to the list of children. |
| [`addIncident(ValidationIncident $incident): void`](#addincident) | Adds an incident to the validation result. |
| [`getBase(): VirtualArrayPath`](#getbase) | Return the current base path used for relative argument resolution. |
| [`getChild(string $name): Validator`](#getchild) | Returns a named child validator. |
| [`getChilds(): array<string, Validator>`](#getchilds) | Returns all child validators. |
| [`getDependencyManager(): DependencyManager`](#getdependencymanager) | Fetches the dependency manager |

### addArgumentResult()

`abstract public function addArgumentResult(ValidationArgument $argument, int $result, ?Validator $validator = null): void`

Adds a intermediate result of an validator for the given argument

The validator (if the error was caused
                                    inside a validator).

| Parameter | Type | Description |
|---|---|---|
| `$argument` | [`ValidationArgument`](/api/validator/validation-argument/) | The argument |
| `$result` | `int` | The arguments result. |
| `$validator` | `?`[`Validator`](/api/validator/validator/) | The validator (if the error was caused inside a validator). |

### addChild()

`abstract public function addChild(Validator $validator): void`

Adds a new validator to the list of children.

The new child.

| Parameter | Type | Description |
|---|---|---|
| `$validator` | [`Validator`](/api/validator/validator/) | The new child. |

### addIncident()

`abstract public function addIncident(ValidationIncident $incident): void`

Adds an incident to the validation result.

The incident.

| Parameter | Type | Description |
|---|---|---|
| `$incident` | [`ValidationIncident`](/api/validator/validation-incident/) | The incident. |

### getBase()

`abstract public function getBase(): VirtualArrayPath`

Return the current base path used for relative argument resolution.

Implementations like ValidationManager provide this; validators rely on it.

Returns [`VirtualArrayPath`](/api/util/virtual-array-path/)

### getChild()

`abstract public function getChild(string $name): Validator`

Returns a named child validator.

The name of the child validator.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the child validator. |

Returns [`Validator`](/api/validator/validator/) — The named child validator.

### getChilds()

`abstract public function getChilds(): array<string, Validator>`

Returns all child validators.

Returns `array``<``string``, `[`Validator`](/api/validator/validator/)`>` — An array of Validator instances.

### getDependencyManager()

`abstract public function getDependencyManager(): DependencyManager`

Fetches the dependency manager

Returns [`DependencyManager`](/api/validator/dependency-manager/) — The dependency manager to be used by child validators.
