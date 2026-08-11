# OpenApiGenerator

> Derives an OpenAPI 3.1 document from things the app already declares: the routing IR says which paths and verbs exist and which action each resolves to, each action's own validators say which parameters it accepts and what they must look like (via ActionInputSchemaResolver, the same derivation that gives an MCP tool its `inputSchema`), the output type says what media type a successful response carries, and ProblemDetails says what a failure looks like.

Derives an OpenAPI 3.1 document from things the app already declares: the routing IR says which paths and verbs exist and which action each resolves to, each action's own validators say which parameters it accepts and what they must look like (via [`ActionInputSchemaResolver`](/api/validator/compiler/json-schema/action-input-schema-resolver/), the same derivation that gives an MCP tool its `inputSchema`), the output type says what media type a successful response carries, and [`ProblemDetails`](/api/http/problem-details/) says what a failure looks like.

Nothing here is a second, hand-maintained description of the API that can drift from it.

Which request parameters land where follows what the pipeline actually reads: a validator-described parameter whose name is a path placeholder becomes a path parameter; on verbs that carry no body (GET/HEAD/DELETE/ OPTIONS/TRACE) the rest become query parameters; on the others they become a requestBody, offered as both `application/json` and `application/x-www-form-urlencoded` because [`PayloadParsingMiddleware`](/api/middleware/payload-parsing-middleware/) parses both into the same request parameters.

Deliberate limits, so the document stays honest rather than looking more complete than it is: - Response *bodies* aren't described. An action returns a view name and the view renders whatever it likes, so there is nothing to derive; the schema is left unconstrained and only the media type is stated. - An action without validators contributes an operation with no parameters beyond its path placeholders -- absence of a declaration is reported as absence of knowledge, not as "accepts nothing". - Symfony's optional path placeholders (`/list/{page?1}`) are emitted as required path parameters carrying that default, because OpenAPI has no optional path parameter at all.

## Synopsis

`final class OpenApiGenerator`

|  |  |
|---|---|
| Since | `1.2.5` |
| Source | `Openapi/OpenApiGenerator.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `CODE_DUPLICATE_OPERATION` | `'DUPLICATE_OPENAPI_OPERATION'` |  |
| `OPENAPI_VERSION` | `'3.1.0'` |  |
| `PROBLEM_SCHEMA_NAME` | `'ProblemDetails'` |  |

## Constructor

### __construct()

`public function __construct(?ActionInputSchemaResolver $schemas = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$schemas` | `?`[`ActionInputSchemaResolver`](/api/validator/compiler/json-schema/action-input-schema-resolver/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`generate(array<RouteDefinition> $routes, Controller $controller, ?OpenApiOptions $options = null): array<string, mixed>`](#generate) |  |
| [`getDiagnostics(): array<Diagnostic>`](#getdiagnostics) |  |

### generate()

`public function generate(array<RouteDefinition> $routes, Controller $controller, ?OpenApiOptions $options = null): array<string, mixed>`

Typically [`RouteCollectionIntrospector`](/api/routing/compiler/route-collection-introspector/)'s
       view of the live route collection, so file-declared routes are
       described alongside `#[Route]`-declared ones.

| Parameter | Type | Description |
|---|---|---|
| `$routes` | `array``<`[`RouteDefinition`](/api/routing/compiler/route-definition/)`>` | Typically [`RouteCollectionIntrospector`](/api/routing/compiler/route-collection-introspector/)'s view of the live route collection, so file-declared routes are described alongside `#[Route]`-declared ones. |
| `$controller` | [`Controller`](/api/controller/controller/) |  |
| `$options` | `?`[`OpenApiOptions`](/api/openapi/open-api-options/) |  |

Returns `array``<``string``, ``mixed``>` — The OpenAPI document, ready for json_encode()/Yaml::dump().

### getDiagnostics()

`public function getDiagnostics(): array<Diagnostic>`

Returns `array``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>` — Diagnostics recorded during the last generate().
