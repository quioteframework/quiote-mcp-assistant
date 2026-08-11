# TriadDiagnosticsScanner

> Diagnoses the Action/View/Template triad convention (`Actions/{Action}Action.php` <-> `Views/{Action}{ViewName}View.php` <-> `Templates/{Action}{ViewName}.php`) for every action ModuleActionDiscovery finds, independent of whether the action is ever actually routed to.

Diagnoses the Action/View/Template triad convention (`Actions/{Action}Action.php` <-> `Views/{Action}{ViewName}View.php` <-> `Templates/{Action}{ViewName}.php`) for every action [`ModuleActionDiscovery`](/api/routing/compiler/module-action-discovery/) finds, independent of whether the action is ever actually routed to.

Three checks, each only attempted once the prior one succeeds (a missing action class means there is nothing to reflect a view name from, etc.):

- `MISSING_ACTION_CLASS`: the `Actions/*Action.php` file does not define the class its own path/namespace convention implies. - `MISSING_VIEW`: `getDefaultViewName()` names a view with no matching `{Action}{ViewName}View` class and no legacy view file on disk. - `MISSING_TEMPLATE`: the view exists, but at least one of its `execute()`/`execute{OutputType}()` methods (per [`TriadViewResolver::executeMethodsFor()`](/api/routing/compiler/triad-view-resolver/#executemethodsfor)) has no matching template file for the extension its output type renders with (per [`TriadViewResolver::templateExtensionFor()`](/api/routing/compiler/triad-view-resolver/#templateextensionfor) -- the app's real renderer configuration when a `Controller` is supplied, `.php` otherwise). Convention-only, not a bug: it can only false-flag as missing, never hide a real gap, so it stays a warning. A method whose declared return type proves it always returns non-null content is skipped automatically ([`TriadViewResolver::alwaysReturnsContent()`](/api/routing/compiler/triad-view-resolver/#alwaysreturnscontent) -- per `ActionExecutor::renderView()`, a non-null return is the response body and the template/layer path is never reached, however the method body itself got there, e.g. via a shared base class's `setupHtml()`/`loadLayout()`). Whatever that can't prove (untyped or nullable return, `mixed`, `void`) falls back to an explicit opt-out via `@quiote-viewmethod-has-no-template` in the method's own docblock -- [`TriadViewResolver::declaresNoTemplate()`](/api/routing/compiler/triad-view-resolver/#declaresnotemplate).

`getDefaultViewName()` is read via `newInstanceWithoutConstructor()` ([`TriadViewResolver`](/api/routing/compiler/triad-view-resolver/)) so no constructor/DI side effects run; an action whose base classes make even this unsafe (an uncatchable fatal, not a Throwable) is simply the one gap this scanner cannot see -- no diagnostic is produced for that action, but no false one either.

## Synopsis

`final class TriadDiagnosticsScanner`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Routing/Compiler/TriadDiagnosticsScanner.php` |

## Constructor

### __construct()

`public function __construct(TriadViewResolver $views = new TriadViewResolver(…), ?Controller $controller = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$views` | [`TriadViewResolver`](/api/routing/compiler/triad-view-resolver/) |  |
| `$controller` | `?`[`Controller`](/api/controller/controller/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`scan(list<ModuleActionEntry> $entries): list<Diagnostic>`](#scan) |  |

### scan()

`public function scan(list<ModuleActionEntry> $entries): list<Diagnostic>`

| Parameter | Type | Description |
|---|---|---|
| `$entries` | `list``<`[`ModuleActionEntry`](/api/routing/compiler/module-action-entry/)`>` |  |

Returns `list``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>`
