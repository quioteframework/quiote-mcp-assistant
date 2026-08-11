# SlotStack

> Stack tracking nested slot/sub-action executions, so recursion depth is explicit and boundable rather than implicit in the call stack.

Stack tracking nested slot/sub-action executions, so recursion depth is explicit and boundable rather than implicit in the call stack.

## Synopsis

`final class SlotStack`

|  |  |
|---|---|
| Source | `Execution/SlotStack.php` |

## Methods

| Method | Description |
|---|---|
| [`depth(): int`](#depth) | Returns how many slot executions are currently nested. |
| [`hasWarned(string $key): bool`](#haswarned) | Reports whether a warning has already been recorded for this key during the current request. |
| [`markWarned(string $key): void`](#markwarned) | Records that a warning has been emitted for this key, so later checks can suppress duplicates. |
| [`occurrences(string $key): int`](#occurrences) | Returns how many times the given key appears anywhere on the stack. |
| [`pop(): void`](#pop) | Marks the end of the innermost slot execution; popping an empty stack is a no-op. |
| [`push(string $key): void`](#push) | Marks the start of a nested slot execution by pushing its key onto the stack. |

### depth()

`public function depth(): int`

Returns how many slot executions are currently nested.

Returns `int`

### hasWarned()

`public function hasWarned(string $key): bool`

Reports whether a warning has already been recorded for this key during the current request.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `bool`

### markWarned()

`public function markWarned(string $key): void`

Records that a warning has been emitted for this key, so later checks can suppress duplicates.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

### occurrences()

`public function occurrences(string $key): int`

Returns how many times the given key appears anywhere on the stack.

A count above one means the same slot is rendering itself, which is what recursion guards test against before dispatching again.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `int`

### pop()

`public function pop(): void`

Marks the end of the innermost slot execution; popping an empty stack is a no-op.

### push()

`public function push(string $key): void`

Marks the start of a nested slot execution by pushing its key onto the stack.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
