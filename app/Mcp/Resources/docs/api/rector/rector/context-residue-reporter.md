# ContextResidueReporter

> Reports the Context call sites the rewriting rules cannot touch, with a reason for each.

Reports the Context call sites the rewriting rules cannot touch, with a reason for each.

There is no static-call gap, despite an earlier commit here claiming one. Both halves work. What looked like a rule that would not fire was [`ResidueReport`](/api/rector/residue/residue-report/) overwriting its output once per Rector worker process, so the file held one worker's partial view. That is fixed there, by appending under a lock. The lesson is recorded because the false diagnosis was reached from absent debug output, and STDERR from a Rector worker does not reach the terminal -- so absent output is not evidence of absent execution.

Does not rewrite. Its entire output is a report, so the remaining work is a finite list rather than a discovery exercise -- which is the point: a migration that leaves an unknown quantity of hand-work behind cannot be scheduled.

Deliberately shares [`ContextCallAnalyzer`](/api/rector/node-analyzer/context-call-analyzer/) with the rewriting rules, so what it reports is exactly what they saw. A reporter with its own idea of "is this a Context call" would produce a list that does not correspond to what was skipped, which is worse than no list.

## What it reports, and why silence is not an option

A rule that declines a site leaves no trace. Nothing distinguishes "there were no sites here" from "there were sites and every rule refused them", and the second is where the residual work lives. So the reasons are enumerated rather than lumped into "unhandled":

- `not-container-built` — the class is outside the four hierarchies the container constructs, so no dependency can be injected into it. Much the largest category in the framework's own tree. - `no-class-to-inject-into` — the site is in a file with no class in it: a template, or a script. Distinct from the above because the answer differs — a class the container does not build still has a constructor a human could thread a dependency through. - `nullable-accessor` — `getDatabaseConnection()`, whose replacement is a call on an injected database manager rather than the manager itself, so it is not a mapping entry in rule 2. - `discarded-mutation` — a statement-level chain rooted in `getRequest()`. Already a no-op since the request became immutable; needs `FormPopulationConfig` and a `publish()`, which is a change of meaning. - `unresolvable-argument` — `getService($id)` with a variable or a plain string, where the target would have to be guessed. - `unhandled-accessor` — a deleted Context accessor still being called. Every accessor is on that list, including the ones a rule handles: a site a rule rewrote is gone before this reporter sees it, so what remains is exactly what was declined. - `foreign-receiver` — shaped like a Context call, but the receiver resolves to a definite other class. Not work to do; work confirmed not to be needed, which a report has to distinguish from silence. - `unresolved-receiver` — shaped like a Context call, and the receiver's type resolves to nothing at all, which in practice means an untyped `$context = null` parameter. Unlike the above, this one may well be work; it just cannot be decided without reading the call site. - `not-an-accessor` — the receiver is a Context and the method is not one it declares, which in practice means a PHPUnit mock builder on a mocked Context.

Written to `core.cache_dir`'s sibling by default, or wherever `QUIOTE_RECTOR_RESIDUE` points, on process shutdown. A Rector rule has no reporting channel of its own, and printing into the diff would be worse than a file.

## Synopsis

`final class ContextResidueReporter extends AbstractRector`

|  |  |
|---|---|
| Extends | `AbstractRector` |
| Since | `4.0.0` |
| Source | `Rector/ContextResidueReporter.php` |

## Constructor

### __construct()

`public function __construct(ContextCallAnalyzer $contextCallAnalyzer, ResidueReport $residueReport): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$contextCallAnalyzer` | [`ContextCallAnalyzer`](/api/rector/node-analyzer/context-call-analyzer/) |  |
| `$residueReport` | [`ResidueReport`](/api/rector/residue/residue-report/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getNodeTypes(): array<class-string<Node>>`](#getnodetypes) | List of nodes this class checks, classes that implements \PhpParser\Node See beautiful map of all nodes https://github.com/rectorphp/php-parser-nodes-docs#node-overview |
| [`refactor(Node $node): ?Node`](#refactor) | Always returns null: this rule records and never changes a node. |

### getNodeTypes()

`public function getNodeTypes(): array<class-string<Node>>`

List of nodes this class checks, classes that implements \PhpParser\Node See beautiful map of all nodes https://github.com/rectorphp/php-parser-nodes-docs#node-overview

Returns `array``<``class-string``<``Node``>``>`

### refactor()

`public function refactor(Node $node): ?Node`

Always returns null: this rule records and never changes a node.

| Parameter | Type | Description |
|---|---|---|
| `$node` | `Node` |  |

Returns `?``Node`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `autowire()` | `AbstractRector` |  |
| `enterNode()` | `AbstractRector` |  |
| `leaveNode()` | `AbstractRector` |  |
