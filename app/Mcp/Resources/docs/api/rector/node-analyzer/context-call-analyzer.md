# ContextCallAnalyzer

> Decides whether a method call actually reaches a Quiote Context.

Decides whether a method call actually reaches a Quiote [`Context`](/api/context/).

Every rewriting rule in this package goes through here, because `getContext()` and `$context` are not distinctive names and getting this wrong corrupts unrelated code. The framework's own tree contains, right now:

- `$span->getContext()->isValid()` and `->getTraceId()` — OpenTelemetry span contexts, one of them in first-party source (`Quiote\Telemetry\Trace`), not just tests. - `$context->getRows()` — a terminal dashboard render context. - `$context->method('getName')` — a **PHPUnit mock builder** on a mocked Context. This one is the reason type resolution alone is not enough: the receiver genuinely *is* a `Context` (as `MockObject&Context`), so only the method name distinguishes it.

So the test has two halves that must both hold: the receiver resolves to a Quiote Context, **and** the method being called is one Context actually declares. A rule written as "rewrite * any call on a Context-typed receiver" would rewrite mock setup into nonsense.

## Synopsis

`final readonly class ContextCallAnalyzer`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `NodeAnalyzer/ContextCallAnalyzer.php` |

## Constructor

### __construct()

`public function __construct(NodeTypeResolver $nodeTypeResolver): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$nodeTypeResolver` | `NodeTypeResolver` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`classNameOf(Type $type): ?string`](#classnameof) | The class name a resolved type names, or null when it names none or more than one. |
| [`isAnyContextCall(MethodCall $methodCall): bool`](#isanycontextcall) | Whether $methodCall calls any rewritable Context method on a real Context. |
| [`isContextCall(MethodCall $methodCall, string $methodName): bool`](#iscontextcall) | Whether $methodCall is a call to $methodName on something that really is a Quiote Context. |
| [`isContextExpr(Expr $expr): bool`](#iscontextexpr) | Whether an expression evaluates to a Quiote Context. |
| [`isContextType(Type $type): bool`](#iscontexttype) | Whether a resolved type is a Quiote Context. |
| [`receiverClassNames(Expr $expr): array<int, string>`](#receiverclassnames) | The object classes a receiver expression resolves to, if any. |
| [`rewritableMethods(): array<int, string>`](#rewritablemethods) | The method names a rule may rewrite. |

### classNameOf()

`public function classNameOf(Type $type): ?string`

The class name a resolved type names, or null when it names none or more than one.

Asked of the type rather than tested with instanceof: PHPStan deprecated inspecting its type objects directly, and a union resolving to several classes has no single answer to give.

| Parameter | Type | Description |
|---|---|---|
| `$type` | `Type` |  |

Returns `?``string`

### isAnyContextCall()

`public function isAnyContextCall(MethodCall $methodCall): bool`

Whether $methodCall calls any rewritable Context method on a real Context.

For the residue reporter, which needs "this is a Context call we did not handle" without caring which accessor it was.

| Parameter | Type | Description |
|---|---|---|
| `$methodCall` | `MethodCall` |  |

Returns `bool`

### isContextCall()

`public function isContextCall(MethodCall $methodCall, string $methodName): bool`

Whether $methodCall is a call to $methodName on something that really is a Quiote Context.

Case-insensitive on the method name, because PHP is: the reference application contains `getTranslationmanager()` with a lowercase m, and a case-sensitive match would skip it and leave behind a call to a method that no longer exists.

| Parameter | Type | Description |
|---|---|---|
| `$methodCall` | `MethodCall` |  |
| `$methodName` | `string` |  |

Returns `bool`

### isContextExpr()

`public function isContextExpr(Expr $expr): bool`

Whether an expression evaluates to a Quiote Context.

Resolves through PHPStan, so `$this->getContext()`, a `Context`-typed parameter, a property and an application's own Context subclass are all recognised, and an unrelated object with a same-named method is not.

| Parameter | Type | Description |
|---|---|---|
| `$expr` | `Expr` |  |

Returns `bool`

### isContextType()

`public function isContextType(Type $type): bool`

Whether a resolved type is a Quiote Context.

Union and intersection types are handled by asking PHPStan for acceptance rather than unwrapping them: a mocked Context resolves to `MockObject&Context`, which *is* a Context and must be recognised as one -- the mock builder's `method()` call is excluded by name, not by pretending the receiver is something else.

Null is removed first, and that is not a convenience. `Action`, `View` and `Validator` declare `getContext()` as `?Context`, so `$this->getContext()->getService(...)` -- the shape the overwhelming majority of real call sites use -- resolves to `Context|null`, which a non-nullable `ObjectType` accepts only as *maybe*. Without this, every rule declined those sites and the residue reporter recorded nothing, so they were invisible in both directions. The framework's own tree hid it: `Service::getContext()` is non-nullable and no framework `Action`/`View` reaches these accessors at all.

Removing null cannot widen this wrongly: a genuinely unknown receiver (`mixed`) still fails, and a `?->` call is a different node type that no rule matches. Where the receiver really can be null, the rewrite replaces a call that would have fatalled with a property read that cannot.

| Parameter | Type | Description |
|---|---|---|
| `$type` | `Type` |  |

Returns `bool`

### receiverClassNames()

`public function receiverClassNames(Expr $expr): array<int, string>`

The object classes a receiver expression resolves to, if any.

Empty means the type names no class at all -- `mixed`, from an untyped parameter -- which is a different answer from "it resolves to some other class", and the residue report distinguishes them: one is confirmed not to be work, the other is unknown.

| Parameter | Type | Description |
|---|---|---|
| `$expr` | `Expr` |  |

Returns `array``<``int``, ``string``>`

### rewritableMethods()

`public static function rewritableMethods(): array<int, string>`

The method names a rule may rewrite.

Returns `array``<``int``, ``string``>`
