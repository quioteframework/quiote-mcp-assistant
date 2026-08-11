# Level

> Ordinal log level with minimum-level (>=) semantics.

Ordinal log level with minimum-level (>=) semantics.

Aligned to PSR-3 / RFC 5424 so a PSR-3 level string maps directly, with an extra [`Level::Trace`](/api/logging/level/#trace) below Debug (Serilog "Verbose") that degrades to "debug" on PSR-3 output. Higher value = more severe. A message passes a threshold when `$message->value >= $threshold->value`.

## Synopsis

`enum Level: int`

|  |  |
|---|---|
| Source | `Logging/Level.php` |

## Cases

| Case | Value | Description |
|---|---|---|
| `Trace` | `50` |  |
| `Debug` | `100` |  |
| `Info` | `200` |  |
| `Notice` | `250` |  |
| `Warning` | `300` |  |
| `Error` | `400` |  |
| `Critical` | `500` |  |
| `Alert` | `550` |  |
| `Emergency` | `600` |  |

## Properties

| Property | Type | Description |
|---|---|---|
| `$name` | `string` | _readonly._ |
| `$value` | `int` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`cases(): array`](#cases) |  |
| [`from(string|int $value): static`](#from) |  |
| [`fromName(string $name): Level`](#fromname) | Parse a case-insensitive level name for configuration (e.g. |
| [`fromPsr(string $psrLevel): Level`](#frompsr) | Map a PSR-3 `LogLevel` string to a Level. |
| [`label(): string`](#label) | Lowercase canonical name used in structured output (e.g. |
| [`passes(Level $threshold): bool`](#passes) | Whether a message at $this level passes the given minimum threshold. |
| [`toPsr(): string`](#topsr) | The PSR-3 level string for this level. |
| [`tryFrom(string|int $value): ?static`](#tryfrom) |  |

### cases()

`public static function cases(): array`

Returns `array`

### from()

`public static function from(string|int $value): static`

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string``|``int` |  |

Returns `static`

### fromName()

`public static function fromName(string $name): Level`

Parse a case-insensitive level name for configuration (e.g.

LOG_LEVEL=info). Accepts "warn" as an alias for "warning".

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns [`Level`](/api/logging/level/)

| Throws | When |
|---|---|
| `InvalidArgumentException` | on an unknown name. |

### fromPsr()

`public static function fromPsr(string $psrLevel): Level`

Map a PSR-3 `LogLevel` string to a Level.

| Parameter | Type | Description |
|---|---|---|
| `$psrLevel` | `string` |  |

Returns [`Level`](/api/logging/level/)

| Throws | When |
|---|---|
| `InvalidArgumentException` | on an unknown level (PSR-3 requirement). |

### label()

`public function label(): string`

Lowercase canonical name used in structured output (e.g.

"trace", "warning").

Returns `string`

### passes()

`public function passes(Level $threshold): bool`

Whether a message at $this level passes the given minimum threshold.

| Parameter | Type | Description |
|---|---|---|
| `$threshold` | [`Level`](/api/logging/level/) |  |

Returns `bool`

### toPsr()

`public function toPsr(): string`

The PSR-3 level string for this level.

Trace has no PSR-3 equivalent and degrades to "debug".

Returns `string`

### tryFrom()

`public static function tryFrom(string|int $value): ?static`

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string``|``int` |  |

Returns `?``static`
