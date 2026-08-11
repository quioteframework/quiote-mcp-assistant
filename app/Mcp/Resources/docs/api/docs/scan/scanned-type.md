# ScannedType

> One class-like declaration, as read out of its source file by the tokenizer.

One class-like declaration, as read out of its source file by the tokenizer.

This is what [`SourceScanner`](/api/docs/scan/source-scanner/) produces before any autoloading happens. The fully-qualified name here is the one the file actually declares, not one derived from the file's path, which is the distinction that makes it safe to reflect.

## Synopsis

`final class ScannedType`

|  |  |
|---|---|
| Source | `Scan/ScannedType.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$absolutePath` | `string` | _readonly._ |
| `$baseDir` | `string` | _readonly._ |
| `$fqcn` | `string` | _readonly._ |
| `$imports` | `array` | _readonly._ |
| `$kind` | `string` | _readonly._ |
| `$namespace` | `string` | _readonly._ |
| `$shortName` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $fqcn, string $shortName, string $namespace, 'class'|'interface'|'trait'|'enum' $kind, string $absolutePath, string $baseDir, array<string, string> $imports): mixed`

Alias (lowercased) => fully-qualified name, from the
                                      file's top-level `use` statements. Needed to resolve
                                      the unqualified ``Foo`` docblock references that
                                      reflection alone cannot.

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |
| `$shortName` | `string` |  |
| `$namespace` | `string` |  |
| `$kind` | `'class'``|``'interface'``|``'trait'``|``'enum'` |  |
| `$absolutePath` | `string` |  |
| `$baseDir` | `string` |  |
| `$imports` | `array``<``string``, ``string``>` | Alias (lowercased) => fully-qualified name, from the file's top-level `use` statements. Needed to resolve the unqualified ``Foo`` docblock references that reflection alone cannot. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`relativePath(): string`](#relativepath) | Returns the path of this file relative to the PSR-4 base directory it was found under. |
| [`resolveImport(string $alias): ?string`](#resolveimport) | Resolves an alias used in this file to its fully-qualified name, or null when unimported. |

### relativePath()

`public function relativePath(): string`

Returns the path of this file relative to the PSR-4 base directory it was found under.

Source links are built from this rather than from ReflectionClass::getFileName(), which resolves symlinks: the monorepo's vendor entries are symlinks into packages/, so the same class reports a different absolute path in a checkout than in a published install.

Returns `string`

### resolveImport()

`public function resolveImport(string $alias): ?string`

Resolves an alias used in this file to its fully-qualified name, or null when unimported.

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `string` |  |

Returns `?``string`
