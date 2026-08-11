# Diagnostic

> A single problem or note surfaced while building a ValidatorPlan or emitting from one.

A single problem or note surfaced while building a ValidatorPlan or emitting from one.

Diagnostics let a caller (a future CLI, a test, a warn-mode compile) see every issue in a source, instead of only the first one that happened to abort a throw-mode build.

## Synopsis

`final class Diagnostic`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Support/Compiler/Diagnostic.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `CODE_MISSING_ACTION_CLASS` | `'MISSING_ACTION_CLASS'` |  |
| `CODE_MISSING_TEMPLATE` | `'MISSING_TEMPLATE'` |  |
| `CODE_MISSING_VALIDATOR` | `'MISSING_VALIDATOR'` |  |
| `CODE_MISSING_VIEW` | `'MISSING_VIEW'` |  |
| `CODE_SHADOWED_CONFIG` | `'SHADOWED_CONFIG'` |  |
| `CODE_UNKNOWN_PARAMETER` | `'UNKNOWN_PARAMETER'` |  |
| `CODE_UNMAPPABLE_PARAMETER` | `'UNMAPPABLE_PARAMETER'` |  |
| `CODE_UNRESOLVABLE_CLASS` | `'UNRESOLVABLE_CLASS'` |  |
| `SEVERITY_ERROR` | `'error'` |  |
| `SEVERITY_WARNING` | `'warning'` |  |

## Properties

| Property | Type | Description |
|---|---|---|
| `$code` | `string` | _readonly._ |
| `$column` | `?``int` | _readonly._ |
| `$endColumn` | `?``int` | _readonly._ |
| `$endLine` | `?``int` | _readonly._ |
| `$line` | `?``int` | _readonly._ |
| `$message` | `string` | _readonly._ |
| `$severity` | `string` | _readonly._ |
| `$symbol` | `?``string` | _readonly._ |
| `$where` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $severity, string $code, string $message, string $where, ?int $line = null, ?int $column = null, ?int $endLine = null, ?int $endColumn = null, ?string $symbol = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$severity` | `string` |  |
| `$code` | `string` |  |
| `$message` | `string` |  |
| `$where` | `string` |  |
| `$line` | `?``int` |  |
| `$column` | `?``int` |  |
| `$endLine` | `?``int` |  |
| `$endColumn` | `?``int` |  |
| `$symbol` | `?``string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`toArray(): array{severity: string, code: string, message: string, file: string, line: ?int, column: ?int, endLine: ?int, endColumn: ?int, symbol: ?string}`](#toarray) | JSON-ready shape shared by every console/probe consumer that surfaces this Diagnostic, so each one doesn't hand-roll its own field mapping (and possibly its own field names) from `where` to `file`. |

### toArray()

`public function toArray(): array{severity: string, code: string, message: string, file: string, line: ?int, column: ?int, endLine: ?int, endColumn: ?int, symbol: ?string}`

JSON-ready shape shared by every console/probe consumer that surfaces this Diagnostic, so each one doesn't hand-roll its own field mapping (and possibly its own field names) from `where` to `file`.

Returns `array{severity: string, code: string, message: string, file: string, line: ?int, column: ?int, endLine: ?int, endColumn: ?int, symbol: ?string}`
