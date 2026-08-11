# PayloadParsingMiddleware

> Unified body parsing leveraging middlewares/payload.

Unified body parsing leveraging middlewares/payload.

Responsibilities: - Parse JSON (application/json, +json types) strict by default; 400 on invalid unless QUIOTE_JSON_STRICT=0 - Parse application/x-www-form-urlencoded (if not already parsed) - Skip re-parsing if the parsed body is already set (e.g. by an earlier middleware) Order: should run before routing and after tracing.

## Synopsis

`class PayloadParsingMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/PayloadParsingMiddleware.php` |

## Constructor

### __construct()

`public function __construct(?bool $strict = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$strict` | `?``bool` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Parses the request body into the parsed-body slot before routing runs. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Parses the request body into the parsed-body slot before routing runs.

A request that already has a parsed body is passed straight through, so an earlier middleware's or a test's parsing is never overwritten. A `application/x-www-form-urlencoded` body is parsed with `parse_str()`; anything else is handed to the JsonPayload middleware, which only acts on JSON content types.

Malformed JSON produces a 400 with an `invalid_json` JSON body when strict mode is on — the default, overridable by the constructor or by setting `QUIOTE_JSON_STRICT=0` — and otherwise falls through with the body left unparsed. Any other throwable is rethrown so ErrorHandlingMiddleware formats it.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
