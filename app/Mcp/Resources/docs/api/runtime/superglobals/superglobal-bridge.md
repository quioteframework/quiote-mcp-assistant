# SuperglobalBridge

> Populates PHP's request superglobals from a PSR-7 request, for runtimes that don't do it themselves (RoadRunner, Swoole), and empties them again at the request boundary.

Populates PHP's request superglobals from a PSR-7 request, for runtimes that don't do it themselves (RoadRunner, Swoole), and empties them again at the request boundary.

Quiote's legacy half still reads them in about two dozen places -- Routing needs $_SERVER['SCRIPT_NAME'] to generate URLs, ext/session finds its id via $_COOKIE, ActionExecutor falls back to $_POST, TelemetryMiddleware wants REQUEST_TIME_FLOAT -- so hydrating here is what lets that code run unchanged off-SAPI. SessionMiddleware already mirrors PSR-7 cookies into $_COOKIE for the same reason; this generalises it.

One thing hydration cannot fake: $_FILES entries have no usable tmp_name, because a PSR-7 UploadedFileInterface may be backed by a stream with no file behind it. App code that reads $_FILES directly is unsupported off-SAPI and must use $request->getUploadedFiles() instead. Core reads only $_POST.

## Synopsis

`final class SuperglobalBridge`

|  |  |
|---|---|
| Source | `Runtime/Superglobals/SuperglobalBridge.php` |

## Constructor

### __construct()

`public function __construct(): mixed`

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`dehydrate(): void`](#dehydrate) | Restores the process baseline $_SERVER and empties the other superglobals. |
| [`hydrate(ServerRequestInterface $request): void`](#hydrate) | Fills $_SERVER, $_GET, $_POST, $_COOKIE, $_REQUEST and $_FILES from the request. |

### dehydrate()

`public function dehydrate(): void`

Restores the process baseline $_SERVER and empties the other superglobals.

Called at the request boundary so one request's HTTP_* keys, query values or cookies cannot be read by the next request on the same worker.

### hydrate()

`public function hydrate(ServerRequestInterface $request): void`

Fills $_SERVER, $_GET, $_POST, $_COOKIE, $_REQUEST and $_FILES from the request.

$_SERVER is the process baseline with the request's server params layered on top; $_REQUEST follows PHP's "GPCS" precedence, so POST values win over GET ones. A parsed body that is not an array leaves $_POST empty. $_FILES entries are rebuilt from the uploaded files but carry an empty `tmp_name`, as the class docblock explains.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
