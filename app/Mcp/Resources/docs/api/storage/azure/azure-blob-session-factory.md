# AzureBlobSessionFactory

> `session` slot factory for AzureBlobSessionPersistence.

`session` slot factory for [`AzureBlobSessionPersistence`](/api/storage/azure/azure-blob-session-persistence/).

```yaml session: class: Quiote\Storage\Azure\AzureBlobSessionFactory params: account_name: '%env(AZURE_STORAGE_ACCOUNT)%' account_key: '%env(AZURE_STORAGE_KEY)%' container: quiote-sessions ```

For small key/value-shaped session payloads [`AzureTableSessionFactory`](/api/storage/azure/azure-table-session-factory/) is cheaper. Bring your own PSR-18 client, bound in the container.

## Synopsis

`final class AzureBlobSessionFactory implements SessionFactoryInterface`

|  |  |
|---|---|
| Implements | [`SessionFactoryInterface`](/api/session/session-factory-interface/) |
| Since | `3.0.0` |
| Source | `AzureBlobSessionFactory.php` |

## Methods

| Method | Description |
|---|---|
| [`createPersistence(Context $context, array<string, mixed> $parameters): SessionPersistenceInterface`](#createpersistence) | Builds blob-backed session persistence from the slot's parameters. |

### createPersistence()

`public function createPersistence(Context $context, array<string, mixed> $parameters): SessionPersistenceInterface`

Builds blob-backed session persistence from the slot's parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |

Returns [`SessionPersistenceInterface`](/api/session/session-persistence-interface/)

| Throws | When |
|---|---|
| `RuntimeException` | If no PSR-18 client is bound in the container. |
