# SessionCodec

> The shipped session codec: igbinary when it is available and wanted, JSON otherwise, and reads both regardless of which it writes.

The shipped session codec: igbinary when it is available and wanted, JSON otherwise, and reads both regardless of which it writes.

One class rather than one per format, because the two share the thing that must not vary: how a stored payload is recognised on the way back in. A payload beginning with `{` or `[` is JSON -- igbinary's format never does, it begins with a null byte -- and anything else is offered to igbinary. That single rule is why a payload written by one backend stays readable by another, and why switching `prefer_binary` on an existing store does not orphan what is already in it.

Which format to *write* is a per-backend decision, so it is a constructor argument rather than a subclass: a local file or a database column benefits from igbinary's smaller, faster payload, while for an object store the network round-trip dominates and JSON keeps the stored object readable by anything else looking at the bucket.

## Synopsis

`final class SessionCodec implements SessionCodecInterface`

|  |  |
|---|---|
| Implements | [`SessionCodecInterface`](/api/session/session-codec-interface/) |
| Since | `3.2.0` |
| Source | `Session/SessionCodec.php` |

## Constructor

### __construct()

`public function __construct(bool $preferBinary = true): mixed`

Write igbinary when the extension is loaded. False writes
            JSON always. Decoding accepts both either way.

| Parameter | Type | Description |
|---|---|---|
| `$preferBinary` | `bool` | Write igbinary when the extension is loaded. False writes JSON always. Decoding accepts both either way. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`binaryPreferred(): SessionCodec`](#binarypreferred) | A codec for a store where payload size and encode/decode cost matter -- a local file, a database column. |
| [`decode(string $payload): ?array`](#decode) | Decodes either format, whichever this instance writes. |
| [`encode(array $data): string`](#encode) | Encodes with igbinary when `prefer_binary` is on and the extension is loaded, otherwise with JSON. |
| [`portable(): SessionCodec`](#portable) | A codec for a store where the transport dominates and a human-readable payload is worth more than a compact one -- an object store, a document database. |

### binaryPreferred()

`public static function binaryPreferred(): SessionCodec`

A codec for a store where payload size and encode/decode cost matter -- a local file, a database column.

Returns [`SessionCodec`](/api/session/session-codec/)

### decode()

`public function decode(string $payload): ?array`

Decodes either format, whichever this instance writes.

A payload starting with `{` or `[` is decoded as JSON, anything else as igbinary. Returns null for an empty payload, for input that fails to decode, for a decoded value that is not a string-keyed array, and for a binary payload on a build without ext-igbinary — the last of these is logged at warning, since nothing on that build can ever read it; the others at debug. Unreadable input is a reason to start a new session, not to fail the request.

| Parameter | Type | Description |
|---|---|---|
| `$payload` | `string` |  |

Returns `?``array`

### encode()

`public function encode(array $data): string`

Encodes with igbinary when `prefer_binary` is on and the extension is loaded, otherwise with JSON.

An igbinary failure is logged at debug and falls through to JSON, which every build can write. Only when JSON also fails — the session holds something with no serializable form, a closure or a resource — does this throw, since storing nothing would silently lose the session.

| Parameter | Type | Description |
|---|---|---|
| `$data` | `array` |  |

Returns `string`

| Throws | When |
|---|---|
| `StorageException` | if neither format can represent the data. |

### portable()

`public static function portable(): SessionCodec`

A codec for a store where the transport dominates and a human-readable payload is worth more than a compact one -- an object store, a document database.

Returns [`SessionCodec`](/api/session/session-codec/)
