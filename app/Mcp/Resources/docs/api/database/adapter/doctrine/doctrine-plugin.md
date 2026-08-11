# DoctrinePlugin

> Enables the `doctrine` (ORM) and `doctrine_dbal` (DBAL-only) driver aliases.

Enables the `doctrine` (ORM) and `doctrine_dbal` (DBAL-only) driver aliases.

Add this class to the `plugins` config key to use them in `databases.xml`.

Extracts to `quioteframework/quiote-doctrine` unchanged.

## Synopsis

`final class DoctrinePlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `DoctrinePlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Registers both Doctrine driver aliases. |

### register()

`public function register(PluginRegistrar $registrar): void`

Registers both Doctrine driver aliases.

`doctrine` maps to [`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/) (full ORM) and `doctrine_dbal` to [`DoctrineDbalDatabase`](/api/database/adapter/doctrine/doctrine-dbal-database/) (DBAL only).

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
