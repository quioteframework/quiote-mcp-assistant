# Toolkit

> Toolkit provides basic utility methods.

Toolkit provides basic utility methods.

## Synopsis

`final class Toolkit`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Util/Toolkit.php` |

## Methods

| Method | Description |
|---|---|
| [`buildUrl(array{scheme?: string, host?: string, port?: (int | string), user?: string, pass?: string, path?: string, query?: string, fragment?: string} $parts): string`](#buildurl) | Counterpart of PHP's parse_url(). |
| [`canonicalName(string $name): string`](#canonicalname) | Returns the canonical name for a dot-separated view/action/model name. |
| [`clearCache(string $path = ''): bool|void`](#clearcache) | Deletes a specified path in the cache dir recursively. |
| [`evaluateModuleDirective(string $moduleName, string $directiveNameFragment, array<string, mixed> $variables = []): string`](#evaluatemoduledirective) | Evaluates a given Config per-module directive using the given info. |
| [`expandDirectives(?string $value): ?string`](#expanddirectives) | Replace configuration directive identifiers in a string. |
| [`expandVariables(?string $string, array<string, mixed> $arguments = []): string`](#expandvariables) | Expand variables in a string. |
| [`floorDivide(float $numerator, int|float $denominator, int &$remainder): int`](#floordivide) | This function takes the numerator and divides it through the denominator while storing the remainder and returning the quotient. |
| [`getValueByKeyList(array<mixed> $array, array<int|string> $keys, mixed $default = null): mixed`](#getvaluebykeylist) | Tries to grab a value from the given array using the given list of keys. |
| [`isNotArray(mixed $value): bool`](#isnotarray) | Checks if a value is not an array |
| [`isPathAbsolute(string $path): bool`](#ispathabsolute) | Determine if a filesystem path is absolute. |
| [`isPortNecessary(string $scheme, int $port): bool`](#isportnecessary) | Determines whether a port declaration is necessary in a URL authority. |
| [`literalize(mixed $value, bool $expandDirectives = true): mixed`](#literalize) | Literalize a string value. |
| [`mkdir(string $path, int $mode = 509, bool $recursive = false, resource $context = null): bool`](#mkdir) | Creates a directory without sucking at permissions. |
| [`normalizePath(string $path): string`](#normalizepath) | Normalizes a path to contain only '/' as path delimiter. |
| [`overloadHelper(array<int, array{parameters: array<int, string>, name: string}> $definitions, array<int, mixed> $parameters): string`](#overloadhelper) | Returns the method from the given definition list matching the given parameters. |
| [`stringBase(string $baseString, string $compString, int &$equalAmount = 0): string`](#stringbase) | Returns the base for two strings (the part at the beginning of both which is equal) |
| [`uniqid(string $prefix = ''): string`](#uniqid) | Generate a proper unique ID. |

### buildUrl()

`public static function buildUrl(array{scheme?: string, host?: string, port?: (int | string), user?: string, pass?: string, path?: string, query?: string, fragment?: string} $parts): string`

Counterpart of PHP's parse_url().

The parts of the URL as defined by parse_url()

| Parameter | Type | Description |
|---|---|---|
| `$parts` | `array{scheme?: string, host?: string, port?: (int | string), user?: string, pass?: string, path?: string, query?: string, fragment?: string}` | The parts of the URL as defined by parse_url() |

Returns `string`

### canonicalName()

`public static function canonicalName(string $name): string`

Returns the canonical name for a dot-separated view/action/model name.

The view/action/model name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The view/action/model name. |

Returns `string` — The canonical name.

### clearCache()

`public static function clearCache(string $path = ''): bool|void`

Deletes a specified path in the cache dir recursively.

The path to remove

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | The path to remove |

Returns `bool``|``void` — False if the given path could not be resolved.

### evaluateModuleDirective()

`public static function evaluateModuleDirective(string $moduleName, string $directiveNameFragment, array<string, mixed> $variables = []): string`

Evaluates a given Config per-module directive using the given info.

The variables to expand in the directive value.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` | The name of the module |
| `$directiveNameFragment` | `string` | The relevant name fragment of the directive |
| `$variables` | `array``<``string``, ``mixed``>` | The variables to expand in the directive value. |

Returns `string` — The final value

### expandDirectives()

`public static function expandDirectives(?string $value): ?string`

Replace configuration directive identifiers in a string.

The value on which to run the replacement procedure.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `?``string` | The value on which to run the replacement procedure. |

Returns `?``string` — The new value.

### expandVariables()

`public static function expandVariables(?string $string, array<string, mixed> $arguments = []): string`

Expand variables in a string.

The variables to use.

| Parameter | Type | Description |
|---|---|---|
| `$string` | `?``string` | The format string. |
| `$arguments` | `array``<``string``, ``mixed``>` | The variables to use. |

Returns `string` — The expanded string.

### floorDivide()

`public static function floorDivide(float $numerator, int|float $denominator, int &$remainder): int`

This function takes the numerator and divides it through the denominator while storing the remainder and returning the quotient.

The remainder.

| Parameter | Type | Description |
|---|---|---|
| `$numerator` | `float` | The numerator. |
| `$denominator` | `int``|``float` | The denominator; must resolve to an int value, or a QuioteException is thrown. |
| `$remainder` | `int` | The remainder. |

Returns `int` — The floored quotient.

### getValueByKeyList()

`public static function getValueByKeyList(array<mixed> $array, array<int|string> $keys, mixed $default = null): mixed`

Tries to grab a value from the given array using the given list of keys.

A default return value, defaults to null.

| Parameter | Type | Description |
|---|---|---|
| `$array` | `array``<``mixed``>` | The array to search in. |
| `$keys` | `array``<``int``|``string``>` | The list of keys. |
| `$default` | `mixed` | A default return value, defaults to null. |

Returns `mixed` — The found value, or the default value if nothing found.

### isNotArray()

`public static function isNotArray(mixed $value): bool`

Checks if a value is not an array

The value to check

| Parameter | Type | Description |
|---|---|---|
| `$value` | `mixed` | The value to check |

Returns `bool` — The result.

### isPathAbsolute()

`public static function isPathAbsolute(string $path): bool`

Determine if a filesystem path is absolute.

A filesystem path.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | A filesystem path. |

Returns `bool` — true, if the path is absolute, otherwise false.

### isPortNecessary()

`public static function isPortNecessary(string $scheme, int $port): bool`

Determines whether a port declaration is necessary in a URL authority.

The port.

| Parameter | Type | Description |
|---|---|---|
| `$scheme` | `string` | The scheme (protocol identifier). |
| `$port` | `int` | The port. |

Returns `bool` — True, if port must be included, otherwise false.

### literalize()

`public static function literalize(mixed $value, bool $expandDirectives = true): mixed`

Literalize a string value.

Whether a leftover string also has its `%directive%`
                  references expanded. Pass false for text that did not come from a
                  configuration file -- [`EnvPlaceholder`](/api/config/env-placeholder/) literalizes what
                  the environment answered, and what a setting means should not depend on
                  whether a deployment's variable happens to hold a directive reference.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `mixed` | The value to literalize. |
| `$expandDirectives` | `bool` | Whether a leftover string also has its `%directive%` references expanded. Pass false for text that did not come from a configuration file -- [`EnvPlaceholder`](/api/config/env-placeholder/) literalizes what the environment answered, and what a setting means should not depend on whether a deployment's variable happens to hold a directive reference. |

Returns `mixed` — A literalized value.

### mkdir()

`public static function mkdir(string $path, int $mode = 509, bool $recursive = false, resource $context = null): bool`

Creates a directory without sucking at permissions.

A Context.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | The path name. |
| `$mode` | `int` | The mode. Really. Defaults to 0775. |
| `$recursive` | `bool` | Recursive or not. |
| `$context` | `resource` | A Context. |

Returns `bool` — The mkdir return value.

### normalizePath()

`public static function normalizePath(string $path): string`

Normalizes a path to contain only '/' as path delimiter.

The path to normalize.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | The path to normalize. |

Returns `string` — The unified bool The mkdir return value.

### overloadHelper()

`public static function overloadHelper(array<int, array{parameters: array<int, string>, name: string}> $definitions, array<int, mixed> $parameters): string`

Returns the method from the given definition list matching the given parameters.

The parameters which were passed to the function.

| Parameter | Type | Description |
|---|---|---|
| `$definitions` | `array``<``int``, ``array{parameters: array<int, string>, name: string}``>` | The definitions of the functions. |
| `$parameters` | `array``<``int``, ``mixed``>` | The parameters which were passed to the function. |

Returns `string` — The name of the function which matched.

### stringBase()

`public static function stringBase(string $baseString, string $compString, int &$equalAmount = 0): string`

Returns the base for two strings (the part at the beginning of both which is equal)

The number of characters which are equal.

| Parameter | Type | Description |
|---|---|---|
| `$baseString` | `string` | The base string. |
| `$compString` | `string` | The string which should be compared to the base string. |
| `$equalAmount` | `int` | The number of characters which are equal. |

Returns `string` — The equal part at the beginning of both strings.

### uniqid()

`public static function uniqid(string $prefix = ''): string`

Generate a proper unique ID.

An optional prefix

| Parameter | Type | Description |
|---|---|---|
| `$prefix` | `string` | An optional prefix |

Returns `string` — A properly unique ID
