# SwooleRequestSnapshotFactory

> The only place in this package that touches \\Swoole\\Http\\Request.

The only place in this package that touches \Swoole\Http\Request.

Kept to a single method so everything else stays testable without ext-swoole.

## Synopsis

`final class SwooleRequestSnapshotFactory`

|  |  |
|---|---|
| Source | `SwooleRequestSnapshotFactory.php` |

## Methods

| Method | Description |
|---|---|
| [`fromSwoole(Request $request): SwooleRequestSnapshot`](#fromswoole) | Copies a Swoole request into a plain [`SwooleRequestSnapshot`](/api/runtime/swoole/swoole-request-snapshot/) that the rest of the package can work with without ext-swoole. |

### fromSwoole()

`public static function fromSwoole(Request $request): SwooleRequestSnapshot`

Copies a Swoole request into a plain [`SwooleRequestSnapshot`](/api/runtime/swoole/swoole-request-snapshot/) that the rest of the package can work with without ext-swoole.

Each of the server/header/get/post/cookie/files bags is null on a Swoole request that carries none of that kind, and becomes an empty array here; a request with no body at all (`rawContent()` returning false) becomes an empty body string.

| Parameter | Type | Description |
|---|---|---|
| `$request` | `Request` |  |

Returns [`SwooleRequestSnapshot`](/api/runtime/swoole/swoole-request-snapshot/)
