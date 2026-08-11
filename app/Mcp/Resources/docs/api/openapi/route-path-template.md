# RoutePathTemplate

> A route path parsed into the shape OpenAPI wants: a template whose placeholders are bare `{name}`, plus what the placeholders' inline syntax said about them.

A route path parsed into the shape OpenAPI wants: a template whose placeholders are bare `{name}`, plus what the placeholders' inline syntax said about them.

Symfony route paths may carry more than a name inside the braces -- `/orders/{id<\d+>}`, `/list/{page?1}`, `/{!locale}/about`, or all at once -- and none of that is legal in an OpenAPI path template, where a placeholder is the parameter name and nothing else. Rather than drop the extra syntax, it is lifted out: an inline requirement becomes a `pattern` on the parameter's schema and an inline default makes the parameter optional, which is exactly the information a spec consumer needs.

## Synopsis

`final readonly class RoutePathTemplate`

|  |  |
|---|---|
| Since | `1.2.5` |
| Source | `Openapi/RoutePathTemplate.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$defaults` | `array` | _readonly._ |
| `$path` | `string` | _readonly._ |
| `$requirements` | `array` | _readonly._ |
| `$variables` | `array` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`parse(string $path): RoutePathTemplate`](#parse) | Parses a Symfony route path into an OpenAPI-legal template plus the placeholder information lifted out of it. |

### parse()

`public static function parse(string $path): RoutePathTemplate`

Parses a Symfony route path into an OpenAPI-legal template plus the placeholder information lifted out of it.

Each placeholder is reduced to `{name}`, with a leading `!` dropped, an inline `<...>` requirement recorded in `$requirements` and an inline `?...` default recorded in `$defaults`. A repeated name appears once in `$variables`. Two shapes are passed through verbatim rather than rejected: a placeholder whose braces never close (the remainder of the path is copied as-is), and one whose contents yield no usable name (the raw `{...}` token is kept).

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns [`RoutePathTemplate`](/api/openapi/route-path-template/)
