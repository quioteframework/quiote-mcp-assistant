# MapRequest

> Marks a class as a request-mappable DTO.

Marks a class as a request-mappable DTO.

An Action method parameter typed with a #[MapRequest] class has its validators derived from the class's constructor-parameter constraint attributes (see Quiote\Request\Attribute\Constraint) and, once validation passes, is constructed and injected by ActionResolver.

## Synopsis

`final class MapRequest`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Request/Attribute/MapRequest.php` |
