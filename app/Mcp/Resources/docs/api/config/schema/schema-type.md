# SchemaType

> The kinds of shape a Rule can describe.

The kinds of shape a Rule can describe.

Struct and Dict are both "map" at the PHP level but mean different things: Struct has a fixed, known key set (a config entry like {class, params}); Dict has dynamic string keys sharing one value shape (e.g. a connection-name-keyed map of database entries). Union is for the genuinely alternative-shaped value -- a bool that a `%env(...)%` placeholder may stand in for until load time -- as opposed to Mixed, which describes a region that is not checked at all.

## Synopsis

`enum SchemaType`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/Schema/SchemaType.php` |

## Cases

| Case | Description |
|---|---|
| `Struct` |  |
| `Dict` |  |
| `ListOf` |  |
| `String` |  |
| `Bool` |  |
| `Int` |  |
| `PhpClass` |  |
| `Enum` |  |
| `Union` |  |
| `Mixed` |  |

## Properties

| Property | Type | Description |
|---|---|---|
| `$name` | `string` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`cases(): array`](#cases) |  |

### cases()

`public static function cases(): array`

Returns `array`
