# EnvPlaceholder

> The `%env(NAME)%` / `%env(NAME, fallback)%` placeholder: a configuration value that comes from the process environment.

The `%env(NAME)%` / `%env(NAME, fallback)%` placeholder: a configuration value that comes from the process environment.

Unlike a `%directive%`, which [`Toolkit::expandDirectives()`](/api/util/toolkit/#expanddirectives) resolves while a configuration file is being compiled, this is resolved when the compiled artifact is *loaded*. That difference is the whole point:

- the compiled cache never holds the value, so a warmed cache baked into a container image carries the placeholder rather than the build machine's environment, and a secret does not land in a file on disk; - changing the variable and restarting the process is enough to change the setting -- no recompilation, no cache invalidation, nothing to key the cache on.

A placeholder standing alone as the whole value is literalized the same way a configuration file's own literals are -- `true`/`off`/`42`/`0.5` become bool/int/float -- so `Config::getBool()` and `Config::getInt()`, both of which reject a string, work on it. A placeholder embedded in a longer string (`https://%env(API_HOST)%/v1`) is substituted textually and the result stays a string.

The resolved text is never re-expanded: neither `%directive%` nor a further `%env(...)%` inside a variable's value or a fallback means anything. What a configuration value resolves to should not depend on data arriving from outside the configuration.

"The environment" is whatever [`Environment`](/api/support/environment/environment/)'s reader answers with, which covers both a variable the platform exported and one a dotenv bootstrap loaded into `$_ENV` without calling `putenv()`. A placeholder does not care which of the two a deployment used.

This resolves compiled configuration declarations and nothing else. Never hand it a request parameter, a header or any other client-supplied string: the variable to read comes from the text it is given, so anything a client can steer would turn it into a way to read the process's environment. The `HTTP_` namespace is refused outright for the same reason -- see [`EnvPlaceholder::assertNotRequestControlled()`](/api/config/env-placeholder/#assertnotrequestcontrolled).

## Synopsis

`final class EnvPlaceholder`

|  |  |
|---|---|
| Since | `4.2.0` |
| Source | `Config/EnvPlaceholder.php` |

## Methods

| Method | Description |
|---|---|
| [`contains(mixed $value): bool`](#contains) | Whether $value contains anything that looks like a placeholder, at any depth of a compiled declaration's arrays. |
| [`resolve(mixed $value, ?string $sourceRef = null): mixed`](#resolve) | Every placeholder in $value replaced by what the environment says, at any depth of a compiled declaration's arrays. |

### contains()

`public static function contains(mixed $value): bool`

Whether $value contains anything that looks like a placeholder, at any depth of a compiled declaration's arrays.

"Looks like" rather than "is": a malformed `%env(...)%` answers true here so that [`EnvPlaceholder::resolve()`](/api/config/env-placeholder/#resolve) gets the chance to reject it by name, instead of it being silently cached and applied as a literal string.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `mixed` |  |

Returns `bool`

### resolve()

`public static function resolve(mixed $value, ?string $sourceRef = null): mixed`

Every placeholder in $value replaced by what the environment says, at any depth of a compiled declaration's arrays.

The configuration file the value was compiled from, named in
                   any error raised here. This is the one thing the failure needs and the one
                   thing the loaded artifact still knows.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `mixed` |  |
| `$sourceRef` | `?``string` | The configuration file the value was compiled from, named in any error raised here. This is the one thing the failure needs and the one thing the loaded artifact still knows. |

Returns `mixed`

| Throws | When |
|---|---|
| `ConfigurationException` | If a variable is unset and has no fallback, or a placeholder is malformed. |
