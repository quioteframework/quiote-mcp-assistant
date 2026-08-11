# AbstractArrayFormatDriver

> Shared parent-chain and imports resolution for array-shaped formats (PHP arrays, YAML).

Shared parent-chain and imports resolution for array-shaped formats (PHP arrays, YAML).

Each format only has to implement parse(): raw array in, everything else -- directive expansion, `imports`, `parent` -- behaves identically regardless of which format produced the array.

Unlike XmlFormatDriver, $environment/$context are not applied here: PHP-array/YAML files have no native equivalent of XML's `<ae:configuration environment="...">` filtering. A config author who needs environment-conditional values in a PHP-array file can already express that directly (`Config::getNullableString('core.environment') === 'test'` inside the returned array's construction) -- that's a deliberate scope limit, not an oversight.

## Synopsis

`abstract class AbstractArrayFormatDriver implements FormatDriverInterface`

|  |  |
|---|---|
| Implements | [`FormatDriverInterface`](/api/config/format/format-driver-interface/) |
| Since | `1.0.0` |
| Source | `Config/Format/AbstractArrayFormatDriver.php` |

## Constructor

### __construct()

`public function __construct(ArrayMergeStrategy $merger = new ArrayMergeStrategy(…), DirectiveExpander $expander = new DirectiveExpander(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$merger` | [`ArrayMergeStrategy`](/api/config/format/array-merge-strategy/) |  |
| `$expander` | [`DirectiveExpander`](/api/config/format/directive-expander/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`load(string $path, string $environment, string|null $context = null): array<string, mixed>`](#load) |  |
| [`parse(string $path): array<string, mixed>`](#parse) |  |
| [`setRegistry(FormatDriverRegistry $registry): void`](#setregistry) | Called by FormatDriverRegistry when this driver is registered, so `parent`/`imports` references can be resolved through any registered format, not just this driver's own. |

### load()

`public function load(string $path, string $environment, string|null $context = null): array<string, mixed>`

The active context name, if any.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$environment` | `string` | The active environment name (only meaningful to drivers whose format has a native environment-filtering concept, e.g. XmlFormatDriver; array/YAML drivers ignore it today -- see class docs). |
| `$context` | `string``|``null` | The active context name, if any. |

Returns `array``<``string``, ``mixed``>` — The resolved, parent-chain-merged, directive-expanded config data.

### parse()

`abstract protected function parse(string $path): array<string, mixed>`

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `array``<``string``, ``mixed``>` — The raw, un-expanded array as read from $path (e.g. the value `require`d from a PHP file, or the parsed YAML document). May contain 'parent' and/or 'imports' keys, which load() strips before returning.

### setRegistry()

`public function setRegistry(FormatDriverRegistry $registry): void`

Called by FormatDriverRegistry when this driver is registered, so `parent`/`imports` references can be resolved through any registered format, not just this driver's own.

| Parameter | Type | Description |
|---|---|---|
| `$registry` | [`FormatDriverRegistry`](/api/config/format/format-driver-registry/) |  |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `supports()` | [`FormatDriverInterface`](/api/config/format/format-driver-interface/) | Whether this driver can handle the given path, based on its extension. |
