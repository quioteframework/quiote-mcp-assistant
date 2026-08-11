# DocBlock

> The prose and tags of one docblock, already separated into the parts a page renders.

The prose and tags of one docblock, already separated into the parts a page renders.

Types here are still the raw strings the author wrote. Turning them into a [`TypeRef`](/api/docs/ir/type-ref/) needs the declaring file's imports, which only the reflector has, so that conversion happens there rather than at parse time.

## Synopsis

`final class DocBlock`

|  |  |
|---|---|
| Source | `Ir/DocBlock.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$deprecated` | `?``string` | _readonly._ |
| `$description` | `string` | _readonly._ |
| `$inheritsDoc` | `bool` | _readonly._ |
| `$internal` | `bool` | _readonly._ |
| `$paramDescriptions` | `array` | _readonly._ |
| `$paramTypes` | `array` | _readonly._ |
| `$returnDescription` | `string` | _readonly._ |
| `$returnType` | `?``string` | _readonly._ |
| `$see` | `array` | _readonly._ |
| `$since` | `?``string` | _readonly._ |
| `$summary` | `string` | _readonly._ |
| `$throws` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $summary = '', string $description = '', array<string, string> $paramDescriptions = [], array<string, string> $paramTypes = [], ?string $returnType = null, string $returnDescription = '', list<array{type: string, description: string}> $throws = [], ?string $deprecated = null, bool $internal = false, ?string $since = null, list<string> $see = [], bool $inheritsDoc = false): mixed`

Raw `@see` targets, in source order.

| Parameter | Type | Description |
|---|---|---|
| `$summary` | `string` |  |
| `$description` | `string` |  |
| `$paramDescriptions` | `array``<``string``, ``string``>` | Parameter name (no `$`) => description. |
| `$paramTypes` | `array``<``string``, ``string``>` | Parameter name (no `$`) => raw type text. |
| `$returnType` | `?``string` |  |
| `$returnDescription` | `string` |  |
| `$throws` | `list``<``array{type: string, description: string}``>` |  |
| `$deprecated` | `?``string` |  |
| `$internal` | `bool` |  |
| `$since` | `?``string` |  |
| `$see` | `list``<``string``>` | Raw `@see` targets, in source order. |
| `$inheritsDoc` | `bool` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`empty(): DocBlock`](#empty) |  |
| [`inheritFrom(DocBlock $parent): DocBlock`](#inheritfrom) | Returns a copy carrying $parent's prose wherever this block left it out. |
| [`isEmpty(): bool`](#isempty) |  |

### empty()

`public static function empty(): DocBlock`

Returns [`DocBlock`](/api/docs/ir/doc-block/)

### inheritFrom()

`public function inheritFrom(DocBlock $parent): DocBlock`

Returns a copy carrying $parent's prose wherever this block left it out.

Used for ``, and for the common case of an override with tags but no summary: the ancestor's description is the right one, and the override's own tags still win because they describe this signature.

| Parameter | Type | Description |
|---|---|---|
| `$parent` | [`DocBlock`](/api/docs/ir/doc-block/) |  |

Returns [`DocBlock`](/api/docs/ir/doc-block/)

### isEmpty()

`public function isEmpty(): bool`

Returns `bool`
