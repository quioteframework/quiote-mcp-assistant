# ClassDoc

> Everything one page needs about one class, interface, trait or enum.

Everything one page needs about one class, interface, trait or enum.

## Synopsis

`final class ClassDoc`

|  |  |
|---|---|
| Source | `Ir/ClassDoc.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$abstract` | `bool` | _readonly._ |
| `$backingType` | `?``string` | _readonly._ |
| `$cases` | `array` | _readonly._ |
| `$constants` | `array` | _readonly._ |
| `$constructor` | `?`[`MethodDoc`](/api/docs/ir/method-doc/) | _readonly._ |
| `$doc` | [`DocBlock`](/api/docs/ir/doc-block/) | _readonly._ |
| `$final` | `bool` | _readonly._ |
| `$fqcn` | `string` | _readonly._ |
| `$implementedBy` | `array` | _readonly._ |
| `$inheritedMethods` | `array` | _readonly._ |
| `$interfaces` | `array` | _readonly._ |
| `$kind` | `string` | _readonly._ |
| `$methods` | `array` | _readonly._ |
| `$namespace` | `string` | _readonly._ |
| `$parent` | `?`[`TypeRef`](/api/docs/ir/type-ref/) | _readonly._ |
| `$properties` | `array` | _readonly._ |
| `$readonly` | `bool` | _readonly._ |
| `$shortName` | `string` | _readonly._ |
| `$sourcePath` | `string` | _readonly._ |
| `$traits` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $fqcn, string $shortName, string $namespace, 'class'|'interface'|'trait'|'enum' $kind, DocBlock $doc, string $sourcePath, bool $abstract = false, bool $final = false, bool $readonly = false, ?TypeRef $parent = null, list<TypeRef> $interfaces = [], list<TypeRef> $traits = [], list<ConstantDoc> $constants = [], list<EnumCaseDoc> $cases = [], list<PropertyDoc> $properties = [], ?MethodDoc $constructor = null, list<MethodDoc> $methods = [], list<InheritedMember> $inheritedMethods = [], list<string> $implementedBy = [], ?string $backingType = null): mixed`

Fully-qualified names, filled in once every class is known.

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |
| `$shortName` | `string` |  |
| `$namespace` | `string` |  |
| `$kind` | `'class'``|``'interface'``|``'trait'``|``'enum'` |  |
| `$doc` | [`DocBlock`](/api/docs/ir/doc-block/) |  |
| `$sourcePath` | `string` |  |
| `$abstract` | `bool` |  |
| `$final` | `bool` |  |
| `$readonly` | `bool` |  |
| `$parent` | `?`[`TypeRef`](/api/docs/ir/type-ref/) |  |
| `$interfaces` | `list``<`[`TypeRef`](/api/docs/ir/type-ref/)`>` |  |
| `$traits` | `list``<`[`TypeRef`](/api/docs/ir/type-ref/)`>` |  |
| `$constants` | `list``<`[`ConstantDoc`](/api/docs/ir/constant-doc/)`>` |  |
| `$cases` | `list``<`[`EnumCaseDoc`](/api/docs/ir/enum-case-doc/)`>` |  |
| `$properties` | `list``<`[`PropertyDoc`](/api/docs/ir/property-doc/)`>` |  |
| `$constructor` | `?`[`MethodDoc`](/api/docs/ir/method-doc/) |  |
| `$methods` | `list``<`[`MethodDoc`](/api/docs/ir/method-doc/)`>` | Declared here, trait-composed included. |
| `$inheritedMethods` | `list``<`[`InheritedMember`](/api/docs/ir/inherited-member/)`>` |  |
| `$implementedBy` | `list``<``string``>` | Fully-qualified names, filled in once every class is known. |
| `$backingType` | `?``string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`declaration(): string`](#declaration) | The declaration line, as it would be written in source. |
| [`namespaceSegments(): list<string>`](#namespacesegments) |  |
| [`withImplementedBy(list<string> $implementedBy): ClassDoc`](#withimplementedby) |  |

### declaration()

`public function declaration(): string`

The declaration line, as it would be written in source.

Returns `string`

### namespaceSegments()

`public function namespaceSegments(): list<string>`

Returns `list``<``string``>` — The namespace split into segments below the framework root.

### withImplementedBy()

`public function withImplementedBy(list<string> $implementedBy): ClassDoc`

| Parameter | Type | Description |
|---|---|---|
| `$implementedBy` | `list``<``string``>` |  |

Returns [`ClassDoc`](/api/docs/ir/class-doc/)
