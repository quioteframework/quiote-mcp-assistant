# DoctrineDbalParams

> Shared translation of flat `databases.xml` parameters into a Doctrine DBAL connection-parameters array, used by both DoctrineDatabase and DoctrineDbalDatabase.

Shared translation of flat `databases.xml` parameters into a Doctrine DBAL connection-parameters array, used by both [`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/) and [`DoctrineDbalDatabase`](/api/database/adapter/doctrine/doctrine-dbal-database/).

DBAL 4's DriverManager no longer parses a `url` parameter itself (that moved to `DsnParser`), and no longer accepts an arbitrary connection array -- it expects a closed parameter shape with per-key types. So a `url` is parsed up front, and flat params are validated/typed one key at a time rather than assembled with `array_filter()`.

## Synopsis

`trait DoctrineDbalParams`

|  |  |
|---|---|
| Source | `DoctrineDbalParams.php` |

## Methods

| Method | Description |
|---|---|
| [`dbalParams(): Params`](#dbalparams) |  |
| [`normalizeInlineDbalParams(mixed $raw): Params`](#normalizeinlinedbalparams) | Validates and re-types an inline `connection` array (as opposed to the flat params handled by [`DoctrineDbalParams::dbalParams()`](/api/database/adapter/doctrine/doctrine-dbal-params/#dbalparams)) into DBAL's expected parameter shape. |

### dbalParams()

`protected function dbalParams(): Params`

Returns `Params`

### normalizeInlineDbalParams()

`protected function normalizeInlineDbalParams(mixed $raw): Params`

Validates and re-types an inline `connection` array (as opposed to the flat params handled by [`DoctrineDbalParams::dbalParams()`](/api/database/adapter/doctrine/doctrine-dbal-params/#dbalparams)) into DBAL's expected parameter shape.

`primary`/`replica` (master/replica overrides) are intentionally rejected -- configure those connections separately.

| Parameter | Type | Description |
|---|---|---|
| `$raw` | `mixed` |  |

Returns `Params`
