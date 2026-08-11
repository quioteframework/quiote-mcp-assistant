# TypeRef

> A type, kept as a tree rather than a string so each part can be linked independently.

A type, kept as a tree rather than a string so each part can be linked independently.

`list<Quiote\Routing\Route>|null` has to render with `Route` pointing at its own page while `list` and `null` stay plain, which a flat string cannot express. Every node carries a `display` form so a renderer that does not care about linking can ignore the structure entirely.

## Synopsis

`final class TypeRef implements Stringable`

|  |  |
|---|---|
| Implements | [`Stringable`](https://www.php.net/manual/en/class.stringable.php) |
| Source | `Ir/TypeRef.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `KIND_GENERIC` | `'generic'` |  |
| `KIND_INTERSECTION` | `'intersection'` |  |
| `KIND_LITERAL` | `'literal'` |  |
| `KIND_NAMED` | `'named'` |  |
| `KIND_NULLABLE` | `'nullable'` |  |
| `KIND_UNION` | `'union'` |  |

## Properties

| Property | Type | Description |
|---|---|---|
| `$args` | `array` | _readonly._ |
| `$display` | `string` | _readonly._ |
| `$fqcn` | `?``string` | _readonly._ |
| `$kind` | `string` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`__toString(): string`](#tostring) |  |
| [`generic(TypeRef $base, list<TypeRef> $arguments): TypeRef`](#generic) |  |
| [`intersection(list<TypeRef> $members): TypeRef`](#intersection) |  |
| [`literal(string $text): TypeRef`](#literal) | A keyword, scalar or anything else with no class behind it to link to. |
| [`named(string $fqcn): TypeRef`](#named) | A class-like type, which may or may not be one the reference documents. |
| [`nullable(TypeRef $inner): TypeRef`](#nullable) |  |
| [`referencedClasses(): list<string>`](#referencedclasses) | Every named type anywhere in the tree, so a renderer can decide what to link without walking the structure itself. |
| [`union(list<TypeRef> $members): TypeRef`](#union) |  |

### __toString()

`public function __toString(): string`

Returns `string`

### generic()

`public static function generic(TypeRef $base, list<TypeRef> $arguments): TypeRef`

| Parameter | Type | Description |
|---|---|---|
| `$base` | [`TypeRef`](/api/docs/ir/type-ref/) |  |
| `$arguments` | `list``<`[`TypeRef`](/api/docs/ir/type-ref/)`>` |  |

Returns [`TypeRef`](/api/docs/ir/type-ref/)

### intersection()

`public static function intersection(list<TypeRef> $members): TypeRef`

| Parameter | Type | Description |
|---|---|---|
| `$members` | `list``<`[`TypeRef`](/api/docs/ir/type-ref/)`>` |  |

Returns [`TypeRef`](/api/docs/ir/type-ref/)

### literal()

`public static function literal(string $text): TypeRef`

A keyword, scalar or anything else with no class behind it to link to.

| Parameter | Type | Description |
|---|---|---|
| `$text` | `string` |  |

Returns [`TypeRef`](/api/docs/ir/type-ref/)

### named()

`public static function named(string $fqcn): TypeRef`

A class-like type, which may or may not be one the reference documents.

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |

Returns [`TypeRef`](/api/docs/ir/type-ref/)

### nullable()

`public static function nullable(TypeRef $inner): TypeRef`

| Parameter | Type | Description |
|---|---|---|
| `$inner` | [`TypeRef`](/api/docs/ir/type-ref/) |  |

Returns [`TypeRef`](/api/docs/ir/type-ref/)

### referencedClasses()

`public function referencedClasses(): list<string>`

Every named type anywhere in the tree, so a renderer can decide what to link without walking the structure itself.

Returns `list``<``string``>`

### union()

`public static function union(list<TypeRef> $members): TypeRef`

| Parameter | Type | Description |
|---|---|---|
| `$members` | `list``<`[`TypeRef`](/api/docs/ir/type-ref/)`>` |  |

Returns [`TypeRef`](/api/docs/ir/type-ref/)
