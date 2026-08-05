# Exposing your app as an MCP server

> Turn a Quiote app into a Model Context Protocol server — actions-as-tools, attribute discovery, transports, and auth.

`quioteframework/mcp` turns a Quiote app into a [Model Context Protocol](https://modelcontextprotocol.io) server, so an AI agent can call your app's capabilities as **tools**, read its data as **resources**, and use **prompts**. It's built on the official [PHP MCP SDK](https://github.com/modelcontextprotocol/php-sdk) (`mcp/sdk`) rather than reimplementing the protocol — Quiote owns the binding (transports, DI, attribute discovery, auth), the SDK owns the wire format.

<Aside type="caution" title="Partially implemented">
This is a newer, actively-developed capability. stdio and HTTP transports, manual registration, plain-class attribute discovery (with a warmable cache), and the actions-as-tools bridge with validator-derived input schemas are implemented and tested. OAuth2 resource-server auth is implemented too. OTel spans per call, RBAC-gated tool listing, rate limiting, resource/prompt attribute discovery, and the stateless `2026-07-28` transport mode are not — see [What isn't built yet](#what-isnt-built-yet).
</Aside>

The [Quiote Assistant MCP](/getting-started/mcp-assistant/) is a full reference app built on this package — read it alongside this page if you want a complete, working example rather than just the mechanism.

## Enabling it

```bash
composer require quioteframework/mcp
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Mcp\McpPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Mcp\McpPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Mcp\McpPlugin" />
    </ae:configuration>
</ae:configurations>
```

#### PHP

```php
// Config/settings.php
'mcp.enabled' => true,
```

#### YAML

```yaml
# Config/settings.yaml
mcp.enabled: true
```

#### XML

```xml
<!-- Config/settings.xml -->
<settings prefix="mcp.">
    <setting name="enabled">true</setting>
</settings>
```

`McpPlugin` publishes every `mcp.*` default (all opt-in-safe — `mcp.enabled` itself defaults to `false`), registers the `mcp:serve`/`mcp:warmup` console commands, and — only when `http` is in `mcp.transports` — splices `McpEndpointMiddleware` (and, unless `mcp.auth = 'none'`, `McpAuthMiddleware` ahead of it) into the pipeline just before `SecurityMiddleware`. See [Settings reference](#settings-reference) for the full key set.

## Three ways to register a capability

`Quiote\Mcp\McpCatalog` is a static, process-global registry of tools/resources/prompts (the same pattern as `MiddlewareCatalog`/`DatabaseDriverRegistry`), fed from three sources:

1. **Manual registration** — any plugin's `register()` calls `McpCatalog::addTool()`/`addResource()`/`addPrompt()` directly. There's no `PluginRegistrar` convenience method for this (a generic registrar shouldn't grow a method per optional package) — depend on `quioteframework/mcp` and call `McpCatalog` yourself.
2. **Attribute discovery on plain classes** — opt in with `mcp.discover_attributes`, and Quiote scans one `{Module}/Mcp/` subdirectory per module (across `core.module_dir` plus every plugin's contributed module directories) for classes carrying the SDK's own `#[McpTool]`, `#[McpResource]`, `#[McpPrompt]`, or `#[McpResourceTemplate]` attributes — delegating the actual scan to the SDK's `Mcp\Capability\Discovery\Discoverer` rather than reimplementing attribute scanning.
3. **Existing `#[Route]` actions exposed as tools** — the headline feature, below.

### The killer feature: `#[McpTool]` on an existing action

Add the SDK's `#[McpTool]` attribute to an action that already carries `#[Route]`, and set `mcp.expose_actions = true`:

```php
<?php
namespace App\Modules\Blog\Actions;

use Mcp\Capability\Attribute\McpTool;
use Quiote\Action\Action;
use Quiote\Request\WebRequest;
use Quiote\Routing\Attribute\Route;

#[Route('/posts/{id}', name: 'post_show')]
#[McpTool(name: 'get_post', description: 'Fetch a blog post by id.')]
class PostAction extends Action
{
    public function executeRead(WebRequest $rd)
    {
        // unchanged — the same action still serves real HTTP requests
    }
}
```

`Quiote\Mcp\Compiler\ActionToolScanner` finds every route-carrying action additionally decorated with `#[McpTool]`. Each match is wired via `Quiote\Mcp\Bridge\ActionToolAdapter`, which drives a synthetic request through **`Context::handle()`** — the same entry point a real HTTP request goes through, not `ActionExecutor::execute()` directly — so the tool call gets the exact same DI resolution, verb dispatch (`executeRead`/`executeWrite`/…), and validation a normal request would get, for free. Path parameters are split from extra arguments using the route's own compiled path variables; extra arguments ride as query params (`GET`/`HEAD`) or a JSON body otherwise. A non-2xx response or any exception surfaces as a tool error (`isError: true`), not a JSON-RPC protocol error.

**A forwarded request fails the tool call.** Status alone isn't enough to tell success from failure here: a security forward renders the login or secure system action and returns **HTTP 200**, so a tool call against a protected action used to report success and hand the connected model the login page's markup as though it were the action's output — plausibly with a "session expired" narrative the model would then act on. The adapter attaches its own `ExecutionState` to the synthetic request, which the pipeline mutates in place, and raises a `ToolCallException` naming the action actually reached if the request was forwarded. Any forward fails the call, not only a security one: if the action you asked for is not the action that ran, the body is not that action's output.

### Input schema, derived from your validators

`Quiote\Validator\Compiler\JsonSchema\ValidatorSchemaMapper` turns the action's existing validator rules — scoped to whichever verb the route actually dispatches to — into the tool's `inputSchema`, so a schema-violating `tools/call` is rejected before your action ever runs:

| Validator | Maps to |
|---|---|
| String | `minLength`/`maxLength` |
| Number | `integer`/`number` + `minimum`/`maximum` |
| Email | `format: email` |
| Inarray | `enum` |
| Regex | `pattern` (positive, unflagged matches only) |
| Boolean, Json, DateTime, IsNotEmpty | mapped |
| `required` flag | reflected in the schema's `required` list |

:::note[The mapper lives in core now]
It moved from `Quiote\Mcp\Compiler\ValidatorSchemaMapper` to `Quiote\Validator\Compiler\JsonSchema\ValidatorSchemaMapper` once [OpenAPI generation](/advanced/openapi/) became a second consumer of the same derivation — validator IR to JSON Schema was never MCP-specific. The MCP class remains as a deprecated forwarding shim, so existing callers keep working; reference the core class in new code.

The resolver above it, `ActionInputSchemaResolver`, also reads **both** validator conventions — the XML file convention *and* the fluent `register{Method}Validators()` hook, [`#[MapRequest]` DTOs](/basics/validation/#request-dtos--maprequest) included — so an action that declares its input fluently gets a derived tool schema too.
:::

This is deliberately **descriptive, not a faithful re-encoding** — the schema always keeps `additionalProperties: true`, operator groups (`and`/`or`/`not`/`xor`) flatten to a union of their fields rather than `allOf`/`anyOf`, and anything unmappable (a negative/flagged regex, an unrecognized validator class) degrades to a looser description instead of being dropped. Real enforcement still happens when the action's validators run again during dispatch — this schema is a pre-dispatch filter, not a replacement for it. If an action declares no validators at all, parsing fails, or nothing describable comes out, the tool falls back to a permissive `{"type":"object","properties":{},"additionalProperties":true}` schema. Output schema, if you want one, comes through as-is from `#[McpTool(outputSchema: ...)]` — nothing is derived automatically from the route's `outputType`.

## Transports

### stdio

```bash
php bin/quiote mcp:serve
```

The default (`mcp.transports = ['stdio']`) and the simplest to ship — no HTTP surface, no auth, what a local client (Claude Desktop, an IDE) launches as a subprocess.

### Streamable HTTP

Add `'http'` to `mcp.transports` to register `Quiote\Mcp\Middleware\McpEndpointMiddleware` in the pipeline, listening on `mcp.path` (default `/mcp`). It sits *before* `SecurityMiddleware` — MCP does its own bearer/token auth, not session credentials — reads the already-parsed JSON body, and returns transport-level errors as [Problem Details](/architecture/error-handling/) with JSON-RPC error objects for protocol-level failures.

#### PHP

```php
// Config/settings.php
'mcp.transports' => ['stdio', 'http'],
```

#### YAML

```yaml
# Config/settings.yaml
mcp.transports:
  - stdio
  - http
```

#### XML

```xml
<!-- Config/settings.xml -->
<settings prefix="mcp.">
    <setting name="transports">
        <ae:parameter>stdio</ae:parameter>
        <ae:parameter>http</ae:parameter>
    </setting>
</settings>
```

Only the stateful `2025-11-25` protocol mode is implemented (`mcp.protocol_version` defaults to it); the installed SDK version's `StreamableHttpTransport` doesn't implement GET/SSE streaming at all, only `OPTIONS`/`POST`/`DELETE`. `mcp.stateless` exists as a config knob for the forthcoming stateless `2026-07-28` mode but that mode isn't implemented yet — see [What isn't built yet](#what-isnt-built-yet).

## Auth

The HTTP endpoint is safe by default: with no `mcp.auth_token` configured, `Quiote\Mcp\Auth\StaticTokenAuthenticator` **rejects every request** rather than silently allowing them through. Set a token, typically from the environment:

```php
// Config/settings.php
'mcp.auth_token' => getenv('QUIOTE_MCP_TOKEN') ?: null,
```

`mcp.auth_token` is an ordinary setting, so it can also live in `Config/settings.yaml` or `Config/settings.xml` (see [Configuration](/architecture/configuration/)) — reading it from an environment variable, as above, is a PHP idiom the other formats don't offer.

For a trusted network, or a reverse proxy that already authenticates, `mcp.auth = 'none'` is the explicit opt-out — a deliberate, last-resort override that also skips registering `McpAuthMiddleware` entirely.

### `mcp.auth = 'oauth2'`

The third mode makes the endpoint an OAuth2 **resource server**: bearer tokens are validated as JWTs against the issuer's JWKS, and RFC 9728 protected-resource metadata is served at the well-known path so a client can discover where to get a token.

| Key | Effect |
|---|---|
| `mcp.oauth.issuer` | The authorization server's issuer URL. JWKS is discovered from it via OIDC. |
| `mcp.oauth.audience` | The audience this resource server accepts. |
| `mcp.oauth.jwks_uri` | Explicit JWKS URI, when discovery isn't available or wanted. |
| `mcp.oauth.scopes_supported` | Advertised in the protected-resource metadata. |
| `mcp.oauth.cache_ttl` | How long a fetched JWKS is cached. |

This composes the MCP SDK's own OIDC discovery, JWKS provider, token validator and authorization middleware rather than adding validation code of its own, so enforcement lives inside the SDK transport's middleware stack — which is why `McpAuthMiddleware` is *not* registered in this mode. There's still no RBAC-gated tool listing; see [what isn't built yet](#what-isnt-built-yet).

## How an MCP HTTP request is handled

Over stdio there's no pipeline — `mcp:serve` runs the SDK's loop directly against standard in/out. Over **HTTP**, an MCP call is just another request through the app's [middleware pipeline](/architecture/middleware-pipeline/), so it helps to see exactly where the two MCP middlewares sit and what each does.

**How the framework registers them.** When `http` is in `mcp.transports`, `McpPlugin::register()` splices two middlewares in, both anchored `before: SecurityMiddleware` (MCP does its own bearer auth, so it must run ahead of session-based security and CSRF):

- `McpEndpointMiddleware` — registered first, so its anchor exists for the next one to reference.
- `McpAuthMiddleware` — registered only when `mcp.auth != 'none'`, anchored `before: McpEndpointMiddleware`.

Once the [topological resolver](/architecture/middleware-pipeline/#the-stack-in-order) orders the pipeline, the two land in this runtime order: **`McpAuthMiddleware` → `McpEndpointMiddleware` → `SecurityMiddleware`**.

**The path a request takes.** Both middlewares first check the request path against `mcp.path` (default `/mcp`); anything else falls straight through to normal MVC dispatch. For a request that *does* target the endpoint:

> Request enters the pipeline → parsed by `PayloadParsingMiddleware` → **`McpAuthMiddleware`** validates the `Authorization: Bearer` token via `McpAuthenticatorInterface` (default `StaticTokenAuthenticator`), returning a 401 Problem Details response on failure → **`McpEndpointMiddleware`** builds an `McpServer` and calls `handleHttp()`, which re-serialises the already-parsed body and hands it to the SDK's `Mcp\Server` over a `StreamableHttpTransport` → the SDK dispatches the JSON-RPC call to the matching **tool handler** → the response is written back.

The tool handler is either a capability you registered on `McpCatalog`, or — for an action exposed with `#[McpTool]` — the `ActionToolAdapter`, which runs the call through `Context::handle()` so it gets the *same* DI resolution, verb dispatch, and validation a real HTTP request would (see [the actions-as-tools bridge](#the-killer-feature-mcptool-on-an-existing-action) above). See [Request lifecycle](/architecture/request-lifecycle/) for the full pipeline this plugs into.

## Discovery caching

Scanning `{Module}/Mcp/` directories for attributed classes on every `McpServer::build()` is wasted work once you're past development. With `mcp.discover_attributes` on, `mcp.discovery_cache` (default `true`) backs discovery with a file-based PSR-16 cache (`Symfony\Component\Cache\Adapter\FilesystemAdapter`, under `{core.cache_dir}/mcp-discovery`), and `mcp:warmup` pre-populates it offline, ahead of a worker or process starting:

```bash
php bin/quiote mcp:warmup
```

This only affects plain-class attribute discovery — the actions-as-tools scan (`ActionToolScanner`) isn't yet covered by `cache:warmup`/`mcp:warmup` and still scans lazily per `McpServer::build()`.

## Settings reference

| Key | Default | Effect |
|---|---|---|
| `mcp.enabled` | `false` | Master switch. |
| `mcp.transports` | `['stdio']` | Any of `stdio`, `http`. |
| `mcp.path` | `'/mcp'` | HTTP endpoint path (only relevant with `http` transport). |
| `mcp.protocol_version` | `'2025-11-25'` | Advertised MCP protocol version. |
| `mcp.stateless` | `true` | Reserved for the `2026-07-28` stateless HTTP mode — not yet implemented. |
| `mcp.server_name` | `'quiote-app'` | Advertised server name. |
| `mcp.server_version` | `'1.0.0'` | Advertised server version. |
| `mcp.auth` | `'bearer'` | `'bearer'`, `'oauth2'`, or `'none'`. |
| `mcp.auth_token` | `null` | Required for `'bearer'` auth to accept any request. |
| `mcp.oauth.issuer` | `null` | `'oauth2'` only — the authorization server's issuer URL; JWKS is discovered from it. |
| `mcp.oauth.audience` | `null` | `'oauth2'` only — the audience this resource server accepts. |
| `mcp.oauth.jwks_uri` | `null` | `'oauth2'` only — explicit JWKS URI, bypassing discovery. |
| `mcp.oauth.scopes_supported` | `[]` | `'oauth2'` only — advertised in the RFC 9728 metadata. |
| `mcp.oauth.cache_ttl` | `3600` | `'oauth2'` only — how long a fetched JWKS is cached, in seconds. |
| `mcp.expose_actions` | `false` | Scan `#[Route]` actions for `#[McpTool]`. |
| `mcp.module_dirs` | `[]` | Extra scan roots; defaults to `core.module_dir` + plugin module directories. |
| `mcp.discover_attributes` | `false` | Scan plain (non-`#[Route]`) classes under `{Module}/Mcp/` for SDK attributes. |
| `mcp.discovery_cache` | `true` | Cache attribute discovery (only takes effect when `mcp.discover_attributes` is on). |

## What isn't built yet

Being direct about the gaps, since this feature is still filling in:

- **OTel spans per tool/resource/prompt call** and bridging MCP `logging` notifications to `Quiote\Logging\Log` — not implemented.
- **RBAC-gated tool listing** — a caller's roles don't yet filter which tools `tools/list` returns.
- **Rate limiting** on the HTTP endpoint — not implemented.
- **Resource/prompt attribute discovery** — attribute discovery (§ above) covers tools; resources and prompts still require manual `McpCatalog` registration.
- **Stateless HTTP (`2026-07-28`)** — `mcp.stateless` is a config placeholder; the transport itself is still stateful `2025-11-25` only.

## Verifying it works

Drive `mcp:serve` with a real MCP client, or call `McpCatalog::tools()`/`resources()`/`prompts()` directly in a test to assert what's registered. The [Quiote Assistant MCP](/getting-started/mcp-assistant/#verifying-it-works) ships real subprocess/HTTP smoke-test clients you can use as a template for testing your own server.
