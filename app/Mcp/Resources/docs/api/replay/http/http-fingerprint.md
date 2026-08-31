# HttpFingerprint

> The fingerprint scheme shared by RecordingHttpTransport and StubbedHttpTransport: method + normalized URI + a hash of the request body.

The fingerprint scheme shared by [`RecordingHttpTransport`](/api/replay/http/recording-http-transport/) and [`StubbedHttpTransport`](/api/replay/replay/stubbed-http-transport/): method + normalized URI + a hash of the request body.

It has to be computed identically on both sides or a cassette recorded by one could never be matched by the other.

Reading the body to hash it must not disturb it for whatever reads it next (the real transport on the recording side; nothing, on the stub side, since a stub never forwards the request at all) -- so a seekable body is rewound before AND after the read. A non-seekable body cannot be read-and-restored safely, so it is left untouched and its content is excluded from the fingerprint entirely (`"unseekable-body"` in its place) rather than risking consuming a stream the real transport still needs to send.

## Synopsis

`final class HttpFingerprint`

|  |  |
|---|---|
| Source | `Http/HttpFingerprint.php` |

## Methods

| Method | Description |
|---|---|
| [`captureBody(StreamInterface $stream): ?string`](#capturebody) | A plain-string snapshot of a seekable stream's content, restoring its position afterward. |
| [`of(RequestInterface $request): string`](#of) |  |

### captureBody()

`public static function captureBody(StreamInterface $stream): ?string`

A plain-string snapshot of a seekable stream's content, restoring its position afterward.

Returns null for a non-seekable stream rather than consuming it -- the caller decides what "no captured body" means for its own recorded effect.

| Parameter | Type | Description |
|---|---|---|
| `$stream` | [`StreamInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns `?``string`

### of()

`public static function of(RequestInterface $request): string`

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`RequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns `string`
