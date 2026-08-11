# XsltRenderer

> Renders `.xsl` stylesheets against an \"inner\" XML document (from `$moreAssigns['inner']`) via ext-xsl.

Renders `.xsl` stylesheets against an "inner" XML document (from `$moreAssigns['inner']`) via ext-xsl.

With the `envelope` parameter (on by default) it wraps the inner document plus each rendered slot into a single synthetic document under the [`XsltRenderer::ENVELOPE_NAMESPACE`](/api/renderer/xslt/xslt-renderer/#envelopenamespace) namespace, so a stylesheet can pull slot content via XPath instead of relying on XSLT string parameters (which can't carry markup).

## Synopsis

`final class XsltRenderer extends Renderer implements IReusableRenderer`

|  |  |
|---|---|
| Extends | [`Renderer`](/api/renderer/renderer/) |
| Implements | [`IReusableRenderer`](/api/renderer/i-reusable-renderer/) |
| Source | `XsltRenderer.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `ENVELOPE_NAMESPACE` | `'http://quiote.org/quiote/renderer/xslt/envelope/1.0'` |  |

## Methods

| Method | Description |
|---|---|
| [`getStarterTemplate(): string`](#getstartertemplate) | Returns the skeleton `.xsl` stylesheet written for a newly scaffolded view. |
| [`render(TemplateLayer $layer, array &$attributes = [], array &$slots = [], array &$moreAssigns = []): mixed`](#render) | Transforms the input document with the layer's `.xsl` stylesheet and returns the serialised result. |

### getStarterTemplate()

`public function getStarterTemplate(): string`

Returns the skeleton `.xsl` stylesheet written for a newly scaffolded view.

The stylesheet declares a `title` parameter and prints it, matching the scalar attributes this renderer forwards as XSLT parameters.

Returns `string`

### render()

`public function render(TemplateLayer $layer, array &$attributes = [], array &$slots = [], array &$moreAssigns = []): mixed`

Transforms the input document with the layer's `.xsl` stylesheet and returns the serialised result.

Only scalar and `Stringable` attributes are passed on as XSLT parameters, since XSLT parameters cannot carry markup; everything else reaches the stylesheet through the document. The document is either the envelope built from the `inner` assign plus the flattened slots (the default) or the `inner` assign on its own when the `envelope` parameter is off. The processor runs with every security preference set, so `document()` cannot read files or the network and `php:function` is unavailable.

| Parameter | Type | Description |
|---|---|---|
| `$layer` | [`TemplateLayer`](/api/view/template-layer/) |  |
| `$attributes` | `array` |  |
| `$slots` | `array` |  |
| `$moreAssigns` | `array` |  |

Returns `mixed`

| Throws | When |
|---|---|
| `RenderException` | if the layer carries no stylesheet, the stylesheet or a document cannot be parsed, the `inner` assign is not a `DOMDocument`, string or null, or the transformation itself fails. |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getContext()` | [`Renderer`](/api/renderer/renderer/) | Retrieve the current application context. |
| `getDefaultExtension()` | [`Renderer`](/api/renderer/renderer/) | Get the template file extension |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `initialize()` | [`Renderer`](/api/renderer/renderer/) | Initialize this Renderer. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `reset()` | [`Renderer`](/api/renderer/renderer/) | Returns the renderer to its post-construction state so the instance can be reused for another rendering. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
