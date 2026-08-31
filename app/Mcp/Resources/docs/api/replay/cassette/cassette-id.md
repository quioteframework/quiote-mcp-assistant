# CassetteId

> A cassette's id, and the safe filesystem/object-store key derived from it.

A cassette's id, and the safe filesystem/object-store key derived from it.

A cassette id is untrusted input -- [`CorrelationId::sanitize()`](/api/support/correlation-id/#sanitize) strips control bytes and caps length, but passes `/`, `.` and `..` straight through, verified against its source. A caller who controls the correlation header therefore controls where a cassette is written unless the id is reduced to a safe slug before it ever reaches a store key or a filename. `$raw` is kept as data (it still has value for a human reading `meta`), `$slug` is what a store ever uses as a key.

## Synopsis

`final readonly class CassetteId`

|  |  |
|---|---|
| Source | `Cassette/CassetteId.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$raw` | `string` | _readonly._ |
| `$slug` | `string` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`fromCorrelationId(?string $raw): CassetteId`](#fromcorrelationid) | Builds a CassetteId from a request's correlation id, falling back to a freshly generated one when absent -- so every cassette gets an id regardless of whether the request carried a correlation header. |
| [`fromRaw(string $raw): CassetteId`](#fromraw) | Builds a CassetteId from an already-known raw value -- e.g. |

### fromCorrelationId()

`public static function fromCorrelationId(?string $raw): CassetteId`

Builds a CassetteId from a request's correlation id, falling back to a freshly generated one when absent -- so every cassette gets an id regardless of whether the request carried a correlation header.

| Parameter | Type | Description |
|---|---|---|
| `$raw` | `?``string` |  |

Returns [`CassetteId`](/api/replay/cassette/cassette-id/)

### fromRaw()

`public static function fromRaw(string $raw): CassetteId`

Builds a CassetteId from an already-known raw value -- e.g.

an id typed on the command line by a developer pasting it out of a log line.

| Parameter | Type | Description |
|---|---|---|
| `$raw` | `string` |  |

Returns [`CassetteId`](/api/replay/cassette/cassette-id/)
