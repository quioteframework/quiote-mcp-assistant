# ParamDoc

> One parameter of a method, with the type actually rendered and its prose.

One parameter of a method, with the type actually rendered and its prose.

## Synopsis

`final class ParamDoc`

|  |  |
|---|---|
| Source | `Ir/ParamDoc.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$byReference` | `bool` | _readonly._ |
| `$default` | `?``string` | _readonly._ |
| `$description` | `string` | _readonly._ |
| `$name` | `string` | _readonly._ |
| `$promoted` | `bool` | _readonly._ |
| `$type` | [`TypeRef`](/api/docs/ir/type-ref/) | _readonly._ |
| `$variadic` | `bool` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $name, TypeRef $type, bool $byReference = false, bool $variadic = false, bool $promoted = false, ?string $default = null, string $description = ''): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$type` | [`TypeRef`](/api/docs/ir/type-ref/) |  |
| `$byReference` | `bool` |  |
| `$variadic` | `bool` |  |
| `$promoted` | `bool` |  |
| `$default` | `?``string` |  |
| `$description` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`signature(): string`](#signature) | The parameter as it appears in a signature, defaults and all. |

### signature()

`public function signature(): string`

The parameter as it appears in a signature, defaults and all.

Returns `string`
