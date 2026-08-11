# Slugger

> Turns a fully-qualified name into the URL path its page lives at.

Turns a fully-qualified name into the URL path its page lives at.

A directory per namespace segment below the framework root, then the class name in kebab case: `Quiote\Routing\Compiler\TriadViewResolver` becomes `routing/compiler/triad-view-resolver`. Nesting by namespace rather than flattening is what keeps two classes that share a short name apart.

## Synopsis

`final class Slugger`

|  |  |
|---|---|
| Source | `Slug/Slugger.php` |

## Methods

| Method | Description |
|---|---|
| [`forClass(string $fqcn): string`](#forclass) | The page path for a class, relative to the reference root and without an extension. |
| [`forNamespace(string $namespace): string`](#fornamespace) | The page path for a namespace's index, relative to the reference root. |
| [`kebab(string $identifier): string`](#kebab) | Converts one identifier to kebab case. |

### forClass()

`public function forClass(string $fqcn): string`

The page path for a class, relative to the reference root and without an extension.

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |

Returns `string`

### forNamespace()

`public function forNamespace(string $namespace): string`

The page path for a namespace's index, relative to the reference root.

| Parameter | Type | Description |
|---|---|---|
| `$namespace` | `string` |  |

Returns `string`

### kebab()

`public function kebab(string $identifier): string`

Converts one identifier to kebab case.

Acronyms are folded to ordinary capitalised words first, so the boundary rule below never has to reason about a run of capitals that is really one word.

| Parameter | Type | Description |
|---|---|---|
| `$identifier` | `string` |  |

Returns `string`
