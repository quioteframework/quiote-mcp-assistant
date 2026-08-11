# ValidationArgument

> ValidationArgument is a tuple of argument name and source that specifies the argument to validate.

ValidationArgument is a tuple of argument name and source that specifies the argument to validate.

## Synopsis

`class ValidationArgument`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Validator/ValidationArgument.php` |

## Constructor

### __construct()

`public function __construct(string $name, string $source = null): mixed`

Create a new ValidationArgument instance.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | the name of the argument. |
| `$source` | `string` | the name of the source, if null, "parameters" is used. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getHash(): string`](#gethash) | Get a unique hash value for this ValidationArgument. |
| [`getName(): string`](#getname) | Retrieve the name of the argument for this instance. |
| [`getSource(): string`](#getsource) | Retrieve the name of the source for this instance. |

### getHash()

`public function getHash(): string`

Get a unique hash value for this ValidationArgument.

Returns `string` — the hash value

### getName()

`public function getName(): string`

Retrieve the name of the argument for this instance.

Returns `string` — the name of the argument

### getSource()

`public function getSource(): string`

Retrieve the name of the source for this instance.

Returns `string` — the name of the source.
