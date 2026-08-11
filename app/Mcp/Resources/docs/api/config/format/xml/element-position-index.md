# ElementPositionIndex

> Maps a merged (post-importNode()) DOMElement to the {file, line} it was cloned from, built incrementally by XmlConfigParser::run() while it merges per-file documents into the final result.

Maps a merged (post-importNode()) DOMElement to the {file, line} it was cloned from, built incrementally by XmlConfigParser::run() while it merges per-file documents into the final result.

Keyed by spl_object_id() of the MERGED element -- the one a handler's toCanonicalArrayWithPositions() actually holds when it looks a position up, not the pre-merge original.

PHP's DOM extension only returns the SAME wrapper object for a given underlying libxml node while at least one PHP reference to that wrapper is still alive; once nothing references it, the wrapper is garbage collected and the next traversal that reaches the same node creates a brand new wrapper (with an unrelated, possibly-recycled spl_object_id()). Recording only the id -- not the object -- would let every recorded element be collected the moment correlatePosition()'s local variables go out of scope, so every later forElement() lookup would silently miss. Keeping a reference here for the index's own lifetime is what makes spl_object_id()-keying actually work as a stable handle.

## Synopsis

`final class ElementPositionIndex`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/Format/Xml/ElementPositionIndex.php` |

## Methods

| Method | Description |
|---|---|
| [`forElement(DOMElement $element): array{file: string, line: int}|null`](#forelement) |  |
| [`record(DOMElement $element, string $file, int $line): void`](#record) | Records the source file and line a merged element was cloned from. |

### forElement()

`public function forElement(DOMElement $element): array{file: string, line: int}|null`

| Parameter | Type | Description |
|---|---|---|
| `$element` | `DOMElement` |  |

Returns `array{file: string, line: int}``|``null`

### record()

`public function record(DOMElement $element, string $file, int $line): void`

Records the source file and line a merged element was cloned from.

The element itself is kept alongside its position, not just its object id: without a live reference the DOM wrapper could be collected and its id recycled, which would make every later [`ElementPositionIndex::forElement()`](/api/config/format/xml/element-position-index/#forelement) lookup miss. Recording the same element twice replaces the earlier entry.

| Parameter | Type | Description |
|---|---|---|
| `$element` | `DOMElement` |  |
| `$file` | `string` |  |
| `$line` | `int` |  |
