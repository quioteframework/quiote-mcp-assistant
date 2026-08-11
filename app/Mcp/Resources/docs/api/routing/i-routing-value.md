# IRoutingValue

> Routing values are used internally and, optionally, by users in gen() calls and callbacks to have more control over encoding behavior and values in pre- and postfixes

Routing values are used internally and, optionally, by users in gen() calls and callbacks to have more control over encoding behavior and values in pre- and postfixes

## Synopsis

`interface IRoutingValue extends ArrayAccess, Stringable`

|  |  |
|---|---|
| Implements | [`ArrayAccess`](https://www.php.net/manual/en/class.arrayaccess.php), [`Stringable`](https://www.php.net/manual/en/class.stringable.php) |
| Implemented by | [`RoutingValue`](/api/routing/routing-value/) |
| Since | `1.0.0` |
| Source | `Routing/IRoutingValue.php` |

## Constructor

### __construct()

`abstract public function __construct(mixed $value, bool $valueNeedsEncoding = true): mixed`

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
| [`getPostfix(): string`](#getpostfix) | Retrieve the postfix. |
| [`getPostfixNeedsEncoding(): bool`](#getpostfixneedsencoding) | Retrieve whether or not the postfix needs to be encoded. |
| [`getPrefix(): string`](#getprefix) | Retrieve the prefix. |
| [`getPrefixNeedsEncoding(): bool`](#getprefixneedsencoding) | Retrieve whether or not the prefix needs to be encoded. |
| [`getValue(): mixed`](#getvalue) | Retrieve the value. |
| [`getValueNeedsEncoding(): bool`](#getvalueneedsencoding) | Retrieve whether or not the value needs to be encoded. |
| [`hasPostfix(): bool`](#haspostfix) | Check if a postfix is set. |
| [`hasPrefix(): bool`](#hasprefix) | Check if a prefix is set. |
| [`initialize(Context $context, array<mixed> $parameters = []): void`](#initialize) | Initialize the routing value. |
| [`setPostfix(string $value): void`](#setpostfix) | Set the postfix. |
| [`setPostfixNeedsEncoding(bool $needsEncoding): void`](#setpostfixneedsencoding) | Set whether or not the postfix needs to be encoded. |
| [`setPrefix(string $value): void`](#setprefix) | Set the prefix. |
| [`setPrefixNeedsEncoding(bool $needsEncoding): void`](#setprefixneedsencoding) | Set whether or not the prefix needs to be encoded. |
| [`setValue(mixed $value): void`](#setvalue) | Set the value. |
| [`setValueNeedsEncoding(bool $needsEncoding): void`](#setvalueneedsencoding) | Set whether or not the value needs to be encoded. |

### __sleep()

`abstract public function __sleep(): mixed`

Pre-serialization callback.

Will set the name of the context instead of the instance, which will later be restored by __wakeup().

Returns `mixed`

### __toString()

`abstract public function __toString(): string`

Return the encoded value (without pre- or postfix) for BC.

Returns `string` — The encoded value.

### __wakeup()

`abstract public function __wakeup(): mixed`

Post-unserialization callback.

Will restore the context instance based on their names set by __sleep().

Returns `mixed`

### equals()

`abstract public function equals(mixed $other): bool`

Check if this routing value is equal to the given parameter.

The value to compare $this against.

| Parameter | Type | Description |
|---|---|---|
| `$other` | `mixed` | The value to compare $this against. |

Returns `bool` — Whether the value matches $this.

### getPostfix()

`abstract public function getPostfix(): string`

Retrieve the postfix.

Returns `string` — The postfix.

### getPostfixNeedsEncoding()

`abstract public function getPostfixNeedsEncoding(): bool`

Retrieve whether or not the postfix needs to be encoded.

Returns `bool` — True, if the postfix needs encoding, false otherwise.

### getPrefix()

`abstract public function getPrefix(): string`

Retrieve the prefix.

Returns `string` — The prefix.

### getPrefixNeedsEncoding()

`abstract public function getPrefixNeedsEncoding(): bool`

Retrieve whether or not the prefix needs to be encoded.

Returns `bool` — True, if the prefix needs encoding, false otherwise.

### getValue()

`abstract public function getValue(): mixed`

Retrieve the value.

Returns `mixed` — The value.

### getValueNeedsEncoding()

`abstract public function getValueNeedsEncoding(): bool`

Retrieve whether or not the value needs to be encoded.

Returns `bool` — True, if the value needs encoding, false otherwise.

### hasPostfix()

`abstract public function hasPostfix(): bool`

Check if a postfix is set.

Returns `bool` — True, if a postfix is set, false otherwise.

### hasPrefix()

`abstract public function hasPrefix(): bool`

Check if a prefix is set.

Returns `bool` — True, if a prefix is set, false otherwise.

### initialize()

`abstract public function initialize(Context $context, array<mixed> $parameters = []): void`

Initialize the routing value.

An array of initialization parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | The Context. |
| `$parameters` | `array``<``mixed``>` | An array of initialization parameters. |

### setPostfix()

`abstract public function setPostfix(string $value): void`

Set the postfix.

The postfix.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string` | The postfix. |

### setPostfixNeedsEncoding()

`abstract public function setPostfixNeedsEncoding(bool $needsEncoding): void`

Set whether or not the postfix needs to be encoded.

True, if the postfix needs encoding, false otherwise.

| Parameter | Type | Description |
|---|---|---|
| `$needsEncoding` | `bool` | True, if the postfix needs encoding, false otherwise. |

### setPrefix()

`abstract public function setPrefix(string $value): void`

Set the prefix.

The prefix.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string` | The prefix. |

### setPrefixNeedsEncoding()

`abstract public function setPrefixNeedsEncoding(bool $needsEncoding): void`

Set whether or not the prefix needs to be encoded.

True, if the prefix needs encoding, false otherwise.

| Parameter | Type | Description |
|---|---|---|
| `$needsEncoding` | `bool` | True, if the prefix needs encoding, false otherwise. |

### setValue()

`abstract public function setValue(mixed $value): void`

Set the value.

The value.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `mixed` | The value. |

### setValueNeedsEncoding()

`abstract public function setValueNeedsEncoding(bool $needsEncoding): void`

Set whether or not the value needs to be encoded.

True, if the postfix needs encoding, false otherwise.

| Parameter | Type | Description |
|---|---|---|
| `$needsEncoding` | `bool` | True, if the postfix needs encoding, false otherwise. |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `offsetExists()` | [`ArrayAccess`](https://www.php.net/manual/en/class.arrayaccess.php) |  |
| `offsetGet()` | [`ArrayAccess`](https://www.php.net/manual/en/class.arrayaccess.php) |  |
| `offsetSet()` | [`ArrayAccess`](https://www.php.net/manual/en/class.arrayaccess.php) |  |
| `offsetUnset()` | [`ArrayAccess`](https://www.php.net/manual/en/class.arrayaccess.php) |  |
