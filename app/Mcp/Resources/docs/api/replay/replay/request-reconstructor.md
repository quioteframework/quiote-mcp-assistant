# RequestReconstructor

> Rebuilds the PSR-7 request a cassette recorded, so ReplayEngine can hand it to the real pipeline.

Rebuilds the PSR-7 request a cassette recorded, so [`ReplayEngine`](/api/replay/replay/replay-engine/) can hand it to the real pipeline.

There is no existing factory that decodes a cassette's plain-array request shape directly (confirmed: `WebRequest::fromPsr()` only reads state off an already-built PSR-7 object) -- this builds a plain `Nyholm\Psr7\ServerRequest` first, exactly as `WebRequest` itself composes internally, then normalizes it through `WebRequest::fromPsr()` so it is the same request shape a real worker would hand to `Context::getRequestHandler()->handle()`.

## Synopsis

`final class RequestReconstructor`

|  |  |
|---|---|
| Source | `Replay/RequestReconstructor.php` |

## Methods

| Method | Description |
|---|---|
| [`fromCassette(Cassette $cassette): ServerRequestInterface`](#fromcassette) |  |

### fromCassette()

`public static function fromCassette(Cassette $cassette): ServerRequestInterface`

| Parameter | Type | Description |
|---|---|---|
| `$cassette` | [`Cassette`](/api/replay/cassette/cassette/) |  |

Returns [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/)

| Throws | When |
|---|---|
| `ReplayException` | if the cassette carries no method/uri to replay -- a `#[NoRecord]` skeleton, or `replay.capture_body` was off when it was recorded. |
