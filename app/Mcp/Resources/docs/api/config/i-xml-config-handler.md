# IXmlConfigHandler

> IXmlConfigHandler is the interface that config handlers may implement to indicate that they wish to process a DOMDocument directly.

IXmlConfigHandler is the interface that config handlers may implement to indicate that they wish to process a DOMDocument directly.

## Synopsis

`interface IXmlConfigHandler`

|  |  |
|---|---|
| Implemented by | [`XmlConfigHandler`](/api/config/xml-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/IXmlConfigHandler.php` |

## Methods

| Method | Description |
|---|---|
| [`execute(XmlConfigDomDocument $document): mixed`](#execute) | Execute this configuration handler. |
| [`initialize(?Context $context = null, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this ConfigHandler. |

### execute()

`abstract public function execute(XmlConfigDomDocument $document): mixed`

Execute this configuration handler.

The document to parse.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document to parse. |

Returns `mixed` — The declaration to be cached.

| Throws | When |
|---|---|
| `ParseException` | If a requested configuration file is improperly formatted. |

### initialize()

`abstract public function initialize(?Context $context = null, array<string, mixed> $parameters = []): void`

Initialize this ConfigHandler.

An associative array of initialization parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | `?`[`Context`](/api/context/) | The context to work with (if available). |
| `$parameters` | `array``<``string``, ``mixed``>` | An associative array of initialization parameters. |

| Throws | When |
|---|---|
| `InitializationException` | If an error occurs while initializing the ConfigHandler |
