# SessionFactoryInterface

> Builds the persistence backend for the `session` factory slot.

Builds the persistence backend for the `session` factory slot.

The slot needs this indirection because the codegen's instantiating branch emits `new $class(); $obj->initialize($context, $params)`, and no [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) implementation has that shape -- FileSessionPersistence takes a directory, PdoSessionPersistence takes a PDO connection. Retrofitting an initialize() onto those value objects purely to satisfy a config template would be backwards; a small factory per backend is the honest seam.

The configured parameters reach both this method and SessionManager's constructor, so cookie settings (`cookie_name`, `session_cookie_lifetime`, `session_cookie_secure`, `session_cookie_samesite`, `session_migration_grace_seconds`) and backend settings live in one place.

## Synopsis

`interface SessionFactoryInterface`

|  |  |
|---|---|
| Implemented by | [`FileSessionFactory`](/api/session/file-session-factory/), [`PdoSessionFactory`](/api/session/pdo-session-factory/), [`PdoSessionFactory`](/api/session/pdo/pdo-session-factory/), [`RedisSessionFactory`](/api/session/redis/redis-session-factory/), [`AzureBlobSessionFactory`](/api/storage/azure/azure-blob-session-factory/), [`AzureTableSessionFactory`](/api/storage/azure/azure-table-session-factory/), [`GcsSessionFactory`](/api/storage/gcs/gcs-session-factory/), [`S3SessionFactory`](/api/storage/s3/s3-session-factory/) |
| Since | `2.2.0` |
| Source | `Session/SessionFactoryInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`createPersistence(Context $context, array<string, mixed> $parameters): SessionPersistenceInterface`](#createpersistence) |  |

### createPersistence()

`abstract public function createPersistence(Context $context, array<string, mixed> $parameters): SessionPersistenceInterface`

The slot's configured parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$parameters` | `array``<``string``, ``mixed``>` | The slot's configured parameters. |

Returns [`SessionPersistenceInterface`](/api/session/session-persistence-interface/)
