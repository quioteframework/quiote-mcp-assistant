# RoutingArraySource

> RoutingArraySource allows you to provide array sources for the routing

RoutingArraySource allows you to provide array sources for the routing

## Synopsis

`class RoutingArraySource implements IRoutingSource`

|  |  |
|---|---|
| Implements | [`IRoutingSource`](/api/routing/i-routing-source/) |
| Since | `1.0.0` |
| Source | `Routing/RoutingArraySource.php` |

## Constructor

### __construct()

`public function __construct(array<mixed> $data): mixed`

Constructor.

An array with data.

| Parameter | Type | Description |
|---|---|---|
| `$data` | `array``<``mixed``>` | An array with data. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getSource(array<int|string> $parts): mixed`](#getsource) | Retrieves the value for a given entry from the source. |

### getSource()

`public function getSource(array<int|string> $parts): mixed`

Retrieves the value for a given entry from the source.

An array with the name parts for the entry.

| Parameter | Type | Description |
|---|---|---|
| `$parts` | `array``<``int``|``string``>` | An array with the name parts for the entry. |

Returns `mixed` — The value.
