# TypeResolver

> Builds TypeRef trees from what the source says, resolving names the way PHP would.

Builds [`TypeRef`](/api/docs/ir/type-ref/) trees from what the source says, resolving names the way PHP would.

A docblock writes `Route`, not `Quiote\Routing\Route`; only the declaring file's `use` statements say which `Route` that is. Reflection cannot supply them, which is why the scanner collects them and they arrive here as the [`ScannedType`](/api/docs/scan/scanned-type/) context.

## Synopsis

`final class TypeResolver`

|  |  |
|---|---|
| Source | `Docblock/TypeResolver.php` |

## Constructor

### __construct()

`public function __construct(): mixed`

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromDocString(?string $type, ScannedType $context): ?TypeRef`](#fromdocstring) | Converts a type as written in a docblock, which is usually the narrower of the two: `list<Route>` where the signature could only say `array`. |
| [`fromReflection(?ReflectionType $type, ScannedType $context): TypeRef`](#fromreflection) | Converts a native parameter, property or return type. |

### fromDocString()

`public function fromDocString(?string $type, ScannedType $context): ?TypeRef`

Converts a type as written in a docblock, which is usually the narrower of the two: `list<Route>` where the signature could only say `array`.

| Parameter | Type | Description |
|---|---|---|
| `$type` | `?``string` |  |
| `$context` | [`ScannedType`](/api/docs/scan/scanned-type/) |  |

Returns `?`[`TypeRef`](/api/docs/ir/type-ref/)

### fromReflection()

`public function fromReflection(?ReflectionType $type, ScannedType $context): TypeRef`

Converts a native parameter, property or return type.

| Parameter | Type | Description |
|---|---|---|
| `$type` | `?``ReflectionType` |  |
| `$context` | [`ScannedType`](/api/docs/scan/scanned-type/) |  |

Returns [`TypeRef`](/api/docs/ir/type-ref/)
