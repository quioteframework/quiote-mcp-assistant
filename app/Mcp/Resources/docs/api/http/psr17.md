# Psr17

> Shared stateless Nyholm\\Psr7\\Factory\\Psr17Factory instance.

Shared stateless Nyholm\Psr7\Factory\Psr17Factory instance.

Psr17Factory holds no per-request state (it's pure construction logic for request/response/stream/uri/upload-file objects), so allocating a fresh one per response on the hot pipeline path is pure waste.

## Synopsis

`final class Psr17`

|  |  |
|---|---|
| Source | `Http/Psr17.php` |

## Methods

| Method | Description |
|---|---|
| [`factory(): Psr17Factory`](#factory) | Returns the shared factory, creating it on first call and reusing it for the life of the process. |

### factory()

`public static function factory(): Psr17Factory`

Returns the shared factory, creating it on first call and reusing it for the life of the process.

Returns `Psr17Factory`
