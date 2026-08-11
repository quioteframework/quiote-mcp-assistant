# OutputCapture

> Catches anything the application echoes outside the response body while a runtime with no SAPI output channel is handling the request.

Catches anything the application echoes outside the response body while a runtime with no SAPI output channel is handling the request.

Under a SAPI, `echo` from a template or a stray debug statement lands in the response and nobody notices. Under RoadRunner it lands on the process's stdout, which is the relay RoadRunner speaks its protocol over, and under Swoole it goes to the server's console. Both are worse than losing the output, so the loop wraps the pipeline in a buffer and applies a policy.

`core.worker.stray_output`: - `append`  (default) fold it onto the response body, matching what a SAPI would have produced - `discard` drop it, with a log line naming the size - `throw`   fail loudly, for development

## Synopsis

`final class OutputCapture`

|  |  |
|---|---|
| Source | `Runtime/OutputCapture.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `POLICY_APPEND` | `'append'` |  |
| `POLICY_DISCARD` | `'discard'` |  |
| `POLICY_THROW` | `'throw'` |  |

## Constructor

### __construct()

`public function __construct(?string $policy = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$policy` | `?``string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`apply(string $stray): string`](#apply) | Applies the configured policy, returning the text to append to the response body ('' when there is nothing to append). |
| [`finish(): string`](#finish) | Unwinds every buffer opened since start() -- application code may have opened its own and not closed it, e.g. |
| [`start(): void`](#start) | Opens the capture buffer for one request. |

### apply()

`public function apply(string $stray): string`

Applies the configured policy, returning the text to append to the response body ('' when there is nothing to append).

| Parameter | Type | Description |
|---|---|---|
| `$stray` | `string` |  |

Returns `string`

| Throws | When |
|---|---|
| `RuntimeException` | when the policy is `throw` and output was captured. |

### finish()

`public function finish(): string`

Unwinds every buffer opened since start() -- application code may have opened its own and not closed it, e.g.

a renderer that threw mid-render -- and returns whatever was written, or '' when there was nothing.

ob_get_clean() pops the innermost buffer first, so the collected chunks come back inside-out and have to be reversed to reproduce write order.

Returns `string`

### start()

`public function start(): void`

Opens the capture buffer for one request.

Records the buffer level beneath it and the level of its own buffer, which is what lets [`OutputCapture::finish()`](/api/runtime/output-capture/#finish) detect application code closing past it. Calling this while a capture is already open does nothing, so the nesting stays balanced.
