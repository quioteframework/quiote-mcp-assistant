# HttpRedirectRoutingCallback

> HttpRedirectRoutingCallback allows redirection of a matched route to a route or URL.

HttpRedirectRoutingCallback allows redirection of a matched route to a route or URL.

Matched arguments can be rewritten. You need to configure this callback using parameters in the <callback> block. To redirect to a URL, use the "url" configuration parameter and supply the destination URL as the value. To redirect to a route, use the "route" configuration parameter and supply the name of the route to generate. You may pass an arbitrary array of arguments in parameter "arguments". If a parameter value contains a valid PHP variable literal such as $foo, ${foo} or {$foo}, the literal will be replaced with the value of the argument "foo" in the matched route the callback is defined on. Default routing gen() options for generating are "relative" set to false and "separator" set to "&". You may pass an array of options or the name of a routing gen() options preset in configuration in parameter "options". By default, the HTTP status code 302 is used for redirects. You can define a different status code through configuration parameter "code".

## Synopsis

`class HttpRedirectRoutingCallback extends RoutingCallback`

|  |  |
|---|---|
| Extends | [`RoutingCallback`](/api/routing/routing-callback/) |
| Since | `1.0.0` |
| Source | `Routing/HttpRedirectRoutingCallback.php` |

## Methods

| Method | Description |
|---|---|
| [`initialize(Context $context, array<mixed, mixed> &$route): void`](#initialize) | Initialize the callback instance. |
| [`onMatched(array<string, mixed> &$parameters, mixed $legacyContainer = null): bool|WebResponse`](#onmatched) | Container-less match hook. |

### initialize()

`public function initialize(Context $context, array<mixed, mixed> &$route): void`

Initialize the callback instance.

An array with information about the route.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | An Context instance. |
| `$route` | `array``<``mixed``, ``mixed``>` | An array with information about the route. |

### onMatched()

`public function onMatched(array<string, mixed> &$parameters, mixed $legacyContainer = null): bool|WebResponse`

Container-less match hook.

Unused; retained for signature compatibility.

| Parameter | Type | Description |
|---|---|---|
| `$parameters` | `array``<``string``, ``mixed``>` | Matched parameters (modifiable for rewrite). |
| `$legacyContainer` | `mixed` | Unused; retained for signature compatibility. |

Returns `bool``|`[`WebResponse`](/api/response/web-response/) — false to reject the match on misconfiguration, otherwise a WebResponse carrying the redirect to be sent to the client.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getContext()` | [`RoutingCallback`](/api/routing/routing-callback/) | Retrieve the current application context. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `onGenerate()` | [`RoutingCallback`](/api/routing/routing-callback/) | Gets executed when the route of this callback is about to be reverse generated into an URL. |
| `onNotMatched()` | [`RoutingCallback`](/api/routing/routing-callback/) | Executed when the route did NOT match (container-less). |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `reset()` | [`RoutingCallback`](/api/routing/routing-callback/) | Returns the callback to its uninitialized state. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
