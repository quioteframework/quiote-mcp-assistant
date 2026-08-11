# OpenApiOptions

> The document-level knobs OpenApiGenerator can't derive from code: `info`, `servers`, and which routes to describe at all.

The document-level knobs [`OpenApiGenerator`](/api/openapi/open-api-generator/) can't derive from code: `info`, `servers`, and which routes to describe at all.

Everything else in the emitted spec comes from the route table and the actions' own validator declarations, so this stays deliberately small.

[`OpenApiOptions::fromConfig()`](/api/openapi/open-api-options/#fromconfig) reads the `core.openapi.*` settings, so an app declares its API metadata once in settings.* and both `openapi:generate` and any programmatic caller agree on it.

## Synopsis

`final readonly class OpenApiOptions`

|  |  |
|---|---|
| Since | `1.2.5` |
| Source | `Openapi/OpenApiOptions.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$description` | `?``string` | _readonly._ |
| `$excludeRoutes` | `array` | _readonly._ |
| `$modules` | `array` | _readonly._ |
| `$problemResponses` | `bool` | _readonly._ |
| `$servers` | `array` | _readonly._ |
| `$title` | `string` | _readonly._ |
| `$useActionDocblocks` | `bool` | _readonly._ |
| `$version` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $title = 'API', string $version = '1.0.0', ?string $description = null, list<array{url: string, description?: string}> $servers = [], list<string> $excludeRoutes = [], list<string> $modules = [], bool $problemResponses = true, bool $useActionDocblocks = true): mixed`

Use each action class's docblock as its operation summary/description. Turn off for an app whose action docblocks are internal notes rather than API prose.

| Parameter | Type | Description |
|---|---|---|
| `$title` | `string` |  |
| `$version` | `string` |  |
| `$description` | `?``string` |  |
| `$servers` | `list``<``array{url: string, description?: string}``>` |  |
| `$excludeRoutes` | `list``<``string``>` | fnmatch() patterns matched against route names; a matching route is left out. |
| `$modules` | `list``<``string``>` | Only describe routes belonging to these modules (case-insensitive); empty means all. |
| `$problemResponses` | `bool` | Emit the RFC 9457 error responses (400 for routes with validators, 500) Quiote's pipeline actually returns. |
| `$useActionDocblocks` | `bool` | Use each action class's docblock as its operation summary/description. Turn off for an app whose action docblocks are internal notes rather than API prose. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`coversModule(string $module): bool`](#coversmodule) | Whether $module is in scope (always true when no module filter is set). |
| [`excludes(string $routeName): bool`](#excludes) | Whether $routeName is excluded by any of the configured fnmatch patterns. |
| [`fromConfig(): OpenApiOptions`](#fromconfig) | Reads the `core.openapi.*` settings into an options snapshot. |
| [`normalizeServers(array<mixed> $servers): list<array{url: string, description?: string}>`](#normalizeservers) | Accepts the two shapes a settings file can plausibly use -- a bare list of URLs, or a list of `{url, description}` maps -- and normalizes both to the OpenAPI Server Object shape. |

### coversModule()

`public function coversModule(string $module): bool`

Whether $module is in scope (always true when no module filter is set).

| Parameter | Type | Description |
|---|---|---|
| `$module` | `string` |  |

Returns `bool`

### excludes()

`public function excludes(string $routeName): bool`

Whether $routeName is excluded by any of the configured fnmatch patterns.

| Parameter | Type | Description |
|---|---|---|
| `$routeName` | `string` |  |

Returns `bool`

### fromConfig()

`public static function fromConfig(): OpenApiOptions`

Reads the `core.openapi.*` settings into an options snapshot.

The title falls back to `core.app_name` and then to `API`; an empty description setting becomes null rather than an empty string. `servers` is normalized to the `{url, description?}` entries OpenAPI expects, and malformed entries are dropped there.

Returns [`OpenApiOptions`](/api/openapi/open-api-options/)

### normalizeServers()

`public static function normalizeServers(array<mixed> $servers): list<array{url: string, description?: string}>`

Accepts the two shapes a settings file can plausibly use -- a bare list of URLs, or a list of `{url, description}` maps -- and normalizes both to the OpenAPI Server Object shape.

| Parameter | Type | Description |
|---|---|---|
| `$servers` | `array``<``mixed``>` |  |

Returns `list``<``array{url: string, description?: string}``>`
