# Compiler

> The Quiote\\Request\\Compiler namespace — 3 documented types.

Everything under `Quiote\Request\Compiler`.

## Classes

| Class | Description |
|---|---|
| [`RequestDtoDefinition`](/api/request/compiler/request-dto-definition/) | Format-independent description of a #[MapRequest] DTO class: its constructor-promoted properties, in declaration order. |
| [`RequestDtoProperty`](/api/request/compiler/request-dto-property/) | One constructor-promoted property of a #[MapRequest] DTO, as reflected by RequestDtoScanner. |
| [`RequestDtoScanner`](/api/request/compiler/request-dto-scanner/) | Reflects a #[MapRequest] DTO class exactly once (results are cached by RequestDtoRegistry) to produce two independent things from the same walk of its constructor-promoted properties: |
