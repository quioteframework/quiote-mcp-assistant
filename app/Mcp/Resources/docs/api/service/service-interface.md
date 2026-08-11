# ServiceInterface

> Marker interface for the DI Service layer.

Marker interface for the DI Service layer.

Lets the container discriminate services from arbitrary autowireable classes without mandating a base class — a class opts in by implementing this interface and/or carrying #[Quiote\DI\Attribute\Service]. Deliberately empty: a service is a POPO with constructor-injected dependencies.

## Synopsis

`interface ServiceInterface`

|  |  |
|---|---|
| Implemented by | [`Service`](/api/service/service/) |
| Source | `Service/ServiceInterface.php` |
