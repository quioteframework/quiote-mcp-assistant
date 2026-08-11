# JsonSchema

> The Quiote\\Validator\\Compiler\\JsonSchema namespace — 2 documented types.

Everything under `Quiote\Validator\Compiler\JsonSchema`.

## Classes

| Class | Description |
|---|---|
| [`ActionInputSchemaResolver`](/api/validator/compiler/json-schema/action-input-schema-resolver/) | Derives a JSON Schema for one action+method's request parameters from whatever validators that action declares, so a single declaration can drive HTTP validation, an MCP tool's `inputSchema` and an OpenAPI operation's parameters/requestBody. |
| [`ValidatorSchemaMapper`](/api/validator/compiler/json-schema/validator-schema-mapper/) | Maps a [`ValidatorPlan`](/api/validator/compiler/ir/validator-plan/) (the format-independent validator IR) to a JSON Schema object describing the request parameters an action accepts -- one validator declaration drives HTTP validation, the `inputSchema` of an action exposed as an MCP tool, and the parameters/requestBody of an OpenAPI operation alike. |
