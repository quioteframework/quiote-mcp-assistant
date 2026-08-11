# WorkerRequestFactory

> The single seam every worker runtime funnels its inbound request through, so reverse-proxy correction happens identically whether the request came from superglobals (a SAPI) or from a server that handed us a PSR-7 object (RoadRunner, Swoole).

The single seam every worker runtime funnels its inbound request through, so reverse-proxy correction happens identically whether the request came from superglobals (a SAPI) or from a server that handed us a PSR-7 object (RoadRunner, Swoole).

Previously this lived in Kernel and applied the correction by writing to $_SERVER before building the request, which is unavailable off-SAPI and untestable anywhere. Here it is a pure transformation of a PSR-7 request.

## Synopsis

`final class WorkerRequestFactory`

|  |  |
|---|---|
| Source | `Runtime/Request/WorkerRequestFactory.php` |

## Constructor

### __construct()

`public function __construct(ForwardedHeaderResolver $resolver = new ForwardedHeaderResolver(…), ?bool $trustForwardedHeaders = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$resolver` | [`ForwardedHeaderResolver`](/api/runtime/proxy/forwarded-header-resolver/) |  |
| `$trustForwardedHeaders` | `?``bool` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromGlobals(): WebRequest`](#fromglobals) | Build the request from PHP's superglobals. |
| [`fromPsr(ServerRequestInterface $request): WebRequest`](#frompsr) | Apply reverse-proxy correction and hand back a WebRequest the rest of the framework can rely on. |

### fromGlobals()

`public function fromGlobals(): WebRequest`

Build the request from PHP's superglobals.

Only valid under a runtime whose capabilities report populatesSuperglobals.

Returns [`WebRequest`](/api/request/web-request/)

### fromPsr()

`public function fromPsr(ServerRequestInterface $request): WebRequest`

Apply reverse-proxy correction and hand back a WebRequest the rest of the framework can rely on.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns [`WebRequest`](/api/request/web-request/)
