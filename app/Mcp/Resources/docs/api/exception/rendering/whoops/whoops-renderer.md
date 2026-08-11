# WhoopsRenderer

> Full-detail developer renderer built on filp/whoops -- the \"shiny page\" shiny.php always tried and failed to be.

Full-detail developer renderer built on filp/whoops -- the "shiny page" shiny.php always tried and failed to be.

Only ever used when core.developer_exceptions is explicitly enabled; never the default.

Whoops\Run is configured with allowQuit(false) and writeToOutput(false) so handleException() returns its generated markup as a string instead of echoing and calling exit() -- required for worker-mode (FrankenPHP) safety, since exit() would kill the persistent process.

## Synopsis

`final class WhoopsRenderer implements ExceptionRenderer`

|  |  |
|---|---|
| Implements | [`ExceptionRenderer`](/api/exception/rendering/exception-renderer/) |
| Uses | [`NegotiatesContent`](/api/exception/rendering/negotiates-content/) |
| Since | `1.0.0` |
| Source | `WhoopsRenderer.php` |

## Methods

| Method | Description |
|---|---|
| [`render(Throwable $e, ServerRequestInterface $request, int $status, ?string $correlationId): ResponseInterface`](#render) | Renders the exception with full developer detail, in the negotiated format. |

### render()

`public function render(Throwable $e, ServerRequestInterface $request, int $status, ?string $correlationId): ResponseInterface`

Renders the exception with full developer detail, in the negotiated format.

A JSON request gets Whoops' JSON handler with the stack trace included, a plain-text request its text handler, and anything else the pretty HTML page -- with the correlation id added as a "Quiote" data table when one is known. The markup is returned in the response body; Whoops never writes to output or terminates the process.

| Parameter | Type | Description |
|---|---|---|
| `$e` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php) |  |
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$status` | `int` |  |
| `$correlationId` | `?``string` |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
