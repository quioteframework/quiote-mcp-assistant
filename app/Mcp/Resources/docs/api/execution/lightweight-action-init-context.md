# LightweightActionInitContext

> The ActionInitContext every dispatch path constructs: the executor, the dispatch, security and validation middleware, the slot dispatcher and the input-schema resolver.

The [`ActionInitContext`](/api/execution/action-init-context/) every dispatch path constructs: the executor, the dispatch, security and validation middleware, the slot dispatcher and the input-schema resolver.

Holds the dispatch identity, request and response as readonly constructor state and adds only what an action needs to write back: the view module and view name, plus the attribute storage inherited from [`AttributeHolder`](/api/util/attribute-holder/), which is what a view later reads as the action's attributes.

The validation manager is resolved lazily from the container and cached, and can be replaced with [`LightweightActionInitContext::setValidationManager()`](/api/execution/lightweight-action-init-context/#setvalidationmanager) so an action's own `validate*()` methods see the same errors and exports as the XML validators that already ran.

## Synopsis

`class LightweightActionInitContext extends AttributeHolder implements ActionInitContext`

|  |  |
|---|---|
| Extends | [`AttributeHolder`](/api/util/attribute-holder/) |
| Implements | [`ActionInitContext`](/api/execution/action-init-context/) |
| Source | `Execution/LightweightActionInitContext.php` |

## Constructor

### __construct()

`public function __construct(Context $context, string $module, string $action, string $method, string $outputType, ?ServerRequestInterface $requestData, WebResponse $response): mixed`

Constructor.

An array of parameters to be set right away.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$method` | `string` |  |
| `$outputType` | `string` |  |
| `$requestData` | `?`[`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$response` | [`WebResponse`](/api/response/web-response/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getActionName(): string`](#getactionname) | Returns the name of the action being executed. |
| [`getContext(): Context`](#getcontext) | Returns the application Context the action is executing under. |
| [`getModuleName(): string`](#getmodulename) | Returns the name of the module the action was dispatched from. |
| [`getOutputTypeName(): string`](#getoutputtypename) | Returns the name of the output type selected for this dispatch. |
| [`getRequestData(): ?ServerRequestInterface`](#getrequestdata) | Returns the PSR-7 server request backing this dispatch. |
| [`getRequestMethod(): string`](#getrequestmethod) | Returns the request method token the action was dispatched with. |
| [`getResponse(): WebResponse`](#getresponse) | Returns the response the action and its view write into. |
| [`getValidationManager(): ?object`](#getvalidationmanager) | Returns the validation manager shared by this dispatch, or null when none can be resolved. |
| [`getViewModuleName(): ?string`](#getviewmodulename) | Returns the view module recorded by setViewModuleName(), or null when none was set. |
| [`getViewName(): ?string`](#getviewname) | Returns the view name recorded by setViewName(), or null when none was set. |
| [`setValidationManager(?object $vm): void`](#setvalidationmanager) | Replace the cached validation manager. |
| [`setViewModuleName(?string $module): void`](#setviewmodulename) | Records the module hosting the view to render, overriding the action's own module. |
| [`setViewName(?string $name): void`](#setviewname) | Records the name of the view to render for this action. |

### getActionName()

`public function getActionName(): string`

Returns the name of the action being executed.

Returns `string`

### getContext()

`public function getContext(): Context`

Returns the application Context the action is executing under.

Returns [`Context`](/api/context/)

### getModuleName()

`public function getModuleName(): string`

Returns the name of the module the action was dispatched from.

Returns `string`

### getOutputTypeName()

`public function getOutputTypeName(): string`

Returns the name of the output type selected for this dispatch.

Returns `string`

### getRequestData()

`public function getRequestData(): ?ServerRequestInterface`

Returns the PSR-7 server request backing this dispatch.

Null when the action is executed without a request, as in a slot or test dispatch assembled directly rather than from an incoming HTTP request.

Returns `?`[`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/)

### getRequestMethod()

`public function getRequestMethod(): string`

Returns the request method token the action was dispatched with.

Returns `string`

### getResponse()

`public function getResponse(): WebResponse`

Returns the response the action and its view write into.

Returns [`WebResponse`](/api/response/web-response/)

### getValidationManager()

`public function getValidationManager(): ?object`

Returns the validation manager shared by this dispatch, or null when none can be resolved.

The first successful lookup goes through the context's container and is cached on this instance, so XML validators, the action's own validate*() methods and error-handling code all observe the same error and export state. A container that cannot supply one — or that throws while trying — yields null rather than propagating, and the lookup is retried on the next call.

Returns `?``object`

### getViewModuleName()

`public function getViewModuleName(): ?string`

Returns the view module recorded by setViewModuleName(), or null when none was set.

Returns `?``string`

### getViewName()

`public function getViewName(): ?string`

Returns the view name recorded by setViewName(), or null when none was set.

Returns `?``string`

### setValidationManager()

`public function setValidationManager(?object $vm): void`

Replace the cached validation manager.

Called by ValidationService / ActionTestCase to inject the VM that XML validators were executed against, so that the action's manual validate*() methods see the same errors and exports.

| Parameter | Type | Description |
|---|---|---|
| `$vm` | `?``object` |  |

### setViewModuleName()

`public function setViewModuleName(?string $module): void`

Records the module hosting the view to render, overriding the action's own module.

Passing null clears the override so the action's module is used.

| Parameter | Type | Description |
|---|---|---|
| `$module` | `?``string` |  |

### setViewName()

`public function setViewName(?string $name): void`

Records the name of the view to render for this action.

Passing null clears the selection, leaving the view to be resolved from the action's own return value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `?``string` |  |

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
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
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
