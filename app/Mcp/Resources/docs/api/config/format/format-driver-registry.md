# FormatDriverRegistry

> Maps a config file's extension to the FormatDriver that understands it, and is itself the thing `parent`/`imports` references are resolved through -- so a PHP-array config can have a YAML parent, a YAML config can import an XML-derived one, etc.

Maps a config file's extension to the FormatDriver that understands it, and is itself the thing `parent`/`imports` references are resolved through -- so a PHP-array config can have a YAML parent, a YAML config can import an XML-derived one, etc.

A registry is scoped to one config *type* (settings, factories, ...), not global: which canonical array shape a `.xml` file resolves to depends entirely on which IArrayConfigHandler its XmlFormatDriver is bound to (see forHandler()). Mixing driver sets across config types would silently produce the wrong shape for whichever type didn't match.

## Synopsis

`final class FormatDriverRegistry`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/Format/FormatDriverRegistry.php` |

## Constructor

### __construct()

`public function __construct(array<FormatDriverInterface> $drivers = []): mixed`

Checked in the given order;
       the first whose supports() matches wins. Pass PHP-array
       before YAML before XML to get the priority order used for
       extension-agnostic discovery (see locate()).

| Parameter | Type | Description |
|---|---|---|
| `$drivers` | `array``<`[`FormatDriverInterface`](/api/config/format/format-driver-interface/)`>` | Checked in the given order; the first whose supports() matches wins. Pass PHP-array before YAML before XML to get the priority order used for extension-agnostic discovery (see locate()). |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`forHandler(IArrayConfigHandler&IXmlConfigHandler $handler, array<string> $transformations = [], array<string, mixed> $validations = []): FormatDriverRegistry`](#forhandler) | Convenience assembly for the common case: PHP array + YAML + XML, all producing the canonical array shape $handler defines, in the priority order extension-agnostic discovery uses (PHP > YAML > XML). |
| [`load(string $path, ?string $environment, ?string $context = null): array<string, mixed>`](#load) |  |
| [`locate(string $basePathWithoutExtension): string|null`](#locate) | Extension-agnostic handler discovery: given a base path with no extension (e.g. |
| [`register(FormatDriverInterface $driver): void`](#register) | Appends a driver to the end of the resolution order. |
| [`resolve(string $path): FormatDriverInterface`](#resolve) | Returns the first registered driver that claims the given path. |

### forHandler()

`public static function forHandler(IArrayConfigHandler&IXmlConfigHandler $handler, array<string> $transformations = [], array<string, mixed> $validations = []): FormatDriverRegistry`

Convenience assembly for the common case: PHP array + YAML + XML, all producing the canonical array shape $handler defines, in the priority order extension-agnostic discovery uses (PHP > YAML > XML).

The handler's declared XSD /
       RelaxNG / Schematron validations, forwarded to the XmlFormatDriver
       so XML resolved through this registry (including via
       `parent`/`imports`) is validated against its schemas exactly like
       a primary XML file; ignored by the PHP/YAML drivers.

| Parameter | Type | Description |
|---|---|---|
| `$handler` | [`IArrayConfigHandler`](/api/config/i-array-config-handler/)`&`[`IXmlConfigHandler`](/api/config/i-xml-config-handler/) |  |
| `$transformations` | `array``<``string``>` | XSL stylesheets applied to the XML path only (see XmlFormatDriver); irrelevant to PHP/YAML. |
| `$validations` | `array``<``string``, ``mixed``>` | The handler's declared XSD / RelaxNG / Schematron validations, forwarded to the XmlFormatDriver so XML resolved through this registry (including via `parent`/`imports`) is validated against its schemas exactly like a primary XML file; ignored by the PHP/YAML drivers. |

Returns [`FormatDriverRegistry`](/api/config/format/format-driver-registry/)

### load()

`public function load(string $path, ?string $environment, ?string $context = null): array<string, mixed>`

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$environment` | `?``string` |  |
| `$context` | `?``string` |  |

Returns `array``<``string``, ``mixed``>`

### locate()

`public function locate(string $basePathWithoutExtension): string|null`

Extension-agnostic handler discovery: given a base path with no extension (e.g.

"%core.config_dir%/settings"), returns the first candidate that exists on disk, checked in registration order (PHP > YAML > XML by convention -- see forHandler()). An explicit extension in the caller's own pattern should bypass this entirely and be used as-is; this is only for the extension-less case.

| Parameter | Type | Description |
|---|---|---|
| `$basePathWithoutExtension` | `string` |  |

Returns `string``|``null` — The resolved, existing path, or null if none of the candidate extensions exist.

### register()

`public function register(FormatDriverInterface $driver): void`

Appends a driver to the end of the resolution order.

Order matters: [`FormatDriverRegistry::resolve()`](/api/config/format/format-driver-registry/#resolve) returns the first driver whose `supports()` matches, and [`FormatDriverRegistry::locate()`](/api/config/format/format-driver-registry/#locate) probes extensions in the same order. A driver that resolves nested `parent`/`imports` references is handed this registry, so those references can cross formats.

| Parameter | Type | Description |
|---|---|---|
| `$driver` | [`FormatDriverInterface`](/api/config/format/format-driver-interface/) |  |

### resolve()

`public function resolve(string $path): FormatDriverInterface`

Returns the first registered driver that claims the given path.

Drivers are asked in registration order, so an earlier registration wins a tie.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns [`FormatDriverInterface`](/api/config/format/format-driver-interface/)

| Throws | When |
|---|---|
| `ConfigurationException` | if no registered driver supports the path. |
