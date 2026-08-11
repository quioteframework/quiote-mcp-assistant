# AppDirResolver

> Resolves the app directory (+ optionally the environment) for a CLI invocation.

Resolves the app directory (+ optionally the environment) for a CLI invocation.

Shared between [`AbstractAppCommand`](/api/console/command/abstract-app-command/) (which needs it once a command actually executes) and `bin/quiote`'s best-effort pre-bootstrap (which needs it before [`Application`](/api/console/application/) is even constructed, so plugin-contributed commands can appear in `list`/`--help` without the user running a command first).

Precedence: 1. `$appDirOption`/`$envOption` — an explicit `--app-dir`/`--env`. 2. `$QUIOTE_APP_DIR`/`$QUIOTE_ENV`. 3. A `.quiote.json` marker file (`{"app_dir": "...", "env": "..."}`), found by walking up from the current directory. `app_dir` is resolved relative to the marker file's own directory (or used as-is if absolute) — this is the fast, explicit path for a project whose app isn't a directory ancestor of `$CWD` (e.g. multiple apps in one repo), and the one that lets a CLI invocation know the app *before* having to guess anything. 4. An upward search from `$CWD` for the first directory containing `Config/settings.{php,xml,yaml,yml}` — the original, guess-based fallback, kept for apps with no marker file.

Returns a null `appDir` when nothing resolves rather than throwing — callers decide whether that's fatal: a real command execution needs one (see `AbstractAppCommand::bootstrapApp()`), `bin/quiote`'s opportunistic pre-bootstrap does not (no app found just means no plugin commands show up yet, exactly like today).

## Synopsis

`final class AppDirResolver`

|  |  |
|---|---|
| Source | `Console/AppDirResolver.php` |

## Methods

| Method | Description |
|---|---|
| [`resolve(?string $appDirOption = null, ?string $envOption = null): array{appDir: ?string, env: ?string}`](#resolve) |  |

### resolve()

`public static function resolve(?string $appDirOption = null, ?string $envOption = null): array{appDir: ?string, env: ?string}`

| Parameter | Type | Description |
|---|---|---|
| `$appDirOption` | `?``string` |  |
| `$envOption` | `?``string` |  |

Returns `array{appDir: ?string, env: ?string}`
