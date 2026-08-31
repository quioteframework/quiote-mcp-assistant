# CassetteProjector

> Turns a decoded Cassette into the flat, section-keyed shape both `cassette:show` and any other reader (an MCP capability, a future web view) present: request/response bodies excerpted to length + sha256 by default, and an effect's captured rows excerpted to a count, so a 2 MiB cassette or a query returning thousands of rows doesn't become that much output by accident.

Turns a decoded [`Cassette`](/api/replay/cassette/cassette/) into the flat, section-keyed shape both `cassette:show` and any other reader (an MCP capability, a future web view) present: request/response bodies excerpted to length + sha256 by default, and an effect's captured rows excerpted to a count, so a 2 MiB cassette or a query returning thousands of rows doesn't become that much output by accident.

`$includeBodies` is the one switch that turns both excerpts back into their full content.

## Synopsis

`final class CassetteProjector`

|  |  |
|---|---|
| Source | `Cassette/CassetteProjector.php` |

## Methods

| Method | Description |
|---|---|
| [`project(Cassette $cassette, bool $includeBodies): array<string, mixed>`](#project) |  |

### project()

`public static function project(Cassette $cassette, bool $includeBodies): array<string, mixed>`

| Parameter | Type | Description |
|---|---|---|
| `$cassette` | [`Cassette`](/api/replay/cassette/cassette/) |  |
| `$includeBodies` | `bool` |  |

Returns `array``<``string``, ``mixed``>`
