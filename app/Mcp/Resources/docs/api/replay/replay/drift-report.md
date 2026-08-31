# DriftReport

> The result of ResponseDiffer::diff() for one replay.

The result of [`ResponseDiffer::diff()`](/api/replay/replay/response-differ/#diff) for one replay.

## Synopsis

`final readonly class DriftReport`

|  |  |
|---|---|
| Source | `Replay/DriftReport.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$diagnostics` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(list<Diagnostic> $diagnostics): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$diagnostics` | `list``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`hasErrors(): bool`](#haserrors) |  |
| [`isClean(): bool`](#isclean) |  |

### hasErrors()

`public function hasErrors(): bool`

Returns `bool`

### isClean()

`public function isClean(): bool`

Returns `bool`
