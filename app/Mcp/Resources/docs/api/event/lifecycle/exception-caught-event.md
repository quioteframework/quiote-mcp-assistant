# ExceptionCaughtEvent

> Emitted by ErrorHandlingMiddleware whenever it catches an unhandled throwable, before rendering the error response.

Emitted by [`ErrorHandlingMiddleware`](/api/middleware/error-handling-middleware/) whenever it catches an unhandled throwable, before rendering the error response.

Lets plugins hook error reporting (e.g. Sentry/Bugsnag) uniformly instead of each wiring its own constructor-injected callback.

## Synopsis

`final class ExceptionCaughtEvent extends Event`

|  |  |
|---|---|
| Extends | [`Event`](/api/event/event/) |
| Source | `Event/Lifecycle/ExceptionCaughtEvent.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$exception` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php) | _readonly._ |
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | _readonly._ |

## Constructor

### __construct()

`public function __construct(Throwable $exception, ServerRequestInterface $request): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$exception` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php) |  |
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns `mixed`
