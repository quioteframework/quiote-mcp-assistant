# WorkerRequestCompletedEvent

> Emitted once per request from Kernel's worker-mode reset step — after WorkerManager::resetForNextRequest() (if worker mode is active), regardless of whether the request succeeded or the pipeline threw.

Emitted once per request from [`Kernel`](/api/runtime/kernel/)'s worker-mode reset step — after [`WorkerManager::resetForNextRequest()`](/api/util/worker-manager/#resetfornextrequest) (if worker mode is active), regardless of whether the request succeeded or the pipeline threw.

This is the per-request-boundary counterpart to [`KernelBootEvent`](/api/event/lifecycle/kernel-boot-event/): a plugin that builds worker-lifetime state at boot (e.g. a batching span/metric exporter) uses this to flush it before the worker serves the next request, instead of `Kernel` naming that plugin's class directly.

Distinct from [`ResponseSendingEvent`](/api/event/lifecycle/response-sending-event/): that one fires inside `Context::handle()` just before a *successful* response is returned, so it never fires on a pre-pipeline failure. This one always fires, once per request, at the outermost worker boundary.

## Synopsis

`final class WorkerRequestCompletedEvent extends Event`

|  |  |
|---|---|
| Extends | [`Event`](/api/event/event/) |
| Source | `Event/Lifecycle/WorkerRequestCompletedEvent.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | _readonly._ |

## Constructor

### __construct()

`public function __construct(Context $context): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |

Returns `mixed`
