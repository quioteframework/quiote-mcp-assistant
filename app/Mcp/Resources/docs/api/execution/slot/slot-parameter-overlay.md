# SlotParameterOverlay

> Puts a slot's own parameters on the shared request for the length of its dispatch, and takes them off again afterwards.

Puts a slot's own parameters on the shared request for the length of its dispatch, and takes them off again afterwards.

A slot receives arguments, but the action it dispatches reads them from the request like any other action -- so the arguments have to be visible there and then stop being visible, or one slot's arguments leak into everything rendered after it.

What gets restored is what the request exposed at overlay time, which is the *validated* request rather than what the client submitted: a parameter validation pruned must stay pruned, since putting the submitted value back would publish unvalidated input to the rest of the page.

A name the parent did not have is revoked rather than blanked. setParameter() adds a whitelist entry, and leaving the name declared would turn a later getParameter() from a refusal into a silent null.

Every restore failure is reported and the rest still attempted: each name left behind is one the parent request now reads with this slot's value.

## Synopsis

`final class SlotParameterOverlay`

|  |  |
|---|---|
| Source | `Execution/Slot/SlotParameterOverlay.php` |

## Constructor

### __construct()

`public function __construct(Context $context, CategoryLogger $logger, string $slotKey): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$logger` | [`CategoryLogger`](/api/logging/category-logger/) |  |
| `$slotKey` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`apply(array<string, mixed> $parameters): WebRequest`](#apply) | Applies the slot's parameters, remembering what each name held before. |
| [`restore(?WebRequest $request): void`](#restore) | Puts the parent's parameters back and republishes the request. |
| [`wasApplied(): bool`](#wasapplied) |  |

### apply()

`public function apply(array<string, mixed> $parameters): WebRequest`

Applies the slot's parameters, remembering what each name held before.

| Parameter | Type | Description |
|---|---|---|
| `$parameters` | `array``<``string``, ``mixed``>` |  |

Returns [`WebRequest`](/api/request/web-request/) — The overlaid request, published to the context.

| Throws | When |
|---|---|
| `RuntimeException` | if there is no request to overlay onto. |

### restore()

`public function restore(?WebRequest $request): void`

Puts the parent's parameters back and republishes the request.

Safe to call when nothing was applied, so the caller can invoke it unconditionally from a finally block.

| Parameter | Type | Description |
|---|---|---|
| `$request` | `?`[`WebRequest`](/api/request/web-request/) |  |

### wasApplied()

`public function wasApplied(): bool`

Returns `bool`
