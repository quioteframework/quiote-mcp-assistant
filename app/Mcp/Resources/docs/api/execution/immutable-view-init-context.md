# ImmutableViewInitContext

> The ViewInitContext a view is initialized with: a fixed snapshot of the dispatch that produced it.

The [`ViewInitContext`](/api/execution/view-init-context/) a view is initialized with: a fixed snapshot of the dispatch that produced it.

Built by the executor, [`ViewFactory`](/api/execution/view-factory/) and the view test harness once the action has finished, from the view module and name, the output type, the originating action's module and name, and the action's attributes at that moment. The attributes are copied into the inherited [`AttributeHolder`](/api/util/attribute-holder/) so `View::getAttribute()` works, and `View` treats a `ViewInitContext` as immutable, ignoring later `setAttribute()` calls.

[`ImmutableViewInitContext::getPsrResponse()`](/api/execution/immutable-view-init-context/#getpsrresponse) wraps the [`WebResponse`](/api/response/web-response/) in a [`PsrResponseAdapter`](/api/http/psr-response-adapter/) on first use unless a PSR-7 response was supplied at construction.

The `getModuleName()`, `getOutputType()`, `getParameter()` and `getParameters()` members serve views written against a container-style API: no parameters are stored here, so those two answer the supplied default and an empty array respectively — raw request parameters are not reachable from a view through this object.

## Synopsis

`final class ImmutableViewInitContext extends AttributeHolder implements ViewInitContext`

|  |  |
|---|---|
| Extends | [`AttributeHolder`](/api/util/attribute-holder/) |
| Implements | [`ViewInitContext`](/api/execution/view-init-context/) |
| Source | `Execution/ImmutableViewInitContext.php` |

## Constructor

### __construct()

`public function __construct(Context $context, string $viewModule, string $viewName, string $outputType, ?string $actionModule, ?string $actionName, array<string, mixed> $actionAttributes, WebResponse $response, ?ResponseInterface $psrResponse = null, ?object $validationManager = null): mixed`

Constructor.

An array of parameters to be set right away.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$viewModule` | `string` |  |
| `$viewName` | `string` |  |
| `$outputType` | `string` |  |
| `$actionModule` | `?``string` |  |
| `$actionName` | `?``string` |  |
| `$actionAttributes` | `array``<``string``, ``mixed``>` |  |
| `$response` | [`WebResponse`](/api/response/web-response/) |  |
| `$psrResponse` | `?`[`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$validationManager` | `?``object` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getActionAttributes(): array<string, mixed>`](#getactionattributes) |  |
| [`getActionModuleName(): ?string`](#getactionmodulename) | Returns the module of the action that selected this view. |
| [`getActionName(): ?string`](#getactionname) | Returns the name of the action that selected this view, or null when there was none. |
| [`getContext(): Context`](#getcontext) | Returns the application Context the view is rendering under. |
| [`getModuleName(): string`](#getmodulename) | Return action module name for legacy code that called getModuleName(). |
| [`getOutputType(): OutputTypeNameProvider`](#getoutputtype) | Return legacy-style output type object proxy requirement: legacy code sometimes dereferenced $this->container->getOutputType()->getName(). |
| [`getOutputTypeName(): string`](#getoutputtypename) | Returns the lowercase name of the output type the view renders for. |
| [`getParameter(mixed $name, mixed $default = null): mixed`](#getparameter) | Legacy parameter bag access – always returns $default (no parameters are stored in immutable context). |
| [`getParameters(): array<string, mixed>`](#getparameters) | Expose an empty parameter array for completeness. |
| [`getPsrResponse(): ResponseInterface`](#getpsrresponse) | Returns the PSR-7 response backing this context, never null. |
| [`getResponse(): WebResponse`](#getresponse) | Returns the response the view writes its rendered output into. |
| [`getValidationManager(): ?object`](#getvalidationmanager) | Return the validation manager, preferring the one injected at construction time (which carries the live error state from the current request). |
| [`getViewModuleName(): string`](#getviewmodulename) | Returns the canonical name of the module hosting the view. |
| [`getViewName(): string`](#getviewname) | Returns the canonical name of the view being rendered. |

### getActionAttributes()

`public function getActionAttributes(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### getActionModuleName()

`public function getActionModuleName(): ?string`

Returns the module of the action that selected this view.

Null when the view was reached without an originating action, so callers that need a module name should fall back to the view module.

Returns `?``string`

### getActionName()

`public function getActionName(): ?string`

Returns the name of the action that selected this view, or null when there was none.

Returns `?``string`

### getContext()

`public function getContext(): Context`

Returns the application Context the view is rendering under.

Returns [`Context`](/api/context/)

### getModuleName()

`public function getModuleName(): string`

Return action module name for legacy code that called getModuleName().

Returns `string`

### getOutputType()

`public function getOutputType(): OutputTypeNameProvider`

Return legacy-style output type object proxy requirement: legacy code sometimes dereferenced $this->container->getOutputType()->getName().

We can't cheaply recreate the output type object here without a controller reference, so omit for now; views should use View::getCurrentOutputType().

Returns [`OutputTypeNameProvider`](/api/execution/output-type-name-provider/) — An anonymous object exposing getName(): string.

### getOutputTypeName()

`public function getOutputTypeName(): string`

Returns the lowercase name of the output type the view renders for.

Returns `string`

### getParameter()

`public function getParameter(mixed $name, mixed $default = null): mixed`

Legacy parameter bag access – always returns $default (no parameters are stored in immutable context).

Slot/layout code that checks flags like 'is_slot' will simply see the default (false) and continue.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$default` | `mixed` |  |

Returns `mixed`

### getParameters()

`public function getParameters(): array<string, mixed>`

Expose an empty parameter array for completeness.

Returns `array``<``string``, ``mixed``>`

### getPsrResponse()

`public function getPsrResponse(): ResponseInterface`

Returns the PSR-7 response backing this context, never null.

An explicitly supplied response is returned as-is. Otherwise the WebResponse is wrapped in a PsrResponseAdapter on first call and that adapter is retained, so repeated calls hand back the same instance.

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### getResponse()

`public function getResponse(): WebResponse`

Returns the response the view writes its rendered output into.

Returns [`WebResponse`](/api/response/web-response/)

### getValidationManager()

`public function getValidationManager(): ?object`

Return the validation manager, preferring the one injected at construction time (which carries the live error state from the current request).

Falls back to creating a fresh instance only when none was supplied — callers that need error messages (e.g. JSON error views) must pass the validation manager explicitly via the constructor.

Returns `?``object`

### getViewModuleName()

`public function getViewModuleName(): string`

Returns the canonical name of the module hosting the view.

Returns `string`

### getViewName()

`public function getViewName(): string`

Returns the canonical name of the view being rendered.

Returns `string`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Append an attribute. |
| `appendAttributeByRef()` | [`AttributeHolder`](/api/util/attribute-holder/) | Append an attribute by reference. |
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearAttributes()` | [`AttributeHolder`](/api/util/attribute-holder/) | Clear all attributes. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an attribute. |
| `getAttributeNames()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an array of attribute names. |
| `getAttributeNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve all attributes within a namespace. |
| `getAttributeNamespaces()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an array of attribute namespaces. |
| `getAttributes()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve all attributes within a namespace. |
| `getDefaultNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Get the default namespace name |
| `getFlatAttributeNames()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an array of flattened attribute names. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `hasAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Indicates whether or not an attribute exists. |
| `hasAttributeNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Indicates whether or not an attribute namespace exists. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `removeAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Remove an attribute. |
| `removeAttributeNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Remove an attribute namespace and all of its associated attributes. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `reset()` | [`ParameterHolder`](/api/util/parameter-holder/) | Removes every parameter held, leaving the holder empty for reuse. |
| `setAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Set an attribute. |
| `setAttributeByRef()` | [`AttributeHolder`](/api/util/attribute-holder/) | Set an attribute by reference. |
| `setAttributes()` | [`AttributeHolder`](/api/util/attribute-holder/) | Set an array of attributes. |
| `setAttributesByRef()` | [`AttributeHolder`](/api/util/attribute-holder/) | Set an array of attributes by reference. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
