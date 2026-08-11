# Inject

> Parameter-level override: resolve this parameter from the container by an explicit id instead of autowiring by type.

Parameter-level override: resolve this parameter from the container by an explicit id instead of autowiring by type.

Use to pick among multiple implementations of an interface, or to name a service registered under a role/alias rather than a class.

## Synopsis

`final class Inject`

|  |  |
|---|---|
| Source | `DI/Attribute/Inject.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$id` | `string` |  |

## Constructor

### __construct()

`public function __construct(string $id): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |

Returns `mixed`
