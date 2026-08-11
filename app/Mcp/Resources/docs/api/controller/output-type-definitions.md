# OutputTypeDefinitions

> What the compiled `output_types` configuration declares, as data.

What the compiled `output_types` configuration declares, as data.

The compiled form used to be statements `require`d inside [`Controller::initialize()`](/api/controller/controller/#initialize), constructing each [`OutputType`](/api/controller/output-type/) and assigning it into `$this->outputTypes` from a scope it had no business reaching. It is a declaration now, for the same reasons the compiled factories and databases configurations are -- see [`FactoryDefinitions`](/api/config/factory/factory-definitions/).

## Synopsis

`final readonly class OutputTypeDefinitions`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `Controller/OutputTypeDefinitions.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$default` | `?``string` | _readonly._ |
| `$outputTypes` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(array<string, array{parameters: array<string, mixed>, renderers: array<string, array<string, mixed>>, defaultRenderer: ?string, layouts: array<string, array<string, mixed>>, defaultLayout: ?string, exceptionTemplate: ?string}> $outputTypes, ?string $default): mixed`

The output type answered when none is named. Null is legal: a
            configuration may declare types without electing one, and
            [`Controller::getOutputType()`](/api/controller/controller/#getoutputtype) falls back on its own terms.

| Parameter | Type | Description |
|---|---|---|
| `$outputTypes` | `array``<``string``, ``array{parameters: array<string, mixed>, renderers: array<string, array<string, mixed>>, defaultRenderer: ?string, layouts: array<string, array<string, mixed>>, defaultLayout: ?string, exceptionTemplate: ?string}``>` | Keyed by output-type name, in declaration order. |
| `$default` | `?``string` | The output type answered when none is named. Null is legal: a configuration may declare types without electing one, and [`Controller::getOutputType()`](/api/controller/controller/#getoutputtype) falls back on its own terms. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromCompiled(mixed $compiled, string $source = 'the compiled output_types cache'): OutputTypeDefinitions`](#fromcompiled) | Read a compiled declaration, rejecting anything malformed. |

### fromCompiled()

`public static function fromCompiled(mixed $compiled, string $source = 'the compiled output_types cache'): OutputTypeDefinitions`

Read a compiled declaration, rejecting anything malformed.

Whatever the compiled file returned.

| Parameter | Type | Description |
|---|---|---|
| `$compiled` | `mixed` | Whatever the compiled file returned. |
| `$source` | `string` |  |

Returns [`OutputTypeDefinitions`](/api/controller/output-type-definitions/)

| Throws | When |
|---|---|
| `ConfigurationException` | When $compiled is not a declaration this version understands -- most likely a cache compiled by an earlier one. |
