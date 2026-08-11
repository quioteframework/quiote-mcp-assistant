# Route

> Declares a route on an action class.

Declares a route on an action class.

Placed on the class (not a method): Quiote's model is one action class exposing multiple HTTP-verb methods (executeRead/executeWrite/...), the opposite of Symfony MVC's one controller/many route methods, so a class can carry one or more of these. `module`/`action` are deliberately not fields here -- they're derived from the class's location by AttributeRouteScanner, the same way Controller::createActionInstance() derives a class from a module/action pair, just in reverse.

## Synopsis

`final class Route`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Routing/Attribute/Route.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$condition` | `?``string` | _readonly._ |
| `$defaults` | `array` | _readonly._ |
| `$host` | `?``string` | _readonly._ |
| `$methods` | `array` | _readonly._ |
| `$name` | `?``string` | _readonly._ |
| `$outputType` | `?``string` | _readonly._ |
| `$path` | `string` | _readonly._ |
| `$priority` | `int` | _readonly._ |
| `$requirements` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $path, string|null $name = null, array<string> $methods = [], array<string, string> $requirements = [], array<string, mixed> $defaults = [], string|null $host = null, string|null $condition = null, int $priority = 0, string|null $outputType = null): mixed`

Quiote output type this route resolves to.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | Symfony route path, e.g. '/products/{id}'. |
| `$name` | `string``|``null` | Route name; derived from module+action when omitted. |
| `$methods` | `array``<``string``>` | HTTP methods this route accepts; empty means all. |
| `$requirements` | `array``<``string``, ``string``>` | Per-parameter regex requirements. |
| `$defaults` | `array``<``string``, ``mixed``>` | Extra route defaults, merged under module/action. |
| `$host` | `string``|``null` | Route host pattern. |
| `$condition` | `string``|``null` | Symfony ExpressionLanguage condition. |
| `$priority` | `int` | Route priority (higher matches first). |
| `$outputType` | `string``|``null` | Quiote output type this route resolves to. |

Returns `mixed`
