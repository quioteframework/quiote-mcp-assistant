# ValidatorSchemaMapper

> The ValidatorSchemaMapper class in Quiote\\Mcp\\Compiler.

The `ValidatorSchemaMapper` class. It carries no description of its own yet.

:::caution[Deprecated]
This class is deprecated. Since 1.2.5, use [`ValidatorSchemaMapper`](/api/validator/compiler/json-schema/validator-schema-mapper/). The mapper moved into core once OpenAPI generation became a second consumer of it -- validator IR to JSON Schema was never MCP-specific. Kept as a forwarding shim so existing callers of the published package keep working.
:::

## Synopsis

`final class ValidatorSchemaMapper`

|  |  |
|---|---|
| Source | `Compiler/ValidatorSchemaMapper.php` |

## Constructor

### __construct()

`public function __construct(): mixed`

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`toInputSchema(ValidatorPlan $plan, string $methodToken): array<string, mixed>|null`](#toinputschema) |  |

### toInputSchema()

`public function toInputSchema(ValidatorPlan $plan, string $methodToken): array<string, mixed>|null`

| Parameter | Type | Description |
|---|---|---|
| `$plan` | [`ValidatorPlan`](/api/validator/compiler/ir/validator-plan/) |  |
| `$methodToken` | `string` |  |

Returns `array``<``string``, ``mixed``>``|``null`
