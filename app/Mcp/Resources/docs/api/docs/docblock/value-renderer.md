# ValueRenderer

> Renders a default value the way it would be written in source.

Renders a default value the way it would be written in source.

`var_export()` is not usable here. It renders an object default as `\Foo::__set_state(array(...))`, which is not what the parameter says, and it prints floats at `serialize_precision`, so the same code produces different pages on two machines with different ini settings.

## Synopsis

`final class ValueRenderer`

|  |  |
|---|---|
| Source | `Docblock/ValueRenderer.php` |

## Methods

| Method | Description |
|---|---|
| [`forParameter(ReflectionParameter $parameter): ?string`](#forparameter) | The default of a parameter, or null when it has none. |
| [`render(mixed $value): string`](#render) | Renders any value that can appear as a default or a constant. |

### forParameter()

`public function forParameter(ReflectionParameter $parameter): ?string`

The default of a parameter, or null when it has none.

A constant default is shown by name rather than by value, since the name is what the caller would write. `getDefaultValueConstantName()` prefixes a global constant with the declaring file's namespace -- `SEEK_SET` comes back as `Quiote\Http\Sse\SEEK_SET` -- so a prefixed name that does not actually exist is reduced to its last segment.

| Parameter | Type | Description |
|---|---|---|
| `$parameter` | `ReflectionParameter` |  |

Returns `?``string`

### render()

`public function render(mixed $value): string`

Renders any value that can appear as a default or a constant.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `mixed` |  |

Returns `string`
