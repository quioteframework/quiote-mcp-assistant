# StubbedHttpTransport

> The isolated-replay counterpart to RecordingHttpTransport: never opens a socket, never resolves a hostname, never touches the real network under any circumstance -- in isolated mode there is no transport at all.

The isolated-replay counterpart to [`RecordingHttpTransport`](/api/replay/http/recording-http-transport/): never opens a socket, never resolves a hostname, never touches the real network under any circumstance -- in isolated mode there is no transport at all.

Answers every `sendRequest()` from an injected [`EffectLedger`](/api/replay/replay/effect-ledger/), matching on the same [`HttpFingerprint`](/api/replay/http/http-fingerprint/) scheme the recorder used, and builds a real PSR-7 response from the recorded status/headers/body via the injected PSR-17 factories.

A ledger miss -- no recorded effect for this method+URI+body, or every recorded effect for it has already been consumed -- raises rather than fabricating a 200: inventing a response would fabricate a passing test. It raises a [`StubbedTransportException`](/api/replay/replay/stubbed-transport-exception/), which is a `ClientExceptionInterface` as PSR-18 requires -- see that class for what a bare `\RuntimeException` here broke.

## Synopsis

`final class StubbedHttpTransport implements ClientInterface`

|  |  |
|---|---|
| Implements | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |
| Source | `Replay/StubbedHttpTransport.php` |

## Constructor

### __construct()

`public function __construct(EffectLedger $ledger, ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |
| `$responseFactory` | `ResponseFactoryInterface` |  |
| `$streamFactory` | `StreamFactoryInterface` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`sendRequest(RequestInterface $request): ResponseInterface`](#sendrequest) | Sends a PSR-7 request and returns a PSR-7 response. |

### sendRequest()

`public function sendRequest(RequestInterface $request): ResponseInterface`

Sends a PSR-7 request and returns a PSR-7 response.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`RequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

| Throws | When |
|---|---|
| `ClientExceptionInterface` | If an error happens while processing the request. |
