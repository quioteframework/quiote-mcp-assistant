# BaseConfigHandler

> BaseConfigHandler allows a developer to create a custom formatted configuration file pertaining to any information they like.

BaseConfigHandler allows a developer to create a custom formatted configuration file pertaining to any information they like.

A handler returns a declaration -- data -- from execute(); turning that into the compiled cache file is the cache's job (see [`CompiledArtifact`](/api/config/compiled-artifact/)), not the handler's.

## Synopsis

`abstract class BaseConfigHandler extends ParameterHolder`

|  |  |
|---|---|
| Extends | [`ParameterHolder`](/api/util/parameter-holder/) |
| Since | `1.0.0` |
| Source | `Config/BaseConfigHandler.php` |

## Methods

| Method | Description |
|---|---|
| [`literalize(mixed $value): mixed`](#literalize) | Literalize a string value. |
| [`replaceConstants(string $value): string`](#replaceconstants) | Replace configuration directive identifiers in a string. |
| [`replacePath(string $path): string`](#replacepath) | Replace a relative filesystem path with an absolute one. |

### literalize()

`public static function literalize(mixed $value): mixed`

Literalize a string value.

The value to literalize.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `mixed` | The value to literalize. |

Returns `mixed` — A literalized value.

### replaceConstants()

`public static function replaceConstants(string $value): string`

Replace configuration directive identifiers in a string.

The value on which to run the replacement procedure.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string` | The value on which to run the replacement procedure. |

Returns `string` — The new value.

### replacePath()

`public static function replacePath(string $path): string`

Replace a relative filesystem path with an absolute one.

A relative filesystem path.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | A relative filesystem path. |

Returns `string` — The new path.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `reset()` | [`ParameterHolder`](/api/util/parameter-holder/) | Removes every parameter held, leaving the holder empty for reuse. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
