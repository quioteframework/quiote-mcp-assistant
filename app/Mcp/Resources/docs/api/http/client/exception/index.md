# Exception

> The Quiote\\Http\\Client\\Exception namespace — 3 documented types.

Everything under `Quiote\Http\Client\Exception`.

## Classes

| Class | Description |
|---|---|
| [`NetworkException`](/api/http/client/exception/network-exception/) | PSR-18 network failure: the request could not be sent / no response was received (DNS failure, connection refused/reset, timeout). |
| [`RequestException`](/api/http/client/exception/request-exception/) | PSR-18 malformed-request failure: the request itself is not a well-formed HTTP request and could not even be attempted (e.g. |
| [`TransportException`](/api/http/client/exception/transport-exception/) | Base PSR-18 client exception for the Quiote HTTP client — anything that went wrong sending a request that isn't more specifically a network or malformed- request failure ([`NetworkException`](/api/http/client/exception/network-exception/)/[`RequestException`](/api/http/client/exception/request-exception/)). |
