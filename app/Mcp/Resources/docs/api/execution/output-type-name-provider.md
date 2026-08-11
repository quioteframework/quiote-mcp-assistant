# OutputTypeNameProvider

> Minimal contract for the legacy-style output type proxy returned by ImmutableViewInitContext::getOutputType().

Minimal contract for the legacy-style output type proxy returned by ImmutableViewInitContext::getOutputType().

Exists so callers relying on $view->getOutputType()->getName() get a real typed contract instead of a bare `object`.

## Synopsis

`interface OutputTypeNameProvider`

|  |  |
|---|---|
| Source | `Execution/OutputTypeNameProvider.php` |

## Methods

| Method | Description |
|---|---|
| [`getName(): string`](#getname) | Returns the name of the output type. |

### getName()

`abstract public function getName(): string`

Returns the name of the output type.

Returns `string`
