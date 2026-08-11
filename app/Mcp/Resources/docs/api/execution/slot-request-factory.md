# SlotRequestFactory

> Factory to derive a child PSR-7 request for slot (sub-action) execution.

Factory to derive a child PSR-7 request for slot (sub-action) execution.

Ensures SlotStack presence and attaches standardized slot metadata attributes.

## Synopsis

`class SlotRequestFactory`

|  |  |
|---|---|
| Source | `Execution/SlotRequestFactory.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `ATTR_SLOT_ACTION` | `'quiote.slot.action'` |  |
| `ATTR_SLOT_MODULE` | `'quiote.slot.module'` |  |
| `ATTR_SLOT_OUTPUTTYPE` | `'quiote.slot.output_type'` |  |
| `ATTR_SLOT_PARAMETERS` | `'quiote.slot.parameters'` |  |

## Methods

| Method | Description |
|---|---|
| [`create(ServerRequestInterface $parent, string $module, string $action, array<string, mixed> $parameters = [], ?string $outputType = null): ServerRequestInterface`](#create) | Create a child request containing slot metadata. |

### create()

`public static function create(ServerRequestInterface $parent, string $module, string $action, array<string, mixed> $parameters = [], ?string $outputType = null): ServerRequestInterface`

Create a child request containing slot metadata.

| Parameter | Type | Description |
|---|---|---|
| `$parent` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |
| `$outputType` | `?``string` |  |

Returns [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/)
