# RecursiveDirectoryFilterIterator

> RecursiveDirectoryFilterIterator filters a RecursiveDirectoryIterator with a given set of include and exclude patterns.

RecursiveDirectoryFilterIterator filters a RecursiveDirectoryIterator with a given set of include and exclude patterns.

## Synopsis

`class RecursiveDirectoryFilterIterator extends RecursiveFilterIterator`

|  |  |
|---|---|
| Extends | `RecursiveFilterIterator` |
| Since | `1.0.0` |
| Source | `Util/RecursiveDirectoryFilterIterator.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$defaultExcludes` | `mixed` | _static._ The list of default excludes |

## Constructor

### __construct()

`public function __construct(RecursiveDirectoryIterator $iterator, array<int, string> $includes = [], array<int, string> $excludes = [], boolean $noDefaultExcludes = false): mixed`

Creates a new RecursiveDirectoryFilterIterator.

whether to use the default exclude patterns.

| Parameter | Type | Description |
|---|---|---|
| `$iterator` | `RecursiveDirectoryIterator` | the directory iterator to decorate |
| `$includes` | `array``<``int``, ``string``>` | the list of include patterns (regular expressions) |
| `$excludes` | `array``<``int``, ``string``>` | the list of exclude patterns (literal) |
| `$noDefaultExcludes` | `boolean` | whether to use the default exclude patterns. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`accept(): boolean`](#accept) | Checks whether the current item is included. |
| [`getChildren(): RecursiveDirectoryFilterIterator`](#getchildren) | Returns a child iterator. |

### accept()

`public function accept(): boolean`

Checks whether the current item is included.

An item is included if it is matched by any of the include expressions and none of the exclude patterns.

Returns `boolean` — true if the item is included

### getChildren()

`public function getChildren(): RecursiveDirectoryFilterIterator`

Returns a child iterator.

Returns [`RecursiveDirectoryFilterIterator`](/api/util/recursive-directory-filter-iterator/) — an iterator for a subdirectory

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `current()` | `IteratorIterator` |  |
| `getInnerIterator()` | `IteratorIterator` |  |
| `hasChildren()` | `RecursiveFilterIterator` |  |
| `key()` | `IteratorIterator` |  |
| `next()` | `FilterIterator` |  |
| `rewind()` | `FilterIterator` |  |
| `valid()` | `IteratorIterator` |  |
