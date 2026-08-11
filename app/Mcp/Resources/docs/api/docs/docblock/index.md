# Docblock

> The Quiote\\Docs\\Docblock namespace — 4 documented types.

Everything under `Quiote\Docs\Docblock`.

## Classes

| Class | Description |
|---|---|
| [`DocblockParser`](/api/docs/docblock/docblock-parser/) | Turns a raw docblock into a [`DocBlock`](/api/docs/ir/doc-block/). |
| [`ReferenceResolver`](/api/docs/docblock/reference-resolver/) | Rewrites the ``…`` references in docblock prose into a form an emitter can link. |
| [`TypeResolver`](/api/docs/docblock/type-resolver/) | Builds [`TypeRef`](/api/docs/ir/type-ref/) trees from what the source says, resolving names the way PHP would. |
| [`ValueRenderer`](/api/docs/docblock/value-renderer/) | Renders a default value the way it would be written in source. |
