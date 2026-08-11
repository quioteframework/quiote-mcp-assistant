# TransportFactory

> Chooses the default underlying PSR-18 transport: Guzzle if it is installed (its `GuzzleHttp\\Client` already implements PSR-18 `ClientInterface`, so it is used directly — no adapter needed), otherwise the zero-dependency CurlTransport.

Chooses the default underlying PSR-18 transport: Guzzle if it is installed (its `GuzzleHttp\Client` already implements PSR-18 `ClientInterface`, so it is used directly — no adapter needed), otherwise the zero-dependency [`CurlTransport`](/api/http/client/curl-transport/).

Callers can override per named client via [`HttpClientConfig::$transport`](/api/http/client/http-client-config/#transport) or globally via [`HttpClientFactory::setDefaultTransportFactory()`](/api/http/client/http-client-factory/#setdefaulttransportfactory).

## Synopsis

`final class TransportFactory`

|  |  |
|---|---|
| Source | `Http/Client/TransportFactory.php` |

## Methods

| Method | Description |
|---|---|
| [`default(): ClientInterface`](#default) |  |

### default()

`public static function default(): ClientInterface`

Returns [`ClientInterface`](https://www.php-fig.org/psr/psr-18/)
