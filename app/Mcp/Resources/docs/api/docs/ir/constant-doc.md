# ConstantDoc

> One public class constant.

One public class constant.

Constants are documented because they turn up as parameter defaults; omitting them would leave those defaults pointing at nothing.

## Synopsis

`final class ConstantDoc`

|  |  |
|---|---|
| Source | `Ir/ConstantDoc.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$doc` | [`DocBlock`](/api/docs/ir/doc-block/) | _readonly._ |
| `$final` | `bool` | _readonly._ |
| `$name` | `string` | _readonly._ |
| `$value` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $name, string $value, DocBlock $doc, bool $final = false): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `string` |  |
| `$doc` | [`DocBlock`](/api/docs/ir/doc-block/) |  |
| `$final` | `bool` |  |

Returns `mixed`
