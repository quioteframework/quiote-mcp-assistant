# ApiReflector

> Builds the documentation model from the types the scanner verified.

Builds the documentation model from the types the scanner verified.

This is the only place reflection is used: everything downstream works from the [`ApiIndex`](/api/docs/ir/api-index/), so an emitter can be tested against a model built by hand.

## Synopsis

`final class ApiReflector`

|  |  |
|---|---|
| Source | `ApiReflector.php` |

## Constructor

### __construct()

`public function __construct(DocblockParser $docblocks = new DocblockParser(…), TypeResolver $types = new TypeResolver(…), ValueRenderer $values = new ValueRenderer(…), ReferenceResolver $references = new ReferenceResolver(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$docblocks` | [`DocblockParser`](/api/docs/docblock/docblock-parser/) |  |
| `$types` | [`TypeResolver`](/api/docs/docblock/type-resolver/) |  |
| `$values` | [`ValueRenderer`](/api/docs/docblock/value-renderer/) |  |
| `$references` | [`ReferenceResolver`](/api/docs/docblock/reference-resolver/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`build(list<ScannedType> $scanned): ApiIndex`](#build) |  |
| [`getDiagnostics(): list<Diagnostic>`](#getdiagnostics) |  |

### build()

`public function build(list<ScannedType> $scanned): ApiIndex`

| Parameter | Type | Description |
|---|---|---|
| `$scanned` | `list``<`[`ScannedType`](/api/docs/scan/scanned-type/)`>` |  |

Returns [`ApiIndex`](/api/docs/ir/api-index/)

### getDiagnostics()

`public function getDiagnostics(): list<Diagnostic>`

Returns `list``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>`
