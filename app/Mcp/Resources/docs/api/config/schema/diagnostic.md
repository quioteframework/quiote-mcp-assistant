# Diagnostic

> One structural-shape violation found by SchemaValidator.

One structural-shape violation found by SchemaValidator.

$keyPath is dot-joined (e.g. "databases.default_db.class") so callers -- including a future probe capability -- can report it against the canonical array without any further formatting.

## Synopsis

`final readonly class Diagnostic`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/Schema/Diagnostic.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$code` | `string` | _readonly._ |
| `$keyPath` | `string` | _readonly._ |
| `$message` | `string` | _readonly._ |
| `$severity` | [`Severity`](/api/config/schema/severity/) | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`error(string $code, string $message, string $keyPath): Diagnostic`](#error) | Builds a Diagnostic with Error severity, for a shape violation that makes the canonical array invalid. |
| [`warning(string $code, string $message, string $keyPath): Diagnostic`](#warning) | Builds a Diagnostic with Warning severity, for a finding a caller may report but that does not on its own make the canonical array invalid. |

### error()

`public static function error(string $code, string $message, string $keyPath): Diagnostic`

Builds a Diagnostic with Error severity, for a shape violation that makes the canonical array invalid.

$code is a stable machine-readable identifier (SchemaValidator uses codes such as "schema.wrong_type" or "schema.missing_required_key"), $message the human-readable explanation, and $keyPath the dot-joined location the violation was found at ('' for the document root).

| Parameter | Type | Description |
|---|---|---|
| `$code` | `string` |  |
| `$message` | `string` |  |
| `$keyPath` | `string` |  |

Returns [`Diagnostic`](/api/config/schema/diagnostic/)

### warning()

`public static function warning(string $code, string $message, string $keyPath): Diagnostic`

Builds a Diagnostic with Warning severity, for a finding a caller may report but that does not on its own make the canonical array invalid.

Takes the same machine-readable $code, human-readable $message and dot-joined $keyPath as [`Diagnostic::error()`](/api/config/schema/diagnostic/#error); only the severity differs, so a caller can partition one diagnostic list into fatal and advisory.

| Parameter | Type | Description |
|---|---|---|
| `$code` | `string` |  |
| `$message` | `string` |  |
| `$keyPath` | `string` |  |

Returns [`Diagnostic`](/api/config/schema/diagnostic/)
