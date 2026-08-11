# InheritedMember

> A member a class gets from an ancestor, listed rather than documented.

A member a class gets from an ancestor, listed rather than documented.

Inherited members outnumber declared ones several times over in this framework, so repeating their documentation on every descendant would bury what each class actually adds. A row pointing at the declaring type says the same thing in one line.

## Synopsis

`final class InheritedMember`

|  |  |
|---|---|
| Source | `Ir/InheritedMember.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$declaredIn` | `string` | _readonly._ |
| `$name` | `string` | _readonly._ |
| `$summary` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $name, string $declaredIn, string $summary = ''): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$declaredIn` | `string` |  |
| `$summary` | `string` |  |

Returns `mixed`
