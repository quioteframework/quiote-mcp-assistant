# DbResult

> The one shape an EffectKind::Db effect's `result` takes, so a consumer does not have to guess which recorder wrote the cassette it is reading.

The one shape an [`EffectKind::Db`](/api/replay/cassette/effect-kind/#db) effect's `result` takes, so a consumer does not have to guess which recorder wrote the cassette it is reading.

Before this, each driver package answered the same question differently and every consumer was written against exactly one of them:

- the PDO recorder wrote rows for a read and an integer affected-count for a write; - the Doctrine recorder wrote rows for both, so a write's affected count was lost; - the Eloquent recorder wrote `null` always, because its event fires after the rows have already gone back to the caller and there is nothing left to capture; - the Cycle recorder wrote a row count and never rows, for the same reason; - the Propulsion recorder wrote a keyed array with rows, columns and a truncation flag.

So `StubbedPdoStatement`, written against the PDO shape, replayed an Eloquent cassette as zero rows for every query and raised a `TypeError` on a Cycle one, and a Doctrine-recorded write replayed with an affected count of zero regardless of what happened. This class makes the three distinctions that actually matter explicit and separable:

- `rows === null` means **no rows were captured** -- the recorder cannot see them at this layer. Distinct from `rows === []`, which means the query genuinely returned nothing. - `affectedRows` is the write's own count, kept even when rows are also present. - `rowsTruncated` says a cap stopped the capture short, so a replay reading fewer rows than the original knows it is looking at a prefix rather than at drift.

Serialized as a plain array because a cassette is JSON; [`DbResult::fromResult()`](/api/replay/cassette/db-result/#fromresult) reads back both this shape and every legacy one above, so cassettes recorded before it stay readable.

## Synopsis

`final readonly class DbResult`

|  |  |
|---|---|
| Source | `Cassette/DbResult.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$affectedRows` | `?``int` | _readonly._ |
| `$rows` | `?``array` | _readonly._ |
| `$rowsTruncated` | `bool` | _readonly._ |

## Constructor

### __construct()

`public function __construct(list<array<array-key, mixed>>|null $rows, int|null $affectedRows = null, bool $rowsTruncated = false): mixed`

Whether a row cap stopped the capture short.

| Parameter | Type | Description |
|---|---|---|
| `$rows` | `list``<``array``<``array-key``, ``mixed``>``>``|``null` | Captured rows, or null when the recorder cannot see them. |
| `$affectedRows` | `int``|``null` | The statement's own affected-row count, when it reported one. |
| `$rowsTruncated` | `bool` | Whether a row cap stopped the capture short. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`affected(int $count): DbResult`](#affected) | A write, or any statement with no result set. |
| [`fromResult(mixed $result): ?DbResult`](#fromresult) | Reads a recorded `result` back, accepting this shape and every shape the driver packages produced before it. |
| [`rows(array<array-key, array<array-key, mixed>> $rows, bool $truncated = false): DbResult`](#rows) | A read that captured its rows. |
| [`toArray(): array<string, mixed>`](#toarray) |  |
| [`unobservedRows(?int $affectedRows = null): DbResult`](#unobservedrows) | A statement whose rows this recorder's seam cannot reach -- the Eloquent and Cycle shape. |

### affected()

`public static function affected(int $count): DbResult`

A write, or any statement with no result set.

| Parameter | Type | Description |
|---|---|---|
| `$count` | `int` |  |

Returns [`DbResult`](/api/replay/cassette/db-result/)

### fromResult()

`public static function fromResult(mixed $result): ?DbResult`

Reads a recorded `result` back, accepting this shape and every shape the driver packages produced before it.

Returns null only when the value is nothing this class can describe at all, which a caller should report as a malformed cassette rather than paper over.

| Parameter | Type | Description |
|---|---|---|
| `$result` | `mixed` |  |

Returns `?`[`DbResult`](/api/replay/cassette/db-result/)

### rows()

`public static function rows(array<array-key, array<array-key, mixed>> $rows, bool $truncated = false): DbResult`

A read that captured its rows.

| Parameter | Type | Description |
|---|---|---|
| `$rows` | `array``<``array-key``, ``array``<``array-key``, ``mixed``>``>` |  |
| `$truncated` | `bool` |  |

Returns [`DbResult`](/api/replay/cassette/db-result/)

### toArray()

`public function toArray(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### unobservedRows()

`public static function unobservedRows(?int $affectedRows = null): DbResult`

A statement whose rows this recorder's seam cannot reach -- the Eloquent and Cycle shape.

`$affectedRows` is still recorded when the seam reports one.

| Parameter | Type | Description |
|---|---|---|
| `$affectedRows` | `?``int` |  |

Returns [`DbResult`](/api/replay/cassette/db-result/)
