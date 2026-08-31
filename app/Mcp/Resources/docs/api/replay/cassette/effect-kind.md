# EffectKind

> The kind of side effect one Effect ledger entry records.

The kind of side effect one [`Effect`](/api/replay/cassette/effect/) ledger entry records.

Each value is the seam a recording decorator observes and a stub answers from during isolated replay.

`Mail` has no recorder yet -- Quiote has no mail subsystem to instrument -- but the case is reserved now so a future one needs no cassette format change.

## Synopsis

`enum EffectKind: string`

|  |  |
|---|---|
| Source | `Cassette/EffectKind.php` |

## Cases

| Case | Value | Description |
|---|---|---|
| `Db` | `'db'` |  |
| `Http` | `'http'` |  |
| `Cache` | `'cache'` |  |
| `Queue` | `'queue'` |  |
| `Mail` | `'mail'` |  |
| `Clock` | `'clock'` |  |
| `Entropy` | `'entropy'` |  |
| `Env` | `'env'` |  |
| `Session` | `'session'` |  |

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
