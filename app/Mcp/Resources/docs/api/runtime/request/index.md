# Request

> The Quiote\\Runtime\\Request namespace — 1 documented type.

Everything under `Quiote\Runtime\Request`.

## Classes

| Class | Description |
|---|---|
| [`WorkerRequestFactory`](/api/runtime/request/worker-request-factory/) | The single seam every worker runtime funnels its inbound request through, so reverse-proxy correction happens identically whether the request came from superglobals (a SAPI) or from a server that handed us a PSR-7 object (RoadRunner, Swoole). |
