# ShutdownSequence

> The ordered list of components to shut down, and the operations on that order.

The ordered list of components to shut down, and the operations on that order.

Order is the whole point: a component's shutdown may write through another one, so the sequence is built back-to-front from the factory configuration and every operation here preserves position rather than recomputing it. That is why replacing a component is a splice at its old index and not an append.

## Synopsis

`final class ShutdownSequence`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `ShutdownSequence.php` |

## Methods

| Method | Description |
|---|---|
| [`all(): array<int, object>`](#all) | The components, in shutdown order. |
| [`append(object $component): void`](#append) | Add a component at the end of the sequence, so it shuts down last. |
| [`count(): int`](#count) | How many components are in the sequence. |
| [`has(object $component): bool`](#has) | Whether the sequence holds this exact component. |
| [`remove(callable(object): bool $matches): void`](#remove) | Drop every component the predicate matches, closing the gaps. |
| [`replaceAll(array<int, mixed> $components): void`](#replaceall) | Install the sequence wholesale. |
| [`replaceRole(object $replacement, callable(object): bool $matches, int $fallbackIndex = 0, string $caller = 'replaceRole'): void`](#replacerole) | Replace every component of one role with $replacement, at the role's original position. |
| [`shutdownAll(?object $skip = null): void`](#shutdownall) | Shut every component down in order. |

### all()

`public function all(): array<int, object>`

The components, in shutdown order.

Returns `array``<``int``, ``object``>`

### append()

`public function append(object $component): void`

Add a component at the end of the sequence, so it shuts down last.

Idempotent by identity: a component already in the sequence keeps its existing position rather than being shut down twice.

| Parameter | Type | Description |
|---|---|---|
| `$component` | `object` |  |

### count()

`public function count(): int`

How many components are in the sequence.

Returns `int`

### has()

`public function has(object $component): bool`

Whether the sequence holds this exact component.

| Parameter | Type | Description |
|---|---|---|
| `$component` | `object` |  |

Returns `bool`

### remove()

`public function remove(callable(object): bool $matches): void`

Drop every component the predicate matches, closing the gaps.

| Parameter | Type | Description |
|---|---|---|
| `$matches` | `callable(object): bool` |  |

### replaceAll()

`public function replaceAll(array<int, mixed> $components): void`

Install the sequence wholesale.

| Parameter | Type | Description |
|---|---|---|
| `$components` | `array``<``int``, ``mixed``>` |  |

### replaceRole()

`public function replaceRole(object $replacement, callable(object): bool $matches, int $fallbackIndex = 0, string $caller = 'replaceRole'): void`

Replace every component of one role with $replacement, at the role's original position.

Label for the debug line, naming why the replacement happened.

| Parameter | Type | Description |
|---|---|---|
| `$replacement` | `object` | The freshly created component. |
| `$matches` | `callable(object): bool` | Identifies instances of the role. |
| `$fallbackIndex` | `int` | Insertion point when the role was absent. |
| `$caller` | `string` | Label for the debug line, naming why the replacement happened. |

### shutdownAll()

`public function shutdownAll(?object $skip = null): void`

Shut every component down in order.

A component shut down by its own owner -- the user, which the
            request-state flush persists so the ordering against the session holds.
            Shutting it down again here would double-write.

| Parameter | Type | Description |
|---|---|---|
| `$skip` | `?``object` | A component shut down by its own owner -- the user, which the request-state flush persists so the ordering against the session holds. Shutting it down again here would double-write. |
