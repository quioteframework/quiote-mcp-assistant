# AbstractContextInjectionRector

> Shared machinery for the rules that replace a Context accessor with an injected collaborator.

Shared machinery for the rules that replace a Context accessor with an injected collaborator.

All of them do the same four things: find the accessor calls in a class, decide what to inject for each, rewrite the calls to a property fetch, and add the constructor parameters. Only the third step differs between rules, so only that is abstract.

Rewriting happens at class level rather than at the call, because injecting a dependency needs the class -- the constructor to add a parameter to, and the properties already there to avoid colliding with.

## Synopsis

`abstract class AbstractContextInjectionRector extends AbstractRector`

|  |  |
|---|---|
| Extends | `AbstractRector` |
| Since | `4.0.0` |
| Source | `Rector/AbstractContextInjectionRector.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$contextCallAnalyzer` | [`ContextCallAnalyzer`](/api/rector/node-analyzer/context-call-analyzer/) | _readonly, protected._ |

## Constructor

### __construct()

`public function __construct(ContextCallAnalyzer $contextCallAnalyzer, ClassDependencyManipulator $classDependencyManipulator, ExtendedClassIndex $extendedClassIndex): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$contextCallAnalyzer` | [`ContextCallAnalyzer`](/api/rector/node-analyzer/context-call-analyzer/) |  |
| `$classDependencyManipulator` | `ClassDependencyManipulator` |  |
| `$extendedClassIndex` | [`ExtendedClassIndex`](/api/rector/node-analyzer/extended-class-index/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`buildReplacement(MethodCall $methodCall, string $propertyName): Expr`](#buildreplacement) | The expression that replaces the rewritten call. |
| [`buildReplacementForStaticCall(StaticCall $staticCall, string $propertyName): Expr`](#buildreplacementforstaticcall) | The expression that replaces a rewritten static call. |
| [`getNodeTypes(): array<class-string<Node>>`](#getnodetypes) | List of nodes this class checks, classes that implements \PhpParser\Node See beautiful map of all nodes https://github.com/rectorphp/php-parser-nodes-docs#node-overview |
| [`isInjectableClass(Class_ $class): bool`](#isinjectableclass) | Whether the container actually constructs this class, and so whether a constructor dependency added to it would ever be supplied. |
| [`prepare(Class_ $class): void`](#prepare) | Hook for work a rule needs to do once per class, before any call is examined. |
| [`propertyNameFor(string $injectableClass, array<string, string> $injected, ?Class_ $class = null): string`](#propertynamefor) | A property name for an injected class: its short name, lower-camel-cased. |
| [`refactor(Node $node): ?Node`](#refactor) | Rewrites a class's Context accessor calls into fetches of injected properties. |
| [`resolveInjectable(MethodCall $methodCall): ?class-string`](#resolveinjectable) | The class to inject in place of this call, or null to leave the call alone. |
| [`resolveInjectableForStaticCall(StaticCall $staticCall): ?class-string`](#resolveinjectableforstaticcall) | The static-call equivalent of [`AbstractContextInjectionRector::resolveInjectable()`](/api/rector/rector/abstract-context-injection-rector/#resolveinjectable), for the one rule that rewrites a static reach rather than an instance call. |

### buildReplacement()

`protected function buildReplacement(MethodCall $methodCall, string $propertyName): Expr`

The expression that replaces the rewritten call.

Defaults to a bare property fetch, which is what the accessor-to-dependency rules want: `getService(Foo::class)` becomes `$this->foo`. A rule whose injected collaborator is an accessor rather than the collaborator itself overrides this -- `getRequest()` becomes `$this->requestState->current()`, not `$this->requestState`.

| Parameter | Type | Description |
|---|---|---|
| `$methodCall` | `MethodCall` |  |
| `$propertyName` | `string` |  |

Returns `Expr`

### buildReplacementForStaticCall()

`protected function buildReplacementForStaticCall(StaticCall $staticCall, string $propertyName): Expr`

The expression that replaces a rewritten static call.

See [`AbstractContextInjectionRector::buildReplacement()`](/api/rector/rector/abstract-context-injection-rector/#buildreplacement).

| Parameter | Type | Description |
|---|---|---|
| `$staticCall` | `StaticCall` |  |
| `$propertyName` | `string` |  |

Returns `Expr`

### getNodeTypes()

`public function getNodeTypes(): array<class-string<Node>>`

List of nodes this class checks, classes that implements \PhpParser\Node See beautiful map of all nodes https://github.com/rectorphp/php-parser-nodes-docs#node-overview

Returns `array``<``class-string``<``Node``>``>`

### isInjectableClass()

`protected function isInjectableClass(Class_ $class): bool`

Whether the container actually constructs this class, and so whether a constructor dependency added to it would ever be supplied.

This is not a refinement, it is a correctness requirement, and running the rules against the framework is what surfaced it. `Quiote\Routing\HttpRedirectRoutingCallback` reaches `getRouting()` and looks like an ideal candidate -- but `RoutingCallbackPool` builds callbacks with a bare `new $className()`, so an injected parameter is never passed and the class fatals on construction. The same is true of models, config handlers and most of the framework's own infrastructure.

Only four hierarchies are built through the container and may therefore be injected into. Everything else is `new`'d by name somewhere, which is also what makes reordering the constructor safe here and unsafe generally: a positional caller would be silently broken.

Resolved from the declared parent rather than from the class itself. The class being rewritten need not be autoloadable -- a Rector fixture never is, and PHPStan's reflection provider does not know it -- but its *parent* is ordinary framework or application code that loads fine, and `is_a()` on the parent walks the rest of the hierarchy. A class with no parent, or a parent that cannot be loaded, is declined: "unknown" must not mean "assume injectable".

| Parameter | Type | Description |
|---|---|---|
| `$class` | `Class_` |  |

Returns `bool`

### prepare()

`protected function prepare(Class_ $class): void`

Hook for work a rule needs to do once per class, before any call is examined.

Rule 3 uses it to find the discarded-mutation statements: that has to be decided by looking *down* from a statement, which is not possible from the call node alone.

| Parameter | Type | Description |
|---|---|---|
| `$class` | `Class_` |  |

### propertyNameFor()

`protected function propertyNameFor(string $injectableClass, array<string, string> $injected, ?Class_ $class = null): string`

A property name for an injected class: its short name, lower-camel-cased.

Already-assigned class => property name.

| Parameter | Type | Description |
|---|---|---|
| `$injectableClass` | `string` |  |
| `$injected` | `array``<``string``, ``string``>` | Already-assigned class => property name. |
| `$class` | `?``Class_` |  |

Returns `string`

### refactor()

`public function refactor(Node $node): ?Node`

Rewrites a class's Context accessor calls into fetches of injected properties.

Walks the class body, asks the concrete rule what collaborator each accessor call stands for, replaces the call with a property fetch and adds a private constructor dependency per distinct collaborator, then repairs the synthesized constructor: parameters whose property the parent already declares lose their promotion, and the parameter order is normalised.

Returns null -- leaving the class untouched -- for an abstract or anonymous class, a class the rule does not consider injectable, a class something else extends (adding a constructor parameter there breaks subclasses either way), and for a class in which no accessor call was found.

| Parameter | Type | Description |
|---|---|---|
| `$node` | `Node` |  |

Returns `?``Node`

### resolveInjectable()

`abstract protected function resolveInjectable(MethodCall $methodCall): ?class-string`

The class to inject in place of this call, or null to leave the call alone.

Returning null is the default answer and the safe one: a rule that cannot determine its target with certainty must decline, so the site reaches the residue reporter instead of being rewritten to a guess.

| Parameter | Type | Description |
|---|---|---|
| `$methodCall` | `MethodCall` |  |

Returns `?``class-string`

### resolveInjectableForStaticCall()

`protected function resolveInjectableForStaticCall(StaticCall $staticCall): ?class-string`

The static-call equivalent of [`AbstractContextInjectionRector::resolveInjectable()`](/api/rector/rector/abstract-context-injection-rector/#resolveinjectable), for the one rule that rewrites a static reach rather than an instance call.

A separate hook rather than widening [`AbstractContextInjectionRector::resolveInjectable()`](/api/rector/rector/abstract-context-injection-rector/#resolveinjectable)'s parameter, because widening it would force every other rule to accept a node type it has nothing to say about -- and PHP's contravariance rules would make each of them a fatal error until they did.

| Parameter | Type | Description |
|---|---|---|
| `$staticCall` | `StaticCall` |  |

Returns `?``class-string`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `autowire()` | `AbstractRector` |  |
| `enterNode()` | `AbstractRector` |  |
| `leaveNode()` | `AbstractRector` |  |
