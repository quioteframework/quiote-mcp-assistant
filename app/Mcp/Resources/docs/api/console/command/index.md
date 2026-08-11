# Command

> The Quiote\\Console\\Command namespace — 16 documented types.

Everything under `Quiote\Console\Command`.

## Classes

| Class | Description |
|---|---|
| [`AboutCommand`](/api/console/command/about-command/) | Prints framework/app diagnostic info. |
| [`AbstractAppCommand`](/api/console/command/abstract-app-command/) | Base for commands that need a bootstrapped Quiote application (as opposed to `new`, which is deliberately pre-bootstrap -- see NewCommand). |
| [`CacheWarmupCommand`](/api/console/command/cache-warmup-command/) | Compiles the app's configuration ahead of time so a freshly started worker starts warm instead of paying the first-request cost of parsing/validating/ XSL-transforming every config file. |
| [`MakeActionCommand`](/api/console/command/make-action-command/) | Scaffolds an Action (and, unless --no-view, a matching View + Template) inside an existing app's Modules/{module}/ tree -- the "inside an app" counterpart to `new` scaffolding a whole app from nothing. |
| [`MakeJobCommand`](/api/console/command/make-job-command/) | Scaffolds a `Quiote\Queue\Job` implementation, optionally `Quiote\Queue\RetryableJob` for a per-job retry policy. |
| [`MakeMiddlewareCommand`](/api/console/command/make-middleware-command/) | Scaffolds a PSR-15 middleware class carrying a [`Middleware`](/api/middleware/attribute/middleware/) attribute -- app-owned classes need no explicit registration beyond that attribute, since `MiddlewareAttributeScanner` picks them up automatically. |
| [`MakeModuleCommand`](/api/console/command/make-module-command/) | Scaffolds an empty module (Actions/Views/Templates directories) -- a module has no class of its own, it's a directory convention (see `ModuleActionDiscovery`), so unlike the other `make:*` commands this one has nothing to templatize beyond the directories themselves and an optional seed Action via --with-index. |
| [`NewCommand`](/api/console/command/new-command/) | Scaffolds a new Quiote application: a Default module (Index/About/Boom actions), the minimal config set needed to boot (settings, factories, routing, output_types -- config_handlers.xml/compile.xml/translation.xml/databases.xml can all be omitted and still boot cleanly), and a FrankenPHP-ready pub/index.php. |
| [`OpenapiGenerateCommand`](/api/console/command/openapi-generate-command/) | Writes an OpenAPI 3.1 description of the app, derived from the live routing service's route collection and each action's own validator declarations -- see [`OpenApiGenerator`](/api/openapi/open-api-generator/) for what is and isn't derivable. |
| [`RoutesCompileCommand`](/api/console/command/routes-compile-command/) | Generates the `cache/introspection/app.json` artifact an editor extension reads directly (no PHP spawn) on its warm path -- routes, modules, Action/ View/Template triads, diagnostics, a dependency manifest, and shadowed- config info -- and prints the same payload to stdout. |
| [`RoutesListCommand`](/api/console/command/routes-list-command/) | Lists every route the app's actual configured Routing service knows about -- i.e. |
| [`ServeCommand`](/api/console/command/serve-command/) | Dev-server convenience wrapper: `quiote new`'s own "next steps" just tell the user to run `php -S` or `frankenphp php-server` by hand -- this runs whichever is available, and `--runtime` reaches the CLI-hosted servers too so there is one entry point for every deployment shape Quiote supports. |
| [`TelemetryDashboardCommand`](/api/console/command/telemetry-dashboard-command/) | Live monitoring for a Quiote app's OTLP telemetry. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Scaffold`](/api/console/command/scaffold/) | 3 types |
