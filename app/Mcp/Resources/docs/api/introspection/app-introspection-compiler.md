# AppIntrospectionCompiler

> Builds the versioned `cache/introspection/app.json` artifact an editor extension reads directly, with no PHP spawn, on its warm path: routes, modules, Action/View/Template triads, diagnostics, a dependency manifest, and shadowed-config info.

Builds the versioned `cache/introspection/app.json` artifact an editor extension reads directly, with no PHP spawn, on its warm path: routes, modules, Action/View/Template triads, diagnostics, a dependency manifest, and shadowed-config info.

`Quiote\Console\Command\RoutesCompileCommand` is the only writer; this class does the actual compilation so a future probe/`overview` capability elsewhere can reuse it verbatim.

Only single-file, one-per-app config types are checked for shadowing here, matching the config validator's own scope.

## Synopsis

`final class AppIntrospectionCompiler`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Introspection/AppIntrospectionCompiler.php` |

## Constructor

### __construct()

`public function __construct(TriadViewResolver $views = new TriadViewResolver(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$views` | [`TriadViewResolver`](/api/routing/compiler/triad-view-resolver/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`compile(string $context): array{_schema_version: int, source_hash: string, config_format: ?string, modules: list<array{name: string, dir: string, actions: list<string>}>, routes: list<array{name: string, path: string, methods: list<string>, module: string, action: string, outputType: ?string, source: string, file: ?string, line: ?int}>, triads: list<array{module: string, action: string, actionFile: string, viewFile: ?string, templateFiles: array<string, string>, verbs: list<array{name: string, line: ?int}>}>, diagnostics: list<array{severity: string, code: string, message: string, file: string, line: ?int, column: ?int, endLine: ?int, endColumn: ?int, symbol: ?string}>, dependencies: list<array{file: string, hash: string}>, shadowed: list<array{logical: string, loaded: ?string, ignored: list<string>}>, outputTypes: array<string, string>}`](#compile) |  |

### compile()

`public function compile(string $context): array{_schema_version: int, source_hash: string, config_format: ?string, modules: list<array{name: string, dir: string, actions: list<string>}>, routes: list<array{name: string, path: string, methods: list<string>, module: string, action: string, outputType: ?string, source: string, file: ?string, line: ?int}>, triads: list<array{module: string, action: string, actionFile: string, viewFile: ?string, templateFiles: array<string, string>, verbs: list<array{name: string, line: ?int}>}>, diagnostics: list<array{severity: string, code: string, message: string, file: string, line: ?int, column: ?int, endLine: ?int, endColumn: ?int, symbol: ?string}>, dependencies: list<array{file: string, hash: string}>, shadowed: list<array{logical: string, loaded: ?string, ignored: list<string>}>, outputTypes: array<string, string>}`

| Parameter | Type | Description |
|---|---|---|
| `$context` | `string` |  |

Returns `array{_schema_version: int, source_hash: string, config_format: ?string, modules: list<array{name: string, dir: string, actions: list<string>}>, routes: list<array{name: string, path: string, methods: list<string>, module: string, action: string, outputType: ?string, source: string, file: ?string, line: ?int}>, triads: list<array{module: string, action: string, actionFile: string, viewFile: ?string, templateFiles: array<string, string>, verbs: list<array{name: string, line: ?int}>}>, diagnostics: list<array{severity: string, code: string, message: string, file: string, line: ?int, column: ?int, endLine: ?int, endColumn: ?int, symbol: ?string}>, dependencies: list<array{file: string, hash: string}>, shadowed: list<array{logical: string, loaded: ?string, ignored: list<string>}>, outputTypes: array<string, string>}`
