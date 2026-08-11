# TriadViewResolver

> Shared Action -> View -> Template resolution for the triad convention (`Actions/{Action}Action.php` <-> `Views/{Action}{ViewName}View.php` <-> `Templates/{Action}{ViewName}.php`), used by both TriadDiagnosticsScanner (which only needs existence) and `Quiote\\Introspection\\AppIntrospectionCompiler` (which needs the resolved file paths for the introspection artifact), so the naming convention is decoded in exactly one place.

Shared Action -> View -> Template resolution for the triad convention (`Actions/{Action}Action.php` <-> `Views/{Action}{ViewName}View.php` <-> `Templates/{Action}{ViewName}.php`), used by both [`TriadDiagnosticsScanner`](/api/routing/compiler/triad-diagnostics-scanner/) (which only needs existence) and `Quiote\Introspection\AppIntrospectionCompiler` (which needs the resolved file paths for the introspection artifact), so the naming convention is decoded in exactly one place.

## Synopsis

`final class TriadViewResolver`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Routing/Compiler/TriadViewResolver.php` |

## Methods

| Method | Description |
|---|---|
| [`alwaysReturnsContent(ReflectionMethod $method): bool`](#alwaysreturnscontent) | Whether this `execute*()` method's declared return type guarantees it always returns a non-null value on every path -- per `ActionExecutor::renderView()`, a non-null return becomes the response body directly and the template/layer path (`View::renderLayers()`) is never reached, regardless of what the method body does internally (e.g. |
| [`canonicalViewToken(ModuleActionEntry $entry, string $viewToken): string`](#canonicalviewtoken) | The canonical form of a view token for the given module/action pair. |
| [`declaresNoTemplate(ReflectionMethod $method): bool`](#declaresnotemplate) | Whether this specific `execute*()` method opts out of the `MISSING_TEMPLATE` check via `@quiote-viewmethod-has-no-template` in its own docblock (inherited from whichever class actually declares it, same as ordinary method resolution). |
| [`executeMethodsFor(ReflectionClass<object> $view): list<ReflectionMethod>`](#executemethodsfor) | The `execute()`/`execute{OutputType}()` methods a view class declares (own or inherited from an app-level base view), one per output type it handles -- mirrors `ActionExecutor`'s own `'execute' . |
| [`legacyViewFileFor(ModuleActionEntry $entry, string $canonicalViewToken): string`](#legacyviewfilefor) | The file path of the non-class view for a module/view token pair. |
| [`outputTypeNameFor(ReflectionMethod $method): ?string`](#outputtypenamefor) | The output type name an `execute*()` method is resolved for, or null for the bare `execute()` method, which stands in for whichever output type is otherwise in effect (the app's configured default, absent further context). |
| [`resolveExistingViewFile(ModuleActionEntry $entry, string $canonicalViewToken, string $namespacePrefix): ?string`](#resolveexistingviewfile) | Existing view class name, or the legacy view file path if only that exists, or null if neither does. |
| [`resolveViewToken(ReflectionClass<object> $reflection): ?string`](#resolveviewtoken) | The view an action *declares* as its default, for triad/diagnostic purposes -- deliberately narrower than "whatever `getDefaultViewName()` * returns". |
| [`templateExtensionFor(ReflectionMethod $method, ?Controller $controller): string`](#templateextensionfor) | The template file extension (leading dot included) that a given `execute*()` method's output type renders with, resolved from the app's real, already-initialized output type/renderer configuration when available. |
| [`templateFileFor(ModuleActionEntry $entry, string $canonicalViewToken, string $extension = '.php'): string`](#templatefilefor) | The template file path a canonical view token renders from. |
| [`viewClassFor(ModuleActionEntry $entry, string $canonicalViewToken, string $namespacePrefix): string`](#viewclassfor) | The fully qualified view class name the triad convention expects. |

### alwaysReturnsContent()

`public function alwaysReturnsContent(ReflectionMethod $method): bool`

Whether this `execute*()` method's declared return type guarantees it always returns a non-null value on every path -- per `ActionExecutor::renderView()`, a non-null return becomes the response body directly and the template/layer path (`View::renderLayers()`) is never reached, regardless of what the method body does internally (e.g.

`setupHtml()`/`loadLayout()` calls in a shared base class this scanner has no visibility into). Deliberately conservative: no declared return type, a nullable type, `void`, or `mixed` all count as "can't prove it", so the caller falls back to [`TriadViewResolver::declaresNoTemplate()`](/api/routing/compiler/triad-view-resolver/#declaresnotemplate) instead of guessing wrong in the direction that would hide a real missing template.

| Parameter | Type | Description |
|---|---|---|
| `$method` | `ReflectionMethod` |  |

Returns `bool`

### canonicalViewToken()

`public function canonicalViewToken(ModuleActionEntry $entry, string $viewToken): string`

The canonical form of a view token for the given module/action pair.

Runs the token through the module's `quiote.view.name` directive so an app can rewrite view names per module, keeping the raw token when that directive evaluates to an empty string, then canonicalises the result via [`Toolkit::canonicalName()`](/api/util/toolkit/#canonicalname). The result is what the class, view file and template lookups below all key off, so they stay consistent.

| Parameter | Type | Description |
|---|---|---|
| `$entry` | [`ModuleActionEntry`](/api/routing/compiler/module-action-entry/) |  |
| `$viewToken` | `string` |  |

Returns `string`

### declaresNoTemplate()

`public function declaresNoTemplate(ReflectionMethod $method): bool`

Whether this specific `execute*()` method opts out of the `MISSING_TEMPLATE` check via `@quiote-viewmethod-has-no-template` in its own docblock (inherited from whichever class actually declares it, same as ordinary method resolution).

Intended for a method whose output type returns content directly (e.g. `executeJson()` returning `json_encode(...)`) and therefore never renders a template by design -- [`TriadDiagnosticsScanner`](/api/routing/compiler/triad-diagnostics-scanner/) has no way to see that statically, so it would otherwise always false-flag a template that will never exist. Scoped per method, not per class, since one view can freely mix template-backed and template-less `execute*()` methods.

Most methods that return content directly don't need this at all -- [`TriadViewResolver::alwaysReturnsContent()`](/api/routing/compiler/triad-view-resolver/#alwaysreturnscontent) detects the common case (a declared, non-nullable return type) automatically. This annotation is the fallback for whatever that can't prove statically, e.g. an untyped or nullable return.

| Parameter | Type | Description |
|---|---|---|
| `$method` | `ReflectionMethod` |  |

Returns `bool`

### executeMethodsFor()

`public function executeMethodsFor(ReflectionClass<object> $view): list<ReflectionMethod>`

The `execute()`/`execute{OutputType}()` methods a view class declares (own or inherited from an app-level base view), one per output type it handles -- mirrors `ActionExecutor`'s own `'execute' .

| Parameter | Type | Description |
|---|---|---|
| `$view` | `ReflectionClass``<``object``>` |  |

Returns `list``<``ReflectionMethod``>`

### legacyViewFileFor()

`public function legacyViewFileFor(ModuleActionEntry $entry, string $canonicalViewToken): string`

The file path of the non-class view for a module/view token pair.

Resolved from the module's `quiote.view.path` directive. The path is returned whether or not a file exists there; [`TriadViewResolver::resolveExistingViewFile()`](/api/routing/compiler/triad-view-resolver/#resolveexistingviewfile) is the variant that checks.

| Parameter | Type | Description |
|---|---|---|
| `$entry` | [`ModuleActionEntry`](/api/routing/compiler/module-action-entry/) |  |
| `$canonicalViewToken` | `string` |  |

Returns `string`

### outputTypeNameFor()

`public function outputTypeNameFor(ReflectionMethod $method): ?string`

The output type name an `execute*()` method is resolved for, or null for the bare `execute()` method, which stands in for whichever output type is otherwise in effect (the app's configured default, absent further context).

| Parameter | Type | Description |
|---|---|---|
| `$method` | `ReflectionMethod` |  |

Returns `?``string`

### resolveExistingViewFile()

`public function resolveExistingViewFile(ModuleActionEntry $entry, string $canonicalViewToken, string $namespacePrefix): ?string`

Existing view class name, or the legacy view file path if only that exists, or null if neither does.

| Parameter | Type | Description |
|---|---|---|
| `$entry` | [`ModuleActionEntry`](/api/routing/compiler/module-action-entry/) |  |
| `$canonicalViewToken` | `string` |  |
| `$namespacePrefix` | `string` |  |

Returns `?``string`

### resolveViewToken()

`public function resolveViewToken(ReflectionClass<object> $reflection): ?string`

The view an action *declares* as its default, for triad/diagnostic purposes -- deliberately narrower than "whatever `getDefaultViewName()` * returns".

| Parameter | Type | Description |
|---|---|---|
| `$reflection` | `ReflectionClass``<``object``>` |  |

Returns `?``string`

### templateExtensionFor()

`public function templateExtensionFor(ReflectionMethod $method, ?Controller $controller): string`

The template file extension (leading dot included) that a given `execute*()` method's output type renders with, resolved from the app's real, already-initialized output type/renderer configuration when available.

Falls back to the PHP-renderer convention (`.php`) when no Controller is supplied, or the output type/renderer can't be resolved (e.g. a name with no configured output type) -- the same default this check used before per-output-type extensions existed.

| Parameter | Type | Description |
|---|---|---|
| `$method` | `ReflectionMethod` |  |
| `$controller` | `?`[`Controller`](/api/controller/controller/) |  |

Returns `string`

### templateFileFor()

`public function templateFileFor(ModuleActionEntry $entry, string $canonicalViewToken, string $extension = '.php'): string`

The template file path a canonical view token renders from.

Takes the module's `quiote.template.directory` directive, strips any trailing slash from it and appends the view token plus `$extension` (leading dot included; [`TriadViewResolver::templateExtensionFor()`](/api/routing/compiler/triad-view-resolver/#templateextensionfor) supplies the output-type-specific one). Existence is not checked.

| Parameter | Type | Description |
|---|---|---|
| `$entry` | [`ModuleActionEntry`](/api/routing/compiler/module-action-entry/) |  |
| `$canonicalViewToken` | `string` |  |
| `$extension` | `string` |  |

Returns `string`

### viewClassFor()

`public function viewClassFor(ModuleActionEntry $entry, string $canonicalViewToken, string $namespacePrefix): string`

The fully qualified view class name the triad convention expects.

Composes `{$namespacePrefix}\Modules\{module}\Views\{token}View`, with any `/` in the canonical token turned into a namespace separator so a nested view token maps onto a sub-namespace. Purely a name computation: the class is not required to exist.

| Parameter | Type | Description |
|---|---|---|
| `$entry` | [`ModuleActionEntry`](/api/routing/compiler/module-action-entry/) |  |
| `$canonicalViewToken` | `string` |  |
| `$namespacePrefix` | `string` |  |

Returns `string`
