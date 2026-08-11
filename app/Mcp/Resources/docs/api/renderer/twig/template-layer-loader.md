# TemplateLayerLoader

> Twig loader that treats the template \"name\" Twig is given as a literal, already-resolved filesystem path.

Twig loader that treats the template "name" Twig is given as a literal, already-resolved filesystem path.

Template resolution (directory conventions, locale fallback, extension) is entirely the TemplateLayer's job — [`TwigRenderer`](/api/renderer/twig/twig-renderer/) always calls Twig with `$layer->getResourceStreamIdentifier()` as the name, so this loader never needs a base directory or its own lookup rules.

## Synopsis

`final class TemplateLayerLoader implements LoaderInterface`

|  |  |
|---|---|
| Implements | `LoaderInterface` |
| Source | `TemplateLayerLoader.php` |

## Methods

| Method | Description |
|---|---|
| [`exists(string $name): bool`](#exists) | Reports whether the template path exists and is readable by this process. |
| [`getCacheKey(string $name): string`](#getcachekey) | Returns the cache key for a template. |
| [`getSourceContext(string $name): Source`](#getsourcecontext) | Reads the template at `$name` and returns it as a Twig source. |
| [`isFresh(string $name, int $time): bool`](#isfresh) | Reports whether the compiled template cached at `$time` is still current. |

### exists()

`public function exists(string $name): bool`

Reports whether the template path exists and is readable by this process.

A file that exists but is not readable counts as missing, because [`TemplateLayerLoader::getSourceContext()`](/api/renderer/twig/template-layer-loader/#getsourcecontext) could not load it either.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `bool`

### getCacheKey()

`public function getCacheKey(string $name): string`

Returns the cache key for a template.

The name is already a fully resolved absolute path, so it is unique on its own and is returned unchanged.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `string`

### getSourceContext()

`public function getSourceContext(string $name): Source`

Reads the template at `$name` and returns it as a Twig source.

`$name` is used verbatim as a filesystem path. Throws a `LoaderError` when the file cannot be read, since Twig has no other way to signal a missing template from here.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `Source`

| Throws | When |
|---|---|
| `LoaderError` |  |

### isFresh()

`public function isFresh(string $name, int $time): bool`

Reports whether the compiled template cached at `$time` is still current.

Compares the template file's modification time against `$time`. A file whose mtime cannot be read is treated as stale, so Twig recompiles it rather than serving a cache entry that may no longer match.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$time` | `int` |  |

Returns `bool`
