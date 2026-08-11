# ValidatorSchemaMapper

> Maps a ValidatorPlan (the format-independent validator IR) to a JSON Schema object describing the request parameters an action accepts -- one validator declaration drives HTTP validation, the `inputSchema` of an action exposed as an MCP tool, and the parameters/requestBody of an OpenAPI operation alike.

Maps a [`ValidatorPlan`](/api/validator/compiler/ir/validator-plan/) (the format-independent validator IR) to a JSON Schema object describing the request parameters an action accepts -- one validator declaration drives HTTP validation, the `inputSchema` of an action exposed as an MCP tool, and the parameters/requestBody of an OpenAPI operation alike.

Deliberately best-effort and *descriptive*, not a faithful re-encoding of the validation logic: the emitted schema always keeps `additionalProperties: true` and the real enforcement still happens when the request is dispatched through the pipeline (the same validators run). So where a rule doesn't map cleanly to JSON Schema (a negative regex match, an operator group spanning several fields, an unrecognized validator class), we degrade to a looser description rather than dropping the field or misrepresenting it -- favoring a permissive schema with server-side validation over a strict but inaccurate one.

Only leaf validators keyed by a single request parameter contribute a property. Operator groups (and/or/not/xor) are flattened -- their child validators' fields are unioned in -- rather than modeled as allOf/anyOf/oneOf/not, since the goal is "which fields exist and roughly * what they accept," not a provable schema.

## Synopsis

`final class ValidatorSchemaMapper`

|  |  |
|---|---|
| Source | `Validator/Compiler/JsonSchema/ValidatorSchemaMapper.php` |

## Methods

| Method | Description |
|---|---|
| [`toInputSchema(ValidatorPlan $plan, string $methodToken): array<string, mixed>|null`](#toinputschema) |  |

### toInputSchema()

`public function toInputSchema(ValidatorPlan $plan, string $methodToken): array<string, mixed>|null`

The action method token (read/write/update/…,
       via [`HttpMethodMapper`](/api/execution/http-method-mapper/)) the schema is being
       derived for; only validators scoped to that method (or
       method-agnostic) apply.

| Parameter | Type | Description |
|---|---|---|
| `$plan` | [`ValidatorPlan`](/api/validator/compiler/ir/validator-plan/) |  |
| `$methodToken` | `string` | The action method token (read/write/update/…, via [`HttpMethodMapper`](/api/execution/http-method-mapper/)) the schema is being derived for; only validators scoped to that method (or method-agnostic) apply. |

Returns `array``<``string``, ``mixed``>``|``null` — A JSON Schema object, or null when the plan yields nothing describable (caller falls back to a permissive schema).
