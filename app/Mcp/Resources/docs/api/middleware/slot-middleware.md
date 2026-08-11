# SlotMiddleware

> SlotMiddleware: establishes a SlotStack in request attributes for nested slot/sub-action rendering.

SlotMiddleware: establishes a SlotStack in request attributes for nested slot/sub-action rendering.

Later stages (DispatchMiddleware or a future SlotDispatcher) can push/pop keys as they perform slot executions.

## Synopsis

`class SlotMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/SlotMiddleware.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `ATTR` | `'Quiote\\Execution\\SlotStack'` |  |

## Constructor

### __construct()

`public function __construct(?Context $context = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$context` | `?`[`Context`](/api/context/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Attaches a SlotStack to the request so downstream code can render nested slots. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Attaches a SlotStack to the request so downstream code can render nested slots.

Does nothing if the request already carries one, which is what keeps a slot rendered through a nested pipeline from starting a fresh stack.

When a context was injected, the rewritten request is republished through RequestState so anything reading Context::getRequest() sees the instance carrying the stack. A failure to publish is logged as a warning and not rethrown; the consequence is that a slot rendered from context-read code will not find a stack.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
