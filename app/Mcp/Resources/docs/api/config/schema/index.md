# Schema

> The Quiote\\Config\\Schema namespace — 5 documented types.

Everything under `Quiote\Config\Schema`.

## Classes

| Class | Description |
|---|---|
| [`Diagnostic`](/api/config/schema/diagnostic/) | One structural-shape violation found by SchemaValidator. |
| [`Rule`](/api/config/schema/rule/) | A declarative description of one canonical-array shape, structural only (allowed keys, enums-of-kind, nesting) -- not required-ness that depends on runtime state or document processing order, which stays a Layer-2 semantic check in the handler's own executeArray()/toCanonicalArray(). |
| [`SchemaValidator`](/api/config/schema/schema-validator/) | Validates a canonical config array against a declarative Rule shape. |

## Enums

| Enum | Description |
|---|---|
| [`SchemaType`](/api/config/schema/schema-type/) | The kinds of shape a Rule can describe. |
| [`Severity`](/api/config/schema/severity/) |  |
