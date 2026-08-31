# CassetteKeyScheme

> Derives an object-store key from a cassette id and the hour it was recorded in:

Derives an object-store key from a cassette id and the hour it was recorded in:

{prefix}/{env}/{yyyy}/{mm}/{dd}/{hh}/{id}.qcast

Time-partitioned so a lifecycle rule and a "what happened this hour" prefix listing are both trivial, and so a flat container holding a year of cassettes never has to be enumerated whole. Always partitions by the cassette's own recorded hour, forced to UTC -- never the current time and never the server's local timezone -- so a cassette fetched a day later resolves to the same key regardless of which timezone the fetching process happens to run in, and two servers in different timezones never partition the same instant into different hour buckets.

Uses [`CassetteId::$slug`](/api/replay/cassette/cassette-id/#slug), never `$id->raw`, for the final path segment: an adopted correlation id can carry `/`, `.` or `..` straight through `Quiote\Support\CorrelationId::sanitize()` (verified against that class, not assumed), and `$slug` is what already reduces that to a safe, bounded identifier -- see `CassetteId`'s own docblock.

## Synopsis

`final readonly class CassetteKeyScheme`

|  |  |
|---|---|
| Source | `CassetteKeyScheme.php` |

## Constructor

### __construct()

`public function __construct(string $prefix, string $env): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$prefix` | `string` |  |
| `$env` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`dayPrefix(DateTimeImmutable $dt): string`](#dayprefix) | The key prefix for every cassette recorded during $dt's UTC calendar day -- one level up from [`CassetteKeyScheme::hourPrefix()`](/api/replay/store/storage/cassette-key-scheme/#hourprefix), for a delimited `listObjects()` call that enumerates that day's hour buckets as common prefixes rather than every object in it. |
| [`hourPrefix(DateTimeImmutable $dt): string`](#hourprefix) | The key prefix for every cassette recorded during $dt's hour, for a bounded backward probe or a listing. |
| [`keyFor(CassetteId $id, ?DateTimeImmutable $recordedAt, DateTimeImmutable $fallback): string`](#keyfor) | The key a cassette recorded at $recordedAt (or, absent that, $fallback) is written under. |

### dayPrefix()

`public function dayPrefix(DateTimeImmutable $dt): string`

The key prefix for every cassette recorded during $dt's UTC calendar day -- one level up from [`CassetteKeyScheme::hourPrefix()`](/api/replay/store/storage/cassette-key-scheme/#hourprefix), for a delimited `listObjects()` call that enumerates that day's hour buckets as common prefixes rather than every object in it.

| Parameter | Type | Description |
|---|---|---|
| `$dt` | [`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php) |  |

Returns `string`

### hourPrefix()

`public function hourPrefix(DateTimeImmutable $dt): string`

The key prefix for every cassette recorded during $dt's hour, for a bounded backward probe or a listing.

| Parameter | Type | Description |
|---|---|---|
| `$dt` | [`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php) |  |

Returns `string`

### keyFor()

`public function keyFor(CassetteId $id, ?DateTimeImmutable $recordedAt, DateTimeImmutable $fallback): string`

The key a cassette recorded at $recordedAt (or, absent that, $fallback) is written under.

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |
| `$recordedAt` | `?`[`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php) |  |
| `$fallback` | [`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php) |  |

Returns `string`
