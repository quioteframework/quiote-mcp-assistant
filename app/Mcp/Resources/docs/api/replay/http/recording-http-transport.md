# RecordingHttpTransport

> A decorating PSR-18 transport: wraps a real inner `ClientInterface` (typically `Quiote\\Http\\Client\\CurlTransport`, installed as the `$transport` `Quiote\\Http\\Client\\HttpClient` is constructed with) and appends one EffectKind::Http entry per successful call to an injected EffectLedger, returning the real response completely untouched to the caller.

A decorating PSR-18 transport: wraps a real inner `ClientInterface` (typically `Quiote\Http\Client\CurlTransport`, installed as the `$transport` `Quiote\Http\Client\HttpClient` is constructed with) and appends one [`EffectKind::Http`](/api/replay/cassette/effect-kind/#http) entry per successful call to an injected [`EffectLedger`](/api/replay/replay/effect-ledger/), returning the real response completely untouched to the caller.

Recording happens once per actual transport-level attempt, not once per logical `HttpClient::sendRequest()` call: `HttpClient::sendWithRetry()` calls `$this->transport->sendRequest($request)` again for each retry, so a request retried twice produces up to three ledger entries -- which is the honest record of what actually happened on the wire, and lets a replay reproduce a retry sequence exactly rather than collapsing it into one call.

A call whose inner transport throws a `ClientExceptionInterface` records nothing and lets the exception propagate: a failed call has no response to replay, and no ledger entry is a more honest state than a fabricated one -- same rule `Quiote\Replay\Db\RecordingPdo` follows for a failed statement.

## Synopsis

`final class RecordingHttpTransport implements ClientInterface`

|  |  |
|---|---|
| Implements | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |
| Source | `Http/RecordingHttpTransport.php` |

## Constructor

### __construct()

`public function __construct(ClientInterface $transport, EffectLedger $ledger, ClockInterface $clock = new SystemClock(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$transport` | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) |  |
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |

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
