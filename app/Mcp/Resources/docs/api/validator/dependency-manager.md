# DependencyManager

> DependencyManager handles the dependencies in the validation process

DependencyManager handles the dependencies in the validation process

## Synopsis

`class DependencyManager implements ResetInterface`

|  |  |
|---|---|
| Implements | `ResetInterface` |
| Since | `1.0.0` |
| Source | `Validator/DependencyManager.php` |

## Methods

| Method | Description |
|---|---|
| [`addDependTokens(array<int, string> $tokens, VirtualArrayPath $base): void`](#adddependtokens) | Puts a list of tokens into the dependency cache. |
| [`checkDependencies(array<int, string> $tokens, VirtualArrayPath $base): bool`](#checkdependencies) | Checks whether a list of dependencies is met. |
| [`clear(): void`](#clear) | Clears the dependency cache. |
| [`getDependTokens(): array<int|string, mixed>`](#getdependtokens) | Returns the list of provided tokens from the dependency cache. |
| [`populateArgumentBaseKeyRefs(string $string): string`](#populateargumentbasekeyrefs) | Populate key references in an argument base string if necessary. |
| [`reset(): void`](#reset) | Discards every dependency token collected so far, by delegating to [`DependencyManager::clear()`](/api/validator/dependency-manager/#clear). |

### addDependTokens()

`public function addDependTokens(array<int, string> $tokens, VirtualArrayPath $base): void`

Puts a list of tokens into the dependency cache.

The base path to which all tokens are
                                  appended.

| Parameter | Type | Description |
|---|---|---|
| `$tokens` | `array``<``int``, ``string``>` | The list of new tokens. |
| `$base` | [`VirtualArrayPath`](/api/util/virtual-array-path/) | The base path to which all tokens are appended. |

### checkDependencies()

`public function checkDependencies(array<int, string> $tokens, VirtualArrayPath $base): bool`

Checks whether a list of dependencies is met.

The base path to which all tokens are
                                  appended.

| Parameter | Type | Description |
|---|---|---|
| `$tokens` | `array``<``int``, ``string``>` | The list of dependencies that have to meet. |
| `$base` | [`VirtualArrayPath`](/api/util/virtual-array-path/) | The base path to which all tokens are appended. |

Returns `bool` — all dependencies are met

### clear()

`public function clear(): void`

Clears the dependency cache.

### getDependTokens()

`public function getDependTokens(): array<int|string, mixed>`

Returns the list of provided tokens from the dependency cache.

Returns `array``<``int``|``string``, ``mixed``>` — Provided tokens from the dependency cache.

### populateArgumentBaseKeyRefs()

`public static function populateArgumentBaseKeyRefs(string $string): string`

Populate key references in an argument base string if necessary.

The argument base string.

| Parameter | Type | Description |
|---|---|---|
| `$string` | `string` | The argument base string. |

Returns `string` — The argument base string with empty brackets filled with correct sprintf() position specifiers.

### reset()

`public function reset(): void`

Discards every dependency token collected so far, by delegating to [`DependencyManager::clear()`](/api/validator/dependency-manager/#clear).
