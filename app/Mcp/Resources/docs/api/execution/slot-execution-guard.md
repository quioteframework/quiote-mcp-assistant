# SlotExecutionGuard

> SlotExecutionGuard centralizes recursion limit enforcement for slot dispatches.

SlotExecutionGuard centralizes recursion limit enforcement for slot dispatches.

## Synopsis

`final readonly class SlotExecutionGuard`

|  |  |
|---|---|
| Source | `Execution/SlotExecutionGuard.php` |

## Constructor

### __construct()

`public function __construct(int $limit): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$limit` | `int` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`enter(SlotStack $stack, string $key): void`](#enter) | Push the key and throw if over the hard limit. |
| [`leave(SlotStack $stack): void`](#leave) | Remove the last pushed key. |
| [`wouldExceed(SlotStack $stack, string $key): bool`](#wouldexceed) | Non-throwing check: would pushing this key exceed the configured limit? |

### enter()

`public function enter(SlotStack $stack, string $key): void`

Push the key and throw if over the hard limit.

| Parameter | Type | Description |
|---|---|---|
| `$stack` | [`SlotStack`](/api/execution/slot-stack/) |  |
| `$key` | `string` |  |

### leave()

`public function leave(SlotStack $stack): void`

Remove the last pushed key.

| Parameter | Type | Description |
|---|---|---|
| `$stack` | [`SlotStack`](/api/execution/slot-stack/) |  |

### wouldExceed()

`public function wouldExceed(SlotStack $stack, string $key): bool`

Non-throwing check: would pushing this key exceed the configured limit?

Useful to allow callers to fail soft (return empty) instead of throwing.

| Parameter | Type | Description |
|---|---|---|
| `$stack` | [`SlotStack`](/api/execution/slot-stack/) |  |
| `$key` | `string` |  |

Returns `bool`
