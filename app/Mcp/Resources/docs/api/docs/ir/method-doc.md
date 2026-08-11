# MethodDoc

> One method, as documented on the page of the class that declares it.

One method, as documented on the page of the class that declares it.

## Synopsis

`final class MethodDoc`

|  |  |
|---|---|
| Source | `Ir/MethodDoc.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$abstract` | `bool` | _readonly._ |
| `$doc` | [`DocBlock`](/api/docs/ir/doc-block/) | _readonly._ |
| `$final` | `bool` | _readonly._ |
| `$fromTrait` | `?``string` | _readonly._ |
| `$name` | `string` | _readonly._ |
| `$parameters` | `array` | _readonly._ |
| `$returnType` | [`TypeRef`](/api/docs/ir/type-ref/) | _readonly._ |
| `$static` | `bool` | _readonly._ |
| `$visibility` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $name, list<ParamDoc> $parameters, TypeRef $returnType, DocBlock $doc, 'public'|'protected' $visibility = 'public', bool $static = false, bool $abstract = false, bool $final = false, string|null $fromTrait = null): mixed`

Fully-qualified trait this method was composed in from, if any.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$parameters` | `list``<`[`ParamDoc`](/api/docs/ir/param-doc/)`>` |  |
| `$returnType` | [`TypeRef`](/api/docs/ir/type-ref/) |  |
| `$doc` | [`DocBlock`](/api/docs/ir/doc-block/) |  |
| `$visibility` | `'public'``|``'protected'` |  |
| `$static` | `bool` |  |
| `$abstract` | `bool` |  |
| `$final` | `bool` |  |
| `$fromTrait` | `string``|``null` | Fully-qualified trait this method was composed in from, if any. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`shortSignature(): string`](#shortsignature) | The compact form used in an at-a-glance table, without modifiers. |
| [`signature(): string`](#signature) | The full signature line. |

### shortSignature()

`public function shortSignature(): string`

The compact form used in an at-a-glance table, without modifiers.

Returns `string`

### signature()

`public function signature(): string`

The full signature line.

Modifiers are included because they are part of what a caller needs to know: a static method is called differently, and an abstract one has to be implemented.

Returns `string`
