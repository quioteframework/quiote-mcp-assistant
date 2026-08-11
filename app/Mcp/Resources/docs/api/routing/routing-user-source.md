# RoutingUserSource

> RoutingUserSource allows you to provide an user source for the routing

RoutingUserSource allows you to provide an user source for the routing

## Synopsis

`class RoutingUserSource implements IRoutingSource`

|  |  |
|---|---|
| Implements | [`IRoutingSource`](/api/routing/i-routing-source/) |
| Since | `1.0.0` |
| Source | `Routing/RoutingUserSource.php` |

## Constructor

### __construct()

`public function __construct(ISecurityUser $user): mixed`

Constructor.

An user instance.

| Parameter | Type | Description |
|---|---|---|
| `$user` | [`ISecurityUser`](/api/user/i-security-user/) | An user instance. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getSource(array<int, string> $parts): mixed`](#getsource) | Retrieves the value for a given entry from the source. |

### getSource()

`public function getSource(array<int, string> $parts): mixed`

Retrieves the value for a given entry from the source.

An array with the name parts for the entry.

| Parameter | Type | Description |
|---|---|---|
| `$parts` | `array``<``int``, ``string``>` | An array with the name parts for the entry. |

Returns `mixed` — The value.
