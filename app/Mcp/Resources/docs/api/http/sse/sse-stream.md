# SseStream

> A write-once PSR-7 stream backed by an iterable of SseEvent (or plain string) items, typically a generator produced by an SseStreamingAction::streamEvents() implementation.

A write-once PSR-7 stream backed by an iterable of SseEvent (or plain string) items, typically a generator produced by an SseStreamingAction::streamEvents() implementation.

There are three ways to drain it, and only one may be used per instance: - writeTo(), a push loop that hands each formatted event to a sink and stops early when the sink reports the client is gone. SapiEmitter uses this. - read()/eof(), an incremental pull for consumers whose only streaming API is chunk-at-a-time (the RoadRunner responder). - __toString()/getContents(), which buffers everything in one pass, for anything treating the body as an ordinary string (dev-exception rendering, HttpTestCase assertions).

Mixing them throws rather than silently dropping events, since the backing iterable can only be traversed once.

## Synopsis

`final class SseStream implements StreamInterface`

|  |  |
|---|---|
| Implements | [`StreamInterface`](https://www.php-fig.org/psr/psr-7/) |
| Source | `Http/Sse/SseStream.php` |

## Constructor

### __construct()

`public function __construct(iterable<SseEvent|string> $events): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$events` | `iterable``<`[`SseEvent`](/api/http/sse/sse-event/)`|``string``>` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`__toString(): string`](#tostring) | Reads all data from the stream into a string, from the beginning to end. |
| [`close(): void`](#close) | Marks the stream consumed so no further draining is attempted; there is no underlying resource to release. |
| [`detach(): mixed`](#detach) | Marks the stream consumed and returns null, since the body is an iterable rather than a resource. |
| [`eof(): bool`](#eof) | Reports whether there is anything left to emit. |
| [`getContents(): string`](#getcontents) | Drains the whole event iterable in one pass and returns the formatted bytes. |
| [`getMetadata(mixed $key = null): mixed`](#getmetadata) | Reports no stream metadata: an empty array for a whole-set request, null for any single key. |
| [`getSize(): ?int`](#getsize) | Always returns null: the byte length of a generator-backed event stream is not known in advance. |
| [`isReadable(): bool`](#isreadable) | Always true; whether a given read() succeeds still depends on the stream not having been drained another way. |
| [`isSeekable(): bool`](#isseekable) | Always false: events are produced once, in order, and cannot be revisited. |
| [`isWritable(): bool`](#iswritable) | Always false: content comes from the iterable given to the constructor, never from callers. |
| [`read(mixed $length): string`](#read) | Pulls events on demand, returning at most $length bytes and keeping the remainder for the next call. |
| [`rewind(): void`](#rewind) | Tolerated as a no-op while nothing has been consumed yet, because that is how PSR-7 consumers conventionally open a body they are about to read (RoadRunner's chunked responder does exactly this). |
| [`seek(mixed $offset, mixed $whence = SEEK_SET): void`](#seek) | Never moves a position. |
| [`tell(): int`](#tell) | Never returns a position. |
| [`write(mixed $string): int`](#write) | Never accepts a write. |
| [`writeTo(callable $sink): void`](#writeto) | Drains the event iterable, formatting each item and passing it to $sink. |

### __toString()

`public function __toString(): string`

Reads all data from the stream into a string, from the beginning to end.

This method MUST attempt to seek to the beginning of the stream before reading data and read the stream until the end is reached.

Warning: This could attempt to load a large amount of data into memory.

This method MUST NOT raise an exception in order to conform with PHP's string casting operations.

Returns `string`

### close()

`public function close(): void`

Marks the stream consumed so no further draining is attempted; there is no underlying resource to release.

### detach()

`public function detach(): mixed`

Marks the stream consumed and returns null, since the body is an iterable rather than a resource.

Returns `mixed`

### eof()

`public function eof(): bool`

Reports whether there is anything left to emit.

On the incremental read() path this is true only once the iterable is exhausted and the pending buffer has been handed out; otherwise it reflects whether the stream has been drained, closed or detached.

Returns `bool`

### getContents()

`public function getContents(): string`

Drains the whole event iterable in one pass and returns the formatted bytes.

This is the buffering path: nothing is streamed, and the stream is left consumed.

Returns `string`

| Throws | When |
|---|---|
| `RuntimeException` | when the incremental read() path has already been started |

### getMetadata()

`public function getMetadata(mixed $key = null): mixed`

Reports no stream metadata: an empty array for a whole-set request, null for any single key.

There is no PHP stream resource behind this body, so there is nothing to describe.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `mixed` |  |

Returns `mixed`

### getSize()

`public function getSize(): ?int`

Always returns null: the byte length of a generator-backed event stream is not known in advance.

Returns `?``int`

### isReadable()

`public function isReadable(): bool`

Always true; whether a given read() succeeds still depends on the stream not having been drained another way.

Returns `bool`

### isSeekable()

`public function isSeekable(): bool`

Always false: events are produced once, in order, and cannot be revisited.

Returns `bool`

### isWritable()

`public function isWritable(): bool`

Always false: content comes from the iterable given to the constructor, never from callers.

Returns `bool`

### read()

`public function read(mixed $length): string`

Pulls events on demand, returning at most $length bytes and keeping the remainder for the next call.

Blocks in the underlying generator exactly as long as the next event takes to produce, so a consumer that reads in a loop streams rather than buffers -- which is what makes SSE work on a runtime whose only streaming API is "give me a chunk at a time" (RoadRunner) rather than a write callback (the SAPI emitter, which uses writeTo() instead).

Mutually exclusive with writeTo()/getContents(): an iterable can only be drained once, so mixing the two throws rather than silently losing events.

| Parameter | Type | Description |
|---|---|---|
| `$length` | `mixed` |  |

Returns `string`

### rewind()

`public function rewind(): void`

Tolerated as a no-op while nothing has been consumed yet, because that is how PSR-7 consumers conventionally open a body they are about to read (RoadRunner's chunked responder does exactly this).

Once events have started flowing there is nothing to rewind to.

### seek()

`public function seek(mixed $offset, mixed $whence = SEEK_SET): void`

Never moves a position.

| Parameter | Type | Description |
|---|---|---|
| `$offset` | `mixed` |  |
| `$whence` | `mixed` |  |

| Throws | When |
|---|---|
| `RuntimeException` | always, as the stream is not seekable |

### tell()

`public function tell(): int`

Never returns a position.

Returns `int`

| Throws | When |
|---|---|
| `RuntimeException` | always, as the stream has no byte offset to report |

### write()

`public function write(mixed $string): int`

Never accepts a write.

| Parameter | Type | Description |
|---|---|---|
| `$string` | `mixed` |  |

Returns `int`

| Throws | When |
|---|---|
| `RuntimeException` | always; produce events through the constructor's iterable instead |

### writeTo()

`public function writeTo(callable $sink): void`

Drains the event iterable, formatting each item and passing it to $sink.

Stops early if $sink returns false (e.g. the client disconnected mid-stream).

| Parameter | Type | Description |
|---|---|---|
| `$sink` | `callable` |  |
