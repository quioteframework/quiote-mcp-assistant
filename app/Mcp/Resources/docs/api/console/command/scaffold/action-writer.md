# ActionWriter

> Writes the files for `make:action`: the Action class itself, and (optionally) a matching View + Template.

Writes the files for `make:action`: the Action class itself, and (optionally) a matching View + Template.

The two PHP classes follow the same "heredoc per file" convention as `AppWriter`.

The *template* is the exception: its content and extension come from the renderer the app actually configures for the `html` output type, via [`Renderer::getStarterTemplate()`](/api/renderer/renderer/#getstartertemplate) -- each renderer knows its own syntax, so this generator never hardcodes one. A PHPTAL/Twig/XSLT app gets a `.tal`/`.twig`/`.xsl` starter rather than a `.php` file full of PHP tags it would never execute.

HTTP-verb -> execute{X}() naming mirrors [`HttpMethodMapper`](/api/execution/http-method-mapper/)'s canonical map (the single source of truth ActionResolver dispatches against): GET/HEAD/OPTIONS/TRACE -> executeRead, POST -> executeWrite, PUT/PATCH -> executeUpdate, DELETE -> executeRemove. Output-type -> execute{X}() naming mirrors the `ucfirst(strtolower($name))` convention already documented on [`View`](/api/view/view/) and used by `AppWriter::viewPhp()`.

## Synopsis

`final class ActionWriter`

|  |  |
|---|---|
| Source | `Console/Command/Scaffold/ActionWriter.php` |

## Constructor

### __construct()

`public function __construct(string $appDir, string $namespace, string $moduleDir): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$appDir` | `string` |  |
| `$namespace` | `string` |  |
| `$moduleDir` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`write(string $name, list<string> $methods, bool $withView, list<string> $outputTypes, bool $force): list<string>`](#write) |  |

### write()

`public function write(string $name, list<string> $methods, bool $withView, list<string> $outputTypes, bool $force): list<string>`

output type names, e.g. ['html', 'json']

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$methods` | `list``<``string``>` | HTTP verbs, e.g. ['GET', 'POST'] |
| `$withView` | `bool` |  |
| `$outputTypes` | `list``<``string``>` | output type names, e.g. ['html', 'json'] |
| `$force` | `bool` |  |

Returns `list``<``string``>` — warnings (e.g. output types left unconfigured)
