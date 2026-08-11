# ContextLifecycle

> A context's per-request state machine: armed, claimed, cleared, armed again.

A context's per-request state machine: armed, claimed, cleared, armed again.

Three things that only make sense together:

- **Arming.** A request begins, and the state flush for it has not run yet. - **The flush claim.** Exactly one caller per request persists the request-scoped state that lives in the session. The session middleware claims it on the pipeline unwind, while the response has not been emitted and the session can still be written; the request boundary and shutdown claim it as a backstop for requests that never reached the middleware. The first caller wins, and the rest are no-ops rather than double writes. - **The clears.** At the end of the request, everything that must not survive into the next request served by the same process is dropped.

The clears carry the guarantee this class mostly exists for. They drop the session bag, the user and the request, and a step that throws must not prevent the steps after it from running: a half-cleared context that keeps request N's authenticated user installed serves request N+1 as that user, which is a cross-user authentication leak rather than a stale-data annoyance. So each step is independently guarded, and a failure is logged at error level and stepped over.

Steps run in registration order, and the order is meaningful: most dangerous first. The context registers the identity clears before anything that can fail.

Also an extension seam. Anything holding request-scoped state of its own -- a plugin with a per-request cache -- can register a clear here instead of having no way to hook the boundary at all.

## Synopsis

`final class ContextLifecycle`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `ContextLifecycle.php` |

## Methods

| Method | Description |
|---|---|
| [`beginRequest(): void`](#beginrequest) | Arm this context for a new request, so the flush for it can still be claimed. |
| [`claimRequestStateFlush(): bool`](#claimrequeststateflush) | Claim this request's state flush, answering whether the caller won. |
| [`endRequest(CategoryLogger $logger): void`](#endrequest) | End the request: run every clear, in order, guarded, then re-arm for the next one. |
| [`forgetSteps(): void`](#forgetsteps) | Forget every registered clear. |
| [`labels(): array<int, string>`](#labels) | The registered step labels, in run order. |
| [`onRequestEnd(string $label, \Closure(): void $step): void`](#onrequestend) | Register a clear to run when the request ends, after everything registered before it. |
| [`requestStateFlushClaimed(): bool`](#requeststateflushclaimed) | Whether this request's state flush has been claimed. |

### beginRequest()

`public function beginRequest(): void`

Arm this context for a new request, so the flush for it can still be claimed.

The authoritative anchor, called on the way in. [`ContextLifecycle::endRequest()`](/api/context-lifecycle/#endrequest) re-arms too, on the way out, and this covers a runtime that serves requests without ending one between them.

### claimRequestStateFlush()

`public function claimRequestStateFlush(): bool`

Claim this request's state flush, answering whether the caller won.

True exactly once per request. Every later caller gets false and must do nothing: the state has already been persisted, and persisting it again would write it twice -- or, after the response has been emitted, write it somewhere nothing will ever read.

Returns `bool`

### endRequest()

`public function endRequest(CategoryLogger $logger): void`

End the request: run every clear, in order, guarded, then re-arm for the next one.

Never throws. The context calls this from a `finally`, where throwing would replace whatever exception caused the reset to fail in the first place.

The re-arm happens last, after every clear, so each of them still sees this request's flush as claimed -- a clear that consulted it would otherwise see a fresh request that has not happened.

| Parameter | Type | Description |
|---|---|---|
| `$logger` | [`CategoryLogger`](/api/logging/category-logger/) |  |

### forgetSteps()

`public function forgetSteps(): void`

Forget every registered clear.

For a context being re-initialized, and for tests.

### labels()

`public function labels(): array<int, string>`

The registered step labels, in run order.

For assertions about what a context clears, and for diagnostics.

Returns `array``<``int``, ``string``>`

### onRequestEnd()

`public function onRequestEnd(string $label, \Closure(): void $step): void`

Register a clear to run when the request ends, after everything registered before it.

| Parameter | Type | Description |
|---|---|---|
| `$label` | `string` | Names the step in the debug line, and in the error line if it fails. It is the only thing that identifies which clear broke. |
| `$step` | `\Closure(): void` |  |

### requestStateFlushClaimed()

`public function requestStateFlushClaimed(): bool`

Whether this request's state flush has been claimed.

Returns `bool`
