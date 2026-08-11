# KernelBootEvent

> Emitted at the end of Quiote::bootstrap(), once settings are loaded, plugins registered, and any requested contexts created.

Emitted at the end of [`Quiote::bootstrap()`](/api/quiote/#bootstrap), once settings are loaded, plugins registered, and any requested contexts created.

The earliest whole-framework "we're up" moment app/plugin code can hook.

## Synopsis

`final class KernelBootEvent extends Event`

|  |  |
|---|---|
| Extends | [`Event`](/api/event/event/) |
| Source | `Event/Lifecycle/KernelBootEvent.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$contexts` | `array` | _readonly._ |
| `$environment` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $environment, array<string, Context> $contexts): mixed`

contexts created during this bootstrap (may be empty)

| Parameter | Type | Description |
|---|---|---|
| `$environment` | `string` |  |
| `$contexts` | `array``<``string``, `[`Context`](/api/context/)`>` | contexts created during this bootstrap (may be empty) |

Returns `mixed`
