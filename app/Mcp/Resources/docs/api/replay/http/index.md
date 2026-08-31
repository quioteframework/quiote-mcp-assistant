# Http

> The Quiote\\Replay\\Http namespace — 2 documented types.

Everything under `Quiote\Replay\Http`.

## Classes

| Class | Description |
|---|---|
| [`HttpFingerprint`](/api/replay/http/http-fingerprint/) | The fingerprint scheme shared by [`RecordingHttpTransport`](/api/replay/http/recording-http-transport/) and [`StubbedHttpTransport`](/api/replay/replay/stubbed-http-transport/): method + normalized URI + a hash of the request body. |
| [`RecordingHttpTransport`](/api/replay/http/recording-http-transport/) | A decorating PSR-18 transport: wraps a real inner `ClientInterface` (typically `Quiote\Http\Client\CurlTransport`, installed as the `$transport` `Quiote\Http\Client\HttpClient` is constructed with) and appends one [`EffectKind::Http`](/api/replay/cassette/effect-kind/#http) entry per successful call to an injected [`EffectLedger`](/api/replay/replay/effect-ledger/), returning the real response completely untouched to the caller. |
