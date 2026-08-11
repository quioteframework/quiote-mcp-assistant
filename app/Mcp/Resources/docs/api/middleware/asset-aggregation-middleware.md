# AssetAggregationMiddleware

> Collects legacy appended attributes like 'css' and 'js' from the Request (when using adapter) and exposes them as PSR request attributes `assets.css` and `assets.js`.

Collects legacy appended attributes like 'css' and 'js' from the Request (when using adapter) and exposes them as PSR request attributes `assets.css` and `assets.js`.

## Synopsis

`class AssetAggregationMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/AssetAggregationMiddleware.php` |

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Passes the request straight through to the rest of the stack. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Passes the request straight through to the rest of the stack.

Nothing is aggregated here: `assets.css` and `assets.js` are expected to be set as request attributes upstream, so this middleware neither reads nor writes them and leaves the response untouched. It stays in the `after_action` phase as the placement for asset collection.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
