# WorkerRuntimeInfo

> \"Which runtime are we on, and what can it do?\" -- the process-wide query surface for code outside the Runtime namespace that needs to behave differently in a persistent worker.

"Which runtime are we on, and what can it do?" -- the process-wide query surface for code outside the Runtime namespace that needs to behave differently in a persistent worker.

Kernel installs the selected runtime here before starting it. Anything asking earlier than that still gets a usable answer: boot-time listeners run inside Kernel::bootstrap(), which happens *before* runtime selection, so a query with nothing installed falls back to auto-detection over the registry and caches the result. Plugins have already registered their aliases by then, so detection sees the full set.

## Synopsis

`final class WorkerRuntimeInfo`

|  |  |
|---|---|
| Source | `Runtime/Worker/WorkerRuntimeInfo.php` |

## Methods

| Method | Description |
|---|---|
| [`alias(): string`](#alias) | The installed runtime's alias, or the detected one's when nothing is installed yet. |
| [`capabilities(): WorkerRuntimeCapabilities`](#capabilities) | What the hosting runtime does for itself: persistence, superglobals, SAPI output, streaming, forking. |
| [`install(WorkerRuntimeInterface $runtime): void`](#install) | Records the runtime that is about to serve this process, process-wide. |
| [`isInstalled(): bool`](#isinstalled) | Whether [`WorkerRuntimeInfo::install()`](/api/runtime/worker/worker-runtime-info/#install) has already run. |
| [`isPersistent(): bool`](#ispersistent) | The question almost every caller actually has: is this process going to handle more than one request? |
| [`reset(): void`](#reset) | Test isolation. |

### alias()

`public static function alias(): string`

The installed runtime's alias, or the detected one's when nothing is installed yet.

Returns `string`

### capabilities()

`public static function capabilities(): WorkerRuntimeCapabilities`

What the hosting runtime does for itself: persistence, superglobals, SAPI output, streaming, forking.

Answers from the installed runtime when there is one. Otherwise the registry is auto-detected and the detected runtime is instantiated to ask it; that answer is cached for the process and invalidated by [`WorkerRuntimeInfo::install()`](/api/runtime/worker/worker-runtime-info/#install) or [`WorkerRuntimeInfo::reset()`](/api/runtime/worker/worker-runtime-info/#reset). A detected runtime whose constructor cannot run here still yields a usable answer, with `persistent` derived from whether it is [`SapiRuntime`](/api/runtime/worker/sapi-runtime/).

Returns [`WorkerRuntimeCapabilities`](/api/runtime/worker/worker-runtime-capabilities/)

### install()

`public static function install(WorkerRuntimeInterface $runtime): void`

Records the runtime that is about to serve this process, process-wide.

Called by the Kernel once selection is done, before the runtime starts. Every later query answers from this instance instead of auto-detecting, and any capabilities cached from an earlier detection are dropped.

| Parameter | Type | Description |
|---|---|---|
| `$runtime` | [`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/) |  |

### isInstalled()

`public static function isInstalled(): bool`

Whether [`WorkerRuntimeInfo::install()`](/api/runtime/worker/worker-runtime-info/#install) has already run.

False means queries below are still answering from auto-detection rather than from the runtime the Kernel actually selected.

Returns `bool`

### isPersistent()

`public static function isPersistent(): bool`

The question almost every caller actually has: is this process going to handle more than one request?

Drives batch-vs-simple telemetry export, shutdown-function registration, and so on.

Returns `bool`

### reset()

`public static function reset(): void`

Test isolation.
