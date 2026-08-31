# RecordingSession

> The in-flight buffer for one request: bounded by `replay.max_bytes` and `replay.max_effects`, so a request with an unusually large body or an unusually long effect ledger produces a cassette that says it was truncated rather than growing without bound.

The in-flight buffer for one request: bounded by `replay.max_bytes` and `replay.max_effects`, so a request with an unusually large body or an unusually long effect ledger produces a cassette that says it was truncated rather than growing without bound.

Holds an [`EffectLedger`](/api/replay/replay/effect-ledger/) for whatever's wired to append to it -- DB effects are wired into a live request automatically by whichever `quioteframework/replay-{propulsion,doctrine,eloquent,cycle}` plugin is installed; cache/queue/env effects still need the app to substitute the matching `Recording*` decorator for its own cache/queue/env binding by hand. The ledger it builds carries an [`EffectRedactor`](/api/replay/recording/effect-redactor/), so every one of those recorders is scrubbed at the one point they all share rather than each having to remember.

## Synopsis

`final class RecordingSession`

|  |  |
|---|---|
| Source | `Recording/RecordingSession.php` |

## Constructor

### __construct()

`public function __construct(int $maxBytes = 2097152, int $maxEffects = 2000, ?EffectLedger $ledger = null, ?EffectRedactor $effectRedactor = null): mixed`

`maxBytes` bounds the request/response bodies *and*, separately, the effect ledger's own payloads: an effect carries cache values, captured result sets and HTTP response bodies, and `maxEffects` bounds only how many effects are kept, not how large.

Each budget is the full `maxBytes` rather than a shared pool, so instrumenting effects never silently costs a request its body -- the two are different failure modes and a reader can tell them apart.

| Parameter | Type | Description |
|---|---|---|
| `$maxBytes` | `int` |  |
| `$maxEffects` | `int` |  |
| `$ledger` | `?`[`EffectLedger`](/api/replay/replay/effect-ledger/) |  |
| `$effectRedactor` | `?`[`EffectRedactor`](/api/replay/recording/effect-redactor/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`boundedEffects(): list<Effect>`](#boundedeffects) |  |
| [`effectsTruncated(): bool`](#effectstruncated) | Whether anything was dropped from the effect ledger on its way into the cassette -- either more effects than `replay.max_effects` allows, or a payload past the byte budget. |
| [`exception(): array<string, mixed>|null`](#exception) |  |
| [`ledger(): EffectLedger`](#ledger) |  |
| [`request(): array<string, mixed>|null`](#request) |  |
| [`requestBodyTruncated(): bool`](#requestbodytruncated) |  |
| [`resolved(): array<string, mixed>`](#resolved) |  |
| [`response(): array<string, mixed>|null`](#response) |  |
| [`responseBodyTruncated(): bool`](#responsebodytruncated) |  |
| [`sessionAfter(): array<string, mixed>|null`](#sessionafter) |  |
| [`sessionBefore(): array<string, mixed>|null`](#sessionbefore) |  |
| [`setException(array<string, mixed>|null $exception): void`](#setexception) |  |
| [`setRequest(array<string, mixed> $request): void`](#setrequest) |  |
| [`setResolved(array<string, mixed> $resolved): void`](#setresolved) |  |
| [`setResponse(array<string, mixed> $response): void`](#setresponse) |  |
| [`setSessionAfter(array<string, mixed>|null $session): void`](#setsessionafter) |  |
| [`setSessionBefore(array<string, mixed>|null $session): void`](#setsessionbefore) |  |

### boundedEffects()

`public function boundedEffects(): list<Effect>`

Returns `list``<`[`Effect`](/api/replay/cassette/effect/)`>` — The ledger's effects, bounded to `replay.max_effects`, in recorded order.

### effectsTruncated()

`public function effectsTruncated(): bool`

Whether anything was dropped from the effect ledger on its way into the cassette -- either more effects than `replay.max_effects` allows, or a payload past the byte budget.

Surfaced in `meta.effects_truncated` by [`RecorderMiddleware`](/api/replay/recording/recorder-middleware/): a cassette that dropped effects is otherwise indistinguishable from one whose request genuinely made that few calls, and replaying it reports the missing effects as drift in the application rather than as an incomplete recording.

Returns `bool`

### exception()

`public function exception(): array<string, mixed>|null`

Returns `array``<``string``, ``mixed``>``|``null`

### ledger()

`public function ledger(): EffectLedger`

Returns [`EffectLedger`](/api/replay/replay/effect-ledger/)

### request()

`public function request(): array<string, mixed>|null`

Returns `array``<``string``, ``mixed``>``|``null`

### requestBodyTruncated()

`public function requestBodyTruncated(): bool`

Returns `bool`

### resolved()

`public function resolved(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### response()

`public function response(): array<string, mixed>|null`

Returns `array``<``string``, ``mixed``>``|``null`

### responseBodyTruncated()

`public function responseBodyTruncated(): bool`

Returns `bool`

### sessionAfter()

`public function sessionAfter(): array<string, mixed>|null`

Returns `array``<``string``, ``mixed``>``|``null`

### sessionBefore()

`public function sessionBefore(): array<string, mixed>|null`

Returns `array``<``string``, ``mixed``>``|``null`

### setException()

`public function setException(array<string, mixed>|null $exception): void`

| Parameter | Type | Description |
|---|---|---|
| `$exception` | `array``<``string``, ``mixed``>``|``null` |  |

### setRequest()

`public function setRequest(array<string, mixed> $request): void`

{method, uri, protocol, headers, cookies, body,
       uploads, server}

| Parameter | Type | Description |
|---|---|---|
| `$request` | `array``<``string``, ``mixed``>` | {method, uri, protocol, headers, cookies, body, uploads, server} |

### setResolved()

`public function setResolved(array<string, mixed> $resolved): void`

| Parameter | Type | Description |
|---|---|---|
| `$resolved` | `array``<``string``, ``mixed``>` |  |

### setResponse()

`public function setResponse(array<string, mixed> $response): void`

{status, headers, body, stray_output}

| Parameter | Type | Description |
|---|---|---|
| `$response` | `array``<``string``, ``mixed``>` | {status, headers, body, stray_output} |

### setSessionAfter()

`public function setSessionAfter(array<string, mixed>|null $session): void`

| Parameter | Type | Description |
|---|---|---|
| `$session` | `array``<``string``, ``mixed``>``|``null` |  |

### setSessionBefore()

`public function setSessionBefore(array<string, mixed>|null $session): void`

| Parameter | Type | Description |
|---|---|---|
| `$session` | `array``<``string``, ``mixed``>``|``null` |  |
