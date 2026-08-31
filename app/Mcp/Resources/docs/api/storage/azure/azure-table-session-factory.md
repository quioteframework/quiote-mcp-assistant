# AzureTableSessionFactory

> `session` slot factory for AzureTableSessionPersistence.

`session` slot factory for [`AzureTableSessionPersistence`](/api/storage/azure/azure-table-session-persistence/).

```yaml session: class: Quiote\Storage\Azure\AzureTableSessionFactory params: account_name: '%env(AZURE_STORAGE_ACCOUNT)%' account_key: '%env(AZURE_STORAGE_KEY)%' table: sessions ```

The `%env(NAME)%` credentials are read from the process environment when the compiled configuration is loaded, not when it is compiled, so no key is written into the config cache -- see [`EnvPlaceholder`](/api/config/env-placeholder/).

Cheaper than [`AzureBlobSessionFactory`](/api/storage/azure/azure-blob-session-factory/) for small key/value-shaped payloads. Bring your own PSR-18 client, bound in the container.

## Synopsis

`final class AzureTableSessionFactory implements SessionFactoryInterface`

|  |  |
|---|---|
| Implements | [`SessionFactoryInterface`](/api/session/session-factory-interface/) |
| Since | `3.0.0` |
| Source | `AzureTableSessionFactory.php` |

## Methods

| Method | Description |
|---|---|
| [`createPersistence(Context $context, array<string, mixed> $parameters): SessionPersistenceInterface`](#createpersistence) | Builds table-backed session persistence from the slot's parameters. |

### createPersistence()

`public function createPersistence(Context $context, array<string, mixed> $parameters): SessionPersistenceInterface`

Builds table-backed session persistence from the slot's parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |

Returns [`SessionPersistenceInterface`](/api/session/session-persistence-interface/)

| Throws | When |
|---|---|
| `RuntimeException` | If no PSR-18 client is bound in the container. |
