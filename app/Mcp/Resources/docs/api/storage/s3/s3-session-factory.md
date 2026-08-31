# S3SessionFactory

> `session` slot factory for S3SessionPersistence.

`session` slot factory for [`S3SessionPersistence`](/api/storage/s3/s3-session-persistence/).

```yaml session: class: Quiote\Storage\S3\S3SessionFactory params: region: eu-west-1 bucket: my-app-sessions access_key_id: '%env(AWS_ACCESS_KEY_ID)%' secret_access_key: '%env(AWS_SECRET_ACCESS_KEY)%' key_prefix: 'sessions/' # endpoint: 'https://minio.internal'   # any S3-compatible service ```

The `%env(NAME)%` credentials are read from the process environment when the compiled configuration is loaded, not when it is compiled, so no key is written into the config cache -- see [`EnvPlaceholder`](/api/config/env-placeholder/).

Bring your own PSR-18 client, bound in the container -- the same contract quioteframework/filesystem-s3 uses. The bucket must already exist; creation and lifecycle belong to infrastructure tooling, not a session backend.

## Synopsis

`final class S3SessionFactory implements SessionFactoryInterface`

|  |  |
|---|---|
| Implements | [`SessionFactoryInterface`](/api/session/session-factory-interface/) |
| Since | `3.0.0` |
| Source | `S3SessionFactory.php` |

## Methods

| Method | Description |
|---|---|
| [`createPersistence(Context $context, array<string, mixed> $parameters): SessionPersistenceInterface`](#createpersistence) | Builds S3-backed session persistence from the slot's parameters. |

### createPersistence()

`public function createPersistence(Context $context, array<string, mixed> $parameters): SessionPersistenceInterface`

Builds S3-backed session persistence from the slot's parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |

Returns [`SessionPersistenceInterface`](/api/session/session-persistence-interface/)

| Throws | When |
|---|---|
| `RuntimeException` | If no PSR-18 client is bound in the container. |
