# FieldNameResolver

> Turns an element's `name` attribute into the parameter path its value lives under, resolving the empty brackets HTML uses for repeated fields.

Turns an element's `name` attribute into the parameter path its value lives under, resolving the empty brackets HTML uses for repeated fields.

A form can name three inputs `tags[]`, and the browser submits them as a list. Nothing in the markup says which one is index 0, so position in the document decides -- which means resolving a name is stateful across the elements of one form. That state is this object: one instance per form, fed each element in document order.

`foo[][3]` and the like are refused for checkable inputs, where `[]` carries the separate meaning of "this is one of a group sharing a name" and so must appear once, at the end.

## Synopsis

`final class FieldNameResolver`

|  |  |
|---|---|
| Source | `Util/FormPopulation/FieldNameResolver.php` |

## Methods

| Method | Description |
|---|---|
| [`resolve(string $name, bool $isCheckable, bool $isMultipleSelect): ?ResolvedFieldName`](#resolve) | Resolves one element's name, or null when the element should be skipped. |

### resolve()

`public function resolve(string $name, bool $isCheckable, bool $isMultipleSelect): ?ResolvedFieldName`

Resolves one element's name, or null when the element should be skipped.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$isCheckable` | `bool` |  |
| `$isMultipleSelect` | `bool` |  |

Returns `?`[`ResolvedFieldName`](/api/util/form-population/resolved-field-name/)
