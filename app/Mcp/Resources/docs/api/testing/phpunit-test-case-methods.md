# PHPUnitTestCaseMethods

> Trait for adding PHPUnit 12 compatibility to PhpUnitTestCase

Trait for adding PHPUnit 12 compatibility to PhpUnitTestCase

## Synopsis

`trait PHPUnitTestCaseMethods`

|  |  |
|---|---|
| Source | `Testing/PHPUnitTestCaseMethods.php` |

## Methods

| Method | Description |
|---|---|
| [`createAttribute(string $name, mixed $value = null): void`](#createattribute) | Create attributes for custom annotations |
| [`getAnnotations(): array<string, array<string, mixed>>`](#getannotations) | Get test annotations/attributes in a format compatible with both PHPUnit < 10 and >= 10 |

### createAttribute()

`public function createAttribute(string $name, mixed $value = null): void`

Create attributes for custom annotations

The value of the annotation

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the annotation |
| `$value` | `mixed` | The value of the annotation |

### getAnnotations()

`protected function getAnnotations(): array<string, array<string, mixed>>`

Get test annotations/attributes in a format compatible with both PHPUnit < 10 and >= 10

Returns `array``<``string``, ``array``<``string``, ``mixed``>``>` — The annotations
