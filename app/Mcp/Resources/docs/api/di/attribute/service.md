# Service

> Class-level discovery marker + scope declaration for services.

Class-level discovery marker + scope declaration for services.

Lets the container (or a future scanner) discriminate services from arbitrary autowireable classes without a forced base class or marker interface.

Defaults to transient, matching what [`ServiceInterface`](/api/service/service-interface/) infers, so the two ways of declaring a service agree. The bare `#[Service]` form reads as "this is a service" rather than "this is process-global", and it takes precedence over the interface check -- so a singleton default would mean adding this attribute to an existing service for discoverability silently promoted it to process lifetime, which under a persistent worker serves one request's state to the next.

Process lifetime is available, but as a claim you make explicitly once you have confirmed the class holds no per-request state:

#[Service(scope: Container::SCOPE_SINGLETON)]

## Synopsis

`final class Service`

|  |  |
|---|---|
| Source | `DI/Attribute/Service.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$scope` | `string` |  |

## Constructor

### __construct()

`public function __construct(string $scope = Quiote\DI\Container::SCOPE_TRANSIENT): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$scope` | `string` |  |

Returns `mixed`
