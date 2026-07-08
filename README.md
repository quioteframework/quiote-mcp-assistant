# Quiote Assistant MCP

[![CI](https://github.com/quioteframework/quiote-mcp-assistant/actions/workflows/ci.yml/badge.svg)](https://github.com/quioteframework/quiote-mcp-assistant/actions/workflows/ci.yml)
[![codecov](https://codecov.io/gh/quioteframework/quiote-mcp-assistant/graph/badge.svg)](https://codecov.io/gh/quioteframework/quiote-mcp-assistant)
[![Latest release](https://img.shields.io/github/v/release/quioteframework/quiote-mcp-assistant)](https://github.com/quioteframework/quiote-mcp-assistant/releases)
[![PHP](https://img.shields.io/badge/php-%3E%3D8.5-777bb4)](composer.json)
[![PHPStan level 9](https://img.shields.io/badge/phpstan-level%209-brightgreen)](phpstan.neon)
[![License: MIT](https://img.shields.io/github/license/quioteframework/quiote-mcp-assistant)](LICENSE)

An MCP server that gives an AI agent (Claude Code, Cursor, GitHub Copilot, …) authoritative
knowledge of the [Quiote](https://github.com/quioteframework/quiote) PHP framework, plus
tools to introspect and scaffold code in a real Quiote app. It's built **as a Quiote app**
itself, dogfooding the framework's own app-as-MCP-server capability.

Point it at nothing and you get a documentation/reference assistant. Point it at a project
with `--target-app-dir` and you also get tools that inspect that project's routes, config,
plugins, and database connections, and can scaffold new modules/actions/plugins/connections.

## Quick start

```bash
composer install

# Bundle the Quiote docs into MCP resources (one-time, or whenever the docs change).
php bin/quiote-assistant mcp:docs:sync --source=/path/to/quioteframework.github.io/src/content/docs

# Serve over stdio — knowledge tools only (no project to introspect yet).
php bin/quiote-assistant

# ...or point it at a Quiote app to unlock the project-aware tools too:
php bin/quiote-assistant --target-app-dir=/path/to/your/project
```

The server speaks MCP over stdio by default — it's meant to be launched by a client as a
subprocess, not run standalone in a terminal for interactive use.

## Connect a client

All of these launch `bin/quiote-assistant` as a stdio subprocess. Add
`--target-app-dir=/path/to/your/project` to any command/args list below to enable the
project-aware tools.

If you omit `--target-app-dir`, it falls back to `Quiote\Console\AppDirResolver` -- the same
discovery `vendor/bin/quiote` itself uses: a `.quiote.json` marker (`{"app_dir": "relative/or/absolute/path"}`)
found by walking up from the client's launch directory, or (failing that) the nearest ancestor
directory containing `Config/settings.{php,xml,yaml,yml}`. This means a client that launches the
server with the workspace root as its working directory can skip the explicit flag entirely if
that workspace already has (or you add) a `.quiote.json` -- handy when the app directory isn't the
workspace root itself (e.g. `{"app_dir": "src/MyApp"}`) and you'd otherwise have to hardcode and
maintain that absolute path in the client config by hand. An explicit `--target-app-dir` always
takes precedence over this discovery.

<details open><summary><strong>Claude Code</strong></summary>

```bash
claude mcp add quiote -- php /abs/path/to/quiote-mcp-assistant/bin/quiote-assistant --target-app-dir=.
```

...or a project-scoped `.mcp.json`:

```jsonc
{ "mcpServers": {
    "quiote": {
      "command": "php",
      "args": ["/abs/path/to/quiote-mcp-assistant/bin/quiote-assistant", "--target-app-dir=/path/to/your/project"]
    }
} }
```

</details>

<details><summary><strong>Cursor</strong></summary>

`.cursor/mcp.json` (project-scoped) or the global `~/.cursor/mcp.json`:

```jsonc
{ "mcpServers": {
    "quiote": {
      "command": "php",
      "args": ["/abs/path/to/quiote-mcp-assistant/bin/quiote-assistant", "--target-app-dir=/path/to/your/project"]
    }
} }
```

</details>

<details><summary><strong>GitHub Copilot (VS Code Chat)</strong></summary>

`.vscode/mcp.json`:

```jsonc
{ "servers": {
    "quiote": {
      "type": "stdio",
      "command": "php",
      "args": ["/abs/path/to/quiote-mcp-assistant/bin/quiote-assistant", "--target-app-dir=/path/to/your/project"]
    }
} }
```

Copilot Chat only calls MCP tools in **Agent mode** — switch the mode dropdown next to the
chat input before asking it to do anything, otherwise it'll fall back to its own built-in
file-search tools and ignore the server entirely.

</details>

<details><summary><strong>GitHub Copilot CLI</strong></summary>

A project-scoped `.mcp.json` (same shape as Claude Code's, above) is picked up automatically.
Run `/mcp` inside the CLI to confirm the server shows as connected and see its tool count.

</details>

### Over HTTP instead (shared/team deployments)

```jsonc
{ "mcpServers": {
    "quiote": {
      "type": "http",
      "url": "https://your-host/mcp",
      "headers": { "Authorization": "Bearer YOUR_TOKEN" }
    }
} }
```

See [HTTP transport](#http-transport) below for how to actually run it that way.

## Run it as a standalone PHAR

No PHP source checkout needed at runtime — build once, ship one file:

```bash
bin/build-phar
php build/quiote-assistant.phar --target-app-dir=/path/to/your/project
```

Use the built `.phar` in place of `bin/quiote-assistant` in any of the client configs above.
Run `mcp:docs:sync` *before* building — the docs are baked into the archive at build time,
not regenerated at runtime.

## Run it via Docker

Bundles its own PHP 8.5 + every extension needed, so there's nothing to install locally at
all — useful if getting a matching local PHP set up (e.g. under WSL) is more trouble than
it's worth:

```bash
docker build -t quiote-assistant .

# Knowledge tools only:
docker run -i --rm quiote-assistant

# Project-aware tools too -- mount the project at a fixed path and point
# --target-app-dir at that path (not the host path, which doesn't exist
# inside the container). --user avoids scaffolded files coming out
# root-owned on the host.
docker run -i --rm \
  --user "$(id -u):$(id -g)" \
  -v /path/to/your/project:/target \
  quiote-assistant --target-app-dir=/target
```

Client config is the same shape as everywhere above, just with `docker` as the command:

```jsonc
{ "mcpServers": {
    "quiote": {
      "command": "docker",
      "args": [
        "run", "-i", "--rm", "--user", "1000:1000",
        "-v", "/path/to/your/project:/target",
        "ghcr.io/quioteframework/quiote-mcp-assistant:latest",
        "--target-app-dir=/target"
      ]
    }
} }
```

(Replace `1000:1000` with your actual `uid:gid` — client configs can't run `$(id -u)` for
you.) Pre-built images are published on tagged releases to
`ghcr.io/quioteframework/quiote-mcp-assistant`, tagged both `:latest` and `:vX.Y.Z`.

The image only ships `pdo_sqlite` (bundled with the base PHP image) as a PDO driver, not
`pdo_mysql`/`pdo_pgsql` — none of the project-aware tools open a real database connection
(`list_db_connections` only parses `databases.xml` for metadata, `run_console`'s whitelist
never touches the DB, and `Database::connect()` is lazy on first query). Quiote itself
doesn't stop an app from eagerly connecting somewhere in its own bootstrap, though — it's a
"do whatever you want" framework, not a walled garden — so if your target app's bootstrap
path is unusual enough to open a MySQL/Postgres connection eagerly, add the matching
`docker-php-ext-install` line to the `Dockerfile` yourself.

## HTTP transport

For a team to share one running instance instead of one subprocess per client, `mcp.transports`
includes `'http'` (`app/Config/settings.php`), which registers `POST /mcp` on the app's normal
PSR-7 front controller. Bearer auth is on by default and safe when unconfigured — an
unset/empty `mcp.auth_token` rejects every request rather than silently disabling auth:

```bash
QUIOTE_ASSISTANT_MCP_TOKEN=$(openssl rand -hex 32) php -S 0.0.0.0:8080 app/pub/index.php
```

> **Note:** MCP's HTTP mode is session-based — the `Mcp-Session-Id` header from `initialize`
> must be sent on every later request, and that session lives in PHP process memory. A plain
> `php -S` / PHP-FPM / CGI deployment starts a fresh process per request, so sessions won't
> survive between calls. A real deployment needs a persistent-worker runtime (e.g.
> [FrankenPHP](https://frankenphp.dev/) worker mode) or a shared session store.

## What it exposes

### Resources

Every bundled Quiote doc is exposed as one MCP resource, readable with `resources/read`
(e.g. `quiote-docs://basics/routing`, `quiote-docs://architecture/plugins`, …). Use
`search_docs` to find the right URI rather than guessing it.

### Knowledge tools (always available)

| Tool | Description |
| --- | --- |
| `search_docs(query, limit?)` | Ranked full-text search across the docs, returning excerpts + the resource URI to cite. |
| `get_convention(topic)` | A concise convention card. Topics: `actions`, `routing`, `config`, `di`, `plugins`, `database`, `validation`, `mcp`. |
| `get_recipe(task)` | Step-by-step instructions + runnable code for a concrete task. Tasks: `read-only-action`, `multi-output-view`, `form-action`, `add-plugin`, `add-database-connection`, `expose-action-as-tool`, `register-mcp-tool`. |
| `describe_symbol(symbol)` | Reflection-based signature + docblock for a `Quiote\*` class/interface/trait/enum, or `Class::method` for one method. |
| `list_api(namespace?, limit?)` | Browse the `Quiote\*` namespace tree; omit `namespace` to list top-level namespaces. |

### Project-aware tools (only when launched with `--target-app-dir`)

Read-only:

| Tool | Description |
| --- | --- |
| `project_info()` | Environment, default context, enabled plugins, module list. |
| `overview()` | Routes + modules + Action/View/Template triads + diagnostics + shadowed-config info, all from one app bootstrap. Prefer this over calling `list_routes`/`list_modules`/`describe_action` separately when you need more than one of them. |
| `diagnostics()` | Every problem this app can find in one call: routing (missing action class, duplicate route), triad (missing view/template), and config (syntax/semantic/schema errors, shadowed configs) — one flat list sharing a single `{severity, code, message, file, line, ...}` shape. |
| `list_routes(module?, action?)` | Every route the target app's live `RouteCollection` resolves with (attribute-routed and programmatic), plus the action class `file`/`line` per route and a top-level `diagnostics` array. Filter server-side to one module and/or action (e.g. `module: "Library"`) instead of fetching everything on a large app. |
| `describe_action(action)` | Verbs (each with its validator-derived input schema and source `line`), credentials, default view, and the resolved `viewFile`/`templateFile` for `"Module.Action"`. |
| `list_db_connections()` | Adapter class + parameter *names* only — never parameter values (DSNs/credentials are never disclosed). |
| `list_plugins()` | Plugins registered during the target app's bootstrap. |
| `list_modules()` | Module names discovered under the target app's module directory. |
| `read_config(key?)` | One setting, restricted to an explicit allowlist (never secrets like `mcp.auth_token`). Omit `key` to see the allowlist. |
| `validate_config(key?)` | Validates the target app's config files — syntax (per-format, with line numbers), semantic (the real config handler's own compilation), and array-shape schema checks — format-agnostically across PHP/YAML/XML. Omit `key` to validate every known config type (`settings`, `factories`, `databases`, `output_types`, `rbac_definitions`, `translation`, `plugins`, `middleware`). |

Scaffolding + console (`dry_run` defaults to `true` on every write tool — it returns a diff and
writes nothing until you pass `dry_run=false`; none of them ever overwrite an existing file):

| Tool | Description |
| --- | --- |
| `scaffold_module(module, dry_run?)` | New module skeleton — an `Index` action + view + template. |
| `scaffold_action(module, action, verbs?, formats?, dry_run?)` | New action + view + template(s), with a `#[Route]` attribute. `verbs` is one or more of `read`/`write`/`update`/`remove`. `formats` (default `["html"]`) is one or more output types the view should serve, e.g. `["html", "json"]` — each gets its own `execute<Format>()` method; a format not yet declared in `Config/output_types.xml` is reported back as a ready-to-paste snippet. |
| `scaffold_plugin(name, dry_run?)` | New plugin class. Never auto-registers it in `Config/settings.*` — the response tells you the one line to add. |
| `scaffold_db_connection(name, driver?, dry_run?)` | New `Config/databases.xml` if one doesn't exist yet, otherwise a ready-to-paste snippet. `driver` is one of `pdo`/`eloquent`/`doctrine`/`doctrine_dbal`/`cycle`. |
| `run_console(command, args?)` | Runs one of the target app's own console commands, restricted to a non-destructive whitelist (`about`, `routes:list`, `cache:warmup`); unlisted commands or options are refused. |

### Prompts

Parameterized templates that stitch together the right convention card + recipe:

| Prompt | Description |
| --- | --- |
| `new-module` | Guidance + a checklist for adding a new module. |
| `add-action` | Guidance for adding a new action (verbs/validators/view) to a module. |
| `add-service` | Guidance for adding a DI-resolved service/model. |
| `add-plugin` | Guidance for writing a plugin that contributes via `PluginRegistrar`. |
| `add-db-connection` | Guidance for declaring a new database connection. |
| `expose-mcp-tool` | Guidance for exposing an existing `#[Route]` action as an MCP tool. |

## Running tests

```bash
composer test       # PHPUnit: unit tests (pure logic) + integration tests (self-bootstrapped app)
composer phpstan     # static analysis, level 9
```

`tests/Unit/` covers pure logic in isolation (doc search ranking, scaffold code generation --
every generated file is linted with a real `php -l`, not just string-matched -- the console
command allowlist, the scaffold-writer's never-overwrite guarantee, framework reflection, and
the hand-authored convention cards/recipes). `tests/Integration/` bootstraps this app itself
(the same self-targeting `tools/mcp-smoke-client.php` already relies on) to test the
introspection capabilities against a real, live `Context` rather than a mock. Both suites
test failure paths deliberately, not just the happy path -- rejected/malformed input,
permission failures, unknown symbols, and the security-critical `read_config` allowlist
refusal are all exercised for real, not just asserted never to happen.

`composer test` requires a coverage driver (PCOV or Xdebug) to also emit a coverage report --
without one, tests still run, just without the report. Output goes to `build/coverage/`
(`html/index.html` for a browsable report, `clover.xml` for tooling); a summary also prints
to the terminal. The release workflow uploads this as a build artifact on every run.

## Verifying a local build

```bash
php tools/mcp-smoke-client.php                              # knowledge + project-aware tools, self-targeting this repo's app/
php tools/mcp-smoke-client-scaffold.php /path/to/scratch/app # scaffolding + run_console, against a throwaway app (never this repo's app/)
php tools/mcp-http-smoke-client.php                          # HTTP transport: auth + a full session-based conversation
```

Each drives the server as a real MCP client would (`initialize` → `tools/list`/`tools/call`).
The PHAR is verified the same way, just pointed at the built archive instead of
`bin/quiote-assistant`.

## Further reading

The doc comments throughout `app/Mcp/` cover the design decisions and internals (why
project-aware tools run in an isolated subprocess, how the PHAR handles read-only-archive
constraints, etc.) if you're extending this server rather than just using it.
