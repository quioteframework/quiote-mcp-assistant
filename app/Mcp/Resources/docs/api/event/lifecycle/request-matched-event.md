# RequestMatchedEvent

> Emitted by RoutingMiddleware immediately after a request is matched to a module/action, before the matched request is handed to the rest of the pipeline.

Emitted by [`RoutingMiddleware`](/api/middleware/routing-middleware/) immediately after a request is matched to a module/action, before the matched request is handed to the rest of the pipeline.

## Synopsis

`final class RequestMatchedEvent extends Event`

|  |  |
|---|---|
| Extends | [`Event`](/api/event/event/) |
| Source | `Event/Lifecycle/RequestMatchedEvent.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$action` | `string` | _readonly._ |
| `$module` | `string` | _readonly._ |
| `$outputType` | `string` | _readonly._ |
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | _readonly._ |
| `$routeName` | `?``string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(ServerRequestInterface $request, string $module, string $action, ?string $routeName, string $outputType): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$routeName` | `?``string` |  |
| `$outputType` | `string` |  |

Returns `mixed`
