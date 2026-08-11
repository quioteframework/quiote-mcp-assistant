# ExtendedClassIndex

> Whether anything in the codebase extends a given class.

Whether anything in the codebase extends a given class.

Adding a constructor parameter to a class that others extend is not safe, and a dry run against the reference application's `Api` module is what proved it. `ApiBaseAction` is concrete, has 58 subclasses, and six of them already declared their own constructor. Injecting into the base gave it `__construct(RequestState, User)`; no subclass forwards to it, so every one of them would have left `$this->user` uninitialized -- and `ApiBaseAction::validatePermissions()`, which every API action calls, reads exactly that. A whole module fatalling at runtime, produced by a migration tool, in code that had just been reviewed.

The reverse is no better: appending a required parameter to a base class's *existing* constructor breaks every subclass that forwards with the old arity. And which of the two happens depends on the order Rector reaches the files in, so it is not even deterministic.

Rector 2.6 has no subclass enumeration -- `FamilyRelationsAnalyzer` walks ancestors, not descendants -- so this indexes the codebase itself, once per process.

## Deliberately approximate, in the safe direction

Matching is on the **short name** after `extends`, not on a resolved fully-qualified name. Resolving one properly means tracking imports and aliases per file, which is where a scanner like this gets subtly wrong. A short-name match can therefore report "extended" for a same-named class in an unrelated namespace -- and the consequence of that is a rule declining a site it could have rewritten, which lands in the residue report for a human to look at. The consequence of the opposite error is the module-wide fatal described above. So the approximation only ever costs coverage, never correctness.

## Synopsis

`final class ExtendedClassIndex`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `NodeAnalyzer/ExtendedClassIndex.php` |

## Constructor

### __construct()

`public function __construct(?array<int, string> $roots = null): mixed`

Directories to scan. Null asks Composer, which is what
                   the container does; a caller that knows its own source roots -- a test --
                   passes them instead of arranging an autoloader to be discovered.

| Parameter | Type | Description |
|---|---|---|
| `$roots` | `?``array``<``int``, ``string``>` | Directories to scan. Null asks Composer, which is what the container does; a caller that knows its own source roots -- a test -- passes them instead of arranging an autoloader to be discovered. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`isExtended(string $className): bool`](#isextended) | Whether any class in the codebase extends this one. |

### isExtended()

`public function isExtended(string $className): bool`

Whether any class in the codebase extends this one.

| Parameter | Type | Description |
|---|---|---|
| `$className` | `string` |  |

Returns `bool`
