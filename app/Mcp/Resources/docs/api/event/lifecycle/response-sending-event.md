# ResponseSendingEvent

> Emitted by Context::handle() once the pipeline has produced a response, just before it is returned to the runtime for emission.

Emitted by [`Context::handle()`](/api/context/#handle) once the pipeline has produced a response, just before it is returned to the runtime for emission.

The last hook that sees the full request + response together.

## Synopsis

`final class ResponseSendingEvent extends Event`

|  |  |
|---|---|
| Extends | [`Event`](/api/event/event/) |
| Source | `Event/Lifecycle/ResponseSendingEvent.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | _readonly._ |
| `$response` | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) | _readonly._ |

## Constructor

### __construct()

`public function __construct(ServerRequestInterface $request, ResponseInterface $response): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$response` | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns `mixed`
