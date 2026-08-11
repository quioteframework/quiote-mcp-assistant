# ActionResolver

> Resolves which execute* method to call and invokes action, returning raw view token.

Resolves which execute* method to call and invokes action, returning raw view token.

Single place where that selection happens, shared by top-level dispatch and slot rendering.

## Synopsis

`class ActionResolver`

|  |  |
|---|---|
| Source | `Execution/ActionResolver.php` |

## Methods

| Method | Description |
|---|---|
| [`candidateMethodNames(string $requestMethod): array<int, string>`](#candidatemethodnames) | Try exact, then canonicalized (e.g. |
| [`execute(Action $action, string $requestMethod, ServerRequestInterface $request): mixed`](#execute) | Execute an action selecting execute<Method>() fallback to execute(). |
| [`resolveMethodName(Action $action, string $requestMethod): ?string`](#resolvemethodname) | The first execute*() method name this action actually implements for the given HTTP verb, or null if none match (mirrors the candidate resolution execute() itself uses, without the execute()/default-view fallbacks -- callers needing that fallback should use execute()). |

### candidateMethodNames()

`public static function candidateMethodNames(string $requestMethod): array<int, string>`

Try exact, then canonicalized (e.g.

POST -> Post), then semantic mapping (GET -> Read, POST -> Write). Semantic mapping is driven by HttpMethodMapper (configurable via the routing.http_method_map setting) so every call site agrees. Default: GET/HEAD/OPTIONS/TRACE -> Read, POST -> Write, PUT/PATCH -> Update, DELETE -> Remove.

| Parameter | Type | Description |
|---|---|---|
| `$requestMethod` | `string` |  |

Returns `array``<``int``, ``string``>`

### execute()

`public function execute(Action $action, string $requestMethod, ServerRequestInterface $request): mixed`

Execute an action selecting execute<Method>() fallback to execute().

| Parameter | Type | Description |
|---|---|---|
| `$action` | [`Action`](/api/action/action/) |  |
| `$requestMethod` | `string` | e.g. GET/POST canonicalized to ucfirst form? |
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns `mixed` — Raw view token returned by action (string|array|View::NONE).

### resolveMethodName()

`public static function resolveMethodName(Action $action, string $requestMethod): ?string`

The first execute*() method name this action actually implements for the given HTTP verb, or null if none match (mirrors the candidate resolution execute() itself uses, without the execute()/default-view fallbacks -- callers needing that fallback should use execute()).

| Parameter | Type | Description |
|---|---|---|
| `$action` | [`Action`](/api/action/action/) |  |
| `$requestMethod` | `string` |  |

Returns `?``string`
