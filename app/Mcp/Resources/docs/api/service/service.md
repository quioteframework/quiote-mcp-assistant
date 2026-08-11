# Service

> Optional, transitional base for services.

Optional, transitional base for services.

This is scaffolding, not a permanent parent: it exists so a service still being converted to constructor injection has somewhere to reach the container from, through `$this->getContext()->getContainer()`. It does not extend Model — the DTO-style getModel() convention and the service convention are deliberately un-conflated.

The end state for a service is a POPO with constructor-injected dependencies and no base class at all. Extending this out of habit just recreates the service-locator pattern under a new name — reach for constructor injection first.

## Synopsis

`abstract class Service implements ServiceInterface`

|  |  |
|---|---|
| Implements | [`ServiceInterface`](/api/service/service-interface/) |
| Source | `Service/Service.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | _readonly, protected._ |

## Constructor

### __construct()

`public function __construct(Context $context): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getContext(): Context`](#getcontext) | Returns the context this service was constructed with. |

### getContext()

`public function getContext(): Context`

Returns the context this service was constructed with.

Returns [`Context`](/api/context/)
