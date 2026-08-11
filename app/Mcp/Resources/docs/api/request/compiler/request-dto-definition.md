# RequestDtoDefinition

> Format-independent description of a #[MapRequest] DTO class: its constructor-promoted properties, in declaration order.

Format-independent description of a #[MapRequest] DTO class: its constructor-promoted properties, in declaration order.

Produced once per class by RequestDtoScanner::scan() and cached by RequestDtoRegistry.

## Synopsis

`final class RequestDtoDefinition`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Request/Compiler/RequestDtoDefinition.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$className` | `string` | _readonly._ |
| `$properties` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $className, array<int, RequestDtoProperty> $properties): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$className` | `string` |  |
| `$properties` | `array``<``int``, `[`RequestDtoProperty`](/api/request/compiler/request-dto-property/)`>` |  |

Returns `mixed`
