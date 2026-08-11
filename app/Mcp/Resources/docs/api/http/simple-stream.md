# SimpleStream

> A minimal PSR-7 `StreamInterface` over a plain PHP stream resource, so the framework can produce response bodies without depending on a third-party PSR-7 implementation.

A minimal PSR-7 `StreamInterface` over a plain PHP stream resource, so the framework can produce response bodies without depending on a third-party PSR-7 implementation.

Used for the bodies built by [`PsrResponseBuilder`](/api/response/psr-response-builder/) and [`PsrResponseAdapter`](/api/http/psr-response-adapter/); [`SimpleStream::fromString()`](/api/http/simple-stream/#fromstring) is the common entry point and wraps content in a rewound `php://temp` handle.

Deliberately thin: [`SimpleStream::getSize()`](/api/http/simple-stream/#getsize) always answers null rather than stat'ing the handle, and [`SimpleStream::__toString()`](/api/http/simple-stream/#tostring) rewinds first and returns an empty string on any failure, since PHP forbids throwing from string conversion. Every other operation on a detached stream throws `RuntimeException`. Constructing with a non-resource does not fail — a fresh `php://temp` handle is substituted.

## Synopsis

`class SimpleStream implements StreamInterface`

|  |  |
|---|---|
| Implements | [`StreamInterface`](https://www.php-fig.org/psr/psr-7/) |
| Source | `Http/SimpleStream.php` |

## Constructor

### __construct()

`public function __construct(resource $resource): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$resource` | `resource` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`__toString(): string`](#tostring) | Reads all data from the stream into a string, from the beginning to end. |
| [`close(): void`](#close) | Closes the underlying handle when one is still open; a detached or already closed stream is a no-op. |
| [`detach(): resource|null`](#detach) | Releases the underlying handle to the caller and leaves this stream detached. |
| [`eof(): bool`](#eof) | Reports whether the handle has reached end-of-file. |
| [`fromString(string $content): SimpleStream`](#fromstring) | Wraps $content in a new read/write `php://temp` handle, rewound to the start so the content can be read back immediately. |
| [`getContents(): string`](#getcontents) | Reads everything remaining from the current position onwards, without rewinding first. |
| [`getMetadata(mixed $key = null): mixed`](#getmetadata) | Returns the handle's stream metadata, or a single entry from it. |
| [`getSize(): ?int`](#getsize) | Always returns null: the size of the wrapped handle is never determined. |
| [`isReadable(): bool`](#isreadable) | Reports readability by inspecting the handle's open mode for a reading flag. |
| [`isSeekable(): bool`](#isseekable) | Reports the handle's seekability as declared by its stream metadata. |
| [`isWritable(): bool`](#iswritable) | Reports writability by inspecting the handle's open mode for a writing flag. |
| [`read(mixed $length): string`](#read) | Reads up to `$length` bytes from the current position; a non-positive length yields an empty string. |
| [`rewind(): void`](#rewind) | Seeks back to the start of the stream. |
| [`seek(mixed $offset, mixed $whence = SEEK_SET): void`](#seek) | Moves the handle position. |
| [`tell(): int`](#tell) | Returns the current handle position. |
| [`write(mixed $string): int`](#write) | Writes to the handle at its current position and returns the byte count written. |

### __toString()

`public function __toString(): string`

Reads all data from the stream into a string, from the beginning to end.

This method MUST attempt to seek to the beginning of the stream before reading data and read the stream until the end is reached.

Warning: This could attempt to load a large amount of data into memory.

This method MUST NOT raise an exception in order to conform with PHP's string casting operations.

Returns `string`

### close()

`public function close(): void`

Closes the underlying handle when one is still open; a detached or already closed stream is a no-op.

### detach()

`public function detach(): resource|null`

Releases the underlying handle to the caller and leaves this stream detached.

Every subsequent operation other than `close()` and `__toString()` throws `RuntimeException`, since there is no resource left to act on.

Returns `resource``|``null` — the handle, or null when the stream was already detached

### eof()

`public function eof(): bool`

Reports whether the handle has reached end-of-file.

Returns `bool`

| Throws | When |
|---|---|
| `RuntimeException` | when the stream is detached |

### fromString()

`public static function fromString(string $content): SimpleStream`

Wraps $content in a new read/write `php://temp` handle, rewound to the start so the content can be read back immediately.

| Parameter | Type | Description |
|---|---|---|
| `$content` | `string` |  |

Returns [`SimpleStream`](/api/http/simple-stream/)

| Throws | When |
|---|---|
| `RuntimeException` | when the temporary handle cannot be opened |

### getContents()

`public function getContents(): string`

Reads everything remaining from the current position onwards, without rewinding first.

Returns `string`

| Throws | When |
|---|---|
| `RuntimeException` | when the stream is detached, or the read fails |

### getMetadata()

`public function getMetadata(mixed $key = null): mixed`

Returns the handle's stream metadata, or a single entry from it.

With no key the whole `stream_get_meta_data()` array is returned; with a key that the metadata does not contain, null is returned.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `mixed` |  |

Returns `mixed`

| Throws | When |
|---|---|
| `RuntimeException` | when the stream is detached |

### getSize()

`public function getSize(): ?int`

Always returns null: the size of the wrapped handle is never determined.

Returns `?``int`

### isReadable()

`public function isReadable(): bool`

Reports readability by inspecting the handle's open mode for a reading flag.

Returns `bool`

| Throws | When |
|---|---|
| `RuntimeException` | when the stream is detached |

### isSeekable()

`public function isSeekable(): bool`

Reports the handle's seekability as declared by its stream metadata.

Returns `bool`

| Throws | When |
|---|---|
| `RuntimeException` | when the stream is detached |

### isWritable()

`public function isWritable(): bool`

Reports writability by inspecting the handle's open mode for a writing flag.

Returns `bool`

| Throws | When |
|---|---|
| `RuntimeException` | when the stream is detached |

### read()

`public function read(mixed $length): string`

Reads up to `$length` bytes from the current position; a non-positive length yields an empty string.

| Parameter | Type | Description |
|---|---|---|
| `$length` | `mixed` |  |

Returns `string`

| Throws | When |
|---|---|
| `RuntimeException` | when the stream is detached, or the read fails |

### rewind()

`public function rewind(): void`

Seeks back to the start of the stream.

| Throws | When |
|---|---|
| `RuntimeException` | when the stream is detached, or the seek fails |

### seek()

`public function seek(mixed $offset, mixed $whence = SEEK_SET): void`

Moves the handle position.

| Parameter | Type | Description |
|---|---|---|
| `$offset` | `mixed` |  |
| `$whence` | `mixed` |  |

| Throws | When |
|---|---|
| `RuntimeException` | when the stream is detached, or the seek fails |

### tell()

`public function tell(): int`

Returns the current handle position.

Returns `int`

| Throws | When |
|---|---|
| `RuntimeException` | when the stream is detached, or the position cannot be read |

### write()

`public function write(mixed $string): int`

Writes to the handle at its current position and returns the byte count written.

| Parameter | Type | Description |
|---|---|---|
| `$string` | `mixed` |  |

Returns `int`

| Throws | When |
|---|---|
| `RuntimeException` | when the stream is detached, not opened for writing, or the write fails |
