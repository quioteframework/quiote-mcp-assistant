# IndexHints

> The developer-supplied resolution hints from `quiote cassette:fetch`/`quiote replay --save`: a key pasted straight out of a log line, or a date/hour narrowing a prefix scan.

The developer-supplied resolution hints from `quiote cassette:fetch`/`quiote replay --save`: a key pasted straight out of a log line, or a date/hour narrowing a prefix scan.

Every field is optional -- a bare id with no hints at all is exactly the case a `log-analytics` index is for.

## Synopsis

`final readonly class IndexHints`

|  |  |
|---|---|
| Source | `Index/IndexHints.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$date` | `?``string` | _readonly._ |
| `$hour` | `?``string` | _readonly._ |
| `$key` | `?``string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(?string $key = null, ?string $date = null, ?string $hour = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$key` | `?``string` |  |
| `$date` | `?``string` |  |
| `$hour` | `?``string` |  |

Returns `mixed`
