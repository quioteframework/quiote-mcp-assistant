# MiddlewarePhase

> Canonical ordering of the `phase` values accepted by `Quiote\\Middleware\\Attribute\\Middleware`.

Canonical ordering of the `phase` values accepted by `Quiote\Middleware\Attribute\Middleware`.

Phase is the primary sort key for MiddlewareOrderResolver — it groups middleware into the same coarse bands the framework's hard-coded pipeline has always used, with `before`/`after` edges and `priority` refining order within/across those bands.

## Synopsis

`final class MiddlewarePhase`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Middleware/Compiler/MiddlewarePhase.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `ORDER` | `['bootstrap', 'pre_routing', 'pre', …]` |  |

## Methods

| Method | Description |
|---|---|
| [`rank(string $phase): int`](#rank) |  |

### rank()

`public static function rank(string $phase): int`

| Parameter | Type | Description |
|---|---|---|
| `$phase` | `string` |  |

Returns `int`

| Throws | When |
|---|---|
| `InvalidArgumentException` | if $phase isn't one of self::ORDER |
