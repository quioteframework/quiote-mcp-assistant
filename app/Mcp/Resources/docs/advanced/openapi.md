# Generating an OpenAPI spec

> Deriving an OpenAPI 3.1 document from the route table and each action's validators with openapi:generate — what is derived, what deliberately isn't, and the core.openapi.* settings.

`quiote openapi:generate` writes an **OpenAPI 3.1** description of your application. The point is what it *doesn't* ask of you: the document is **derived**, not maintained. There is no second, hand-written description of your API sitting next to the code, waiting to drift from it.

Every part of the document comes from something the app already declares:

| Part of the document | Derived from |
|---|---|
| Paths and verbs | The route table |
| Which action handles each operation | The route's own action resolution |
| Parameters and request bodies | Each action's **validators** |
| Success response media type | The route's output type |
| Error responses | `Quiote\Http\ProblemDetails` |
| Operation summary/description | The action class's docblock |

Add a route, and it appears. Add a validator, and the parameter appears with its constraints. Delete an action, and its operation disappears. Nothing has to be remembered.

```bash
vendor/bin/quiote openapi:generate -o openapi.json
```

## What is and isn't described

The generator is deliberately conservative — the document is meant to be *honest*, not to look more complete than it is. Four limits are worth knowing before you publish the output.

**Response bodies aren't described.** An action returns a view name and the view renders whatever it likes, so there is nothing to derive. Each success response states its **media type** and leaves the schema unconstrained. If you need described response schemas, you'll need to merge them in after generation.

**An action with no validators contributes an operation with no parameters** beyond its path placeholders. That is absence of *knowledge*, not a claim that the operation accepts nothing — and the distinction matters, because the honest alternative (guessing) is worse. Declare validators and the parameters appear.

**Optional path placeholders become required path parameters.** Symfony's `/list/{page?1}` syntax has no OpenAPI equivalent — the spec has no notion of an optional path parameter at all — so it is emitted as a required path parameter carrying that default.

**Action docblocks become operation prose.** By default each action class's docblock becomes its operation summary and description. This *publishes developer prose*, which is fine if your docblocks read as API documentation and unhelpful if they read as internal notes. Turn it off with `core.openapi.use_action_docblocks: false` or `--no-docblocks`.

### Where parameters land

Which validator-described parameter becomes what follows what the pipeline actually reads:

- A parameter whose name is a **path placeholder** becomes a path parameter.
- On the bodyless verbs (`GET`, `HEAD`, `DELETE`, `OPTIONS`, `TRACE`), the rest become **query** parameters.
- On the others they become a **`requestBody`**, offered as both `application/json` and `application/x-www-form-urlencoded` — because [`PayloadParsingMiddleware`](/architecture/middleware-reference/#payloadparsingmiddleware) parses both into the same request parameters, so both are genuinely accepted.

### Error responses

With `core.openapi.problem_responses` on (the default), the generator emits the [RFC 9457](https://www.rfc-editor.org/rfc/rfc9457) error responses the pipeline actually returns — a 400 wherever an action declares validators, and a 500 always — plus a `ProblemDetails` component schema they reference. See [Error handling](/architecture/error-handling/).

## The command

```bash
quiote openapi:generate                          # JSON to stdout
quiote openapi:generate -o openapi.yaml          # format inferred from the extension
quiote openapi:generate --format=yaml
quiote openapi:generate --module=Orders --exclude='internal.*'
quiote openapi:generate --title='Orders API' --api-version=2.1.0 \
  --server=https://api.example.com --server=https://staging.example.com
quiote openapi:generate --no-docblocks
```

Alongside the standard `--app-dir`/`--env`:

| Option | Effect |
|---|---|
| `--context` | Context to resolve the routing service from (defaults to `core.default_context`, else `web`). |
| `--output`, `-o` | Write to this file instead of stdout. |
| `--format` | `json` or `yaml`. Defaults to the `--output` extension, else `json`. |
| `--title` | Overrides `core.openapi.title`. |
| `--api-version` | Overrides `core.openapi.version`. |
| `--server` | Server URL. Repeatable; overrides `core.openapi.servers`. |
| `--module` | Only describe this module's routes. Repeatable. |
| `--exclude` | `fnmatch()` pattern of route names to leave out. Repeatable. |
| `--no-docblocks` | Don't use action docblocks as operation summaries/descriptions. |

The overrides exist for a CI job that publishes one spec per server or per module from the same codebase; the settings below are the app's own defaults.

Two behaviours worth knowing:

- It reads routes from the app's **configured routing service** — the same way [`routes:list`](/getting-started/cli/#routeslist--list-routes) does — so file-declared and `#[Route]`-declared routes are described alike, and the two commands never disagree about which routes exist.
- Diagnostics (for instance, two routes claiming the same path and verb) are only printed when `--output` is used. Without it, stdout holds the document and nothing else.

## Settings

Set these under `core.openapi.` in your app's settings file. They only affect the generated document — nothing here changes runtime behaviour.

| Key | Default | Effect |
|---|---|---|
| `core.openapi.title` | `core.app_name`, else `API` | `info.title`. |
| `core.openapi.version` | `1.0.0` | `info.version` — your API's version, not the framework's. |
| `core.openapi.description` | *(unset)* | `info.description`. |
| `core.openapi.servers` | `[]` | Server URLs. Either a bare list of URLs or a list of `{url, description}` maps. |
| `core.openapi.exclude_routes` | `[]` | `fnmatch()` patterns of route names to leave out (e.g. `internal.*`). |
| `core.openapi.modules` | `[]` | Only describe these modules (case-insensitive). Empty means all. |
| `core.openapi.problem_responses` | `true` | Emit the RFC 9457 error responses plus the `ProblemDetails` component schema. |
| `core.openapi.use_action_docblocks` | `true` | Use each action class's docblock as its operation summary/description. |

#### PHP

```php
// Config/settings.php
'core.openapi.title'          => 'Orders API',
'core.openapi.version'        => '2.1.0',
'core.openapi.servers'        => ['https://api.example.com'],
'core.openapi.exclude_routes' => ['internal.*', 'health'],
```

#### YAML

```yaml
# Config/settings.yaml
core.openapi.title: Orders API
core.openapi.version: '2.1.0'
core.openapi.servers:
  - https://api.example.com
core.openapi.exclude_routes:
  - 'internal.*'
  - health
```

#### XML

```xml
<!-- Config/settings.xml -->
<settings prefix="core.openapi.">
  <setting name="title">Orders API</setting>
  <setting name="version">2.1.0</setting>
</settings>
```

## One declaration, three consumers

The parameter half of the document comes from `Quiote\Validator\Compiler\JsonSchema\ActionInputSchemaResolver`, which turns an action's validators into a JSON Schema. That is the **same** derivation that gives an [MCP tool its `inputSchema`](/advanced/mcp-server/), reading both validator conventions — the `{module}/Validate/{action}.xml` file convention and the fluent `register{Method}Validators()` hook, [`#[MapRequest]` DTOs](/basics/validation/#request-dtos--maprequest) included.

So one validator declaration drives three things at once: HTTP request validation, the MCP tool schema, and the OpenAPI operation. They cannot disagree, because there is only one of them.

:::note[`Quiote\Mcp\Compiler\ValidatorSchemaMapper` has moved]
The mapper now lives in core, as `Quiote\Validator\Compiler\JsonSchema\ValidatorSchemaMapper` — validator IR to JSON Schema was never MCP-specific, and OpenAPI generation is a second consumer of it. The MCP class remains as a deprecated forwarding shim, so nothing breaks, but reference the core class in new code.
:::
