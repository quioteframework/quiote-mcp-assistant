# StubbedTransportException

> What StubbedHttpTransport raises when the ledger has no recorded counterpart for a request.

What [`StubbedHttpTransport`](/api/replay/replay/stubbed-http-transport/) raises when the ledger has no recorded counterpart for a request.

A plain `\RuntimeException` was the wrong type, not the wrong decision. PSR-18 states that `sendRequest()` throws a `ClientExceptionInterface` when it cannot send the request, so a caller's correct `catch (ClientExceptionInterface)` did not catch this and `Quiote\Http\Client\HttpClient::sendWithRetry()`, which drives retries off `NetworkExceptionInterface`, could not see it either -- meaning the retry sequence [`RecordingHttpTransport`](/api/replay/http/recording-http-transport/) deliberately records could never be reproduced on replay.

There was never a trade-off to make: `Quiote\Http\Client\Exception\TransportException` shows the shape, extending `\RuntimeException` *and* implementing the PSR interface. This does the same rather than depending on the framework's HTTP client from a replay stub.

## Synopsis

`final class StubbedTransportException extends RuntimeException implements ClientExceptionInterface`

|  |  |
|---|---|
| Extends | `RuntimeException` |
| Implements | `ClientExceptionInterface` |
| Source | `Replay/StubbedTransportException.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `getCode()` | `Exception` |  |
| `getFile()` | `Exception` |  |
| `getLine()` | `Exception` |  |
| `getMessage()` | `Exception` |  |
| `getPrevious()` | `Exception` |  |
| `getTrace()` | `Exception` |  |
| `getTraceAsString()` | `Exception` |  |
