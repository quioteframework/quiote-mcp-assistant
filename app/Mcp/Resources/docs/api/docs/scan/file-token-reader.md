# FileTokenReader

> Reads a PHP file's namespace, first class-like declaration and `use` imports straight from its tokens, without executing or autoloading anything.

Reads a PHP file's namespace, first class-like declaration and `use` imports straight from its tokens, without executing or autoloading anything.

The generator cannot ask the autoloader what a file declares. Composer's PSR-4 map allows one base directory under several prefixes, so a path can imply a class name that does not exist; asking `class_exists()` about that name makes Composer include the file a second time, and the resulting "Cannot redeclare * class" is a fatal that no catch block can intercept. Reading the declaration first, and reflecting only when it matches what the path implied, is what keeps the scan safe.

## Synopsis

`final class FileTokenReader`

|  |  |
|---|---|
| Source | `Scan/FileTokenReader.php` |

## Methods

| Method | Description |
|---|---|
| [`read(string $path): array{namespace: string, imports: array<string, string>, types: list<array{name: string, kind: ('class' | 'interface' | 'trait' | 'enum')}>}|null`](#read) | Returns what the file declares, or null when it declares no class-like at all. |

### read()

`public function read(string $path): array{namespace: string, imports: array<string, string>, types: list<array{name: string, kind: ('class' | 'interface' | 'trait' | 'enum')}>}|null`

Returns what the file declares, or null when it declares no class-like at all.

Every top-level declaration is reported, not just the first. PSR-4 addresses one type per file, but a file is free to declare more alongside it -- `Quiote\DI\Container` ships its two PSR-11 exceptions that way, and they are defined the moment the file loads, so they are as documentable as the type that named it. Which of them the path points at is the scanner's business, not this reader's.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `array{namespace: string, imports: array<string, string>, types: list<array{name: string, kind: ('class' | 'interface' | 'trait' | 'enum')}>}``|``null`
