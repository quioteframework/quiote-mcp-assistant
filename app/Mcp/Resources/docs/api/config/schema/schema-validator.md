# SchemaValidator

> Validates a canonical config array against a declarative Rule shape.

Validates a canonical config array against a declarative Rule shape.

Pure and stateless -- no I/O, no coupling to Config/ConfigCache -- so a future validate_config probe capability can call it directly against an already-loaded canonical array without threading through the config cache pipeline again.

## Synopsis

`final class SchemaValidator`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/Schema/SchemaValidator.php` |

## Methods

| Method | Description |
|---|---|
| [`validate(Rule $schema, mixed $value, string $path = ''): list<Diagnostic>`](#validate) |  |

### validate()

`public static function validate(Rule $schema, mixed $value, string $path = ''): list<Diagnostic>`

| Parameter | Type | Description |
|---|---|---|
| `$schema` | [`Rule`](/api/config/schema/rule/) |  |
| `$value` | `mixed` |  |
| `$path` | `string` |  |

Returns `list``<`[`Diagnostic`](/api/config/schema/diagnostic/)`>`
