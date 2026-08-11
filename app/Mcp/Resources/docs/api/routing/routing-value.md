# RoutingValue

> Routing values are used internally and, optionally, by users in gen() calls and callbacks to have more control over encoding behavior and values in pre- and postfixes

Routing values are used internally and, optionally, by users in gen() calls and callbacks to have more control over encoding behavior and values in pre- and postfixes

## Synopsis

`class RoutingValue implements IRoutingValue, ResetInterface`

|  |  |
|---|---|
| Implements | [`IRoutingValue`](/api/routing/i-routing-value/), `ResetInterface` |
| Since | `1.0.0` |
| Source | `Routing/RoutingValue.php` |

## Constructor

### __construct()

`public function __construct(mixed $value, bool $valueNeedsEncoding = true): mixed`

Constructor.

Whether or not the value needs encoding.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `mixed` | The value. |
| `$valueNeedsEncoding` | `bool` | Whether or not the value needs encoding. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`__sleep(): mixed`](#sleep) | Pre-serialization callback. |
| [`__toString(): string`](#tostring) | Return the encoded value (without pre- or postfix) for BC. |
| [`__wakeup(): mixed`](#wakeup) | Post-unserialization callback. |
| [`equals(mixed $other): bool`](#equals) | Check if this routing value is equal to the given parameter. |
| [`getPostfix(): string|null`](#getpostfix) | Retrieve the postfix. |
| [`getPostfixNeedsEncoding(): bool`](#getpostfixneedsencoding) | Retrieve whether or not the postfix needs to be encoded. |
| [`getPrefix(): string|null`](#getprefix) | Retrieve the prefix. |
| [`getPrefixNeedsEncoding(): bool`](#getprefixneedsencoding) | Retrieve whether or not the prefix needs to be encoded. |
| [`getValue(): mixed`](#getvalue) | Retrieve the value. |
| [`getValueNeedsEncoding(): bool`](#getvalueneedsencoding) | Retrieve whether or not the value needs to be encoded. |
| [`hasPostfix(): bool`](#haspostfix) | Check if a postfix is set. |
| [`hasPrefix(): bool`](#hasprefix) | Check if a prefix is set. |
| [`initialize(Context $context, array<mixed> $parameters = []): mixed`](#initialize) | Initialize the routing value. |
| [`offsetExists(mixed $offset): bool`](#offsetexists) | ArrayAccess method for isset(). |
| [`offsetGet(mixed $offset): mixed`](#offsetget) | ArrayAccess method for getting a value. |
| [`offsetSet(mixed $offset, mixed $value): void`](#offsetset) | ArrayAccess method for setting a value. |
| [`offsetUnset(mixed $offset): void`](#offsetunset) | ArrayAccess method for unset(). |
| [`reset(): void`](#reset) | Clears every piece of state the value carries. |
| [`setPostfix(string $value): $this`](#setpostfix) | Set the postfix. |
| [`setPostfixNeedsEncoding(bool $needsEncoding): $this`](#setpostfixneedsencoding) | Set whether or not the postfix needs to be encoded. |
| [`setPrefix(string $value): $this`](#setprefix) | Set the prefix. |
| [`setPrefixNeedsEncoding(bool $needsEncoding): $this`](#setprefixneedsencoding) | Set whether or not the prefix needs to be encoded. |
| [`setValue(mixed $value): $this`](#setvalue) | Set the value. |
| [`setValueNeedsEncoding(bool $needsEncoding): $this`](#setvalueneedsencoding) | Set whether or not the value needs to be encoded. |

### __sleep()

`public function __sleep(): mixed`

Pre-serialization callback.

Will set the name of the context instead of the instance, which will later be restored by __wakeup().

Returns `mixed`

### __toString()

`public function __toString(): string`

Return the encoded value (without pre- or postfix) for BC.

Returns `string` — The encoded value.

### __wakeup()

`public function __wakeup(): mixed`

Post-unserialization callback.

Will restore the context instance based on their names set by __sleep().

Returns `mixed`

### equals()

`public function equals(mixed $other): bool`

Check if this routing value is equal to the given parameter.

The value to compare $this against.

| Parameter | Type | Description |
|---|---|---|
| `$other` | `mixed` | The value to compare $this against. |

Returns `bool` — Whether the value matches $this.

### getPostfix()

`public function getPostfix(): string|null`

Retrieve the postfix.

Returns `string``|``null` — The postfix, or null if none is set.

### getPostfixNeedsEncoding()

`public function getPostfixNeedsEncoding(): bool`

Retrieve whether or not the postfix needs to be encoded.

Returns `bool` — True, if the postfix needs encoding, false otherwise.

### getPrefix()

`public function getPrefix(): string|null`

Retrieve the prefix.

Returns `string``|``null` — The prefix, or null if none is set.

### getPrefixNeedsEncoding()

`public function getPrefixNeedsEncoding(): bool`

Retrieve whether or not the prefix needs to be encoded.

Returns `bool` — True, if the prefix needs encoding, false otherwise.

### getValue()

`public function getValue(): mixed`

Retrieve the value.

Returns `mixed` — The value.

### getValueNeedsEncoding()

`public function getValueNeedsEncoding(): bool`

Retrieve whether or not the value needs to be encoded.

Returns `bool` — True, if the value needs encoding, false otherwise.

### hasPostfix()

`public function hasPostfix(): bool`

Check if a postfix is set.

Returns `bool` — True, if a postfix is set, false otherwise.

### hasPrefix()

`public function hasPrefix(): bool`

Check if a prefix is set.

Returns `bool` — True, if a prefix is set, false otherwise.

### initialize()

`public function initialize(Context $context, array<mixed> $parameters = []): mixed`

Initialize the routing value.

An array of initialization parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | The Context. |
| `$parameters` | `array``<``mixed``>` | An array of initialization parameters. |

Returns `mixed`

### offsetExists()

`public function offsetExists(mixed $offset): bool`

ArrayAccess method for isset().

The offset.

| Parameter | Type | Description |
|---|---|---|
| `$offset` | `mixed` | The offset. |

Returns `bool` — Whether or not the given offset exists.

### offsetGet()

`public function offsetGet(mixed $offset): mixed`

ArrayAccess method for getting a value.

The offset.

| Parameter | Type | Description |
|---|---|---|
| `$offset` | `mixed` | The offset. |

Returns `mixed` — The value, nor null if the value does not exist.

### offsetSet()

`public function offsetSet(mixed $offset, mixed $value): void`

ArrayAccess method for setting a value.

The value.

| Parameter | Type | Description |
|---|---|---|
| `$offset` | `mixed` | The offset. |
| `$value` | `mixed` | The value. |

### offsetUnset()

`public function offsetUnset(mixed $offset): void`

ArrayAccess method for unset().

The offset.

| Parameter | Type | Description |
|---|---|---|
| `$offset` | `mixed` | The offset. |

### reset()

`public function reset(): void`

Clears every piece of state the value carries.

Drops the context and context name, the pre- and postfix along with their encoding flags, and unsets the constructor-promoted value and its encoding flag, so a container-managed instance holds nothing from the previous request. The instance is unusable until it is re-initialized: reading the value or casting to string before then hits an uninitialized property.

Only instance state is cleared. The `pre`/`val`/`post` offset map is a constant shared by every instance, so it stays put and ArrayAccess keeps resolving for the rest of the process.

### setPostfix()

`public function setPostfix(string $value): $this`

Set the postfix.

The postfix.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string` | The postfix. |

Returns `$this`

### setPostfixNeedsEncoding()

`public function setPostfixNeedsEncoding(bool $needsEncoding): $this`

Set whether or not the postfix needs to be encoded.

True, if the postfix needs encoding, false otherwise.

| Parameter | Type | Description |
|---|---|---|
| `$needsEncoding` | `bool` | True, if the postfix needs encoding, false otherwise. |

Returns `$this`

### setPrefix()

`public function setPrefix(string $value): $this`

Set the prefix.

The prefix.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string` | The prefix. |

Returns `$this`

### setPrefixNeedsEncoding()

`public function setPrefixNeedsEncoding(bool $needsEncoding): $this`

Set whether or not the prefix needs to be encoded.

True, if the prefix needs encoding, false otherwise.

| Parameter | Type | Description |
|---|---|---|
| `$needsEncoding` | `bool` | True, if the prefix needs encoding, false otherwise. |

Returns `$this`

### setValue()

`public function setValue(mixed $value): $this`

Set the value.

The value.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `mixed` | The value. |

Returns `$this`

### setValueNeedsEncoding()

`public function setValueNeedsEncoding(bool $needsEncoding): $this`

Set whether or not the value needs to be encoded.

True, if the postfix needs encoding, false otherwise.

| Parameter | Type | Description |
|---|---|---|
| `$needsEncoding` | `bool` | True, if the postfix needs encoding, false otherwise. |

Returns `$this`
