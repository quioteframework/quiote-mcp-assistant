# Ir

> The Quiote\\Docs\\Ir namespace — 10 documented types.

Everything under `Quiote\Docs\Ir`.

## Classes

| Class | Description |
|---|---|
| [`ApiIndex`](/api/docs/ir/api-index/) | Every documented class, plus the lookups the emitters need across them. |
| [`ClassDoc`](/api/docs/ir/class-doc/) | Everything one page needs about one class, interface, trait or enum. |
| [`ConstantDoc`](/api/docs/ir/constant-doc/) | One public class constant. |
| [`DocBlock`](/api/docs/ir/doc-block/) | The prose and tags of one docblock, already separated into the parts a page renders. |
| [`EnumCaseDoc`](/api/docs/ir/enum-case-doc/) | One case of an enum, with its backing value when it has one. |
| [`InheritedMember`](/api/docs/ir/inherited-member/) | A member a class gets from an ancestor, listed rather than documented. |
| [`MethodDoc`](/api/docs/ir/method-doc/) | One method, as documented on the page of the class that declares it. |
| [`ParamDoc`](/api/docs/ir/param-doc/) | One parameter of a method, with the type actually rendered and its prose. |
| [`PropertyDoc`](/api/docs/ir/property-doc/) | One property, including a constructor-promoted one. |
| [`TypeRef`](/api/docs/ir/type-ref/) | A type, kept as a tree rather than a string so each part can be linked independently. |
