# DocumentEncoding

> The character encoding a document is being populated in, and the conversions between it and UTF-8.

The character encoding a document is being populated in, and the conversions between it and UTF-8.

DOM works in UTF-8 internally, but a field name read out of the document and a value written back into it both have to be in the document's own encoding -- otherwise a name like "stra&szlig;e" never matches the submitted parameter, and a populated value arrives mojibaked. Both directions are needed, which is why this is one object rather than two helpers.

ISO-8859-1 is converted with mbstring, which every build has; anything else needs iconv, so an encoding that would silently fail is refused up front instead.

## Synopsis

`final readonly class DocumentEncoding`

|  |  |
|---|---|
| Source | `Util/FormPopulation/DocumentEncoding.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `ISO_8859_1` | `'iso-8859-1'` |  |
| `UTF_8` | `'utf-8'` |  |

## Properties

| Property | Type | Description |
|---|---|---|
| `$isUtf8` | `bool` | _readonly._ |
| `$name` | `string` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`fromUtf8(mixed $value): mixed`](#fromutf8) | Converts a value from UTF-8 to this encoding, recursing into arrays. |
| [`named(string $encoding): DocumentEncoding`](#named) |  |
| [`toUtf8(mixed $value): mixed`](#toutf8) | Converts a value from this encoding to UTF-8, recursing into arrays. |
| [`utf8(): DocumentEncoding`](#utf8) |  |

### fromUtf8()

`public function fromUtf8(mixed $value): mixed`

Converts a value from UTF-8 to this encoding, recursing into arrays.

Used on the way *out*: a value about to be written into the document has to be in the document's own encoding.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `mixed` |  |

Returns `mixed`

### named()

`public static function named(string $encoding): DocumentEncoding`

| Parameter | Type | Description |
|---|---|---|
| `$encoding` | `string` |  |

Returns [`DocumentEncoding`](/api/util/form-population/document-encoding/)

| Throws | When |
|---|---|
| `QuioteException` | if the encoding needs iconv and iconv is absent. |

### toUtf8()

`public function toUtf8(mixed $value): mixed`

Converts a value from this encoding to UTF-8, recursing into arrays.

Used on the way *in*: a field name lifted out of the document is in the document's encoding and has to be UTF-8 to match a submitted parameter.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `mixed` |  |

Returns `mixed`

### utf8()

`public static function utf8(): DocumentEncoding`

Returns [`DocumentEncoding`](/api/util/form-population/document-encoding/)
