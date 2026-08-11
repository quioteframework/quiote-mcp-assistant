# IRoutingSource

> IRoutingSource allows you to provide sources for the routing

IRoutingSource allows you to provide sources for the routing

## Synopsis

`interface IRoutingSource`

|  |  |
|---|---|
| Implemented by | [`RoutingArraySource`](/api/routing/routing-array-source/), [`RoutingUserSource`](/api/routing/routing-user-source/) |
| Since | `1.0.0` |
| Source | `Routing/IRoutingSource.php` |

## Methods

| Method | Description |
|---|---|
| [`getSource(array<int, string> $parts): mixed`](#getsource) | Retrieves the value for a given entry from the source. |

### getSource()

`abstract public function getSource(array<int, string> $parts): mixed`

Retrieves the value for a given entry from the source.

An array with the name parts for the entry.

| Parameter | Type | Description |
|---|---|---|
| `$parts` | `array``<``int``, ``string``>` | An array with the name parts for the entry. |

Returns `mixed` — The value.
