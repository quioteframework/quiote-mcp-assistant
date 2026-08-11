# SkipList

> The fields configured to be left exactly as the view rendered them.

The fields configured to be left exactly as the view rendered them.

Matching is on the front of the resolved parameter path, so naming `user` skips `user[name]` too. A configured `foo[]` matches any subscript, which is how a whole repeated field is skipped without naming every index.

## Synopsis

`final readonly class SkipList`

|  |  |
|---|---|
| Source | `Util/FormPopulation/SkipList.php` |

## Methods

| Method | Description |
|---|---|
| [`fromConfig(mixed $skip): SkipList`](#fromconfig) | Builds the list from the `skip` configuration value, which config may hand over as an array, a ParameterHolder, or nothing at all. |
| [`isEmpty(): bool`](#isempty) | Whether anything is configured at all, so callers can skip the check entirely. |
| [`skips(string $parameterPath): bool`](#skips) |  |

### fromConfig()

`public static function fromConfig(mixed $skip): SkipList`

Builds the list from the `skip` configuration value, which config may hand over as an array, a ParameterHolder, or nothing at all.

| Parameter | Type | Description |
|---|---|---|
| `$skip` | `mixed` |  |

Returns [`SkipList`](/api/util/form-population/skip-list/)

### isEmpty()

`public function isEmpty(): bool`

Whether anything is configured at all, so callers can skip the check entirely.

Returns `bool`

### skips()

`public function skips(string $parameterPath): bool`

| Parameter | Type | Description |
|---|---|---|
| `$parameterPath` | `string` |  |

Returns `bool`
