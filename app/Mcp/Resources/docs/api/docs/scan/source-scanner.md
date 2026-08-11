# SourceScanner

> Finds every documentable class-like in the framework by walking Composer's PSR-4 prefix map and reading each file's own declaration.

Finds every documentable class-like in the framework by walking Composer's PSR-4 prefix map and reading each file's own declaration.

The prefix map is the discovery source rather than a classmap or a fixed directory list because the framework is one namespace spread across many packages -- adding a package must not mean editing this class. Nothing here autoloads: a candidate is accepted only when the name its file declares matches the name its path implies, so a path that maps to no real class is skipped rather than handed to `class_exists()`, where Composer would include the file again and PHP would raise an uncatchable redeclaration fatal.

## Synopsis

`final class SourceScanner`

|  |  |
|---|---|
| Source | `Scan/SourceScanner.php` |

## Constructor

### __construct()

`public function __construct(?ClassLoader $loader = null, FileTokenReader $reader = new FileTokenReader(…), bool $excludeTestDirectories = true): mixed`

Whether to drop base directories under a `tests` segment.
                                    On by default because `autoload-dev` prefixes share the
                                    PSR-4 map with the real ones; only this package's own
                                    fixtures, which deliberately live under `tests`, turn it
                                    off.

| Parameter | Type | Description |
|---|---|---|
| `$loader` | `?``ClassLoader` |  |
| `$reader` | [`FileTokenReader`](/api/docs/scan/file-token-reader/) |  |
| `$excludeTestDirectories` | `bool` | Whether to drop base directories under a `tests` segment. On by default because `autoload-dev` prefixes share the PSR-4 map with the real ones; only this package's own fixtures, which deliberately live under `tests`, turn it off. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getDiagnostics(): list<Diagnostic>`](#getdiagnostics) | Diagnostics accumulated by the last [`SourceScanner::scan()`](/api/docs/scan/source-scanner/#scan): files whose declaration did not match the path that found them, and files declaring nothing at all. |
| [`roots(): list<array{prefix: string, baseDir: string}>`](#roots) | The prefix/directory pairs that contribute framework code. |
| [`scan(): list<ScannedType>`](#scan) | Returns every class-like under the framework's namespace, ordered by name. |

### getDiagnostics()

`public function getDiagnostics(): list<Diagnostic>`

Diagnostics accumulated by the last [`SourceScanner::scan()`](/api/docs/scan/source-scanner/#scan): files whose declaration did not match the path that found them, and files declaring nothing at all.

Returns `list``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>`

### roots()

`public function roots(): list<array{prefix: string, baseDir: string}>`

The prefix/directory pairs that contribute framework code.

A pair rather than a map, because neither side is unique: one prefix may list several directories, and one directory may sit under several prefixes -- `packages/session-pdo/src` is reachable as both `Quiote\Session\Pdo\` and `Quiote\Storage\Pdo\`, and only the first names anything the files actually declare. Collapsing either side would silently drop real classes, so every pair is tried and the declarations decide.

Pairs are ordered longest prefix first, so a package wins over the kernel for a namespace they share, and by name within a length, so the result does not depend on the order Composer happened to install things in. Directories are resolved to their real path because the monorepo installs its own packages as symlinks, and any directory under a `tests` segment is dropped -- by path, not by namespace, since `Quiote\Testing` is shipped API.

Returns `list``<``array{prefix: string, baseDir: string}``>`

### scan()

`public function scan(): list<ScannedType>`

Returns every class-like under the framework's namespace, ordered by name.

Returns `list``<`[`ScannedType`](/api/docs/scan/scanned-type/)`>`
