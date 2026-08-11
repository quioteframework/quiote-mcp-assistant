# ValidatorConfigHandler

> Compiles a validators.xml document into a compiled Quiote configuration file: a declaration of the validators to build, which ValidatorDeclarationApplier registers onto a validation manager.

Compiles a validators.xml document into a compiled Quiote configuration file: a declaration of the validators to build, which [`ValidatorDeclarationApplier`](/api/validator/compiler/runtime/validator-declaration-applier/) registers onto a validation manager.

The artifact is data and cannot register anything itself.

The XML interpretation lives in ValidatorPlanBuilder, which builds a format-independent ValidatorPlan (see Quiote\Validator\Compiler\Ir). This handler is a thin adapter: parse to IR, emit the declaration from that IR via RuntimeDeclarationEmitter, wrap in the standard compiled-file header. The same ValidatorPlan also feeds a fluent-source emitter for hand-committable, opcacheable validator files, and a non-XML config front-end builds the same IR without touching this class or the emitter.

## Synopsis

`class ValidatorConfigHandler extends XmlConfigHandler`

|  |  |
|---|---|
| Extends | [`XmlConfigHandler`](/api/config/xml-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/ValidatorConfigHandler.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `XML_NAMESPACE` | `'http://quiote.dev/quiote/config/parts/validators/1.1'` |  |

## Methods

| Method | Description |
|---|---|
| [`execute(XmlConfigDomDocument $document): mixed`](#execute) | Compiles the validators document into the declaration to cache. |

### execute()

`public function execute(XmlConfigDomDocument $document): mixed`

Compiles the validators document into the declaration to cache.

The XML is first turned into a format-independent validator plan, which is then emitted as a plain data declaration. The result registers nothing by itself; applying it to a validation manager is a separate step.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |

Returns `mixed`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `initialize()` | [`XmlConfigHandler`](/api/config/xml-config-handler/) | Initialize this ConfigHandler. |
| `literalize()` | [`BaseConfigHandler`](/api/config/base-config-handler/) | Literalize a string value. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `replaceConstants()` | [`BaseConfigHandler`](/api/config/base-config-handler/) | Replace configuration directive identifiers in a string. |
| `replacePath()` | [`BaseConfigHandler`](/api/config/base-config-handler/) | Replace a relative filesystem path with an absolute one. |
| `reset()` | [`ParameterHolder`](/api/util/parameter-holder/) | Removes every parameter held, leaving the holder empty for reuse. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
