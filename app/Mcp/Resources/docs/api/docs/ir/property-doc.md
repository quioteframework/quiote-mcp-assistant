# PropertyDoc

> One property, including a constructor-promoted one.

One property, including a constructor-promoted one.

## Synopsis

`final class PropertyDoc`

|  |  |
|---|---|
| Source | `Ir/PropertyDoc.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$default` | `?``string` | _readonly._ |
| `$doc` | [`DocBlock`](/api/docs/ir/doc-block/) | _readonly._ |
| `$name` | `string` | _readonly._ |
| `$promoted` | `bool` | _readonly._ |
| `$readonly` | `bool` | _readonly._ |
| `$static` | `bool` | _readonly._ |
| `$type` | [`TypeRef`](/api/docs/ir/type-ref/) | _readonly._ |
| `$visibility` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $name, TypeRef $type, DocBlock $doc, 'public'|'protected' $visibility = 'public', bool $static = false, bool $readonly = false, bool $promoted = false, ?string $default = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$type` | [`TypeRef`](/api/docs/ir/type-ref/) |  |
| `$doc` | [`DocBlock`](/api/docs/ir/doc-block/) |  |
| `$visibility` | `'public'``|``'protected'` |  |
| `$static` | `bool` |  |
| `$readonly` | `bool` |  |
| `$promoted` | `bool` |  |
| `$default` | `?``string` |  |

Returns `mixed`
