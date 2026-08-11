# AttributeBag

> Simple immutable-style attribute bag for no-container execution path.

Simple immutable-style attribute bag for no-container execution path.

Provides a focused API; mutation returns a cloned instance.

## Synopsis

`class AttributeBag implements ArrayAccess, Countable, IteratorAggregate`

|  |  |
|---|---|
| Implements | [`ArrayAccess`](https://www.php.net/manual/en/class.arrayaccess.php), [`Countable`](https://www.php.net/manual/en/class.countable.php), [`IteratorAggregate`](https://www.php.net/manual/en/class.iteratoraggregate.php) |
| Source | `Execution/AttributeBag.php` |

## Constructor

### __construct()

`public function __construct(array<string, mixed> $data = []): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$data` | `array``<``string``, ``mixed``>` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`all(): array<string, mixed>`](#all) |  |
| [`count(): int`](#count) | Returns the number of entries currently held. |
| [`get(string $key, mixed $default = null): mixed`](#get) |  |
| [`getIterator(): Traversable`](#getiterator) | Returns an iterator over the entries, keyed by attribute name. |
| [`has(string $key): bool`](#has) | Reports whether the bag holds an entry under the given key, including one whose value is null. |
| [`merge(array<string, mixed> $values): AttributeBag`](#merge) |  |
| [`offsetExists(mixed $offset): bool`](#offsetexists) | Reports whether an entry exists under the offset, treating a stored null as present. |
| [`offsetGet(mixed $offset): mixed`](#offsetget) | Returns the value stored under the offset, or null when nothing is stored there. |
| [`offsetSet(mixed $offset, mixed $value): void`](#offsetset) | Stores a value under the offset, mutating this bag in place. |
| [`offsetUnset(mixed $offset): void`](#offsetunset) | Removes the entry under the offset, mutating this bag in place; an absent key is a no-op. |
| [`with(string $key, mixed $value): AttributeBag`](#with) |  |
| [`without(string $key): AttributeBag`](#without) | Returns a clone of the bag with the given key removed. |

### all()

`public function all(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### count()

`public function count(): int`

Returns the number of entries currently held.

Returns `int`

### get()

`public function get(string $key, mixed $default = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$default` | `mixed` |  |

Returns `mixed`

### getIterator()

`public function getIterator(): Traversable`

Returns an iterator over the entries, keyed by attribute name.

The iterator walks a snapshot taken at call time, so mutating the bag afterwards does not affect an iteration already in progress.

Returns [`Traversable`](https://www.php.net/manual/en/class.traversable.php)

### has()

`public function has(string $key): bool`

Reports whether the bag holds an entry under the given key, including one whose value is null.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `bool`

### merge()

`public function merge(array<string, mixed> $values): AttributeBag`

| Parameter | Type | Description |
|---|---|---|
| `$values` | `array``<``string``, ``mixed``>` |  |

Returns [`AttributeBag`](/api/execution/attribute-bag/)

### offsetExists()

`public function offsetExists(mixed $offset): bool`

Reports whether an entry exists under the offset, treating a stored null as present.

| Parameter | Type | Description |
|---|---|---|
| `$offset` | `mixed` |  |

Returns `bool`

### offsetGet()

`public function offsetGet(mixed $offset): mixed`

Returns the value stored under the offset, or null when nothing is stored there.

| Parameter | Type | Description |
|---|---|---|
| `$offset` | `mixed` |  |

Returns `mixed`

### offsetSet()

`public function offsetSet(mixed $offset, mixed $value): void`

Stores a value under the offset, mutating this bag in place.

Callers that want the immutable semantics of the bag should use with() instead.

| Parameter | Type | Description |
|---|---|---|
| `$offset` | `mixed` |  |
| `$value` | `mixed` |  |

| Throws | When |
|---|---|
| `InvalidArgumentException` | If the offset is not a string. |

### offsetUnset()

`public function offsetUnset(mixed $offset): void`

Removes the entry under the offset, mutating this bag in place; an absent key is a no-op.

| Parameter | Type | Description |
|---|---|---|
| `$offset` | `mixed` |  |

### with()

`public function with(string $key, mixed $value): AttributeBag`

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$value` | `mixed` |  |

Returns [`AttributeBag`](/api/execution/attribute-bag/)

### without()

`public function without(string $key): AttributeBag`

Returns a clone of the bag with the given key removed.

The receiver is never modified. When the key is absent the same instance is returned rather than a clone, since there is nothing to change.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns [`AttributeBag`](/api/execution/attribute-bag/)
