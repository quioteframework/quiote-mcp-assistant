# Openapi

> The Quiote\\Openapi namespace — 3 documented types.

Everything under `Quiote\Openapi`.

## Classes

| Class | Description |
|---|---|
| [`OpenApiGenerator`](/api/openapi/open-api-generator/) | Derives an OpenAPI 3.1 document from things the app already declares: the routing IR says which paths and verbs exist and which action each resolves to, each action's own validators say which parameters it accepts and what they must look like (via [`ActionInputSchemaResolver`](/api/validator/compiler/json-schema/action-input-schema-resolver/), the same derivation that gives an MCP tool its `inputSchema`), the output type says what media type a successful response carries, and [`ProblemDetails`](/api/http/problem-details/) says what a failure looks like. |
| [`OpenApiOptions`](/api/openapi/open-api-options/) | The document-level knobs [`OpenApiGenerator`](/api/openapi/open-api-generator/) can't derive from code: `info`, `servers`, and which routes to describe at all. |
| [`RoutePathTemplate`](/api/openapi/route-path-template/) | A route path parsed into the shape OpenAPI wants: a template whose placeholders are bare `{name}`, plus what the placeholders' inline syntax said about them. |
