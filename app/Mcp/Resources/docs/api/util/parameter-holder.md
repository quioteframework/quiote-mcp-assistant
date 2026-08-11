# ParameterHolder

> ParameterHolder provides a base class for managing parameters.

ParameterHolder provides a base class for managing parameters.

## Synopsis

`class ParameterHolder implements ResetInterface`

|  |  |
|---|---|
| Implements | `ResetInterface` |
| Since | `1.0.0` |
| Source | `Util/ParameterHolder.php` |

## Constructor

### __construct()

`public function __construct(array<int|string, mixed> $parameters = []): mixed`

Constructor.

An array of parameters to be set right away.

| Parameter | Type | Description |
|---|---|---|
| `$parameters` | `array``<``int``|``string``, ``mixed``>` | An array of parameters to be set right away. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`appendParameter(int|string $name, mixed $value): void`](#appendparameter) | Append a parameter. |
| [`appendParameterByRef(int|string $name, mixed &$value): void`](#appendparameterbyref) | Append a parameter by reference. |
| [`clearParameters(): void`](#clearparameters) | Clear all parameters associated with this request. |
| [`getFlatParameterNames(): array<int, string>`](#getflatparameternames) | Retrieve an array of flattened parameter names. |
| [`getParameter(int|string $name, mixed $default = null): mixed`](#getparameter) | Retrieve a parameter. |
| [`getParameterNames(): array<int, int|string>`](#getparameternames) | Retrieve an array of parameter names. |
| [`getParameters(): array<int|string, mixed>`](#getparameters) | Retrieve an array of parameters. |
| [`hasParameter(int|string $name): bool`](#hasparameter) | Indicates whether or not a parameter exists. |
| [`removeParameter(int|string $name): mixed`](#removeparameter) | Remove a parameter. |
| [`reset(): void`](#reset) | Removes every parameter held, leaving the holder empty for reuse. |
| [`setParameter(int|string $name, mixed $value): void`](#setparameter) | Set a parameter. |
| [`setParameterByRef(int|string $name, mixed &$value): void`](#setparameterbyref) | Set a parameter by reference. |
| [`setParameters(array<int|string, mixed> $parameters): void`](#setparameters) | Set an array of parameters. |
| [`setParametersByRef(array<int|string, mixed> &$parameters): void`](#setparametersbyref) | Set an array of parameters by reference. |

### appendParameter()

`public function appendParameter(int|string $name, mixed $value): void`

Append a parameter.

A parameter value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `int``|``string` | A parameter name. |
| `$value` | `mixed` | A parameter value. |

### appendParameterByRef()

`public function appendParameterByRef(int|string $name, mixed &$value): void`

Append a parameter by reference.

A reference to a parameter value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `int``|``string` | A parameter name. |
| `$value` | `mixed` | A reference to a parameter value. |

### clearParameters()

`public function clearParameters(): void`

Clear all parameters associated with this request.

### getFlatParameterNames()

`public function getFlatParameterNames(): array<int, string>`

Retrieve an array of flattened parameter names.

This means when a parameter is an array you wont get the name of the parameter in the result but instead all child keys appended to the name (like foo[0],foo[1][0], ...)

Returns `array``<``int``, ``string``>` — An indexed array of parameter names.

### getParameter()

`public function getParameter(int|string $name, mixed $default = null): mixed`

Retrieve a parameter.

A default parameter value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `int``|``string` | A parameter name. |
| `$default` | `mixed` | A default parameter value. |

Returns `mixed` — A parameter value, if the parameter exists, otherwise null.

### getParameterNames()

`public function getParameterNames(): array<int, int|string>`

Retrieve an array of parameter names.

Returns `array``<``int``, ``int``|``string``>` — An indexed array of parameter names.

### getParameters()

`public function getParameters(): array<int|string, mixed>`

Retrieve an array of parameters.

Returns `array``<``int``|``string``, ``mixed``>` — An associative array of parameters.

### hasParameter()

`public function hasParameter(int|string $name): bool`

Indicates whether or not a parameter exists.

A parameter name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `int``|``string` | A parameter name. |

Returns `bool` — true, if the parameter exists, otherwise false.

### removeParameter()

`public function removeParameter(int|string $name): mixed`

Remove a parameter.

A parameter name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `int``|``string` | A parameter name. |

Returns `mixed` — A parameter value, if the parameter was removed, otherwise null.

### reset()

`public function reset(): void`

Removes every parameter held, leaving the holder empty for reuse.

### setParameter()

`public function setParameter(int|string $name, mixed $value): void`

Set a parameter.

A parameter value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `int``|``string` | A parameter name. |
| `$value` | `mixed` | A parameter value. |

### setParameterByRef()

`public function setParameterByRef(int|string $name, mixed &$value): void`

Set a parameter by reference.

A reference to a parameter value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `int``|``string` | A parameter name. |
| `$value` | `mixed` | A reference to a parameter value. |

### setParameters()

`public function setParameters(array<int|string, mixed> $parameters): void`

Set an array of parameters.

An associative array of parameters and their associated
                  values.

| Parameter | Type | Description |
|---|---|---|
| `$parameters` | `array``<``int``|``string``, ``mixed``>` | An associative array of parameters and their associated values. |

### setParametersByRef()

`public function setParametersByRef(array<int|string, mixed> &$parameters): void`

Set an array of parameters by reference.

An associative array of parameters and references to their
                  associated values.

| Parameter | Type | Description |
|---|---|---|
| `$parameters` | `array``<``int``|``string``, ``mixed``>` | An associative array of parameters and references to their associated values. |
