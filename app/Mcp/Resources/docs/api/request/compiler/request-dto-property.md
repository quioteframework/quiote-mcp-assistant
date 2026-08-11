# RequestDtoProperty

> One constructor-promoted property of a #[MapRequest] DTO, as reflected by RequestDtoScanner.

One constructor-promoted property of a #[MapRequest] DTO, as reflected by RequestDtoScanner.

Carries everything RequestDtoMapper needs to pull a value back out of an already-validated WebRequest and cast it to the property's declared PHP type.

## Synopsis

`final class RequestDtoProperty`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Request/Compiler/RequestDtoProperty.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$defaultValue` | `mixed` | _readonly._ |
| `$enumClass` | `?``string` | _readonly._ |
| `$hasDefault` | `bool` | _readonly._ |
| `$kind` | `string` | _readonly._ |
| `$name` | `string` | _readonly._ |
| `$nullable` | `bool` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $name, 'string'|'int'|'float'|'bool'|'array'|'datetime'|'enum' $kind, bool $nullable, bool $hasDefault, mixed $defaultValue, ?class-string $enumClass = null): mixed`

Set only when $kind === 'enum'.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$kind` | `'string'``|``'int'``|``'float'``|``'bool'``|``'array'``|``'datetime'``|``'enum'` |  |
| `$nullable` | `bool` |  |
| `$hasDefault` | `bool` |  |
| `$defaultValue` | `mixed` |  |
| `$enumClass` | `?``class-string` | Set only when $kind === 'enum'. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`isRequired(): bool`](#isrequired) | Reports whether the mapper has to find a value for this property. |

### isRequired()

`public function isRequired(): bool`

Reports whether the mapper has to find a value for this property.

True only when the property is neither nullable nor has a constructor default: in either of those cases the DTO can still be built without an incoming value.

Returns `bool`
