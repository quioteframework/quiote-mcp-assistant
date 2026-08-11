# McpDirectoryResolver

> Resolves the plain-class attribute-discovery scan set: every existing `{ModuleDir}/{Module}/Mcp/` subdirectory across the app's module directory plus any plugin-contributed module directories -- mirroring the `{Module}/Actions/`, `{Module}/Validate/` per-module convention the rest of the framework already uses, scoped to a `Mcp/` subtree so this scan is cheap and doesn't also walk every action/controller class in the app.

Resolves the plain-class attribute-discovery scan set: every existing `{ModuleDir}/{Module}/Mcp/` subdirectory across the app's module directory plus any plugin-contributed module directories -- mirroring the `{Module}/Actions/`, `{Module}/Validate/` per-module convention the rest of the framework already uses, scoped to a `Mcp/` subtree so this scan is cheap and doesn't also walk every action/controller class in the app.

## Synopsis

`final class McpDirectoryResolver`

|  |  |
|---|---|
| Source | `Compiler/McpDirectoryResolver.php` |

## Methods

| Method | Description |
|---|---|
| [`resolve(iterable<string>|null $moduleDirs = null): list<string>`](#resolve) |  |

### resolve()

`public function resolve(iterable<string>|null $moduleDirs = null): list<string>`

Defaults to
       [core.module_dir, ...PluginManager::moduleDirectories()].

| Parameter | Type | Description |
|---|---|---|
| `$moduleDirs` | `iterable``<``string``>``|``null` | Defaults to [core.module_dir, ...PluginManager::moduleDirectories()]. |

Returns `list``<``string``>`
