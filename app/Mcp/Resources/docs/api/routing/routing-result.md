# RoutingResult

> Immutable routing result facade providing legacy-like getters.

Immutable routing result facade providing legacy-like getters.

## Synopsis

`final readonly class RoutingResult`

|  |  |
|---|---|
| Source | `Routing/RoutingResult.php` |

## Constructor

### __construct()

`public function __construct(?string $module, ?string $action, string $outputType, string $method, array<string, mixed> $parameters = [], array<int, mixed> $matchedRoutes = []): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$module` | `?``string` |  |
| `$action` | `?``string` |  |
| `$outputType` | `string` |  |
| `$method` | `string` |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |
| `$matchedRoutes` | `array``<``int``, ``mixed``>` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getActionName(): ?string`](#getactionname) | Returns the matched action name, or null when routing did not resolve one. |
| [`getMatchedRoutes(): array<int, mixed>`](#getmatchedroutes) |  |
| [`getModuleName(): ?string`](#getmodulename) | Returns the matched module name, or null when routing did not resolve one. |
| [`getOutputType(): string`](#getoutputtype) | Returns the output type the matched route renders with. |
| [`getParameters(): array<string, mixed>`](#getparameters) |  |
| [`getRequestMethod(): string`](#getrequestmethod) | Returns the HTTP method the routed request was made with. |

### getActionName()

`public function getActionName(): ?string`

Returns the matched action name, or null when routing did not resolve one.

Returns `?``string`

### getMatchedRoutes()

`public function getMatchedRoutes(): array<int, mixed>`

Returns `array``<``int``, ``mixed``>`

### getModuleName()

`public function getModuleName(): ?string`

Returns the matched module name, or null when routing did not resolve one.

Returns `?``string`

### getOutputType()

`public function getOutputType(): string`

Returns the output type the matched route renders with.

Returns `string`

### getParameters()

`public function getParameters(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### getRequestMethod()

`public function getRequestMethod(): string`

Returns the HTTP method the routed request was made with.

Returns `string`
