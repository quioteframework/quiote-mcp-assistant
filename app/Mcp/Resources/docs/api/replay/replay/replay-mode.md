# ReplayMode

> How ReplayEngine runs a cassette.

How [`ReplayEngine`](/api/replay/replay/replay-engine/) runs a cassette.

`Isolated` is the default because it is the safe one, and because it is what the feature is for: a cassette is worth having because it lets a production request be examined somewhere that is not production. `Live` exists for the case isolation cannot serve -- confirming that a fix actually works against real collaborators -- and is gated behind `replay.allow_live` and `--force`.

## Synopsis

`enum ReplayMode: string`

|  |  |
|---|---|
| Source | `Replay/ReplayMode.php` |

## Cases

| Case | Value | Description |
|---|---|---|
| `Isolated` | `'isolated'` | Every ledger-backed subsystem answered from the cassette's own recorded effects, nothing performed. |
| `Live` | `'live'` | Dispatched against whatever the context is really configured with, re-performing the request's side effects for real. |

## Properties

| Property | Type | Description |
|---|---|---|
| `$name` | `string` | _readonly._ |
| `$value` | `string` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`cases(): array`](#cases) |  |
| [`from(string|int $value): static`](#from) |  |
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

### tryFrom()

`public static function tryFrom(string|int $value): ?static`

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string``|``int` |  |

Returns `?``static`
