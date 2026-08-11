# Format

> The Quiote\\Config\\Format namespace — 13 documented types.

Everything under `Quiote\Config\Format`.

## Classes

| Class | Description |
|---|---|
| [`AbstractArrayFormatDriver`](/api/config/format/abstract-array-format-driver/) | Shared parent-chain and imports resolution for array-shaped formats (PHP arrays, YAML). |
| [`ArrayMergeStrategy`](/api/config/format/array-merge-strategy/) | Format-agnostic parent/child config inheritance (phase 4). |
| [`DirectiveExpander`](/api/config/format/directive-expander/) | Applies the same %core.quiote_dir%-style directive expansion and literal-boolean coercion that XML config values get "for free" via XmlConfigDomElement::getLiteralValue() (which runs Toolkit::literalize() on element text by default) -- to PHP-array and YAML config values, which have no XML text-node equivalent to hook that into. |
| [`FormatAwareConfigCache`](/api/config/format/format-aware-config-cache/) | Extension-agnostic sibling of ConfigCache::checkConfig(): given a base path with NO extension, resolves whichever of .php/.yaml/.yml/.xml actually exists (via FormatDriverRegistry::locate(), priority PHP > YAML > XML), compiles it through the given handler's array contract, and reuses ConfigCache's own cache-naming/staleness/write primitives so the compiled artifact is indistinguishable from one ConfigCache produced. |
| [`FormatDriverRegistry`](/api/config/format/format-driver-registry/) | Maps a config file's extension to the FormatDriver that understands it, and is itself the thing `parent`/`imports` references are resolved through -- so a PHP-array config can have a YAML parent, a YAML config can import an XML-derived one, etc. |
| [`PhpArrayFormatDriver`](/api/config/format/php-array-format-driver/) | Loads a config source that is itself a plain PHP file returning an array -- the recommended primary format (zero parsing cost beyond opcache, full IDE support, native `parent`/`imports` path resolution via AbstractArrayFormatDriver). |
| [`XmlFormatDriver`](/api/config/format/xml-format-driver/) | Wraps the existing XmlConfigParser pipeline (XInclude, XSD validation, XSL normalization, parent-chain merge -- all untouched, see phase 1's "what this is NOT") and converts its output to the canonical array via the bound handler's toCanonicalArray(). |
| [`YamlFormatDriver`](/api/config/format/yaml-format-driver/) | Loads a config source written in YAML, via symfony/yaml. |

## Interfaces

| Interface | Description |
|---|---|
| [`FormatDriverInterface`](/api/config/format/format-driver-interface/) | A FormatDriver turns one config source file, in whatever format it understands, into a normalized PHP array -- the same canonical shape a given config handler's array-based execute() method consumes regardless of which driver produced it (see Quiote\Config\IArrayConfigHandler). |
| [`PositionAwareFormatDriverInterface`](/api/config/format/position-aware-format-driver-interface/) | Opt-in "locating" parse mode (see VSCODE_EXTENSION_INTEGRATION.md's config validator work item 3): same canonical array a plain load() would produce, plus a key-path -> {file, line} index for whichever keys the driver could trace back to a source position. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Php`](/api/config/format/php/) | 1 type |
| [`Xml`](/api/config/format/xml/) | 1 type |
| [`Yaml`](/api/config/format/yaml/) | 1 type |
