# Introspection

> The Quiote\\Introspection namespace — 2 documented types.

Everything under `Quiote\Introspection`.

## Classes

| Class | Description |
|---|---|
| [`AppIntrospectionArtifactWriter`](/api/introspection/app-introspection-artifact-writer/) | Writes the `cache/introspection/app.json` artifact via a write-to-temp-then-rename, so an editor extension polling the file never observes a partial write mid-regeneration -- the same technique `Quiote\Support\Compiler\FilesystemArtifactWriter` uses for compiled PHP artifacts, just for arbitrary JSON content instead of PHP source. |
| [`AppIntrospectionCompiler`](/api/introspection/app-introspection-compiler/) | Builds the versioned `cache/introspection/app.json` artifact an editor extension reads directly, with no PHP spawn, on its warm path: routes, modules, Action/View/Template triads, diagnostics, a dependency manifest, and shadowed-config info. |
