# RecordedAt

> Reads a cassette's `recorded_at` as an instant.

Reads a cassette's `recorded_at` as an instant.

One implementation because three call sites need the same rule and had three different ones: `cassette:list` compared the raw strings, `cassette:prune` used `strtotime()`, and `ObjectStoreCassetteStore` used a bare `new DateTimeImmutable()`.

Two things it insists on. Comparison is by instant, not by string: `RecorderMiddleware` formats `recorded_at` in PHP's default timezone rather than forcing UTC, so two cassettes recorded either side of an offset difference sort wrong under a string comparison even though both are valid ISO-8601. And only an *absolute* instant is accepted: `recorded_at` is untrusted cassette content, while both `strtotime()` and `DateTimeImmutable` take `now`, `tomorrow` and `+100 years` as readily as a timestamp -- so a relative expression there made a cassette sort wherever it liked, partition into an hour a backward probe can never reach, and never match a retention cutoff.

## Synopsis

`final class RecordedAt`

|  |  |
|---|---|
| Source | `Cassette/RecordedAt.php` |

## Methods

| Method | Description |
|---|---|
| [`parse(?string $value): ?DateTimeImmutable`](#parse) | The instant $value names, or null when it names none or is not absolute. |
| [`timestamp(?string $value): ?int`](#timestamp) | [`RecordedAt::parse()`](/api/replay/cassette/recorded-at/#parse) as a Unix timestamp, for sorting and cutoff comparisons. |

### parse()

`public static function parse(?string $value): ?DateTimeImmutable`

The instant $value names, or null when it names none or is not absolute.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `?``string` |  |

Returns `?`[`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php)

### timestamp()

`public static function timestamp(?string $value): ?int`

[`RecordedAt::parse()`](/api/replay/cassette/recorded-at/#parse) as a Unix timestamp, for sorting and cutoff comparisons.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `?``string` |  |

Returns `?``int`
