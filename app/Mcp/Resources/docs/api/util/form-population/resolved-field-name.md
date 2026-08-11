# ResolvedFieldName

> A form element's name, resolved to the parameter path its value lives under.

A form element's name, resolved to the parameter path its value lives under.

`$groupsByValue` marks a checkable input whose name ended in `[]`: the submitted parameter is then a list of the *values* that were checked, so whether this element is checked is decided by looking for its own value in that list rather than by comparing the parameter to it.

## Synopsis

`final readonly class ResolvedFieldName`

|  |  |
|---|---|
| Source | `Util/FormPopulation/ResolvedFieldName.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$groupsByValue` | `bool` | _readonly._ |
| `$path` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $path, bool $groupsByValue): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$groupsByValue` | `bool` |  |

Returns `mixed`
