# ExecutionTimeMiddleware

> Basic execution timing middleware replacing ExecutionTimeFilter.

Basic execution timing middleware replacing ExecutionTimeFilter.

## Synopsis

`class ExecutionTimeMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/ExecutionTimeMiddleware.php` |

## Constructor

### __construct()

`public function __construct(bool $appendHtmlComment = true): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$appendHtmlComment` | `bool` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Times the rest of the pipeline and optionally appends the duration as an HTML comment. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Times the rest of the pipeline and optionally appends the duration as an HTML comment.

The comment is only appended when the constructor was told to and the response is a PsrResponseAdapter whose wrapped response already carries string content — a streamed or non-string body is left alone, so the duration is silently dropped rather than corrupting the payload. The response object itself is mutated in place, not replaced.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
