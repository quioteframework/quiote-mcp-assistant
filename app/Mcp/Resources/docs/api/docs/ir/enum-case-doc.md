# EnumCaseDoc

> One case of an enum, with its backing value when it has one.

One case of an enum, with its backing value when it has one.

## Synopsis

`final class EnumCaseDoc`

|  |  |
|---|---|
| Source | `Ir/EnumCaseDoc.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$backingValue` | `?``string` | _readonly._ |
| `$doc` | [`DocBlock`](/api/docs/ir/doc-block/) | _readonly._ |
| `$name` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $name, ?string $backingValue, DocBlock $doc): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$backingValue` | `?``string` |  |
| `$doc` | [`DocBlock`](/api/docs/ir/doc-block/) |  |

Returns `mixed`
