# MimeTypeRegistry

> Maps between Quiote format names, MIME types, and file extensions using symfony/mime.

Maps between Quiote format names, MIME types, and file extensions using symfony/mime.

A "format" is the canonical name used throughout the framework (e.g. 'json', 'html', 'xml'). It corresponds to the primary file extension by convention. symfony/mime provides the underlying MIME type database; this class handles: - extension canonicalisation (e.g. 'htm' → 'html', 'jpeg' → 'jpg') - charset determination from MIME type structure - a curated list of formats recognised for content negotiation

## Synopsis

`final class MimeTypeRegistry`

|  |  |
|---|---|
| Source | `Http/MimeTypeRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`allMimeTypes(): array<string>`](#allmimetypes) |  |
| [`formatForExtension(string $extension): ?string`](#formatforextension) | Returns the canonical format name for a file extension, or null if unrecognised. |
| [`formatForMime(string $mime): ?string`](#formatformime) | Returns the primary format name for a MIME type, or null if unrecognised. |
| [`formatsForMime(string $mime): array<string>`](#formatsformime) | Returns an ordered list of format names for a MIME type, most-canonical first. |
| [`negotiableMimeTypes(): array<string>`](#negotiablemimetypes) | The MIME types for `$negotiableFormats`, html-first, memoized. |
| [`primaryMimeType(string $format): ?string`](#primarymimetype) | Returns the primary MIME type for a format name, with '; charset=UTF-8' appended for text-based types, or null if the format is unknown. |

### allMimeTypes()

`public static function allMimeTypes(): array<string>`

Returns `array``<``string``>`

### formatForExtension()

`public static function formatForExtension(string $extension): ?string`

Returns the canonical format name for a file extension, or null if unrecognised.

Example: formatForExtension('htm')  === 'html' formatForExtension('jpeg') === 'jpg'

| Parameter | Type | Description |
|---|---|---|
| `$extension` | `string` |  |

Returns `?``string`

### formatForMime()

`public static function formatForMime(string $mime): ?string`

Returns the primary format name for a MIME type, or null if unrecognised.

Example: formatForMime('application/json') === 'json' formatForMime('image/png')         === 'png'

| Parameter | Type | Description |
|---|---|---|
| `$mime` | `string` |  |

Returns `?``string`

### formatsForMime()

`public static function formatsForMime(string $mime): array<string>`

Returns an ordered list of format names for a MIME type, most-canonical first.

Multiple formats are returned when the MIME type maps to several recognised extensions, letting callers try execute methods in order (e.g. executeJs(), executeMjs()). Example: formatsForMime('application/json')      === ['json'] formatsForMime('application/xhtml+xml') === ['html'] formatsForMime('image/jpeg')             === ['jpg']

| Parameter | Type | Description |
|---|---|---|
| `$mime` | `string` |  |

Returns `array``<``string``>`

### negotiableMimeTypes()

`public static function negotiableMimeTypes(): array<string>`

The MIME types for `$negotiableFormats`, html-first, memoized.

This is the priority list content negotiation should score an Accept header against — a handful of entries instead of ~60, so getBest()'s inner loop does far less work per request.

Returns `array``<``string``>`

### primaryMimeType()

`public static function primaryMimeType(string $format): ?string`

Returns the primary MIME type for a format name, with '; charset=UTF-8' appended for text-based types, or null if the format is unknown.

Example: primaryMimeType('json') === 'application/json; charset=UTF-8' primaryMimeType('png')  === 'image/png'

| Parameter | Type | Description |
|---|---|---|
| `$format` | `string` |  |

Returns `?``string`
