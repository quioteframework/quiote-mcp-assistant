# ReferenceResolver

> Rewrites the ``…`` references in docblock prose into a form an emitter can link.

Rewrites the ``…`` references in docblock prose into a form an emitter can link.

The framework writes these unqualified -- ``Context``, `[`ReferenceResolver::reset()`](/api/docs/docblock/reference-resolver/#reset)` -- which only the declaring file's imports can resolve, so it has to happen here rather than at render time. Left alone they reach the page verbatim, braces and all, which is how a reference ends up looking abandoned.

Output is ``Name::member`` when the target resolved and plain backticked text when it did not, so the emitter never has to guess.

## Synopsis

`final class ReferenceResolver`

|  |  |
|---|---|
| Source | `Docblock/ReferenceResolver.php` |

## Methods

| Method | Description |
|---|---|
| [`resolve(DocBlock $doc, ScannedType $context): DocBlock`](#resolve) | Resolves every reference in a docblock's prose against the file that declared it. |

### resolve()

`public function resolve(DocBlock $doc, ScannedType $context): DocBlock`

Resolves every reference in a docblock's prose against the file that declared it.

| Parameter | Type | Description |
|---|---|---|
| `$doc` | [`DocBlock`](/api/docs/ir/doc-block/) |  |
| `$context` | [`ScannedType`](/api/docs/scan/scanned-type/) |  |

Returns [`DocBlock`](/api/docs/ir/doc-block/)
