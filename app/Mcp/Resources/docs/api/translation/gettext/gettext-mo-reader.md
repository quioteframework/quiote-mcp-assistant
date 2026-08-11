# GettextMoReader

> GettextMoReader reads a .mo file into an array.

GettextMoReader reads a .mo file into an array.

## Synopsis

`final class GettextMoReader`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Translation/Gettext/GettextMoReader.php` |

## Methods

| Method | Description |
|---|---|
| [`readFile(string $filePath): array<string, string>`](#readfile) | Parses a .mo file and returns the data as an array. |

### readFile()

`public static function readFile(string $filePath): array<string, string>`

Parses a .mo file and returns the data as an array.

Full path to the .mo file.

| Parameter | Type | Description |
|---|---|---|
| `$filePath` | `string` | Full path to the .mo file. |

Returns `array``<``string``, ``string``>` — The translation data.
