# The command-line tool

> The quiote CLI — scaffold an application and its modules/actions/jobs, run a dev server, list routes, warm caches, and inspect the environment.

Quiote ships a command-line tool, `quiote`, built on Symfony Console. Its built-in commands scaffold a new application (`new`) and pieces inside one (`make:module`, `make:action`, `make:middleware`, `make:job`), run a local dev server (`serve`), list an app's routes (`routes:list`), print framework/app info (`about`), compile caches ahead of time (`routes:compile`, `cache:warmup`), and derive an API spec (`openapi:generate`). Plugins can contribute more (see [Writing your own command](#writing-your-own-command)).

## Running it

The CLI comes with the framework, so [install Quiote](/getting-started/installation/) first. Every command except `new` also needs an application to point at (see [Application-aware commands](#application-aware-commands) below); `new` runs anywhere because it only writes files.

When Quiote is installed as a dependency, the binary is at `vendor/bin/quiote`. From a checkout of the framework itself it's `bin/quiote`.

```bash
vendor/bin/quiote list          # show all available commands
vendor/bin/quiote <command> --help   # options for one command
vendor/bin/quiote --version
```

`list`, `help`, and `--version` come from Symfony Console; the Quiote-specific commands are below.

## Commands

| Command | Purpose | Needs an app? |
|---|---|---|
| `new` | Scaffold a new Quiote application | No (writes files only) |
| `serve` | Run a local development server | Yes (locates `pub/`; doesn't boot) |
| `make:module` | Scaffold a module directory tree | Yes |
| `make:action` | Scaffold an Action (and matching View/Template) | Yes |
| `make:middleware` | Scaffold a PSR-15 middleware class | Yes |
| `make:job` | Scaffold a queue `Job` class | Yes |
| `routes:list` | List routes from the app's routing service | Yes |
| `about` | Print framework and application info | Yes |
| `routes:compile` | Compile route/module introspection data into `cache/introspection/app.json` | Yes |
| `cache:warmup` | Compile and cache configuration ahead of time so workers start warm | Yes |
| `openapi:generate` | Derive an OpenAPI document from routes and validators. See [OpenAPI generation](/advanced/openapi/) | Yes |

Plugin-contributed commands — `queue:work` and `queue:failed:*` from [`quioteframework/queue`](/advanced/queues/), `schedule:run` from [`quioteframework/scheduler`](/advanced/scheduling/), `mcp:*` from [`quioteframework/mcp`](/advanced/mcp-server/) — appear in `list` once their package is installed and the plugin enabled.

### Application-aware commands

Every command except `new` and `serve` bootstraps a real application, so it needs to find one. `new` doesn't — it only writes files and never boots the framework. `serve` needs to *locate* an app (to find its `pub/` directory) but deliberately doesn't boot it, since the server process it starts will do that itself.

The app-aware commands all accept:

| Option | Default | Effect |
|---|---|---|
| `--app-dir` | `$QUIOTE_APP_DIR`, else an upward search | Path to the application directory. |
| `--env` | `$QUIOTE_ENV`, else `development` | Environment to bootstrap. |

**App-directory resolution order:** `--app-dir`, then `$QUIOTE_APP_DIR`, then a `.quiote.json` marker file (`{"app_dir": "...", "env": "..."}`) found by walking up from the current directory, then an upward search from the current directory for a `Config/settings.*` file. If none is found, the command errors and tells you to pass `--app-dir`, set `$QUIOTE_APP_DIR`, or run from inside an app directory. In practice, running the command from your project root just works.

## `new` — scaffold an application

Creates a self-contained, runnable application: a `Default` module with `Index`, `About`, `Boom`, and `Contact` actions (the last routed via a `#[Route]` attribute rather than in `AppRouting`, to demonstrate both routing styles), the config needed to boot (`settings`, `factories`, `databases`, `output_types`) plus a PHP `AppRouting` routing class, and a FrankenPHP-ready `pub/index.php`.

```bash
vendor/bin/quiote new my-app
```

| Argument / option | Default | Effect |
|---|---|---|
| `path` (argument, required) | — | Directory to create the application in. |
| `--namespace` | `App` | PSR-4 namespace prefix for the app (e.g. `App`, `SampleApp`). Must start with an uppercase letter. |
| `--config-format` | `php` | Format for the generated `settings` file: `php`, `yaml`, or `xml`. (The scaffold deliberately mixes formats: `factories` is always YAML and `databases`/`output_types` are always XML, so a generated app exercises all three config drivers.) |
| `--runtime` | — | Also scaffold an entrypoint for a persistent worker runtime: `roadrunner` (writes `worker.php` and `.rr.yaml`) or `swoole` (writes `swoole.php`). See [Deployment](/architecture/deployment/). |
| `--force`, `-f` | — | Write into a directory that already exists and is non-empty. |

```bash
# A YAML-configured app under a custom namespace
vendor/bin/quiote new ./shop --namespace Shop --config-format yaml
```

If the target directory exists and isn't empty, the command refuses unless you pass `--force`. The generated app has no `composer.json` of its own — its front controller registers a PSR-4 autoloader for its own namespace and locates a `vendor/autoload.php` that has Quiote in it.

After scaffolding, the command prints the next steps:

```bash
cd my-app
php -S localhost:8000 -t pub pub/index.php   # quick smoke test
# or, with FrankenPHP:
frankenphp php-server --root pub
```

Or let [`serve`](#serve--run-a-development-server) pick whichever of those is available for you:

```bash
cd my-app
vendor/bin/quiote serve
```

The generated app serves `GET /`, `GET /about`, `GET /contact`, and `GET /boom` — `boom` deliberately throws, so you can see error handling (set `core.developer_exceptions` true in `Config/settings.*` for the Whoops page). See [Your first application](/getting-started/your-first-app/) for a walkthrough of what it generates.

## `serve` — run a development server

`new` prints a `php -S` command for you to run by hand; `serve` runs one for you, and reaches every runtime Quiote supports through a single entry point.

```bash
vendor/bin/quiote serve
vendor/bin/quiote serve --port=9000
vendor/bin/quiote serve --runtime=roadrunner
```

| Option | Default | Effect |
|---|---|---|
| `--host` | `localhost` | Host to bind. |
| `--port` | `8000` | Port to bind. |
| `--runtime` | `auto` | Which server to run: `auto`, `frankenphp`, `php`, `roadrunner`, `swoole`. |

Under `auto`, the command looks for a `frankenphp` binary on `PATH`. If it finds one it runs `frankenphp php-server --listen {host}:{port} --root {app}/pub`; otherwise it falls back to `php -S {host}:{port} -t {app}/pub` with a note that FrankenPHP is recommended for anything beyond a quick local check, since `php -S` is single-threaded.

`--runtime` also accepts the two off-SAPI runtimes, so one command covers every [deployment shape](/architecture/deployment/):

| Runtime | Runs | Where the listen address comes from | Needs |
|---|---|---|---|
| `frankenphp` | `frankenphp php-server` | `--host` / `--port` | `frankenphp` on `PATH` |
| `php` | `php -S` | `--host` / `--port` | nothing |
| `roadrunner` | `rr serve` from the app root | **`.rr.yaml`** | `rr` on `PATH` or at `vendor/bin/rr`, plus a `.rr.yaml` |
| `swoole` | the app's `swoole.php` | **`worker.swoole.*` settings** | `ext-swoole`, plus a `swoole.php` |

For RoadRunner and Swoole, `--host`/`--port` deliberately do **not** apply — that runtime's own config owns the address — and the command says so when it starts. Each missing prerequisite is reported as a specific, actionable error (how to install the binary, or which `quiote new --runtime=…` invocation generates the missing entrypoint) rather than a generic failure.

Every branch wraps the server's own binary or the app's entrypoint script as a **child process**, never an in-process `Kernel::run()` — the console has already bootstrapped the app in its own process, so serving inline would bootstrap twice. The server runs in the foreground until Ctrl-C, like any dev server.

## Scaffolding inside an app: the `make:*` commands

Where `new` scaffolds a whole application from nothing, the four `make:*` commands scaffold *within* one that already exists. They all take the standard `--app-dir`/`--env` options plus `--force` (`-f`) to overwrite an existing file, and all validate names as PHP class-name segments before writing anything.

```bash
vendor/bin/quiote make:module Blog --with-index
vendor/bin/quiote make:action Post --module=Blog --methods=GET,POST --output-types=html,json
vendor/bin/quiote make:middleware RequestId --phase=before_action --priority=10
vendor/bin/quiote make:job SendWelcomeEmail --retryable
```

### `make:module`

A module in Quiote is a **directory convention**, not a class — so this creates the tree (`Modules/{Name}/{Actions,Views,Templates}`) rather than generating any code.

| Option | Default | Effect |
|---|---|---|
| `--with-index` | — | Also seed an `IndexAction`/View/Template trio, so the new module isn't left completely empty. Equivalent to following up with `make:action Index --methods=GET`. |
| `--force`, `-f` | — | Overwrite existing files (only meaningful with `--with-index`). |

### `make:action`

Generates the Action and, unless `--no-view`, a matching View and Template.

| Option | Default | Effect |
|---|---|---|
| `--module` | `Default` | Module to create the action in. |
| `--methods` | `GET` | Comma-separated HTTP verbs the action handles. |
| `--output-types` | `html` | Comma-separated output types the View should support. |
| `--no-view` | — | Generate only the Action — no View or Template. |
| `--force`, `-f` | — | Overwrite existing files. |

`--methods` takes real HTTP verbs (`GET`, `HEAD`, `OPTIONS`, `TRACE`, `POST`, `PUT`, `PATCH`, `DELETE`) and maps them through the same `HttpMethodMapper` convention `ActionResolver` dispatches against, so the generated methods are `executeRead()` / `executeWrite()` / `executeUpdate()` / `executeRemove()` — not `executeGet()`. An unknown verb is rejected with the supported list. See [Actions and views](/architecture/actions-and-views/).

`--output-types` maps each type to an `execute{OutputType}()` method on the generated View — `json` becomes `executeJson()`. For `json`, `xml` and `text`, the command additionally **provisions the output type into `Config/output_types.xml`** if it isn't declared yet, as a `php`-rendered `<output_type>` entry with a sensible `Content-Type`. Any other type name still gets its View method stub, plus a warning that you need to add a matching `output_types.xml` entry by hand. `--output-types` is incompatible with `--no-view` (there would be nothing to attach it to) and says so.

The generated **template** is written in the syntax of whichever renderer your app configures for `html`, via [`Renderer::getStarterTemplate()`](/advanced/custom-renderers/#optional-a-scaffold-starter-template) and that renderer's default extension — so a Twig-configured app gets `PostSuccess.twig`, not a `.php` file Twig would never execute. If the configured renderer offers no starter template, the command writes none and warns, naming the file and extension for you to author by hand.

### `make:middleware`

Generates a PSR-15 `MiddlewareInterface` class in `Middleware/`, carrying a `#[Quiote\Middleware\Attribute\Middleware]` attribute built from your ordering options.

| Option | Default | Effect |
|---|---|---|
| `--phase` | `before_action` | One of `bootstrap`, `pre_routing`, `pre`, `routing`, `before_action`, `action`, `after_action`, `finalize`. |
| `--priority` | `0` | Ordering priority within the phase. |
| `--after` | — | Run after this middleware class/name. |
| `--before` | — | Run before this middleware class/name. |
| `--force`, `-f` | — | Overwrite an existing file. |

There is no separate registration step: attribute scanning picks up app-owned middleware automatically. See [Writing custom middleware](/advanced/custom-middleware/).

### `make:job`

Generates a `Quiote\Queue\Job` implementation in `Jobs/` — just a `handle()` method — or, with `--retryable`, a `Quiote\Queue\RetryableJob` that also stubs `maxAttempts()` and `backoffSeconds(int $attempt)`.

| Option | Default | Effect |
|---|---|---|
| `--retryable` | — | Implement `RetryableJob` instead of `Job`, for a per-job retry policy. |
| `--force`, `-f` | — | Overwrite an existing file. |

If [`quioteframework/queue`](/advanced/queues/) isn't installed, the command still writes the file but notes inline that the generated class won't autoload until you `composer require` the package.

## `routes:list` — list routes

Lists every route the app's configured routing service knows about — whatever the class named for the `routing` factory role exposes, whether declared in `Routing::build()`, via `#[Route]` attributes, or both merged together. It is a read-only view of the live result, not a second opinion. See [Routing](/basics/routing/).

```bash
vendor/bin/quiote routes:list
```

```
 Name    Path          Methods  Module   Action   Output type  Source
 ------- ------------- -------- -------- -------- ------------ ----------
 index   /             ANY      Default  Index                 File
 about   /about        ANY      Default  About                 File
 contact /contact      GET      Default  Contact               Attribute
```

Columns:

- **Methods** — the HTTP methods the route accepts, or `ANY` if unrestricted.
- **Source** — `Attribute` if the route's name was declared via a `#[Route]` attribute, `File` for anything else (`Routing::build()`, a programmatic builder, and so on).

Options (in addition to `--app-dir` / `--env`):

| Option | Default | Effect |
|---|---|---|
| `--context` | `core.default_context`, else `web` | Context to resolve the routing service from. |
| `--module` | — | Only show routes for this module (case-insensitive). |
| `--action` | — | Only show routes resolving to this action (case-insensitive). |
| `--sort` | `name` | Sort by `name`, `path`, `module`, or `action`. |
| `--json` | — | Output JSON instead of a table. |

```bash
vendor/bin/quiote routes:list --module Blog --sort path
vendor/bin/quiote routes:list --json
```

**Diagnostics and exit code:** the command independently scans `#[Route]` attributes and reports authoring problems (e.g. duplicate route names or paths) as warnings or errors above the table. If any diagnostic is an error, the command exits non-zero — useful in CI to catch route conflicts.

## `about` — framework and app info

Bootstraps the app and prints a short diagnostic table: Quiote version, application directory, environment, module directory, and namespace prefix.

```bash
vendor/bin/quiote about
```

It takes the standard `--app-dir` / `--env` options and nothing else. It's the simplest way to confirm the CLI can locate and boot your application.

## `cache:warmup` — precompiling config and routing

Compiles the app's configuration ahead of time so a freshly started worker doesn't pay the first-request cost of parsing, validating and XSL-transforming every config file.

```bash
vendor/bin/quiote cache:warmup
vendor/bin/quiote cache:warmup --check     # CI guard: verify, don't write
```

| Option | Default | Effect |
|---|---|---|
| `--context` | `core.default_context`, else `web` | Context to warm. |
| `--check` | — | Verify the compiled routing matcher is up to date **without writing**, and exit non-zero on drift. |

It warms three things:

1. **Compiled config** — every default config file (`settings`, `factories`, `output_types`, `databases`, `translation`, …). Optional files that are simply absent are reported as skipped, not as errors.
2. **The routing IR** — `AttributeRouteScanner`'s scan result, so `AttributeRouting::build()` can skip the live `#[Route]` scan. Only applies to attribute-based routing, and is skipped with a note otherwise.
3. **The compiled route matcher**.

The config backend is auto-detected the same way the runtime picks it: if `QUIOTE_USE_APCU_CONFIG_CACHE` is defined and true, the APCu path runs; otherwise the on-disk cache under `{app_dir}/cache/config` is populated. APCu is per-process shared memory, so warming it from a detached CLI (where `apc.enable_cli` is typically `0`) doesn't help — warm the file backend there and let the worker's `QUIOTE_APCU_PREWARM` hydrate APCu at boot.

Running this on every deploy is what makes the two production trust switches safe to enable — see [`core.config_check_freshness` and `core.routing.trust_compiled_ir`](/architecture/settings-reference/#trusting-compiled-artifacts-in-production). `--check` in CI catches a compiled matcher that has drifted from the source routes.

## Writing your own command

Because the CLI is Symfony Console, a custom command is a standard Symfony `Command`. The one Quiote-specific piece is the base class `Quiote\Console\Command\AbstractAppCommand`, which handles bootstrapping a real application so your command has access to config, the context, and the DI container.

```php
<?php
declare(strict_types=1);

namespace App\Console;

use Quiote\Config\Config;
use Quiote\Context;
use Quiote\Console\Command\AbstractAppCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\{InputInterface, InputOption};
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'cache:prune', description: 'Prune expired cache entries')]
final class PruneCacheCommand extends AbstractAppCommand
{
    protected function configure(): void
    {
        $this->configureAppOptions();   // adds --app-dir and --env
        $this->addOption('context', null, InputOption::VALUE_REQUIRED, 'Context to use', 'web');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->bootstrapApp($input);    // Config + Context now available
        $io = new SymfonyStyle($input, $output);

        $context = Context::getInstance((string) $input->getOption('context'));
        // resolve services via $context->getContainer()->get(...), read Config::get(...), etc.

        $io->success('Done.');
        return self::SUCCESS;
    }
}
```

The essentials:

- **`#[AsCommand(name:, description:)]`** names the command (this is also how it's de-duplicated).
- **`configure()`** — call `$this->configureAppOptions()` to get the standard `--app-dir` / `--env`, then add your own arguments and options.
- **`bootstrapApp($input)`** — call this first in `execute()`. It resolves the app directory, reads `--env`, boots the framework, and registers a fallback autoloader for your app's namespace. After it returns, `Config::get()` and `Context::getInstance()` work.
- **`execute()`** returns `self::SUCCESS` or `self::FAILURE`. Use `SymfonyStyle` for tables, titles, and status output.

A command that only writes files and never needs the framework (like a scaffolder) can extend Symfony's `Command` directly and skip `bootstrapApp()`.

### Registering the command

There is no directory scan for commands — you contribute yours through a [plugin](/architecture/plugins/), with `PluginRegistrar::command()`:

```php
$registrar->command(\App\Console\PruneCacheCommand::class);
```

Once a plugin registers it, the CLI picks it up (after the app is bootstrapped) and `vendor/bin/quiote cache:prune` runs. This is the same seam plugins use to ship their own commands, so an authentication or health-check plugin can add commands to your CLI without you wiring anything.
